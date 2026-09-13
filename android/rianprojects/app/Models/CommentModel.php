<?php
namespace App\Models;
use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table            = 'prompt_comments';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['prompt_id', 'name', 'comment'];
    protected $useTimestamps    = false; 
}