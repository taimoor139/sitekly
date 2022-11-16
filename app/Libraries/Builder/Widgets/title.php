<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Title
 */
$selectors = array(
'z-back'=>'.z-back',
'z-content'=>'.z-content'
);

$config = array(
'name' => 'title',
'label' => lang('app.title'),
'selector' => '.text.t',
'html'=>'<div class="sitekly-edit text t"><div class="z-back"></div><p class="z-content">'.lang('app.edtitor-title-text').'</p></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.content')),
    array('html-by-tiny','conclass'=>'full-width','class'=>'t','settings'=>array('selector'=>$selectors['z-content'])),
    array('text-type','settings'=>array('selector'=>$selectors['z-content'])),
    array('text-align','settings'=>array('selector'=>$selectors['z-content'])),

array('[/maintab]'),
array('[maintab]'),
    array('[intab1]','label'=>lang('app.spacing')),
            array('margin-top','units'=>$units['px100widget']),
    array('[intab1]','label'=>lang('app.typography')),
            array('(typography)','settings'=>array('selector'=>$selectors['z-content'])),
    array('[intab1]','label'=>lang('app.background')),
           array('background-color','settings'=>array('selector'=>$selectors['z-back'])),

    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['z-back'])),
            array('(border)','settings'=>array('selector'=>$selectors['z-back']),'input-settings'=>array('selector'=>$selectors['z-back'])),
            array('{shadow}','{selector}'=>$selectors['z-back']),
            array('{animation}','{selector}'=>""), 
             array('{position}'), array('{visibility}'),
array('[/maintab]'),

),
);