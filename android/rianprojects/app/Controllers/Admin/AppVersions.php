<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AppVersionModel;

class AppVersions extends BaseController
{
    protected $appVersionModel;

    public function __construct()
    {
        $this->appVersionModel = new AppVersionModel();
    }

    public function index()
    {
        $data = [
            'title' => 'App Versions',
            'versions' => $this->appVersionModel->orderBy('id', 'DESC')->findAll()
        ];
        return view('admin/appversions/index', $data);
    }

    public function create()
    {
        return view('admin/appversions/create', ['title' => 'Rilis Versi Baru']);
    }

    public function store()
    {
        $file = $this->request->getFile('apk');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->withInput()->with('error', 'File APK tidak valid.');
        }
        if (strtolower($file->getExtension()) !== 'apk') {
            return redirect()->back()->withInput()->with('error', 'File harus berformat .apk.');
        }

        $uploadPath = 'uploads/apk';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $version = trim($this->request->getPost('version'));
        $newName = 'broadcastkit-' . preg_replace('/[^a-zA-Z0-9.]/', '', $version) . '.apk';
        $file->move($uploadPath, $newName, true);

        $this->appVersionModel->save([
            'version'      => $version,
            'changelog'    => $this->request->getPost('changelog'),
            'apk_path'     => $uploadPath . '/' . $newName,
            'force_update' => $this->request->getPost('force_update') ? 1 : 0,
        ]);

        return redirect()->to('admin/appversions')->with('success', 'Versi baru berhasil dirilis.');
    }

    public function delete($id)
    {
        $row = $this->appVersionModel->find($id);
        if ($row && file_exists($row['apk_path'])) {
            unlink($row['apk_path']);
        }
        $this->appVersionModel->delete($id);
        return redirect()->back()->with('success', 'Versi dihapus.');
    }
}
