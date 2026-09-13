<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AppVersionModel;

class AppVersion extends BaseController
{
    public function latest()
    {
        $model = new AppVersionModel();
        $row = $model->latest();

        if (!$row) {
            return $this->response->setJSON(['latest_version' => null]);
        }

        return $this->response->setJSON([
            'latest_version' => $row['version'],
            'changelog'      => $row['changelog'],
            'apk_url'        => base_url($row['apk_path']),
            'force_update'   => (bool) $row['force_update'],
        ]);
    }
}
