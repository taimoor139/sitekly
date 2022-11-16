<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

require_once __DIR__ . '/app/app.php';

if(!$app->getStatus()){
  return false;  
}

$router->get('/', function () use ($app) {
        $data = $app->getPage();
		$app->view('layout',$data);
		
    });

 $router->get('([^/]+)', function ($page) use ($app) {
       $data = $app->getPage($page);
	   $app->view('layout',$data);
    });
 $router->get('([^/]+/[^/]+)', function ($page) use ($app) {
        $data = $app->getPage($page);
		$app->view('layout',$data);
    }); 
    
 $router->post('/ajaxform/([\w-]+)', function ($formid) use ($app) {
    echo json_encode($app->processForm($formid));
 });

$router->run(); 