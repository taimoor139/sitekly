<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Slide
 */
$selectors = array(
'innercon'=>'.innercon',
'content'=>'.innercon .slide-content',


'z-back'=>'.z-back',
'sitekly-edit'=>'useClass .innercon .slide-content .sitekly-edit',
'z-back-after' => '.z-back:after',
);

$config = array(
'name' => 'slide',
'label' => lang('app.slide'),
'selector' => '.slide',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.layout'),lang('app.style'))),

array('[maintab]'),
   array('[intab1]','label'=>lang('app.spacing')),
        array('margin-top','units'=>$units['px100widget'],'label'=> lang('app.widget-spacing'),'settings'=>array('selector'=>$selectors['sitekly-edit'])),
        array('padding-advanced','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['content'])),
        
 
   array('[intab1]','label'=>lang('app.dimensions')),             
        array('width-slider','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['content'])),
        
   array('[intab1]','label'=>lang('app.alignment')),     
        array('align-content','settings'=>array('selector'=>$selectors['innercon'])),
        array('justify-content','settings'=>array('selector'=>$selectors['innercon'])),
         array('custom-button','class'=>'endtab1 goback custom-edit','label'=>lang('app.go-back')),
array('[/maintab]'),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.background')),
            array('{full-background}','{class-prefix}'=>'bg-','{selector}'=>$selectors['z-back']),
    array('[intab1]','label'=>lang('app.background-overlay')),
            array('{full-background}','{class-prefix}'=>'fg-','{selector}'=>$selectors['z-back-after']),
            array('opacity','settings'=>array('selector'=>$selectors['z-back-after'])),
    array('[intab1]','label'=>lang('app.background-effects')),        
            array('{scroll}','{selector}'=>$selectors['z-back']),
            array('{stretch}','{selector}'=>$selectors['z-back']), 
            
    array('[intab1]','label'=>lang('app.content-background')),
            array('background-color','settings'=>array('selector'=>$selectors['content'])),
            array('custom-button','class'=>'endtab1 goback custom-edit','label'=>lang('app.go-back')),
array('[/maintab]'),

),
);