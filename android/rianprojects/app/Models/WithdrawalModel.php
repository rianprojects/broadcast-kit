<?php
namespace App\Models;
use CodeIgniter\Model;

class WithdrawalModel extends Model
{
    protected $table            = 'withdrawals';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'user_id', 'amount', 'transfer_fee', 'platform_fee', 
        'net_amount', 'bank_name', 'bank_account', 'bank_account_name', 
        'status', 'notes'
    ];
    protected $useTimestamps    = true;
}