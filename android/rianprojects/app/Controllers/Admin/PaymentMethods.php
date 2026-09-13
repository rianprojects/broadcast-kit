<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentMethodModel;

class PaymentMethods extends BaseController
{
    protected $paymentMethodModel;

    public function __construct()
    {
        $this->paymentMethodModel = new PaymentMethodModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Metode Pembayaran Manual',
            'methods' => $this->paymentMethodModel->orderBy('sort_order', 'ASC')->findAll()
        ];
        return view('admin/paymentmethods/index', $data);
    }

    public function create()
    {
        return view('admin/paymentmethods/create', ['title' => 'Tambah Metode Pembayaran']);
    }

    public function store()
    {
        $logo = $this->uploadLogo($this->request->getFile('logo'));

        $this->paymentMethodModel->save([
            'name'           => $this->request->getPost('name'),
            'logo'           => $logo,
            'account_number' => $this->request->getPost('account_number'),
            'account_name'   => $this->request->getPost('account_name'),
            'is_active'      => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order'     => (int) $this->request->getPost('sort_order'),
        ]);

        return redirect()->to('admin/paymentmethods')->with('success', 'Metode pembayaran ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title'  => 'Edit Metode Pembayaran',
            'method' => $this->paymentMethodModel->find($id)
        ];
        return view('admin/paymentmethods/edit', $data);
    }

    public function update($id)
    {
        $row = $this->paymentMethodModel->find($id);
        $logo = $row['logo'] ?? null;

        $newLogo = $this->uploadLogo($this->request->getFile('logo'));
        if ($newLogo) {
            if ($logo && file_exists('uploads/payment_methods/' . $logo)) {
                unlink('uploads/payment_methods/' . $logo);
            }
            $logo = $newLogo;
        }

        $this->paymentMethodModel->update($id, [
            'name'           => $this->request->getPost('name'),
            'logo'           => $logo,
            'account_number' => $this->request->getPost('account_number'),
            'account_name'   => $this->request->getPost('account_name'),
            'is_active'      => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order'     => (int) $this->request->getPost('sort_order'),
        ]);

        return redirect()->to('admin/paymentmethods')->with('success', 'Metode pembayaran diperbarui.');
    }

    public function delete($id)
    {
        $row = $this->paymentMethodModel->find($id);
        if ($row && $row['logo'] && file_exists('uploads/payment_methods/' . $row['logo'])) {
            unlink('uploads/payment_methods/' . $row['logo']);
        }
        $this->paymentMethodModel->delete($id);
        return redirect()->back()->with('success', 'Metode pembayaran dihapus.');
    }

    private function uploadLogo($file)
    {
        if (!$file || !$file->isValid()) return null;

        $uploadPath = 'uploads/payment_methods';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        return $newName;
    }
}
