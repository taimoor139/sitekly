<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Custom code 
 */
$selectors = array(
'content'=>'.z-content',
);

$config = array(
'name' => 'dynamic-widget',
'label' => lang('app.dynamic-widget'),
'selector' => '.dynamic-widget',
'html'=>'<div class="sitekly-edit dynamic-widget"><div class="z-content">'.lang('app.dynamic-widget').'</div></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.content')),
    array('codemirror','settings'=>array('selector'=>$selectors['content'])),
    array('custom-button','class'=>'cmirrorUpdate','label'=>lang('app.update')),


array('[/maintab]'),
array('[maintab]'),
    array('[intab1]','label'=>lang('app.fit')),
            array('margin-top','units'=>$units['px100widget']),
            array('padding-advanced-x-y','units'=>$units['px100'],'label'=> lang('app.inner-spacing')),
    array('[intab1]','label'=>lang('app.typography')),
    array('(typography)'), 
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100']),
            array('(border)'),
            array('{shadow}','{selector}'=>""),
            array('{animation}','{selector}'=>""), 
             array('{position}'), array('{visibility}'),
array('[/maintab]'),

),
);