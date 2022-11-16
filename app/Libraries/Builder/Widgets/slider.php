<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Section slider
 */
$selectors = array(
'slides'=>'.slides',
'slide'=>'.slides .slide',
'arrows'=>'.arrow',
'innercon'=> '.slides .slide .innercon',
'z-back'=>'.z-back',
'anchor'=>'.anchor',
'z-back-after' => '.z-back:after',
);

$config = array(
'name' => 'slider',
'label' => lang('app.slider'),
'selector' => '.sitekly-block.slider',
'html'=>'<section class="sitekly-block cblock slider arrows autoplay" data-speed="3">
<div class="z-back"></div>
<a class="anchor"></a>
<a class="arrow prev">❮</a><a class="arrow next">❯</a>
<div class="slides">
<div class="slide current" style="display:block;"><div class="z-back"></div><div class="innercon"><div class="slide-content"></div></div></div>
</div>
</section>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.layout'),lang('app.style'))),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.slides')),
        array('[repeater]'),
            array('element_repeater','class'=>'protectLast','settings'=>array('controls'=>'sort,clone,delete,edit','limit'=>'30','parent'=>$selectors['slide'])),
                array('attr-by-input','label'=>lang('app.name'),'settings'=>array('iattr'=>'alt','copylabel'=>'true')),        
        array('[/repeater]'),

     array('[intab1]','label'=>lang('app.settings')),
        array('class-by-checkbox','label'=>lang('app.arrows'),'on'=>'arrows','off'=>''), 
        array('class-by-checkbox',"id"=>'isauto',"class"=>'altcons','label'=>lang('app.autoplay'),'on'=>'autoplay','off'=>''),
        array('[altcon]','class'=>'isauto autoplay'),
        array('[desc-label]','label'=>lang('app.option-disabled-in-editor')),
        array('default-slider','label'=>lang('app.duration'),'units' => array(''=> array('step'=>'1','min'=>'1','max'=>'100')),'settings'=>array('iattr'=>'data-speed','sattr'=>'val')),  
        array('[desc-label]','label'=>lang('app.time-in-seconds')),
        array('[/altcon]'),
     array('{anchor}','{selector}'=>$selectors['anchor']),      
     
array('[/maintab]'),
array('[maintab]'),
array('[element]','label'=>lang('app.slider')),
     array('[intab1]','label'=>lang('app.dimensions')),           
        array('width-slider','label'=>lang('app.inner-width'),'units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['innercon'],"iprop"=>"max-width")),
        array('height-slider','units'=>$units['vhvwpx1440']),
    array('[intab1]','label'=>lang('app.background')),
            array('{full-background}','{class-prefix}'=>'bg-','{selector}'=>$selectors['z-back']),
    array('[intab1]','label'=>lang('app.background-overlay')),
            array('{full-background}','{class-prefix}'=>'fg-','{selector}'=>$selectors['z-back-after']),
            array('opacity','settings'=>array('selector'=>$selectors['z-back-after'])),
     array('[intab1]','label'=>lang('app.background-effects')),        
            array('{scroll}','{selector}'=>$selectors['z-back']),
            array('{stretch}','{selector}'=>$selectors['z-back']),    
                   
    array('{animation}','{selector}'=>""), 
    array('{visibility}'),
  array('[element]','label'=>lang('app.arrows')), 
    array('[intab1]','label'=>lang('app.spacing')),
            array('padding-master','units'=>$units['px100'],'label'=> lang('app.inner-spacing'),'settings'=>array('selector'=>$selectors['arrows'])),
            array('margin-master-x','units'=>array('px'=> array('step'=>'1','max'=>'1000'),'%'=> array('step'=>'1','max'=>'50')),'label'=> lang('app.out-spacing'),'settings'=>array('selector'=>$selectors['arrows'])),
    array('[intab1]','label'=>lang('app.dimensions')),
			array('font-size','label'=>lang('app.size'),'units'=>$units['px300'],'settings'=>array('selector'=>$selectors['arrows'],'duplicate'=>array("iprop"=>array('width','height')))),
	array('[intab1]','label'=>lang('app.colors')),
            array('text-color','label'=>lang('app.color'),'settings'=>array('selector'=>$selectors['arrows'])),
            array('background-color','settings'=>array('selector'=>$selectors['arrows'])),
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['arrows'])),
            array('(border)','settings'=>array('selector'=>$selectors['arrows']),'input-settings'=>array('selector'=>$selectors['arrows'])),
            array('{shadow}','{selector}'=>$selectors['arrows']),
   
array('[/maintab]'),

),
);