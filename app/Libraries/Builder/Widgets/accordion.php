<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Accordion
 */
$selectors = array(
'item' =>'.items .item',
'head' =>'.items .item .head',
'title' =>'.items .item .head .title',
'icon' =>'.items .item .head i',
'body' =>'.items .item .body'
);

$config = array(
'name' => 'accordion',
'label' => lang('app.accordion'),
'selector' => '.accordion',
'html'=>'<div class="accordion sitekly-edit angle-left"><div class="items"><div class="item"><div class="head"><h6 class="title">'.lang('app.edtitor-title-text').'</h6><i class="icon las"></i></div><div class="body" style="display: none;">'.lang('app.edtitor-paragraph-text').'</div></div></div></div>',

'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),

array('[maintab]'),

    array('[intab1]','label'=>lang('app.items')),
        array('[repeater]'),
            array('element_repeater','class'=>'protectLast','settings'=>array('controls'=>'sort,clone,delete','parent'=>$selectors['item'])),
            array('text-type','settings'=>array('selector'=>$selectors['title'])),
               // array('attr-by-input','conclass'=>'full-width','label'=>lang('app.title'),'settings'=>array('iattr'=>'text','selector'=>$selectors['title'],'copylabel'=>'true')),
                array('html-by-tiny','conclass'=>'full-width','class'=>'t','label'=>lang('app.title'),'settings'=>array('selector'=>$selectors['title'],'copylabel'=>'true')),
                array('html-by-tiny','label'=>lang('app.content'),'settings'=>array('selector'=>$selectors['body'])),
        array('[/repeater]'),
    array('[intab1]','label'=>lang('app.icon')),
            array('class-by-select','label'=>lang('app.type'),'options' => array(lang('app.none')=> "none",lang('app.plus')=> "plus",lang('app.angle-left')=> "angle-left",lang('app.angle-right')=> "angle-right")),
             array('class-by-select','label'=>lang('app.position'),'options' => array(lang('app.right')=> "",lang('app.left')=> "left")),
    
    array('[intab1]','label'=>lang('app.settings')),
        array('class-by-select','label'=>lang('app.initial'),'class'=>'iniopt','options' => array(lang('app.collapsed')=> "",lang('app.expanded')=> "expand")),
        array('class-by-select','label'=>lang('app.expanded'),'class'=>'expopt','options' => array(lang('app.one')=> "",lang('app.unlimited')=> "unhide")),
    
array('[/maintab]'),

array('[maintab]'),

array('[element]','label'=>lang('app.box')),
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-top','units'=>$units['px100widget']),
    array('{animation}','{selector}'=>""), 
     array('{position}'), array('{visibility}'),
array('[element]','label'=>lang('app.item')),
    array('[intab1]','label'=>lang('app.spacing')),    
    array('margin-bottom','label'=>lang('app.spacing'),'units'=>$units['px100'],'settings'=>array('selector'=>$selectors['item'])),
    array('[intab1]','label'=>lang('app.border')),
    array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['item'])),
    array('(border)','settings'=>array('selector'=>$selectors['item']),'input-settings'=>array('selector'=>$selectors['item'])),
    array('{shadow}','{selector}'=>$selectors['item']),
    

array('[element]','label'=>lang('app.title')),    
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('padding-master-x','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['title'])),
    array('padding-master-y','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['title'])),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('text-align','settings'=>array('selector'=>$selectors['title'])),
    
    array('[intab1]','label'=>lang('app.typography')),
    array('(typography)','settings'=>array('selector'=>$selectors['title'])), 
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','settings'=>array('selector'=>$selectors['head'])),
    array('[intab1]','label'=>lang('app.border')),
    array('(border-bottom)','settings'=>array('selector'=>$selectors['head']),'input-settings'=>array('selector'=>$selectors['head'])),
    
array('[element]','label'=>lang('app.content')),    
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('padding-master-x','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['body'])),
    array('padding-master-y','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['body'])),
    
    array('[intab1]','label'=>lang('app.dimensions')),
    array('height-slider','units'=>$units['px1000'],'settings'=>array('selector'=>$selectors['body'],"iprop"=>"height")),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('text-align','settings'=>array('selector'=>$selectors['body'])),
    
    array('[intab1]','label'=>lang('app.typography')),
    array('(typography)','settings'=>array('selector'=>$selectors['body'])), 
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','settings'=>array('selector'=>$selectors['body'])),
    
array('[element]','label'=>lang('app.icon')), 
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('padding-master-x','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['icon'])),
    
    array('[intab1]','label'=>lang('app.dimensions')),
    array('font-size','label'=>lang('app.size'),'units'=>$units['px100'],'settings'=>array('selector'=>$selectors['icon'])),

    array('[intab1]','label'=>lang('app.colors')),
    array('text-color','label'=>lang('app.color'),'settings'=>array('selector'=>$selectors['icon'])),
    array('background-color','settings'=>array('selector'=>$selectors['icon'])),
 
                    
array('[/maintab]'),
),
);