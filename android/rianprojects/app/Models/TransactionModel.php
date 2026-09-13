<?php
namespace App\Models;
use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'prompt_id', 'amount', 'proof_image', 'status', 'merchant_ref', 'payment_method', 'reference', 'checkout_url'];
    protected $useTimestamps = true;
}