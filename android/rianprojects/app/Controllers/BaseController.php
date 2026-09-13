<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Jangan ubah baris ini
        parent::initController($request, $response, $logger);
    
        // 1. Ambil data setting dari DB
        $db = \Config\Database::connect();
        $settings = $db->table('settings')->where('id', 1)->get()->getRowArray();
    
        // 2. Kirim ke view secara GLOBAL (Gunakan cara ini)
        $renderer = \Config\Services::renderer();
        $renderer->setData(['site_settings' => $settings]);
    
        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }
}
