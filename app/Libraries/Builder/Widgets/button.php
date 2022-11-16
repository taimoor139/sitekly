<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Button
 */
$selectors = array(
'back'=>'.back',
'back-after'=>'.back:before',
'a' => 'a'
);

$config = array(
'name' => 'button',
'label' => lang('app.button'),
'selector' => '.btn',
'html'=>'<div class="sitekly-edit btn"><a class="back" href="/start">'.lang('app.button').'</a></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.content')),
     array('href','settings'=>array('selector'=>$selectors['a'])),
     array('text-by-input','settings'=>array('selector'=>$selectors['a'])),

    
array('[/maintab]'),
array('[maintab]'),
    
    array('[intab1]','label'=>lang('app.spacing')),
            array('margin-top','units'=>$units['px100widget']),
            array('padding-master-x','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['a'])),
            array('padding-master-y','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['a'])),
    
    array('[intab1]','label'=>lang('app.dimensions')),       
            array('width-slider','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['a'])),
    
     array('[intab1]','label'=>lang('app.alignment')),      
            array('align-no-justify'),
            
    array('[intab1]','label'=>lang('app.typography')),
            array('(typography)','settings'=>array('selector'=>$selectors['a'])),
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','settings'=>array('selector'=>$selectors['back'])),

    
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['back'])),
            array('(border)','settings'=>array('selector'=>$selectors['back']),'input-settings'=>array('selector'=>$selectors['back'])),
            array('{shadow}','{selector}'=>$selectors['back']),
            array('{animation}','{selector}'=>""), 
             array('{position}'), array('{visibility}'),
             
array('[/maintab]'),

),
);