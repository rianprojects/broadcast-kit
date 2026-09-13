<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\WidgetModel;

class Blog extends BaseController
{
    public function index()
    {
        $model = new PostModel();
        $categories = $model->select('category')
                            ->where('status', 'published')
                            ->where('category !=', '')
                            ->distinct()
                            ->findColumn('category') ?? [];

        $activeCategory = $this->request->getVar('category');
        $query = $model->where('posts.status', 'published')
                       ->select('posts.*, users.username as author_name')
                       ->join('users', 'users.id = posts.author_id', 'left');

        if (!empty($activeCategory) && $activeCategory !== 'all') {
            $query->where('posts.category', $activeCategory);
        }

        $posts = $query->orderBy('posts.created_at', 'DESC')->paginate(6);

        $data = [
            'title'           => 'Blog - Rian Projects',
            'meta_desc'       => 'Baca Artikel Mengenai informasi, Ai, Lifestyle dan lainnya disini',
            'posts'           => $posts,
            'pager'           => $model->pager,
            'categories'      => $categories,
            'active_category' => $activeCategory ?? 'all'
        ];
        
        return view('frontend/blog_list', $data);
    }

    public function read($slug)
    {
        $model = new PostModel();
        $post = $model->select('posts.*, users.username as author_real_name')
                      ->join('users', 'users.id = posts.author_id', 'left')
                      ->where('posts.slug', $slug)
                      ->where('posts.status', 'published')
                      ->first();
    
        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    
        $related = $model->select('title, slug, featured_image, created_at')
                         ->where('status', 'published')
                         ->where('id !=', $post['id']) 
                         ->orderBy('created_at', 'DESC')
                         ->findAll(5);

        $widgetModel = new WidgetModel();
        $widgets = $widgetModel->where('is_active', 1)
                               ->orderBy('sort_order', 'ASC')
                               ->findAll();

        $data = [
            'title'         => ($post['meta_title'] ?: $post['title']) . ' - Rian Projects',
            'post'          => $post,
            'related_posts' => $related,
            'meta_desc'     => $post['meta_desc'],
            'meta_image'    => base_url('uploads/blog/' . $post['featured_image']),
            'widgets'       => $widgets
        ];
        
        return view('frontend/blog_detail', $data);
    }
}