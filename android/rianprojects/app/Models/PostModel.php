<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table            = 'posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'author_id',
        'title', 
        'slug', 
        'content', 
        'featured_image', 
        'status', 
        'category', 
        'tags', 
        'meta_title', 
        'meta_desc'
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getPostsWithAuthor($limit = 5)
    {
        return $this->select('posts.*, users.username as author_name')
                    ->join('users', 'users.id = posts.author_id', 'left')
                    ->orderBy('posts.created_at', 'DESC')
                    ->paginate($limit);
    }
}