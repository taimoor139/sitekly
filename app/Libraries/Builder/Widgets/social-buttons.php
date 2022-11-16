<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Social buttons 
 */
$selectors = array(
'icon'=>'.sicon',
'a'=>'.sicon a',
'z-back'=>'.z-back',
'z-content'=>'.z-content'
);

$config = array(
'name' => 'social-buttons',
'label' => lang('app.social-buttons'),
'selector' => '.social-buttons',
'html'=>'<div class="sitekly-edit social-buttons"><div class="sicon"><a class="lab la-facebook-f"></a></div></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.content')),
    array('[repeater]'),
    array('element_repeater','class'=>'protectLast','settings'=>array('controls'=>'sort,clone,delete','limit'=>'30','parent'=>$selectors['icon'])),
    
    array('hidden-input','value'=>'','settings'=>array('selector'=>$selectors['a'],'iattr'=>'class','sattr'=>'val','customGet'=>'ignore')),
    array('class-by-select','settings'=>array('selector'=>$selectors['a'],'dependedOpt'=>'custom-icon','scope'=>'.repeater','copylabel'=>'true'),'options' => array("Facebook"=> "lab la-facebook-f","Flickr"=> "lab la-flickr","Foursquare"=> "lab la-foursquare","Github"=> "lab la-github","Instagram"=> "lab la-instagram","Linkedin"=> "lab la-linkedin-in","Medium"=> "lab la-medium","Pinterest"=> "lab la-pinterest-p","Snapchat"=> "lab la-snapchat","Tumblr"=> "lab la-tumblr","Twitter"=> "lab la-twitter","Vimeo"=> "lab la-vimeo","Youtube"=> "lab la-youtube",lang('app.other')=> "other")),
    array('icon','conclass'=>'depend custom-icon other','settings'=>array('selector'=>$selectors['a'],'onDisabled'=>'ignore')),
    array('hidden-input','conclass'=>'depend custom-icon other','value'=>'other','settings'=>array('selector'=>$selectors['a'],'special'=>'class','customGet'=>'ignore')),
    
    array('href','settings'=>array('selector'=>$selectors['a'])),
    array('[/repeater]'),
     
array('[/maintab]'),
array('[maintab]'),

    array('[element]','label'=>lang('app.box')),
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-top','units'=>$units['px100widget']),
    array('padding-advanced-x-y','units'=>$units['px100'],'label'=> lang('app.inner-spacing')),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('[multiselect]','label'=>lang('app.align-content')),
    array('justify-content-full','label'=>lang('app.horizontal')),
    array('[/multiselect]'), 
    
    
    array('{animation}','{selector}'=>""), 
     array('{position}'), array('{visibility}'),
    
    array('[element]','label'=>lang('app.icon')),
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-right','units'=>$units['px100'],'label'=> lang('app.spacing'),'settings'=>array('selector'=>$selectors['icon'])),
    array('padding-master','units'=>$units['px100'],'label'=> lang('app.inner-spacing'),'settings'=>array('selector'=>$selectors['a'])),
    
    array('[intab1]','label'=>lang('app.dimensions')),
    array('font-size','label'=>lang('app.size'),'units'=>$units['px300'],'settings'=>array('selector'=>$selectors['a'])),
    
    array('[intab1]','label'=>lang('app.colors')),
    array('text-color','label'=>lang('app.color'),'settings'=>array('selector'=>$selectors['a'])),
    array('background-color','settings'=>array('selector'=>$selectors['a'])),

    array('[intab1]','label'=>lang('app.border')),
    array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['a'])),
    array('(border)','settings'=>array('selector'=>$selectors['a']),'input-settings'=>array('selector'=>$selectors['a'])),
    array('{shadow}','{selector}'=>$selectors['a']),


array('[/maintab]'),

),
);