<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Users');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override('App\Controllers\Preview::view404');
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
$appHost = parse_url(config('App')->baseURL)['host'];
$previewHost = !empty(config('MasterConfig')->previewDomain) ? parse_url(config('MasterConfig')->previewDomain)['host'] : '';
$customFront = config('MasterConfig')->customFront;

$routes->match(['get', 'post'], 'install', 'Install\Install::index/1');
$routes->match(['get', 'post'], 'install/(:num)', 'Install\Install::index/$1');


$routes->group('testy', function ($routes) {
    $routes->match(['get', 'post'], '(:any)', 'test::$1', ['as' => 'test/']);
    $routes->match(['get', 'post'], '(:any)', 'test::$1', ['as' => 'test/']);
    // $routes->match(['get','post'],'(:any)', 'test::index', ['as' => 'test']);
    //  $routes->match(['get','post'],'(:any)/(:any)', 'test::index/$1', ['as' => 'test//']);
});

if ($_SERVER['HTTP_HOST'] == $appHost) {

    // We get a performance increase by specifying the default
    // route since we don't have to scan directories.

    $routes->get('tasks/(:any)', 'Tasks::$1');

    $routes->get('lang/(:segment)', 'Lang::index/$1', ['as' => 'lang/']);
    $routes->get('lang/(:segment)/(:segment)', 'Lang::index/$1/$2', ['as' => 'lang//']);

    $routes->match(['get', 'post'], 'dashboard/newsite', 'Dashboard\NewSite::index', ['as' => 'dashboard-newsite']);
    $routes->match(['get', 'post'], 'payconfirm', 'Payconfirm::index', ['as' => 'payconfirm']);

    $routes->group('dashboard', ['filter' => 'guest', 'namespace' => 'App\Controllers\Dashboard'], function ($routes) {
        $routes->match(['get', 'post'], 'login', 'Users::index', ['as' => 'dashboard-login']);

        $routes->match(['get', 'post'], 'hostlogin', 'Users::hostLogin', ['as' => 'dashboard-hostLogin']);
        $routes->match(['get', 'post'], 'demologin', 'Users::demologin', ['as' => 'dashboard-demologin']);

        $routes->match(['get', 'post'], 'register', 'Users::register', ['as' => 'dashboard-register']);
        $routes->match(['get', 'post'], 'reset', 'Users::reset', ['as' => 'dashboard-reset']);
    });

    $routes->group('dashboard', ['filter' => 'logged', 'namespace' => 'App\Controllers\Dashboard'], function ($routes) {
        $routes->get('/', 'Dashboard::index', ['filter' => 'user', 'as' => 'dashboard']);


        $routes->get('logout', 'Users::logout', ['as' => 'dashboard-logout']);
        $routes->match(['get', 'post'], 'profile', 'Users::profile', ['as' => 'dashboard-profile']);

        $routes->match(['get', 'post'], 'mailbox', 'MailBoxes::index', ['as' => 'dashboard-mailbox']);
        $routes->match(['get', 'post'], 'mailbox/(:segment)', 'MailBoxes::$1', ['as' => 'dashboard-mailbox/']);
        $routes->match(['get', 'post'], 'mailbox/(:segment)/(:segment)', 'MailBoxes::$1/$2', ['as' => 'dashboard-mailbox//']);

        $routes->match(['get', 'post'], '(:segment)', '_Dashboard::$1', ['as' => 'dashboard/']); //_mod
        $routes->match(['get', 'post'], '(:segment)/(:segment)', '_Dashboard::$1/$2', ['as' => 'dashboard//']);
        $routes->add('(:any)', 'Dashboard::$1');
    });





    $routes->group('builder', ['filter' => 'logged'], function ($routes) {
        $routes->match(['get', 'post'], '/', 'Builder::index', ['as' => 'builder']);
        $routes->match(['get', 'post'], '(:any)', 'Builder::$1', ['as' => 'builder/']);
    });

    $routes->group('admin', ['filter' => 'admin', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
        $routes->get('/', 'Adashboard::index', ['as' => 'admin']);

        $routes->match(['get', 'post'], 'users', 'Ausers::index', ['as' => 'admin-users']);
        $routes->match(['get', 'post'], 'users/(:segment)', 'Ausers::$1', ['as' => 'admin-users/']);
        $routes->match(['get', 'post'], 'users/(:segment)/(:segment)', 'Ausers::$1/$2', ['as' => 'admin-users//']);

        $routes->match(['get', 'post'], 'pricing', 'Apricing::index', ['as' => 'admin-pricing']);
        $routes->match(['get', 'post'], 'pricing/(:segment)', 'Apricing::$1', ['as' => 'admin-pricing/']);
        $routes->match(['get', 'post'], 'pricing/(:segment)/(:segment)', 'Apricing::$1/$2', ['as' => 'admin-pricing//']);

        $routes->match(['get', 'post'], 'sites', 'Asites::index', ['as' => 'admin-sites']);
        $routes->match(['get', 'post'], 'sites/(:segment)', 'Asites::$1', ['as' => 'admin-sites/']);
        $routes->match(['get', 'post'], 'sites/(:segment)/(:segment)', 'Asites::$1/$2', ['as' => 'admin-sites//']);

        $routes->match(['get', 'post'], 'templates', 'Atemplates::index', ['as' => 'admin-templates']);
        $routes->match(['get', 'post'], 'templates/(:segment)', 'Atemplates::$1', ['as' => 'admin-templates/']);
        $routes->match(['get', 'post'], 'templates/(:segment)/(:segment)', 'Atemplates::$1/$2', ['as' => 'admin-templates//']);

        $routes->add('(:any)', 'Adashboard::index');
    });


    $routes->group('viewtemplate', function ($routes) {
        $routes->get('(:segment)/style.css', 'Preview::getStyle/template/$1');
        $routes->match(['get', 'post'], '(:segment)', 'Preview::template/$1');
        $routes->match(['get', 'post'], '(:segment)/(:segment)', 'Preview::template/$1/$2');

        $routes->add('(:any)', 'Preview::template/$1');
    });

    $routes->match(['get', 'post'], 'newsite', 'NewSite::index', ['as' => 'newsite']);

    if ($customFront) { //custom views and controller for front pages  
        $supportedLocales = join('|', config('App')->supportedLocales);

        $routes->match(['get', 'post'], '/', 'Front::home/');
        $routes->match(['get', 'post'], $supportedLocales, 'Front::home');
        $routes->post('ajaxform/(:segment)', 'Front::ajaxform/$1');
        $routes->match(['get', 'post'], $supportedLocales . '/(:any)', 'Front::viewPage/$1');
        $routes->match(['get', 'post'], '(:any)', 'Front::viewPage/$1');
    } else { //builder theme for front pages 
        $routes->get('/style.css', 'Preview::getStyle/builder/');
        $routes->post('ajaxform/(:segment)', 'Preview::form/$1');
        $routes->match(['get', 'post'], 'templates', 'Preview::builder/templates', ['as' => 'templates']);
        $routes->match(['get', 'post'], '/', 'Preview::builder/');
        $routes->match(['get', 'post'], '(:segment)', 'Preview::builder/$1');
        $routes->match(['get', 'post'], '(:segment)/(:segment)', 'Preview::builder/$1/$2');
    }
} else if ($_SERVER['HTTP_HOST'] == $previewHost) {

    $routes->group('project', function ($routes) {

        $routes->get('(:segment)/style.css', 'Preview::getStyle/project/$1');
        $routes->match(['get', 'post'], '(:segment)', 'Preview::project/$1');
        $routes->match(['get', 'post'], '(:segment)/(:segment)', 'Preview::project/$1/$2');

        $routes->add('(:any)', 'Preview::project/$1');
    });
} else {
    $routes->get('style.css', 'Preview::getStyle/local/' . $_SERVER['HTTP_HOST']);
    $routes->post('ajaxform/(:segment)', 'Preview::localform/' . $_SERVER['HTTP_HOST'] . '/$1');
    $routes->match(['get', 'post'], '(:segment)', 'Preview::local/' . $_SERVER['HTTP_HOST'] . '/$1');
    $routes->match(['get', 'post'], '(:segment)/(:segment)', 'Preview::local/' . $_SERVER['HTTP_HOST'] . '/$1/$2');
    $routes->add('(:any)', 'Preview::local/' . $_SERVER['HTTP_HOST']);
}

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
