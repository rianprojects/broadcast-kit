<?php
namespace App\Models;
use CodeIgniter\Model;

class InvoiceItemModel extends Model
{
    protected $table            = 'invoice_items';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['invoice_id', 'item_name', 'quantity', 'price', 'total'];
}