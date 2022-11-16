<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<base href="<?= base_url(); ?>/">
<?php echo $css; ?>
</head>
<body class="mode_<?= $privileges->getRole() ?>" style="background: linear-gradient(145deg, rgb(2, 178, 187) 0%, rgb(19, 141, 212) 100%);">
<div id="preloader">
<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>

<div class="published" style="display: none;">
  <div class="status"></div>
 <div style="display: flex;justify-content: end;">
<a class="z-toptool tool-close" href="<?php echo namedRoute('builder')?>"><?php echo lang('app.reload-editor'); ?></a>
<a class="z-toptool tool-close" href="<?php echo namedRoute('dashboard')?>"><?php echo lang('app.go-to-dashboard'); ?></a>
</div>
 
  </div>
  

</div>


<div class="sitecon" style="display: none;">
<iframe class="site" src="<?= namedRoute("builder/frame"); ?>"></iframe>
</div>

<div class="editor">
    <div class="z-panel top">
    <div class="e-logo"></div>
    
    <ul class="tool-select tool-navigate"></ul>
    
    <div class="hcontrols">
    <div class="z-toptool harrows tool-sback"></div>
    <div class="z-toptool harrows tool-sforw"></div>
    <div class="hmess"></div>
    </div>
    
    <div class="tool-views">
    <div class="z-toptool tool-view active" id="lg"><i class="fas fa-desktop"></i></div>
    <div class="z-toptool tool-view" id="md"><i class="fas fa-tablet-alt"></i></div>
    <div class="z-toptool tool-view" id="sm"><i class="fas fa-mobile-alt"></i></div>
    <div class="z-toptool tool-view" id="xs"><i class="fas fa-mobile-alt"></i></div>
    </div>

    <div class="emessage">
    <?php //echo $message; ?>
    </div>
    
    <a class="toggle"></a>
    <div class="z-topcon">
    <ul class="tool-select tool-version">
    <li id="pv" class="<?php echo $site['isDraft'] ? '' : 'active'; ?>"><?php echo lang('app.current-version'); ?></li>
    <li id="dv" class="<?php echo $site['isDraft'] ? 'active' : ($site['hasDraft'] ? '' : 'disabled') ?>"><?php echo lang('app.draft-version'); ?></li>
    </ul>
    
    <div class="z-toptool tool-close" onclick="javascript:location.href='<?php echo namedRoute('dashboard')?>'"><?php echo lang('app.close'); ?></div>
    <div class="z-toptool tool-save draft"><?php echo lang('app.save-as-draft'); ?></div>
    <div class="z-toptool tool-save"><?php echo lang('app.publish'); ?></div>
    </div>
    </div>
    
    <div class="z-panel left">
    <?php if($privileges->can('sections','tools_allowed')){ ?><div class="tool-group-title tool-templates" id="group"><?php echo lang('app.blocks'); ?></div><?php } ?>
    <?php if($privileges->can('templates','tools_allowed')){ ?><div class="tool-group-title side tool-templates"><?php echo lang('app.templates'); ?></div><?php } ?>
    <?php if($privileges->can('media','tools_allowed')){ ?><div class="tool-group-title tool-media side"><?php echo lang('app.media'); ?></div><?php } ?>
    <?php if($privileges->can('pages','tools_allowed')){ ?><div class="tool-group-title tool-menu" id="site"><?php echo lang('app.pages'); ?></div><?php } ?>
    <?php if($privileges->can('settings','tools_allowed')){ ?><div class="tool-group-title tool-settings" id="site"><?php echo lang('app.settings'); ?></div><?php } ?>
    <?php if($privileges->can('design','tools_allowed')){ ?><div class="tool-group-title tool-cpalette edit-css" id="globalDesign"><?php echo lang('app.design'); ?></div><?php } ?>
    </div>
    
    <div class="z-hidden">
    <div class="z-addel z-elems" id="element">
    <div class="z-addel-tabs">
       <div class="active"><?php echo lang('app.elements'); ?></div>
      <?php if($privileges->can('globals','tools_allowed')){ ?>   <div><?php echo lang('app.globals'); ?></div> <?php } ?>
    </div>
    <div class="z-addel-con elements">
    <?php echo $widgets ?>
    </div>
    <div class="z-addel-con globals" style="display: none;"></div>
    </div>
    </div>
    
    
    <div class="z-popup z-popmedia z-pophelper images" style="display: none;">
<div class="z-close"></div>
<div class="title"><?php echo lang('app.media-manager'); ?></div>

<div class="z-pop-cont cnt3" style="overflow-y: auto; max-height: calc(100% - 100px);">
<div class="mediacon">
<div class="img-con">
<form action="<?= namedRoute('builder/upload') ?>"
      class=""
      id="imgform">
     <?= csrf_field() ?> 
      
      </form>
<div class="dimg">x</div>
<?php echo $images; ?>
</div>
<div class="img-opt"><div class="img-optinner">

<div class="impreview"></div>

<div class="media-btn-con nbc2">
<div class="media-btn" id="rcrop-open" ><?php echo lang('app.crop'); ?></div>
<div class="media-btn" id="rcrop-delete" ><?php echo lang('app.delete'); ?></div>
</div>

<label class="z-inp-label" id="rcrop-size-label"><?php echo lang('app.filesize'); ?>: <span></span> KB</label>

<div class="psg slider-inp pbox rcrop-width-con">
<div class="numgroup-top">
<label class="z-inp-label"><?php echo lang('app.image-width'); ?></label>
<div class="numgroup-unit">
<span class="active" step="1" suffix="px" max="200" min="1">px</span></div>
</div>

<div class="slider-con inpcon">

<div class="z-popslider-default ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-multi="1">
<div class="z-popline"></div>
<div class="z-popslide ui-slider-handle ui-state-default ui-corner-all" style="left: 0%;"></div>
</div>

<input class="z-pop-inp prop sliinp img-width" id="" step="1" suffix="px"  max="200" min="10" init="0" type="number">
</div>
<div class="media-btn-con nbc2" id="rcrop-width-controls">
<div class="media-btn rcrop-resize" id="update"><?php echo lang('app.update'); ?></div>
<div class="media-btn rcrop-resize" id="save"><?php echo lang('app.save-as-new'); ?></div>
</div>
</div>   

</div>


<div class="media-btn" id="rcrop-insert"><?php echo lang('app.insert-image'); ?></div>

</div></div>
</div>
</div>
</div>

<div class="z-popup z-popmedia" id="imcrop">
<div class="z-pop-cont imcropcon flex-center-inside" >
<img id="rcropimg" />
</div>
<div id="rcrop-dimensions"></div>
<div style="display: flex;justify-content: end;margin-top: -20px;">
<div class="media-btn rcrop-crop" id="update"><?php echo lang('app.update'); ?></div>
<div class="media-btn rcrop-crop" id="save"><?php echo lang('app.save-as-new'); ?></div>
<div class="media-btn" id="rcrop-cancel"><?php echo lang('app.cancel'); ?></div>
</div>

</div>

<div class="z-popup z-popmedia z-pophelper icons">
<div class="z-close"></div>
<div class="title"><?php echo lang('app.pick-icon'); ?></div>
<div class="p-tabs">
<div class="j-tab" id="fa-icon-con"><?php echo lang('app.all'); ?></div>
 <input type="text" class="icofind" placeholder="<?php echo lang('app.find-icon'); ?>" /> 
</div>
 <div class="z-pop-cont"> 
<div class="fa-icon-con">
<?php echo $icons; ?>
</div>
</div> 
</div>


<div class="z-popup z-popmedia sections" style="display: none;">
<div class="z-close"></div>
<div class="title"><?php echo lang('app.section-templates'); ?></div>
<div class="p-tabs">
<?php if($privileges->can('sections','tools_allowed')){ ?><div class="p-tab" id="fa-icon-con"><?php echo lang('app.sections'); ?></div> <?php } ?>
<?php if($privileges->can('templates','tools_allowed')){ ?><div class="p-tab" id="fa-icon-con"><?php echo lang('app.pages'); ?></div> <?php } ?>

</div>
<?php if($privileges->can('sections','tools_allowed')){ ?>
 <div class="z-pop-cont popsections"> 

<div class="filterBar">
<div class="label"><?php echo lang('app.category'); ?></div>
<div class="searchSelect" id="sectionCategory" data-options='<?php echo json_encode($exports['localized']['sectionCategories'],JSON_FORCE_OBJECT); ?>'></div>
<div class="label"><?php echo lang('app.template'); ?></div>
<div class="searchSelect favorite" id="themeName" data-options='<?php echo json_encode($exports['localized']['themes'],JSON_FORCE_OBJECT); ?>'></div>
<div class="favbutton" id="themeName"><?php echo lang('app.favorites'); ?></div>
</div>
<?php echo $exports['sections']; ?>
</div>
<?php } ?>

<?php if($privileges->can('templates','tools_allowed')){ ?>
 <div class="z-pop-cont poppages"> 
 <div class="filterBar">
<div class="label"><?php echo lang('app.page'); ?></div>
<div class="searchSelect" id="pageName" data-options='<?php echo json_encode($exports['localized']['pageCategories'],JSON_FORCE_OBJECT); ?>'></div>
<div class="label"><?php echo lang('app.template'); ?></div>
<div class="searchSelect favorite" id="themeName2" data-options='<?php echo json_encode($exports['localized']['themes'],JSON_FORCE_OBJECT); ?>'></div>
<div class="favbutton" id="themeName2"><?php echo lang('app.favorites'); ?></div>
</div>
<?php echo $exports['pages']; ?>
</div> 
<?php } ?>

</div>
<div class="z-tools">
<div class="tbox">
<div class="z-tool wname"><span class="label"><?php echo lang('app.element'); ?></span></div>
<?php echo $context; ?>
<i class="fas fa-pen zicon tbicon" aria-hidden="true"></i>
</div>
</div>

<div class="c-tools">
<div class="tbox">
<div class="z-tool wname"><span class="label"><?php echo lang('app.column'); ?></span></div>
<?php echo $context; ?>
<i class="fas fa-columns cicon tbicon" aria-hidden="true"></i>
</div>
</div>

<div class="b-tools">
<div class="tbox">
<div class="z-tool wname"><span class="label"><?php echo lang('app.section'); ?></span><span class="name"></span></div>
<?php echo $context; ?>
<i class="fa fa-th-large bicon tbicon" aria-hidden="true"></i>
</div>
</div>

<div class="z-popup z-pop16">
<?php echo $widgetControl; ?>
<div style="display: none;" class="popup-button pop-save save right"></div>
</div>


<?php echo $js; ?>
<script><?php echo $sitedata['js']; ?></script>
<?php echo $sitedata['html']; ?>
</body>
</html>