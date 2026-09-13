<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceItemModel;
use App\Models\InvoiceSettingModel;

class Invoice extends BaseController
{
    protected $customerModel;
    protected $invoiceModel;
    protected $itemModel;
    protected $settingModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->invoiceModel  = new InvoiceModel();
        $this->itemModel     = new InvoiceItemModel();
        $this->settingModel  = new InvoiceSettingModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Manajemen Invoice',
            'invoices' => $this->invoiceModel->getInvoicesWithCustomer()
        ];
        return view('admin/invoice/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Buat Invoice Baru'
        ];
        return view('admin/invoice/create', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart(); 

        try {
            $customerData = [
                'name'    => $this->request->getPost('customer_name'),
                'email'   => $this->request->getPost('customer_email'),
                'phone'   => $this->request->getPost('customer_phone'),
                'address' => $this->request->getPost('customer_address'),
            ];
            
            $this->customerModel->insert($customerData);
            $customerId = $this->customerModel->getInsertID();
            
            $lastInv = $this->invoiceModel->orderBy('id', 'DESC')->first();
            $nextId = $lastInv ? $lastInv['id'] + 1 : 1;
            $invNumber = 'INV-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            
            $invoiceData = [
                'invoice_number' => $invNumber,
                'customer_id'    => $customerId,
                'issue_date'     => $this->request->getPost('issue_date'),
                'due_date'       => $this->request->getPost('due_date'),
                'subtotal'       => str_replace(',', '', $this->request->getPost('subtotal')),
                'discount'       => str_replace(',', '', $this->request->getPost('discount')),
                'tax'            => str_replace(',', '', $this->request->getPost('tax_amount')),
                'total_amount'   => str_replace(',', '', $this->request->getPost('total_amount')),
                'status'         => 'unpaid',
                'notes'          => $this->request->getPost('notes')
            ];
            
            $this->invoiceModel->insert($invoiceData);
            $invoiceId = $this->invoiceModel->getInsertID();
            $items = json_decode($this->request->getPost('items_json'), true);
            
            if (!empty($items) && is_array($items)) {
                $batchItems = [];
                foreach ($items as $item) {
                    if (!empty($item['name'])) {
                        $batchItems[] = [
                            'invoice_id' => $invoiceId,
                            'item_name'  => $item['name'],
                            'quantity'   => $item['qty'],
                            'price'      => $item['price'],
                            'total'      => $item['qty'] * $item['price']
                        ];
                    }
                }
                if (!empty($batchItems)) {
                    $this->itemModel->insertBatch($batchItems);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to(base_url('admin/invoices/create'))->with('error', 'Gagal menyimpan invoice. Terjadi kesalahan database.');
            }

            return redirect()->to(base_url('admin/invoices'))->with('success', 'Invoice ' . $invNumber . ' berhasil dibuat!');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to(base_url('admin/invoices/create'))->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $this->invoiceModel->update($id, ['status' => $status]);
        
        return redirect()->to(base_url('admin/invoices'))->with('success', 'Status Invoice berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->invoiceModel->delete($id);
        
        return redirect()->to(base_url('admin/invoices'))->with('success', 'Data Invoice berhasil dihapus permanen!');
    }

    public function settings()
    {
        $setting = $this->settingModel->find(1);
        if (!$setting) {
            $this->settingModel->insert([
                'id' => 1, 
                'company_name' => 'Rian Projects.',
                'company_tagline' => 'Web Development & Digital Services',
                'company_address' => 'Jakarta, Indonesia'
            ]);
            $setting = $this->settingModel->find(1);
        }

        $data = [
            'title'   => 'Pengaturan Invoice',
            'setting' => $setting
        ];
        return view('admin/invoice/settings', $data);
    }

    public function saveSettings()
    {
        $data = [
            'company_name'    => $this->request->getPost('company_name'),
            'company_tagline' => $this->request->getPost('company_tagline'),
            'company_address' => $this->request->getPost('company_address'),
        ];

        $bankNames   = $this->request->getPost('bank_name') ?? [];
        $bankNumbers = $this->request->getPost('bank_number') ?? [];
        $bankOwners  = $this->request->getPost('bank_owner') ?? [];
        $oldIcons    = $this->request->getPost('old_icon') ?? [];
        
        $accounts = [];
        
        foreach ($bankNames as $i => $name) {
            if (empty($name) && empty($bankNumbers[$i])) continue;
            
            $iconPath = $oldIcons[$i] ?? '';
            $file = $this->request->getFile("bank_icon.$i");
            if ($file && $file->isValid() && !$file->hasMoved()) {

                 if (!empty($iconPath) && file_exists(FCPATH . $iconPath)) {
                     unlink(FCPATH . $iconPath);
                 }
                 $newName = $file->getRandomName();
                 $file->move(FCPATH . 'uploads/invoice', $newName);
                 $iconPath = 'uploads/invoice/' . $newName;
            }
            
            $accounts[] = [
                'bank'   => $name,
                'number' => $bankNumbers[$i] ?? '',
                'owner'  => $bankOwners[$i] ?? '',
                'icon'   => $iconPath
            ];
        }

        $data['bank_account'] = json_encode($accounts);

        $this->settingModel->update(1, $data);
        
        return redirect()->to(base_url('admin/invoices/settings'))->with('success', 'Pengaturan Invoice & Rekening berhasil diperbarui!');
    }

    public function print($id)
    {
        $invoice = $this->invoiceModel->select('invoices.*, customers.name, customers.email, customers.phone, customers.address')
                                      ->join('customers', 'customers.id = invoices.customer_id')
                                      ->find($id);

        if (!$invoice) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $items   = $this->itemModel->where('invoice_id', $id)->findAll();
        $setting = $this->settingModel->find(1);

        $data = [
            'invoice' => $invoice,
            'items'   => $items,
            'setting' => $setting
        ];

        return view('admin/invoice/print', $data);
    }
}