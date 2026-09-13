<?php
namespace App\Models;
use CodeIgniter\Model;

class PaymentMethodModel extends Model
{
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'logo', 'account_number', 'account_name', 'is_active', 'sort_order'];
    protected $useTimestamps = false;
}
