<?php
namespace App\Models;
use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'invoices';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['invoice_number', 'customer_id', 'issue_date', 'due_date', 'subtotal', 'discount', 'tax', 'total_amount', 'status', 'notes'];
    public function getInvoicesWithCustomer()
    {
        return $this->select('invoices.*, customers.name as customer_name')
                    ->join('customers', 'customers.id = invoices.customer_id')
                    ->orderBy('invoices.created_at', 'DESC')
                    ->findAll();
    }
}