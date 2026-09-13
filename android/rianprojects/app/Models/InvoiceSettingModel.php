<?php
namespace App\Models;
use CodeIgniter\Model;

class InvoiceSettingModel extends Model
{
    protected $table         = 'invoice_settings';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['company_name', 'company_tagline', 'company_address', 'bank_account', 'payment_icon'];
    public $timestamps       = false;
}