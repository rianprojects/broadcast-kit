<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//==============================================================
// RUTE PUBLIK / HALAMAN DEPAN
//==============================================================
$routes->get('cron/run', 'Cron::checkPendingTransactions');
$routes->get('/maintenance', 'Maintenance::index');

$routes->group('api', function($routes) {
    $routes->post('products', 'Api::addProduct');
    $routes->get('products/telegram', 'Api::getTelegramProducts');
    $routes->delete('products', 'Api::deleteProduct');
    $routes->post('products/buy', 'Api::createBotTransaction');
    $routes->post('create-transaction', 'Api::createBotTransaction');
    $routes->get('payment-channels', 'Api::paymentChannels');

    $routes->get('categories', 'Api::getCategories');
    $routes->post('categories', 'Api::addCategory'); 
    $routes->delete('categories', 'Api::deleteCategory');
    $routes->get('recap', 'Api::getBusinessRecap');
    
    $routes->post('user/manual-balance', 'Api::addManualBalance');
    $routes->get('user/balance/(:any)', 'Api::getUserBalance/$1');
    $routes->get('deposit/check-active/(:any)', 'Api::checkActiveDeposit/$1');
    
    $routes->get('api/transaksi/status/(:any)', 'Api::checkTransactionStatus/$1');
});

// terms & Privacy

$routes->get('/syarat-ketentuan', 'Pages::terms');
$routes->get('/kebijakan-privasi', 'Pages::privacy');

$routes->group('/', ['filter' => 'maintenance'], static function($routes) {
    $routes->get('', 'Home::index');
    $routes->get('brand/(:segment)', 'Home::brand/$1');
    $routes->post('bayar', 'Transaksi::bayar');
    $routes->get('lacak', 'Transaksi::lacak');
    $routes->post('lacak/cek', 'Transaksi::cek');
    $routes->get('transaksi/invoice/(:segment)', 'Transaksi::invoice/$1');
    $routes->get('transaksi/sukses/(:segment)', 'Transaksi::sukses/$1');
});

$routes->get('/api/payment-channels', 'Transaksi::paymentChannels');
$routes->get('/api/transaction-detail/(:segment)', 'Transaksi::detail/$1');
$routes->get('/api/transaction-status/(:segment)', 'Transaksi::status/$1');
$routes->post('api/validate-coupon', 'Transaksi::validateCoupon');
$routes->post('/callback/tripay', 'Callback::tripay');
$routes->post('/callback/digiflazz', 'Callback::digiflazz');

//==============================================================
// RUTE PANEL ADMIN (SUPER SECURE & FLEXIBLE)
//==============================================================

// Ambil path dari .env, gunakan 'portal-rahasia' sebagai default jika .env kosong
$secret_login = env('ADMIN_LOGIN_PATH', 'portal-rahasia');

$routes->get($secret_login, 'Admin\Auth::login', ['as' => 'admin.login']);
$routes->post($secret_login . '/process', 'Admin\Auth::processLogin', ['as' => 'admin.login.process']);

// Rute logout
$routes->get('admin/logout', 'Admin\Auth::logout', ['as' => 'admin.logout']);

$routes->get('admin', function() {
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
});
$routes->get('admin/login', function() {
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
});

$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    $routes->get('coupons', 'Admin\Coupon::index');
    $routes->get('coupons/create', 'Admin\Coupon::create');
    $routes->post('coupons/store', 'Admin\Coupon::store');
    $routes->get('coupons/edit/(:num)', 'Admin\Coupon::edit/$1');
    $routes->post('coupons/update/(:num)', 'Admin\Coupon::update/$1');
    $routes->get('coupons/delete/(:num)', 'Admin\Coupon::delete/$1');
    
    // Transaksi
    $routes->get('transaksi', 'Admin\Transaksi::index');
    $routes->get('transaksi/detail/(:segment)', 'Admin\Transaksi::detail/$1');
    
    $routes->group('users', ['filter' => 'lead_auth'], static function ($routes) {
        $routes->get('/', 'Admin\User::index');
        $routes->get('create', 'Admin\User::create');
        $routes->post('store', 'Admin\User::store');
        $routes->get('edit/(:num)', 'Admin\User::edit/$1');
        $routes->post('update/(:num)', 'Admin\User::update/$1');
        $routes->get('delete/(:num)', 'Admin\User::delete/$1');
    });
    
    // Petunjuk Penggunaan
    $routes->get('instructions', 'Admin\Instruction::index');

    // Kelola Produk
    $routes->get('products', 'Admin\Produk::index');
    $routes->get('product/sync', 'Admin\Produk::sync');
    $routes->get('products/edit/(:num)', 'Admin\Produk::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\Produk::update/$1'); 
    $routes->post('products/bulk-update', 'Admin\Produk::bulkUpdate');
    $routes->post('products/delete-image', 'Admin\Produk::deleteImage');

    // Kelola Kategori (Brands)
    $routes->get('brands', 'Admin\Brand::index');
    $routes->get('brands/create', 'Admin\Brand::create');
    $routes->post('brands/store', 'Admin\Brand::store');
    $routes->get('brands/edit/(:num)', 'Admin\Brand::edit/$1');
    $routes->post('brands/update/(:num)', 'Admin\Brand::update/$1');
    $routes->get('brands/delete/(:num)', 'Admin\Brand::delete/$1');
    $routes->post('brands/delete-image', 'Admin\Brand::deleteImage');
    
    $routes->get('settings', 'Admin\Setting::index');
    $routes->post('settings/update', 'Admin\Setting::update');
    $routes->post('settings/delete-payment-logo', 'Admin\Setting::deletePaymentLogo');

    // Kelola Slider
    $routes->get('sliders', 'Admin\Slider::index');
    $routes->get('sliders/create', 'Admin\Slider::create');
    $routes->post('sliders/store', 'Admin\Slider::store');
    $routes->get('sliders/edit/(:num)', 'Admin\Slider::edit/$1');
    $routes->post('sliders/update/(:num)', 'Admin\Slider::update/$1');
    $routes->get('sliders/delete/(:num)', 'Admin\Slider::delete/$1');
});
