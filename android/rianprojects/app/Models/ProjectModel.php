<?php
namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'slug',
        'category',
        'client',
        'description',
        'preview_url',
        'tech_stack',
        'thumbnail',
        'meta_title',
        'meta_desc',
        'order_position',
    ];
    
    protected $useTimestamps = true;

    public function getOrdered()
    {
        return $this->orderBy('order_position', 'ASC')->findAll();
    }
}