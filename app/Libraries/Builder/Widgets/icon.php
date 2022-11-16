<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Icon 
 */
$selectors = array(
'a'=>'a',
'z-back'=>'.z-back',
'z-content'=>'.z-content'
);

$config = array(
'name' => 'icon',
'label' => lang('app.icon'),
'selector' => '.icon',
'html'=>'<div class="sitekly-edit icon"><a class="las la-edit"></a></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.content')),
    array('icon','settings'=>array('selector'=>$selectors['a'])),
    array('href','settings'=>array('selector'=>$selectors['a'])),

array('[/maintab]'),
array('[maintab]'),
    array('[intab1]','label'=>lang('app.spacing')),
            array('margin-top','units'=>$units['px100widget']),
            array('padding-advanced-x-y','units'=>$units['px100'],'label'=> lang('app.inner-spacing'),'settings'=>array('selector'=>$selectors['a'])),
    array('[intab1]','label'=>lang('app.dimensions')),         
            array('font-size','label'=>lang('app.size'),'units'=>$units['px300'],'settings'=>array('selector'=>$selectors['a'],'duplicate'=>array("iprop"=>array('width','height')))),
            
    array('[intab1]','label'=>lang('app.alignment')),        
            array('align-no-justify'),
   array('[intab1]','label'=>lang('app.colors')),          
            array('text-color','label'=>lang('app.color'),'settings'=>array('selector'=>$selectors['a'])),
            array('background-color','settings'=>array('selector'=>$selectors['a'])),

    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['a'])),
            array('(border)','settings'=>array('selector'=>$selectors['a']),'input-settings'=>array('selector'=>$selectors['a'])),
            array('{shadow}','{selector}'=>$selectors['a']),
            array('{animation}','{selector}'=>""), 
             array('{position}'), array('{visibility}'),
array('[/maintab]'),

),
);