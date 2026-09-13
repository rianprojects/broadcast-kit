<?php
namespace App\Models;
use CodeIgniter\Model;

class UserPromptModel extends Model
{
    protected $table = 'user_prompts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'prompt_id'];
    protected $useTimestamps = true; // created_at
}