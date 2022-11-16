<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

if (! function_exists('newModel'))
{

	function newModel($class)
	{  
       $class = getItem('Models',$class);
       return new $class;
	}
 }
 
 if (! function_exists('newLib'))
{   
    	function newLib($class)
	{  
	   $class = getItem('Libraries',$class);
       return new $class;
	}
}

 if (! function_exists('getView'))
{   
    function getView($path, $data = [], $options = []){
        
      $view = getItem('Views',$path);
      return view($view,$data,$options);

    }
}

 if (! function_exists('getItem')){ 
    function getItem($type,$item){
 	  
      $path = explode('/',$item);
      $file = array_pop($path);
      $path = count($path)> 0 ? implode('/',$path).'/' : ''; 
      
      $lib = file_exists(APPPATH.$type.'/'.$path.'_'.$file.'.php') ? '_'.$file : $file;
      if($type == 'View'){
        return $path.'/'.$file;
      }

      $path = str_replace('/',"\\",$path);
      $class = "\\App\\".$type."\\".$path.$lib;

      return $class;
    }
}

 if (! function_exists('namedRoute')){ 
    function namedRoute($path){
        
        $dashboard_methods = get_class_methods('\App\Controllers\Dashboard\Dashboard');
        
        $path = explode('/',trim($path,'/'));

       if($path[0] == 'admin' && count($path) > 1 || $path[0] == 'dashboard' && count($path) > 1 && !in_array($path[1],$dashboard_methods)){
        $path[0] .= '-'.$path[1];
        unset($path[1]);
        }
        $path[0] .= str_repeat('/',count($path)-1);
       
        return base_url(call_user_func_array("route_to", $path));
    }
 }
 
  if (! function_exists('namedRedirect')){ 
    function namedRedirect($path){
       return redirect()->to(namedRoute($path)); 
    }
 }
 
   if (! function_exists('base_url_versioned')){ 
    function base_url_versioned($path,$base = false){
        $file = getcwd().'/'.$path;
        $path .= '?v='.hash('crc32',  @filemtime($file));
        if($base) return $base.$path;
            
       return base_url($path);
    }
 }