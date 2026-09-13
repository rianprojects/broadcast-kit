<?php
namespace App\Models;
use CodeIgniter\Model;

class WidgetModel extends Model
{
    protected $table = 'sidebar_widgets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content', 'sort_order', 'is_active'];
    protected $useTimestamps = false;
}