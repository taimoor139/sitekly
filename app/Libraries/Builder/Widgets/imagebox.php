<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Image box 
 */
$selectors = array(
'first'=>'.first',
'first-separate'=>'.incol.first',
'second'=>'.incol.second',
'img'=>'.img img',
'z-back'=>'.z-back',
't'=> '.incol .t',
'p'=> '.incol .p',

);

$config = array(
'name' => 'imagebox',
'label' => lang('app.image-box'),
'selector' => '.imgbox',
'html'=>'<div class="sitekly-edit imgbox inrow lg-left md-left sm-left xs-left"><div class="z-back"></div><a class="img incol first"><img src="'.base_url('editor/images/placeimg.gif').'"></a><div class="incol second"><a class="t">'.lang('app.edtitor-title-text').'</a><div class="p">'.lang('app.edtitor-paragraph-text').'</div></div></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.image')),
    array('image-src','settings'=>array('selector'=>$selectors['img'])),
    
    array('[intab1]','label'=>lang('app.title')),
    array('html-by-tiny','conclass'=>'full-width','class'=>'t','settings'=>array('selector'=>$selectors['t'])),
    array('href','conclass'=>'full-width','settings'=>array('selector'=>$selectors['t'])),
    array('[intab1]','label'=>lang('app.paragraph')),
    array('html-by-tiny','settings'=>array('selector'=>$selectors['p'])),

array('[/maintab]'),
array('[maintab]'),

array('[element]','label'=>lang('app.image-box')),
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-top','units'=>$units['px100widget']),
    array('padding-advanced-x-y','units'=>$units['px100'],'label'=> lang('app.inner-spacing')),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('responsive-align-class','settings'=>array("dependedOpt"=>"malign")),
    
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','settings'=>array('selector'=>$selectors['z-back'])),
    array('[intab1]','label'=>lang('app.border')),
    array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['z-back'])),
    array('(border)','settings'=>array('selector'=>$selectors['z-back']),'input-settings'=>array('selector'=>$selectors['z-back'])),
    array('{shadow}','{selector}'=>$selectors['z-back']),
    array('{animation}','{selector}'=>""), 
     array('{position}'), array('{visibility}'),
            
array('[element]','label'=>lang('app.image')),
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-master','units'=>$units['px100'],'label'=> lang('app.spacing'),'settings'=>array('selector'=>$selectors['first'])),
    
    array('[intab1]','label'=>lang('app.dimensions')),
    array('width-slider','conclass'=>'depend malign -left -right','units'=>$units['p100'],'settings'=>array('selector'=>$selectors['first'],'clonecss'=>array('selector'=>$selectors['second'],"iprop"=>"width",'action' =>'share100percent'))),
    array('width-slider','conclass'=>'depend malign -center','units'=>$units['p100'],'settings'=>array('onDisabled'=>'ignore','selector'=>$selectors['first'])),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('[multiselect]','label'=>lang('app.align-content')),
    array('justify-content','label'=>lang('app.horizontal'),'conclass'=>'depend malign -left -right','settings'=>array('selector'=>$selectors['first'])),
    array('align-self','label'=>lang('app.vertical'),'conclass'=>'depend malign -left -right','settings'=>array('selector'=>$selectors['first'])),
    array('align-self-as-x','label'=>lang('app.vertical'),'conclass'=>'depend malign -center','settings'=>array('selector'=>$selectors['first-separate'],'duplicate'=>array("iprop"=>"justify-content"))),
    array('[/multiselect]'),  
    
    array('[intab1]','label'=>lang('app.border')),
    array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['img'])),
    array('(border)','settings'=>array('selector'=>$selectors['img']),'input-settings'=>array('selector'=>$selectors['img'])),
    array('{shadow}','{selector}'=>$selectors['img']),

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