<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Icon list 
 */
$selectors = array(
'row'=>'.colover .irow',
'col'=>'.colover .irow .iconcol',
'icon'=>'.colover .irow .iconcol i',
'icon-hover'=>'.colover .irow .iconcol:hover i',
'z-back'=>'.z-back',
'text'=> '.colover .irow .iconcol span',
'text-hover'=> '.colover .irow .iconcol:hover span',

);

$config = array(
'name' => 'iconlist',
'label' => lang('app.icon-list'),
'selector' => '.iconlist',
'html'=>'<div class="sitekly-edit iconlist">
<div class="z-back"></div><div class="colover"><div class="irow"><a class="iconcol"><i class="las la-photo-video"></i><span>'.lang('app.edtitor-text-short').'</span></a></div></div></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.content')),
    array('[repeater]'),
    array('element_repeater','class'=>'protectLast','settings'=>array('controls'=>'sort,clone,delete','limit'=>'30','parent'=>$selectors['col'])),
    array('icon','settings'=>array('selector'=>$selectors['icon'],'copylabel'=>'true')),
    array('html-by-tiny','conclass'=>'full-width','class'=>'t','settings'=>array('selector'=>$selectors['text'])),
    array('href','settings'=>array('selector'=>$selectors['col'])),
    array('[/repeater]'),
     
array('[/maintab]'),
array('[maintab]'),

    array('[element]','label'=>lang('app.list')),
    
    array('[intab1]','label'=>lang('app.view')), 
    array('default-select','label'=>lang('app.view'),'options' => array(lang('app.default')=> "",lang('app.vertical')=> "100%"),'settings' => array("iprop"=>"width","sattr"=>"val",'selector'=>$selectors['col'])),

    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-top','units'=>$units['px100widget']),
    array('padding-advanced-x-y','units'=>$units['px100'],'label'=> lang('app.inner-spacing')),
    array('{column-spacing}','{units}'=>$units['px100'],'{column}'=>$selectors['col'],'{row}'=>$selectors['row']),
    array('{row-spacing}','{units}'=>$units['px100'],'{column}'=>$selectors['col'],'{row}'=>$selectors['row']),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('[multiselect]','label'=>lang('app.align-content')),
    array('justify-content-full','label'=>lang('app.horizontal'),'settings'=>array('selector'=>$selectors['row'],'clonecss'=>array('selector'=>$selectors['col'],'iprop'=>'justify-content'))),
    array('[/multiselect]'),
    

    
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
    array('padding-master','units'=>$units['px100'],'label'=> lang('app.inner-spacing'),'settings'=>array('selector'=>$selectors['icon'])),
    
    array('[intab1]','label'=>lang('app.dimensions')),
    array('font-size','label'=>lang('app.size'),'units'=>$units['px300'],'settings'=>array('selector'=>$selectors['icon'])),

    array('[intab1]','label'=>lang('app.colors')), 
    array('text-color','label'=>lang('app.color'),'parentHover'=>$selectors['icon-hover'],'settings'=>array('selector'=>$selectors['icon'])),
    array('background-color','parentHover'=>$selectors['icon-hover'],'settings'=>array('selector'=>$selectors['icon'])),
    
    array('[intab1]','label'=>lang('app.border')),
    array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['icon'])),
    array('(border)','settings'=>array('selector'=>$selectors['icon']),'input-settings'=>array('selector'=>$selectors['icon'])),
    array('{shadow}','{selector}'=>$selectors['icon']),
    
    array('[element]','label'=>lang('app.text')),    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-left','units'=>$units['px100'],'label'=> lang('app.spacing'),'settings'=>array('selector'=>$selectors['text'])),
    array('[intab1]','label'=>lang('app.typography')),
    array('(typography)','parentHover'=>$selectors['text-hover'],'settings'=>array('selector'=>$selectors['text'])), 

array('[/maintab]'),

),
);