<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Settings
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * 1. PUBLIC ROUTES
 * --------------------------------------------------------------------
 */

// Home & Utilities
$routes->get('/', 'Home::index');
$routes->get('status', 'Status::index');
$routes->get('status/check', 'Status::check');
$routes->get('sitemap.xml', 'Sitemap::index');
$routes->post('api/askrian', 'AskRian::chat');

// Rute PWA (Jika file sw.js/manifest ada di root PHP, jika tidak biarkan di folder public)
// $routes->get('sw.js', 'Pwa::serviceWorker');
// $routes->get('manifest.json', 'Pwa::manifest');

// Rute Impersonasi: Logout-As (Wajib di luar grup filter admin)
$routes->get('admin/users/logout-as', 'Admin\UserManager::logoutAs');

// Public Content & Tools
$routes->get('prompts', 'Prompts::index');
$routes->get('prompt/(:segment)', 'Prompts::detail/$1');
$routes->get('project/(:any)', 'Home::detail/$1');
$routes->get('blog', 'Blog::index');
$routes->get('blog/(:any)', 'Blog::read/$1');
// $routes->get('porto', 'PortoController::index');
$routes->get('tools', 'Tools::index');

// Tools
$routes->group('tools', function($routes) {
    $routes->get('downloader', 'Downloader::index');
    $routes->post('extract-link', 'Downloader::extractLink');
    $routes->post('extract-all', 'Downloader::extractAll');   // <-- baris baru
    // $routes->post('download-zip', 'Downloader::downloadZip');
    $routes->get('qrcode', 'Tools::qrcode');
    $routes->get('color-contrast', 'Tools::colorcontrast');
    $routes->get('gradient-generator', 'Tools::gradient');
    $routes->get('box-shadow', 'Tools::boxshadow');
    $routes->get('grid-builder', 'Tools::gridbuilder');
    $routes->get('palettes', 'Tools::palettes');
    $routes->get('video-proxy', 'Downloader::videoProxy');
    $routes->get('image-proxy', 'Downloader::imageProxy');
    $routes->get('download-media', 'Downloader::downloadMedia');
    $routes->get('meme', 'Tools::meme');
});

// AI Lab Public Routes
$routes->group('ailab', function($routes) {
    $routes->get('/', 'AiLab::index'); 
    $routes->get('imaging', 'AiLab::imaging');
    $routes->get('blogai', 'AiLab::blogai');
    $routes->post('generate-image', 'AiLab::generateImage');
    $routes->post('generate-content', 'AiLab::generateContent');
    $routes->get('code-reviewer', 'AiLab::codeReviewer');
    $routes->post('analyze-code', 'AiLab::analyzeCode');
    $routes->get('social-media', 'AiLab::socialMedia');
    $routes->post('generate-social', 'AiLab::generateSocial');
    $routes->get('cv-scanner', 'AiLab::cvScanner');
    $routes->post('scan-cv', 'AiLab::scanCv');
    $routes->get('newsai', 'AiLab::newsai');
    $routes->post('generate-news', 'AiLab::generateNews');
    $routes->get('chat', 'AiLab::chat');
    $routes->post('send-chat', 'AiLab::sendChat');
    $routes->get('data-analyst', 'AiLab::dataAnalyst');
    $routes->post('analyze-data', 'AiLab::analyzeData');
    $routes->get('youtube-summarizer', 'AiLab::youtubeSummarizer');
    $routes->post('generate-youtube-summary', 'AiLab::generateYoutubeSummary');
    $routes->get('text-detector', 'AiLab::textDetector');
    $routes->post('analyze-text', 'AiLab::analyzeText');
    $routes->post('extract-file', 'AiLab::extractFile');
});



// Halaman Legalitas
$routes->get('terms', 'Pages::terms');
$routes->get('privacy', 'Pages::privacy');

// API & Komentar
$routes->post('api/withdraw/process', 'Api\TelegramWebhook::processWithdraw');
$routes->post('api/transaction/process', 'Api\TelegramWebhook::processTransaction');
$routes->get('api/version', 'Api\AppVersion::latest');
$routes->post('prompt/comment', 'Prompts::addComment');
$routes->post('prompt/deleteComment/(:num)', 'Prompts::deleteComment/$1', ['filter' => 'auth']);
$routes->get('buy/(:segment)', 'Transaction::buy/$1', ['filter' => 'auth']);
$routes->post('transaction/process', 'Transaction::process', ['filter' => 'auth']);
$routes->post('transaction/tripay/create', 'Transaction::createTripay', ['filter' => 'auth']);
$routes->post('transaction/qris/create', 'Transaction::createQrisAjax', ['filter' => 'auth']);
$routes->get('transaction/status/(:segment)', 'Transaction::status/$1', ['filter' => 'auth']);
$routes->post('callback/tripay', 'Callback::tripay');

/*
 * --------------------------------------------------------------------
 * 2. AUTH ROUTES
 * --------------------------------------------------------------------
 */
$routes->get('login', 'Auth::login');
$routes->get('register', 'Auth::register');

$routes->group('auth', function($routes) {
    $routes->post('loginProcess', 'Auth::loginProcess');
    $routes->post('registerProcess', 'Auth::registerProcess');
    $routes->get('activate/(:any)', 'Auth::activate/$1');
    $routes->get('forgot', 'Auth::forgot');
    $routes->post('forgotProcess', 'Auth::forgotProcess');
    $routes->get('reset/(:any)', 'Auth::reset/$1');
    $routes->post('resetProcess', 'Auth::resetProcess');
    $routes->get('logout', 'Auth::logout');
});

/*
 * --------------------------------------------------------------------
 * 3. MEMBER DASHBOARD (Filter: auth)
 * --------------------------------------------------------------------
 */
$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'User\Dashboard::index'); 
    $routes->get('settings', 'Account::settings');
    $routes->post('settings/update', 'Account::updateSettings');
    $routes->get('wallet', 'Account::wallet');
    $routes->post('wallet/withdraw', 'Account::requestWithdraw');
});

$routes->group('prompts/my', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'User\Prompts::index');
    $routes->get('new', 'User\Prompts::create');
    $routes->post('save', 'User\Prompts::save');
    $routes->delete('delete/(:num)', 'User\Prompts::delete/$1');
});

/*
 * --------------------------------------------------------------------
 * 4. ADMIN ROUTES (Filter: auth:admin)
 * --------------------------------------------------------------------
 */
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    
    $routes->get('/', 'Admin\Dashboard::index');
    
    // Kelola Pengguna
    $routes->group('users', function($routes) {
        $routes->get('/', 'Admin\UserManager::index');
        $routes->get('verify/(:num)', 'Admin\UserManager::verifyUser/$1');
        $routes->post('toggle-ban/(:num)', 'Admin\UserManager::toggleBan/$1');
        $routes->post('reset-password/(:num)', 'Admin\UserManager::resetPassword/$1');
        $routes->get('login-as/(:num)', 'Admin\UserManager::loginAs/$1');
        $routes->post('delete/(:num)', 'Admin\UserManager::delete/$1'); // FITUR HAPUS
    });

    // Kelola Penarikan Dana
    $routes->get('withdrawals', 'Admin\WithdrawalManager::index');
    $routes->post('withdrawals/process', 'Admin\WithdrawalManager::process');

    // App Versions (BroadcastKit Companion update checker)
    $routes->group('appversions', function($routes) {
        $routes->get('/', 'Admin\AppVersions::index');
        $routes->get('create', 'Admin\AppVersions::create');
        $routes->post('store', 'Admin\AppVersions::store');
        $routes->post('delete/(:num)', 'Admin\AppVersions::delete/$1');
    });

    // Payment Methods (manual payment channels shown on /buy)
    $routes->group('paymentmethods', function($routes) {
        $routes->get('/', 'Admin\PaymentMethods::index');
        $routes->get('create', 'Admin\PaymentMethods::create');
        $routes->post('store', 'Admin\PaymentMethods::store');
        $routes->get('edit/(:num)', 'Admin\PaymentMethods::edit/$1');
        $routes->post('update/(:num)', 'Admin\PaymentMethods::update/$1');
        $routes->post('delete/(:num)', 'Admin\PaymentMethods::delete/$1');
    });

    // Projects (Portofolio)
    $routes->group('projects', function($routes) {
        $routes->get('/', 'Admin\Projects::index');
        $routes->get('new', 'Admin\Projects::create');
        $routes->post('store', 'Admin\Projects::store'); 
        $routes->get('edit/(:num)', 'Admin\Projects::edit/$1');
        $routes->post('update/(:num)', 'Admin\Projects::update/$1');
        $routes->post('delete/(:num)', 'Admin\Projects::delete/$1'); 
    });
    
    // --- MANAJEMEN INVOICE ---
    $routes->get('invoices', 'Admin\Invoice::index');
    $routes->get('invoices/create', 'Admin\Invoice::create');
    $routes->post('invoices/store', 'Admin\Invoice::store');
    $routes->get('invoices/print/(:num)', 'Admin\Invoice::print/$1');
    $routes->post('invoices/update-status/(:num)', 'Admin\Invoice::updateStatus/$1');
    $routes->get('invoices/settings', 'Admin\Invoice::settings');
    $routes->post('invoices/settings/save', 'Admin\Invoice::saveSettings');
    $routes->post('invoices/delete/(:num)', 'Admin\Invoice::delete/$1');

    // Admin AI Lab
    $routes->group('ailab', function($routes) {
        $routes->get('/', 'Admin\AdminAiLab::index');
        $routes->get('create', 'Admin\AdminAiLab::create');
        $routes->post('store', 'Admin\AdminAiLab::store');
        $routes->get('edit/(:num)', 'Admin\AdminAiLab::edit/$1');
        $routes->post('update/(:num)', 'Admin\AdminAiLab::update/$1');
        $routes->post('delete/(:num)', 'Admin\AdminAiLab::delete/$1');
        $routes->post('toggle/(:num)', 'Admin\AdminAiLab::toggle/$1');
    });

    // Blog Posts
    $routes->group('posts', function($routes) {
        $routes->get('/', 'Admin\Posts::index');           
        $routes->get('new', 'Admin\Posts::create');
        $routes->post('save', 'Admin\Posts::save');        
        $routes->get('edit/(:num)', 'Admin\Posts::edit/$1');
        $routes->post('update/(:num)', 'Admin\Posts::update/$1');
        $routes->delete('delete/(:num)', 'Admin\Posts::delete/$1');
    });

    // Widgets
    $routes->group('widgets', function($routes) {
        $routes->get('/', 'Admin\Widget::index');
        $routes->get('create', 'Admin\Widget::create');
        $routes->post('store', 'Admin\Widget::store');
        $routes->get('edit/(:num)', 'Admin\Widget::edit/$1');
        $routes->post('update/(:num)', 'Admin\Widget::update/$1');
        $routes->post('delete/(:num)', 'Admin\Widget::delete/$1');
        $routes->post('updateOrder', 'Admin\Widget::updateOrder');
    });

    // Pengaturan Porto & Akun
    $routes->get('ai-prompts', 'Admin\AiPrompts::index');
    $routes->get('ai-prompts/new', 'Admin\AiPrompts::create');
    $routes->post('ai-prompts/save', 'Admin\AiPrompts::save');
    $routes->get('ai-prompts/edit/(:num)', 'Admin\AiPrompts::edit/$1');
    $routes->delete('ai-prompts/delete/(:num)', 'Admin\AiPrompts::delete/$1');
    
   // ========================================================
    // PENGATURAN PORTO
    // ========================================================
    $routes->get('porto', 'Admin\Porto::admin');
    $routes->post('porto/profile', 'Admin\Porto::saveProfile');
    $routes->post('porto/sections/reorder', 'Admin\Porto::reorderSections');
    $routes->get('porto/item/(:alpha)/(:num)', 'Admin\Porto::getItem/$1/$2');
    $routes->post('porto/bulkDelete/(:alpha)', 'Admin\Porto::bulkDelete/$1');
    
    // --- Rute Khusus SKILLS ---
    $routes->post('porto/skill/save', 'Admin\Porto::saveSkill');
    $routes->post('porto/skill/delete/(:num)', 'Admin\Porto::deleteSkill/$1'); // <-- DIUBAH JADI POST
    $routes->post('porto/skill/reorder', 'Admin\Porto::reorderSkills');

    // --- Rute Khusus EXPERIENCE ---
    $routes->post('porto/experience/save', 'Admin\Porto::saveExperience');
    $routes->post('porto/experience/delete/(:num)', 'Admin\Porto::deleteExperience/$1'); // <-- DIUBAH JADI POST
    $routes->post('porto/experience/reorder', 'Admin\Porto::reorderExperiences');

    // --- Rute Khusus PROJECTS ---
    $routes->post('porto/project/save', 'Admin\Porto::saveProject');
    $routes->post('porto/project/delete/(:num)', 'Admin\Porto::deleteProject/$1'); // <-- DIUBAH JADI POST
    $routes->post('porto/project/reorder', 'Admin\Porto::reorderProjects');

    // --- Rute Khusus EDUCATION ---
    $routes->post('porto/education/save', 'Admin\Porto::saveEducation');
    $routes->post('porto/education/delete/(:num)', 'Admin\Porto::deleteEducation/$1'); // <-- DIUBAH JADI POST
    $routes->post('porto/education/reorder', 'Admin\Porto::reorderEducation');
    
    $routes->get('transactions', 'Admin\Transactions::index');
    $routes->get('transactions/approve/(:num)', 'Admin\Transactions::approve/$1');
    $routes->get('transactions/reject/(:num)', 'Admin\Transactions::reject/$1');

    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings/update', 'Admin\Settings::update');
});