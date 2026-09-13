<?php

namespace App\Models;

use CodeIgniter\Model;

class AiPromptModel extends Model
{
    protected $table            = 'ai_prompts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields = [
    'title', 
    'slug', 
    'prompt', 
    'description',
    'image', 
    'creator_name', 
    'type',
    'price',
    'user_id',
    'type',
    'social_instagram', 
    'social_tiktok', 
    'social_facebook', 
    'social_threads'
];
    protected $useTimestamps    = true;
}