<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Image 
 */
$selectors = array(
'a'=>'a',
'img'=>'a img',
'z-back'=>'.z-back',
'z-content'=>'.z-content'
);

$config = array(
'name' => 'img',
'label' => lang('app.image'),
'selector' => '.img',
'html'=>'<div class="sitekly-edit img"><a><img src="'.base_url('editor/images/placeimg.gif').'"></a></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.content')),
    array('image-src','settings'=>array('selector'=>$selectors['img'])),
    
    array('href','settings'=>array('selector'=>$selectors['a'])),
    array('alt','settings'=>array('selector'=>$selectors['img'])),

array('[/maintab]'),
array('[maintab]'),
    array('[intab1]','label'=>lang('app.spacing')),
            array('margin-top','units'=>$units['px100widget']),
            
            array('[intab1]','label'=>lang('app.dimensions')),
            array('width-slider','units'=>$units['px400p100'],'settings'=>array('selector'=>$selectors['img'])), 
            
            array('[intab1]','label'=>lang('app.alignment')),
            array('text-align-no-justify'),

    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['img'])),
            array('(border)','settings'=>array('selector'=>$selectors['img']),'input-settings'=>array('selector'=>$selectors['img'])),
            array('{shadow}','{selector}'=>$selectors['img']),
            array('{animation}','{selector}'=>""), 
             array('{position}'), array('{visibility}'),
array('[/maintab]'),

),
);