<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AiToolModel;

class AdminAiLab extends BaseController
{
    protected $aiToolModel;

    public function __construct()
    {
        $this->aiToolModel = new AiToolModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen AI Tools',
            'tools' => $this->aiToolModel->findAll()
        ];
        return view('admin/ailab/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah AI Tool'
        ];
        return view('admin/ailab/create', $data);
    }

    public function store()
    {
        $this->aiToolModel->save([
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
            'tags'        => $this->request->getPost('tags'),
            'color'       => $this->request->getPost('color'),
            'icon_color'  => $this->request->getPost('icon_color'),
            'bg_color'    => $this->request->getPost('bg_color'),
            'link'        => $this->request->getPost('link'),
            'status'      => $this->request->getPost('status')
        ]);

        return redirect()->to(base_url('admin/ailab'))->with('success', 'Fitur AI berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit AI Tool',
            'tool'  => $this->aiToolModel->find($id)
        ];

        if (empty($data['tool'])) {
            return redirect()->to(base_url('admin/ailab'))->with('error', 'Fitur AI tidak ditemukan.');
        }

        return view('admin/ailab/edit', $data);
    }

    public function update($id)
    {
        $this->aiToolModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
            'tags'        => $this->request->getPost('tags'),
            'color'       => $this->request->getPost('color'),
            'icon_color'  => $this->request->getPost('icon_color'),
            'bg_color'    => $this->request->getPost('bg_color'),
            'link'        => $this->request->getPost('link'),
            'status'      => $this->request->getPost('status')
        ]);

        return redirect()->to(base_url('admin/ailab'))->with('success', 'Fitur AI berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->aiToolModel->delete($id);
        return redirect()->to(base_url('admin/ailab'))->with('success', 'Fitur AI berhasil dihapus.');
    }

    public function toggle($id)
    {
        $tool = $this->aiToolModel->find($id);
        if ($tool) {
            $newStatus = ($tool['status'] === 'Active') ? 'off' : 'Active';
            $this->aiToolModel->update($id, ['status' => $newStatus]);
            return redirect()->to(base_url('admin/ailab'))->with('success', 'Status diubah menjadi ' . $newStatus);
        }
        return redirect()->to(base_url('admin/ailab'))->with('error', 'Fitur tidak ditemukan.');
    }
}