<?php
namespace App\Models;
use CodeIgniter\Model;

class AppVersionModel extends Model
{
    protected $table = 'app_versions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['version', 'changelog', 'apk_path', 'force_update'];
    protected $useTimestamps = false;

    public function latest()
    {
        return $this->orderBy('id', 'DESC')->first();
    }
}
