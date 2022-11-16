<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Location map
 */
$selectors = array(
'mapcon'=>'.mapcon',
'mapcon-before'=>'.mapcon:before',
'frame'=>'.mapcon iframe'
);

$config = array(
'name' => 'map',
'label' => lang('app.map'),
'selector' => '.gmap',
'html'=>'<div class="gmap sitekly-edit"><div class="mapcon"><iframe src="https://maps.google.com/maps?q=zamieście 5050&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div></div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.settings')),
    array('default-input','conclass'=>'full-width','label'=>lang('app.location'),'settings'=>array('iattr'=>'data-location','sattr'=>'val')),
    array('default-checkbox','label'=>lang('app.satellite'),'on'=>'k','off'=>'','settings'=>array('iattr'=>'data-sat','sattr'=>'check')),
    array('default-slider','label'=>lang('app.zoom'),'units' => array(''=> array('step'=>'1','min'=>'1','max'=>'20')),'settings'=>array('iattr'=>'data-zoom','sattr'=>'val')),

  array('hidden-input','settings'=>array('customSet'=>'mapUpdate','customGet'=>'ignore','selector'=>$selectors['frame'])),


array('[/maintab]'),
array('[maintab]'),
    array('[intab1]','label'=>lang('app.spacing')),
            array('margin-top','units'=>$units['px100widget']),
    
     array('[intab1]','label'=>lang('app.dimensions')),       
            array('height-slider','units'=>$units['px1440vhvw'],'settings'=>array('selector'=>$selectors['frame'])),
            array('width-slider','units'=>$units['p100vhvwpx1440'],'settings'=>array('selector'=>$selectors['mapcon'])),
    
     array('[intab1]','label'=>lang('app.alignment')),      
            array('align-no-justify'),

    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['frame'])),
            array('(border)','settings'=>array('selector'=>$selectors['mapcon']),'input-settings'=>array('selector'=>$selectors['mapcon'])),
            array('{shadow}','{selector}'=>$selectors['mapcon']),
            array('{animation}','{selector}'=>""), 
             array('{position}'), array('{visibility}'),
array('[/maintab]'),

),
);