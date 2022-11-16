<?php
/**
 * Image gallery
 */
$selectors = array(
'colover' =>'.colover',
'colcon' =>'.colover .colcon',
'imgcon'=> '.colover .colcon .imgcon',
'img'=> '.colover .colcon .imgcon .img',
);

$config = array(
'name' => 'gallery',
'label' => lang('app.gallery'),
'selector' => '.gallery',
'html'=>'<div class="gallery sitekly-edit" data-thumb="500px">
<div class="colover">
<div class="colcon">
<div class="imgcon"><div class="img" style=\'background-image: url("'.base_url('editor/images/placeimg.gif').'");\'></div></div>
</div>
</div>
</div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),

array('[maintab]'),

    array('[intab1]','label'=>lang('app.images')),
        array('[repeater]'),
            array('element_repeater','class'=>'protectLast','settings'=>array('controls'=>'sort,clone,delete','limit'=>'60','parent'=>$selectors['imgcon'])),
                array('background-image','label'=>'','controls'=>array('delete'=>false),'settings'=>array('selector'=>$selectors['img'],'copylabel'=>'true')),
                array('attr-by-input','label'=>lang('app.title'),'settings'=>array('iattr'=>'alt','selector'=>$selectors['img'])),
                array('href','settings'=>array('selector'=>$selectors['img'])),
                array('background-size','label'=>lang('app.thumbnail-size'),'settings'=>array('selector'=>$selectors['img'])),
               
             
        array('[/repeater]'),

array('[intab1]','label'=>lang('app.thumbnail')),
   array('thumb-width','label'=>lang('app.image-width'),'units' => array('px'=> array('step'=>'1','min'=>'1','max'=>'1000')),'settings' =>array("ignoreLive"=>'1')),

    array('class-by-select','label'=>lang('app.click-action'),'options' => array(lang('app.open-in-box')=> "",lang('app.open-in-tab')=> "intab",lang('app.none')=> "nofull")),
    


array('[/maintab]'),

array('[maintab]'),
array('[element]','label'=>lang('app.gallery')),
    
    array('[intab1]','label'=>lang('app.view')), 
    array('flex-columns','label'=> lang('app.images-in-row'),'units'=>array( ''=> array('step'=>'1','max'=>'10',"min"=>"1")),'settings'=>array('selector'=>$selectors['imgcon'])),
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-top','units'=>$units['px100widget']),
    array('padding-advanced-x-y','units'=>$units['px100'],'label'=> lang('app.inner-spacing'),'settings'=>array('selector'=>$selectors['colcon'])),
    array('{row-spacing}','{units}'=>$units['px100'],'{column}'=>$selectors['imgcon'],'{row}'=>$selectors['colcon']),
    array('{column-spacing}','{units}'=>$units['px100'],'{column}'=>$selectors['imgcon'],'{row}'=>$selectors['colcon']),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('[multiselect]','label'=>lang('app.align-content')),
    array('justify-content-full','label'=>lang('app.horizontal'),'settings'=>array('selector'=>$selectors['colcon'])),
    array('[/multiselect]'), 
    
    
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','settings'=>array()),
    array('[intab1]','label'=>lang('app.border')),
    array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['colover'])),
    array('(border)','settings'=>array('selector'=>$selectors['colover']),'input-settings'=>array('selector'=>$selectors['colover'])),
    array('{shadow}','{selector}'=>$selectors['colover']),	
    array('{animation}','{selector}'=>""), 	
     array('{position}'), array('{visibility}'),
array('[element]','label'=>lang('app.images')),
    
    array('[intab1]','label'=>lang('app.dimensions')),
    array('background-size','label'=>lang('app.thumbnail-size'),'settings'=>array('selector'=>$selectors['img'])),
    array('padding-bottom','label'=>lang('app.height'),'units' => array('%'=> array('step'=>'1','min'=>'1','max'=>'200')),'settings'=>array('selector'=>$selectors['img'])),
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','settings'=>array('selector'=>$selectors['img'])),
    array('[intab1]','label'=>lang('app.border')),
    array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['img'])),
    array('(border)','settings'=>array('selector'=>$selectors['img']),'input-settings'=>array('selector'=>$selectors['img'])),		
    array('{shadow}','{selector}'=>$selectors['img']),
array('[/maintab]'),
),
);