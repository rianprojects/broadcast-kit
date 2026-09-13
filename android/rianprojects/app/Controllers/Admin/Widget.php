<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WidgetModel;

class Widget extends BaseController
{
    protected $widgetModel;

    public function __construct()
    {
        $this->widgetModel = new WidgetModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Widgets',
            'widgets' => $this->widgetModel->orderBy('sort_order', 'ASC')->findAll()
        ];
        return view('admin/widgets/index', $data);
    }

    public function create()
    {
        return view('admin/widgets/create', ['title' => 'Tambah Widget Baru']);
    }

    public function store()
    {
        
        $lastWidget = $this->widgetModel->orderBy('sort_order', 'DESC')->first();
        $nextOrder = $lastWidget ? $lastWidget['sort_order'] + 1 : 1;

        $this->widgetModel->save([
            'title'      => $this->request->getPost('title'),
            'content'    => $this->request->getPost('content'),
            'is_active'  => $this->request->getPost('is_active'),
            'sort_order' => $nextOrder
        ]);

        return redirect()->to('admin/widgets')->with('success', 'Widget berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Widget',
            'widget' => $this->widgetModel->find($id)
        ];
        return view('admin/widgets/edit', $data);
    }

    public function update($id)
    {
        $this->widgetModel->update($id, [
            'title'     => $this->request->getPost('title'),
            'content'   => $this->request->getPost('content'),
            'is_active' => $this->request->getPost('is_active')
        ]);

        return redirect()->to('admin/widgets')->with('success', 'Widget berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->widgetModel->delete($id);
        return redirect()->back()->with('success', 'Widget berhasil dihapus.');
    }

    public function updateOrder()
    {
        $json = $this->request->getJSON();
        if ($json && isset($json->order)) {
            $order = $json->order;
            foreach ($order as $index => $id) {
                $this->widgetModel->update($id, ['sort_order' => $index + 1]);
            }
            return $this->response->setJSON(['status' => 'success', 'message' => 'Urutan disimpan']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid']);
    }
}