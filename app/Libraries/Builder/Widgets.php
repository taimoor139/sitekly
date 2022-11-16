<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Builder;

class Widgets {
public $data;

public $widgets_config = array();
public $widget_controls = array();

function __construct(){
    
    include dirname(__FILE__).'/WidgetControls.php';
    $this->widget_controls = $controls;
    
    foreach (glob(dirname(__FILE__)."/Widgets/*.php") as $filename) {
    include $filename;
    if(!isset($config)){
        echo $filename;
    }
    if(is_array($config)){ 
     $this->widgets_config[$config['name']] = $config;     
    }
    unset($config);
    }
    
    }
    
function build($fieldname,$config){
        if(substr( $fieldname, 0, 1 ) === "["){
        $this->containers($fieldname,$config);  
        } 
        else if(substr( $fieldname, 0, 1 ) === "("){
        foreach($this->widget_controls[$fieldname] as $subfield => $fdata){
            if(!is_array($fdata)){
             $subfield = $fdata; 
             unset($fdata);  
            }
            
            if(isset($config[$subfield]) && is_array($config[$subfield])){
            $data = array_replace_recursive($config, $config[$subfield]); 
               
               if(isset($fdata)){
                $data = array_replace_recursive($data, $fdata);     
                }
                   
             $this->build($subfield,$data); 
            } else {
                if(isset($fdata)){
                $data = array_replace_recursive($config, $fdata);     
                } else{
                  $data = $config;  
                }
                $this->build($subfield,$data); 
            }      
        }
        
        } 
        else if(substr( $fieldname, 0, 1 ) === "{"){
        $confing = $this->widget_controls[$fieldname];
        foreach($this->widget_controls[$fieldname] as $subfield){
        $fieldname = $subfield[0];
        unset($subfield[0]);
        $sconfig = $subfield; 
        $sconfig = $this->reqrep($sconfig,$config);
        
        $this->build($fieldname,$sconfig);        
       }  
        
        } 
        else if(isset($this->widget_controls[$fieldname])){
            
            $data = array_replace_recursive($this->widget_controls[$fieldname], $config);
            $this->data = $data;
            $method = $data['type'];
            
            $this->$method(); 
        }  
    
   
    
}
function reqrep($config,$mconfig){
    $new_config = array();
    foreach($config as $key => $value)
    {
        if (is_array($value))
        {
            
           unset($config[$key]);
           $new_config[$key] = $this->reqrep($value,$mconfig);
        }
        else
        { 
            foreach($mconfig as $mc=>$mcv){
 
         
        if($value == $mc){
            $value = $mcv;
        } else{
            
          // temp check
            if(!is_array($mcv) && !is_array($value)){
            
            
           $value = str_replace($mc,$mcv,$value);  
           }
        } 

               
            }
            $new_config[$key] = $value;
            unset($config[$key]);
        }
    }

    return $new_config;
}
function buildAll(){
 
  foreach($this->widgets_config as $widgetname => $widget){
  $widget['after-hide'] = isset($widget['after-hide']) ? $widget['after-hide'] : "";  
echo '<div class="wcontrol init" data-selector="'.$widget['selector'].'" data-label="'.$widget['label'].'" data-after-hide="'.$widget['after-hide'].'" id="'.$widgetname.'">';

foreach($widget['controls'] as $field){
    
$fieldname = $field[0];
unset($field[0]);
$config = $field; 
   
$this->build($fieldname,$config);        
}
echo '</div>';  
    
  }
    
}

function setUnits(){
$active = (count($this->data['units']) == 1) ? "active" : "";    
$units ='';
foreach($this->data['units'] as $k=>$unit){
$unit['min'] = isset($unit['min']) ? $unit['min'] : "0";
$units .= '<span class="'.$active.'" step="'.$unit['step'].'" suffix="'.$k.'" max="'.$unit['max'].'" min="'.$unit['min'].'">'.$k.'</span>';
}
return $units;    
}
function defaultRange(){  
foreach($this->data['units'] as $k=>$unit){
$unit['min'] = isset($unit['min']) ? $unit['min'] : "0";
$unit['init'] = isset($unit['init']) ? $unit['init'] : "0";
return 'step="'.$unit['step'].'" suffix="'.$k.'" max="'.$unit['max'].'" min="'.$unit['min'].'"'.'init="'.$unit['init'].'"';
}
   
}

function setSettings($settings = false, $nohide=false,$index=false){
 if(!$settings){
  $settings = $this->data['settings'];  
 }
 
 $data['default'] = $settings; 
 $data['default']['show'] = isset($data['default']['show']) ? $data['default']['show'] : "";
 if($nohide || $data['default']['show'] != '0'){ 
 $data['default']['show'] = '1';
 } else {
    $data['default']['show'] = '0';
 }
 
return 'data-settings="'.htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8').'"';    
}

function slider_input(){ 
?>
<div class="psg slider-inp pbox <?php echo ifset($this->data["conclass"]) ?>">
<div class="numgroup-top">
<label class="z-inp-label"><?php echo ifset($this->data["label"])?></label>
<div class="numgroup-unit">
<?php echo $this->setUnits() ?>
</div>
</div>

<div class="slider-con inpcon">

<div class="z-popslider">
<div class="z-popline"></div>
<div class="z-popslide ui-slider-handle"></div>
</div>

<input class="z-pop-inp prop sliinp <?php echo ifset($this->data["class"]) ?>" id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
<?php echo $this->defaultRange() ?>
type="number" />
</div>

</div>    
<?php    
}

function input(){
$hidden = isset($this->data["hidden"]) ? 'hidden' : '';   
$readonly = isset($this->data["readonly"]) ? 'readonly="true"' : '';   
    ?>
    <div class="psg inline-psg <?php echo $hidden ?> <?php echo ifset($this->data["conclass"]) ?>">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>
<input class="z-pop-inp prop <?php echo ifset($this->data["class"]) ?>" value="<?php echo ifset($this->data["value"]) ?>" type="<?php echo ifset($this->data["itype"]) ?>" <?php echo $readonly ?> id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
/>
</div>
    <?php
}
function tinymce(){   
    ?>
    <div class="psg inline-psg full-width <?php echo ifset($this->data["conclass"]) ?>">
    
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>
<div class="cpicker tiny"></div>
<input class="z-pop-inp prop tiny <?php echo ifset($this->data["class"]) ?>" value="<?php echo ifset($this->data["value"]) ?>" type="hidden" id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
/>
<div class="tiny-preview"></div>
</div>
    <?php
}
function codeHighlight(){   
    ?>
    <div class="psg inline-psg full-width <?php echo ifset($this->data["conclass"]) ?>">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>
<input class="z-pop-inp prop code <?php echo ifset($this->data["class"]) ?>" value="<?php echo ifset($this->data["value"]) ?>" type="hidden" id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
/>
<pre><code class="language-html"></code></pre>
</div>
    <?php
}
function checkbox(){
$hidden = isset($this->data["hidden"]) ? 'hidden' : '';    
    ?>
    <div class="psg inline-psg <?php echo $hidden ?> <?php echo ifset($this->data["conclass"]) ?>">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>

<input class="z-pop-inp prop checker <?php echo ifset($this->data["class"]) ?>" type="checkbox"  data-on="<?php echo ifset($this->data["on"]) ?>" data-off="<?php echo ifset($this->data["off"]) ?>" id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
/>
</div>
    <?php
}
function textarea(){
    ?>
    <div class="psg inline-psg <?php echo ifset($this->data["conclass"]) ?>">
<?php if($this->data["label"]){ ?>
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>
<?php } ?>
<textarea placeholder="<?php echo ifset($this->data["placeholder"]) ?>" class="z-pop-inp prop <?php echo ifset($this->data["class"]) ?>" id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
><?php echo ifset($this->data["value"]) ?></textarea>
</div>
    <?php
}
function select(){
    ?>
    <div class="psg inline-psg <?php echo ifset($this->data["conclass"]) ?>">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>
<select class="z-pop-inp prop <?php echo ifset($this->data["class"]) ?>" id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
>
<?php 
if(isset($this->data["options"])){
    foreach($this->data["options"] as $k => $v){ 
    echo '<option value="'.$v.'">'.$k.'</option>';
    } 
}
?>

</select>
</div>
    <?php
}

function iconSelect(){
    ?>
    <div class="psg inline-psg <?php echo ifset($this->data["conclass"]) ?>">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>

<div class="z-pop-inp icon-select-con prop <?php echo ifset($this->data["class"]) ?>" id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
>
<?php 
if(isset($this->data["options"])){
    foreach($this->data["options"] as $k => $v){ 
    echo '<div class="icon-select" alt="'.$k.'" id="'.$v.'"></div>';
    } 
}
?>
</div>
</div>
    <?php
}

function color(){
 if(!isset($this->data['hidehover']) || $this->data['hidehover'] != "true"){
    $this->data['hidehover'] = 'true';
  return $this->double_color();  
 }   
    ?>
    <div class="psg inline-psg <?php echo ifset($this->data["conclass"]) ?>">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>
<div class="blank-con">
<div class="cpicker estb prop <?php echo ifset($this->data["class"]).ifset($this->data["isfirst"]) ?>" id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
></div>
</div>
</div>
    <?php
}

function double_color(){
    $this->containers('[inlinecon]',array('class'=>"double-color ".ifset($this->data["inlineconclass"])));
$this->containers('[main-label]',array('label'=>$this->data["label"]));
$this->data["label"] = isset($this->data["sublabel1"]) ? $this->data["sublabel1"] : lang('app.normal');
$this->data["isfirst"] =' first';
$this->color();
$this->data["label"] = isset($this->data["sublabel2"]) ? $this->data["sublabel2"] : lang('app.hover');
ifset($this->data["settings"]['selector']);
if(substr($this->data["settings"]['selector'], -7) === ".z-back" || substr($this->data["settings"]['selector'], -13) === ".z-back:after" || in_array('widgetHover',$this->data)){
   
$this->data["settings"]['selector'] = ':hover '.$this->data["settings"]['selector'];  
} else if(isset($this->data['parentHover'])){
$this->data["settings"]['selector'] = $this->data['parentHover'];
} else{
$this->data["settings"]['selector'] .= ':hover';
}
$this->data["isfirst"] ='';
$this->color();
  $this->containers('[/inlinecon]',array());

}
function color_palette(){
      ?>
    <div class="psg">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>
<div class="prop" style="display: none;" id='<?php echo ifset($this->data["id"]) ?>'
<?php echo $this->setSettings() ?>
></div>
<div class="palette-con">

</div>
</div>
    <?php  
}

function connected_inputs(){
    ?>
    <div class="vspacont pbox <?php echo ifset($this->data["conclass"]) ?>">
<div class="numgroup-top">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>
<div class="numgroup-unit"><?php echo $this->setUnits() ?></div>
</div>

<div class="numgroup inpcon">

<?php 
$i = 0;
foreach($this->data['settings']['inputs'] as $k=>$input){
$iid = (isset($this->data['inputids'][$i])) ? $this->data['inputids'][$i] : "";
if(isset($this->data['settings']['selector'])){
 $input['selector'] =  $this->data['settings']['selector'];  
}
if(isset($this->data['input-settings']) && is_array($this->data['input-settings'])){
$input = array_replace_recursive($input, $this->data['input-settings']);
}
   
?>
<div class="psg vspa">
<input class="z-pop-inp prop" id="<?php echo $iid ?>" 
<?php echo $this->setSettings($input,false,$i) ?>
<?php echo $this->defaultRange() ?>
type="number" />
<span class="smal-lab"><?php echo $input['label']; ?></span>
</div>
<?php
$i++;    
}
?>

<input class="prop special" 
data-settings='{"default":{"special":"valcon1","show":"1"}}'
<?php //echo $this->setSettings($this->data['settings']['connect'],true) ?>
type="hidden" />

<div class="psg vspa linked">
<i class="fas fa-link"></i>
<i class="fas fa-unlink"></i>
<span class="smal-lab"><?php echo lang('app.connect'); ?></span>
</div>

</div>

</div>
    <?php
}

function image(){
    ?>
    <div class="psg <?php echo ifset($this->data["conclass"]) ?>">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>
<div class="imch">

<div class="prop inp2 impr images" 
<?php echo $this->setSettings() ?>
><i class="plus fas fa-plus"></i></div>
<?php if(isset($this->data['controls']['delete'])){ ?>
<div class="popup-button delimg <?php echo ifset($this->data["class"]) ?>"><?php echo lang('app.delete'); ?></div>
<?php } ?> 
</div>

</div>
    <?php
}
function icon(){
    ?>
    <div class="psg <?php echo ifset($this->data["conclass"]) ?>">
<label class="z-inp-label"><?php echo ifset($this->data["label"]) ?></label>

<div class="imch">

<div class="prop inp2 impr icons" <?php echo $this->setSettings() ?> >
<i></i></div>
<div class="popup-button <?php echo ifset($this->data["class"]) ?>"><?php echo lang('app.change'); ?></div>
</div>
</div>
    <?php
}

function selector_changer(){
    ?>
    <div <?php echo $this->setSettings(false,true) ?> class="pbox subtabs">


</div>
    <?php
}

function button(){
    ?>
    <input type="button" <?php echo $this->setSettings() ?> class="prop actionButton <?php echo ifset($this->data["class"]) ?>" value="<?php echo ifset($this->data["label"]) ?>" />
    <?php
}

function element_repeater(){
    ?>
<div class="repeatset <?php echo ifset($this->data["class"]) ?>">
<div class="prop" style="display: none;" <?php echo $this->setSettings() ?> ></div>
<div class="repeater-handle"></div>
<div class="repeater-controls">
<div class="control edit custom-edit"><i class="fas fa-pen"></i></div>
<div class="control clone"><i class="fas fa-copy"></i></div>
<div class="control delete" data-confirm="<?php ifset($this->data["deleteConfirm"]) ?>"><i class="fas fa-trash-alt"></i></div>
</div>
</div>
    <?php
}
function containers($name,$config){
$class = isset($config['class']) ? ' '.$config['class'] : ''; 
$conclass = isset($config['conclass']) ? ' '.$config['conclass'] : ''; 
$id = isset($config['id']) ? 'id="'.$config['id'].'"' : '';
$label = isset($config['label']) ? $config['label'] : ''; 

$html = array(
'[maintab]' => '<div class="z-pop-cont'.$class.'">',
'[/maintab]' => '</div>',

'[element]' => '<div class="item-select'.$class.'" data-wrap="contolcon">'.$label.'</div>',
'[element-group]' => '<div class="item-title'.$class.'">'.$label.'</div>',

'[intab1]' => '<div class="intab intab1" data-wrap="intabcon intabcon1">'.$label.'</div>',
'[intab2]' => '<div class="intab intab2" data-wrap="intabcon intabcon2">'.$label.'</div>',
'[intab3]' => '<div class="intab intab3" data-wrap="intabcon intabcon3">'.$label.'</div>',

'[advanced]' => '<div class="advtab'.$class.'"><span>'.$label.'</span></div><div class="advtabcon'.$class.'">',
'[/advanced]' => '</div>',

'[repeater]' => '<div class="repeater-container '.$class.'" '.$id.'><div class="proto">',
'[/repeater]' => '</div></div>',
'[altcon]' => '<div class="altcon'.$class.'" '.$id.'>',
'[/altcon]' => '</div>',
'[dependcon]' => '<div class="depend'.$class.'" '.$id.'>',
'[/dependcon]' => '</div>',
'[inlinecon]' => '<div class="inlinecon'.$class.'" '.$id.'>',
'[/inlinecon]' => '</div>',
'[multiselect]' => '<label class="z-inp-label">'.$label.'</label><div class="inlinecon multiselect'.$class.'" '.$id.'>',
'[/multiselect]' => '</div>',
'[main-label]' => '<label class="z-inp-label mainlab'.$class.'" '.$id.'>'.$label.'</label>',
'[desc-label]' => '<label class="z-inp-label smal-lab'.$class.'" '.$id.'>'.$label.'</label>'
);

if(isset($html[$name])){
    echo $html[$name];
} 
else if($name == '[main-tabs]'){
    echo '<div class="p-tabs">';
    foreach($config['tabs'] as $tab){
    echo '<div class="p-tab">'.$tab.'</div>';    
    }  
    echo '</div>';
 }   
}

}
function ifset(&$var){
 return isset($var) ? $var : ''; 
}
