<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Inner container/column
 */
$selectors = array(
'inner'=>'.z-inner',
);

$config = array(
'name' => 'container',
'label' => lang('app.inner-column'),
'selector' => '.z-incont',
'html'=>'<div class="sitekly-edit z-incont"><div class="z-inner"></div></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.layout'),lang('app.style'))),

array('[maintab]'),
   array('[intab1]','label'=>lang('app.spacing')),
        array('margin-top','units'=>$units['px100widget']),
        array('margin-left','units'=>$units['p100px1440']),
        array('padding-advanced-x-y','units'=>$units['px100'],'label'=> lang('app.inner-spacing'),'settings'=>array('selector'=>$selectors['inner'])),
 
   array('[intab1]','label'=>lang('app.dimensions')),             
        array('height-slider','units'=>$units['p100vhvwpx1440'],'settings'=>array('selector'=>$selectors['inner'])),
         array('width-slider','units'=>$units['p100px1440'],'label'=> lang('app.width')),
   
       array('[intab1]','label'=>lang('app.alignment')),
    array('[multiselect]','label'=>lang('app.align-content')),
        array('justify-content-full','label'=>lang('app.horizontal'),'settings'=>array('selector'=>$selectors['inner'])),
        array('align-content','label'=>lang('app.vertical'),'settings'=>array('selector'=>$selectors['inner'])),    
      array('[/multiselect]'),  

    
array('[/maintab]'),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.background')),
           //array('background-color','settings'=>array('selector'=>$selectors['inner'])),
           array('(standard-background)','settings'=>array('selector'=>$selectors['inner'])),
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['inner'])),
            array('(border)','settings'=>array('selector'=>$selectors['inner']),'input-settings'=>array('selector'=>$selectors['inner'])),
            array('{shadow}','{selector}'=>$selectors['inner']),
            array('{animation}','{selector}'=>""), 
    array('{visibility}'),
array('[/maintab]'),

),
);