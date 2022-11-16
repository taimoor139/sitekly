<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Menu 
 */
$selectors = array(
'sub-ul' => 'ul.subnav',
'link' => 'li',
'link-a' => 'li a'
);

$config = array(
'name' => 'menu-manage',
'label' => lang('app.menu-links'),
'selector' => 'menu',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'))),
  
array('[maintab]'),

array('[intab1]','label'=>lang('app.links')),
        array('[repeater]'),
            array('element_repeater','deleteConfirm'=>'','settings'=>array('controls'=>'multisort,delete','parent'=>$selectors['link'],'subparent'=>$selectors['sub-ul'])),
            array('text-by-input','label'=> lang('app.label'),'class'=>'label','settings'=>array('selector'=>$selectors['link-a'],'copylabel'=>'true')),
            array('hidden-input','class'=>'linkid','settings'=>array('iattr'=>'id','sattr'=>'val')),
            array('attr-by-input','label'=> lang('app.link'),'class'=>'linkhref','settings'=>array('iattr'=>'href','selector'=>$selectors['link-a'],'customGet'=>'menuLinkHref')),
        array('[/repeater]'),
        array('[intab2]','label'=>lang('app.add-new')), 
    array('custom-select',"id"=>'linkType',"class"=>'altcons','label'=>lang('app.choose-page'),'settings'=>array('customGet'=>'menuPagesAddList','customSet'=>'ignore')),
    array('[altcon]','class'=>'linkType customLink'),
    array('custom-input','class'=>'ownlink','label'=>lang('app.url')),
    array('[/altcon]'),
    array('custom-button','class'=>'addToMenu','label'=>lang('app.add-link')),
    array('custom-button','class'=>'endtab1 goback custom-edit','label'=>lang('app.go-back')),
array('[/maintab]'),

),
);