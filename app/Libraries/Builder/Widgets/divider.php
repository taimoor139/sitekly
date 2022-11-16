<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Divider 
 */
$selectors = array(
'line'=>'.line',
);

$config = array(
'name' => 'divider',
'label' => lang('app.divider'),
'selector' => '.divider',
'html'=>'<div class="sitekly-edit divider"><div class="line"></div></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.style'))),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.spacing')),
            array('margin-top','units'=>$units['px100widget']),
    array('[intab1]','label'=>lang('app.dimensions')),        
            array('width-slider','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['line'])),
    array('[intab1]','label'=>lang('app.alignment')),       
            array('align-no-justify'),

    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['line'])),
            array('(border-top)','hidehover'=>'true','settings'=>array('selector'=>$selectors['line']),'input-settings'=>array('selector'=>$selectors['line'])),
            array('{shadow}','{selector}'=>$selectors['line'],'{hidehover}'=>'true'),
            array('{animation}','{selector}'=>""), 
             array('{position}'), 
             array('{visibility}'),
array('[/maintab]'),

),
);