<?php

namespace App\Models;

use CodeIgniter\Model;

class AiToolModel extends Model
{
    protected $table            = 'ai_tools';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'slug', 'name', 'description', 'icon', 'color', 
        'icon_color', 'bg_color', 'link', 'status', 'tags'
    ];
}