<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

if (! function_exists('dlog'))
{

	function dlog($m,$t='error')
	{  
	   log_message($t,$m); 
	   if(ENVIRONMENT == 'development' ){
	       echo $t.': '.$m;
	   } 
	      log_message($t,$m); 
	}
}
