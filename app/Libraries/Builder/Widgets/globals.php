<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Global items 
 */
$selectors = array(
'item' => '.z-elad',
'label' => '.label'
);

$config = array(
'name' => 'globals',
'label' => lang('app.globals'),
'selector' => '.z-addel-con',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.global-elements'))),

array('[maintab]'),

    array('[intab1]','label'=>lang('app.elements')),
        array('[repeater]'),
            array('element_repeater','deleteConfirm'=>lang('app.global-delete-confirm'),'settings'=>array('controls'=>'sort,delete','parent'=>$selectors['item'])),
            array('text-by-input','label'=> lang('app.label'),'settings'=>array('selector'=>$selectors['label'],'copylabel'=>'true')),
            
        array('[/repeater]'),
        //show hide labels on/off switcher
array('[/maintab]'),
),
);