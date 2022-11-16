<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Global items 
 */
$selectors = array(

);

$config = array(
'name' => 'site-settings',
'label' => lang('app.site-settings'),
'selector' => 'website',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.site-settings'))),

array('[maintab]'),

    array('[intab1]','label'=>lang('app.favicon')),
    array('image-src','settings'=>array()),
    
    array('[intab1]','label'=>lang('app.site-name')),
    array('attr-by-input','settings'=>array('iattr'=>'name')),
    array('default-checkbox','label'=>lang('app.add-to-title'),'settings' => array("iattr"=>"title-suffix","sattr"=>"check")),
    
array('[/maintab]'),
),
);