<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Icon box 
 */
$selectors = array(
'first'=>'.first',
'first-separate'=>'.incol.first',
'i'=>'.first i',
'z-back'=>'.z-back',
't'=> '.incol .t',
'p'=> '.incol .p',

);

$config = array(
'name' => 'iconbox',
'label' => lang('app.icon-box'),
'selector' => '.iconbox',
'html'=>'<div class="sitekly-edit iconbox inrow lg-left md-left sm-left xs-left">
<div class="z-back"></div><a class="incol first"><i class="las la-photo-video"></i></a><div class="incol"><a class="t" href="">'.lang('app.edtitor-title-text').'</a><div class="p">'.lang('app.edtitor-paragraph-text').'</div></div></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.icon')),
    array('icon','settings'=>array('selector'=>$selectors['i'])),
    array('href','settings'=>array('selector'=>$selectors['first'])),
    array('[intab1]','label'=>lang('app.title')),
    array('html-by-tiny','conclass'=>'full-width','class'=>'t','settings'=>array('selector'=>$selectors['t'])),
    array('href','settings'=>array('selector'=>$selectors['t'])),
    array('[intab1]','label'=>lang('app.paragraph')),
    array('html-by-tiny','settings'=>array('selector'=>$selectors['p'])),

array('[/maintab]'),
array('[maintab]'),

array('[element]','label'=>lang('app.icon-box')),
    
    array('[intab1]','label'=>lang('app.view')),
    array('responsive-align-class','settings'=>array("dependedOpt"=>"malign")),
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-top','units'=>$units['px100widget']),
  //  array('padding-master','units'=>$units['px100'],'label'=> lang('app.inner-spacing')),
    
    array('padding-advanced-x-y','label'=> lang('app.in-spacing'),'units'=>$units['px100']),
    
    
    
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','settings'=>array('selector'=>$selectors['z-back'])),
    array('[intab1]','label'=>lang('app.border')),
    array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['z-back'])),
    array('(border)','settings'=>array('selector'=>$selectors['z-back']),'input-settings'=>array('selector'=>$selectors['z-back'])),
    array('{shadow}','{selector}'=>$selectors['z-back']),
    array('{animation}','{selector}'=>""), 
    
     array('{position}'), array('{visibility}'),

array('[element]','label'=>lang('app.icon')),
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-master','units'=>$units['px100'],'label'=> lang('app.spacing'),'settings'=>array('selector'=>$selectors['first'])),
    array('padding-master','units'=>$units['px100'],'label'=> lang('app.inner-spacing'),'settings'=>array('selector'=>$selectors['i'])),
    
    array('[intab1]','label'=>lang('app.dimensions')), 
    array('font-size','label'=>lang('app.size'),'units'=>$units['px300'],'settings'=>array('selector'=>$selectors['i'],'duplicate'=>array("iprop"=>array('width','height')))),

    array('[intab1]','label'=>lang('app.alignment')),
    array('align-self','conclass'=>'depend malign -left -right','settings'=>array('selector'=>$selectors['first'])),
    array('align-self-as-x','conclass'=>'depend malign -center','settings'=>array('selector'=>$selectors['first-separate'],'duplicate'=>array("iprop"=>"justify-content"))),
    
    array('[intab1]','label'=>lang('app.colors')), 
    array('text-color','label'=>lang('app.color'),'settings'=>array('selector'=>$selectors['i'])),
    array('background-color','settings'=>array('selector'=>$selectors['i'])),
    
    array('[intab1]','label'=>lang('app.border')),
    array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['i'])),
    array('(border)','settings'=>array('selector'=>$selectors['i']),'input-settings'=>array('selector'=>$selectors['i'])),
    array('{shadow}','{selector}'=>$selectors['i']),

array('[element]','label'=>lang('app.title')),    
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-top','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['t'])),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('text-align','settings'=>array('selector'=>$selectors['t'])),
    
    array('[intab1]','label'=>lang('app.typography')),
    array('(typography)','settings'=>array('selector'=>$selectors['t'])), 
    
array('[element]','label'=>lang('app.paragraph')),    
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-top','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['p'])),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('text-align','settings'=>array('selector'=>$selectors['p'])),
    
    array('[intab1]','label'=>lang('app.typography')),
    array('(typography)','settings'=>array('selector'=>$selectors['p'])),                      
array('[/maintab]'),

),
);