<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Paragraph
 */
$selectors = array(
'vidcon'=>'.vidcon',
'vidcon-before'=>'.vidcon:before',
'frame'=>'.vidcon iframe'
);

$config = array(
'name' => 'video',
'label' => lang('app.video'),
'selector' => '.video',
'html'=>'<div class="video sitekly-edit" data-href="https://vimeo.com/groups/freehd/videos/20890937" data-auto="0" data-mute="0" data-controls="1" data-loop="0" data-background="0" data-start="" data-end=""><div class="vidcon" style=\'background-image: url("https://i.vimeocdn.com/video/133933568_295x166.jpg");\'></div></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.content')),
    array('default-input','conclass'=>'full-width','label'=>lang('app.video-url'),'settings'=>array('iattr'=>'data-href','sattr'=>'val')),

    array('[desc-label]','label'=>lang('app.youtube-or-vimeo')),
    array('image-src','label'=>lang('app.custom-thumb'),'controls'=>array('info'=>true,'delete'=>true),'settings'=>array('iattr'=>'data-cthumb')),
    array('default-checkbox','class'=>'auto','label'=>lang('app.autoplay'),'settings'=>array('iattr'=>'data-auto','sattr'=>'check')),
    array('default-checkbox','class'=>'mute','label'=>lang('app.mute'),'settings'=>array('iattr'=>'data-mute','sattr'=>'check')),
   
    array('[altcon]','class'=>'vtype yt'),
    array('default-input','itype'=>'number','label'=>lang('app.start-time'),'settings'=>array('iattr'=>'data-start','sattr'=>'val')),
    array('default-input','itype'=>'number','label'=>lang('app.end-time'),'settings'=>array('iattr'=>'data-end','sattr'=>'val')),
    array('[/altcon]'),
    
    array('[altcon]','class'=>'vtype vim'),
    array('default-checkbox','label'=>lang('app.controls'),'settings'=>array('iattr'=>'data-controls','sattr'=>'check')),
    array('default-checkbox','label'=>lang('app.loop'),'settings'=>array('iattr'=>'data-loop','sattr'=>'check')),
    array('default-checkbox','label'=>lang('app.background'),'settings'=>array('iattr'=>'data-background','sattr'=>'check')),
    array('[/altcon]'),
    array('hidden-input','class'=>'altcons',"id"=>'vtype','settings'=>array('customSet'=>'vidtypes','customGet'=>'vidtype')),


array('[/maintab]'),
array('[maintab]'),
    
    array('[intab1]','label'=>lang('app.spacing')),
            array('margin-top','units'=>$units['px100widget']),
    
     array('[intab1]','label'=>lang('app.dimensions')),      
            array('width-slider','units'=>$units['p100vhvwpx1440'],'settings'=>array('selector'=>$selectors['vidcon'])),
            array('video-aspect-ratio','settings'=>array('selector'=>$selectors['vidcon-before'])),
    
     array('[intab1]','label'=>lang('app.alignment')),       
            array('align-no-justify'),

    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['vidcon'])),
            array('(border)','settings'=>array('selector'=>$selectors['vidcon']),'input-settings'=>array('selector'=>$selectors['vidcon'])),
            array('{shadow}','{selector}'=>$selectors['vidcon']),
            array('{animation}','{selector}'=>""), 
             array('{position}'), array('{visibility}'),
array('[/maintab]'),

),
);