<!DOCTYPE HTML>
<html>
   <head>
      <meta charset="utf-8">
      <title><?php echo $meta['title']; ?></title>
      <meta name="description" content="<?php echo $meta['description']; ?>">
      <meta name="keywords" content="<?php echo $meta['keywords']; ?>">
      <?php echo '<base href="'.$basehref.'/">'; ?>
      <?php 
         if(!empty($meta['altlang'])){
            $altlang = explode("|",$meta['altlang']);
            echo '<link rel="alternate" href="'.$baseurl.'/'.$altlang[1].'" hreflang="'.$altlang[0].'" />';
         }
          if(!empty($meta['favicon'])){
            echo '<link rel="icon" type="image/png" href="'.$meta['favicon'].'"/>';
         }
         ?> 
      <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
      <link type="text/css" href="<?= base_url_versioned('/template/css/style.css',$baseurl) ?>" rel="stylesheet">
      <?= $fonts?>
      <?php if($editMode){ ?>
      <link  type="text/css" href="<?= base_url_versioned('/editor/css/frame.css',$baseurl) ?>" rel="stylesheet">
      <link  type="text/css" href="<?= base_url_versioned('/custom/css/editor-frame.css',$baseurl) ?>" rel="stylesheet">
      <link href="<?= base_url_versioned('/template/font-awesome/css/all.css',$baseurl) ?>" rel="stylesheet">
      <?php } else{ ?>   
      <link type="text/css" href="<?= $siteStyle; ?>" rel="stylesheet">
      <?php } ?>    
          

   </head>
   <body>
      <?php if(!$editMode && $type != 'builder' && $type != 'local'){ ?>
      <script>previewModeInfo = "<?= lang('app.disabled-in-preview'); ?>"</script>
        <script src="<?= base_url_versioned('/template/js/preview.js',$baseurl) ?>" defer></script>
      <?php } ?>
      
      <?php if($editMode){ ?>
      <script src="<?= base_url_versioned('/editor/vendor/tinymce/tinymce.min.js',$baseurl) ?>"></script>
      <script src="<?= base_url_versioned('/editor/js/iframe.js',$baseurl) ?>" defer></script>
      <script src="<?= base_url_versioned('/custom/js/editor-frame.js',$baseurl) ?>"></script>
      <?php } ?>   
      <div class="sitekly-container">
         <?php echo $content;?>
      </div>
      
      
      <link href="<?= base_url_versioned('/template/line-awesome/1.3.0/css/line-awesome.min.css',$baseurl) ?>" rel="stylesheet">
      <link href="<?= base_url_versioned('/template/css/animate.min.css',$baseurl) ?>" rel="stylesheet">
      <script src="<?= base_url_versioned('/template/js/jquery.js',$baseurl) ?>" ></script>
      <script src="https://f.vimeocdn.com/js/froogaloop2.min.js" defer></script>
      <script src="<?= base_url_versioned('/template/js/site.js',$baseurl) ?>" defer></script>
      
      <?php if(isset($_GET['capture'])){ ?>
      <link href="<?= base_url_versioned('/template/css/capture.css',$baseurl) ?>" rel="stylesheet">
      <?php } ?>
      <?php if(!empty($_GET['hash-capture'])){ ?>
      <script>var hash = "<?= $_GET['hash-capture'] ?>";</script>
      <script src="<?= base_url_versioned('/template/js/hash-capture.js',$baseurl) ?>" ></script> 
      <?php  } ?>
   </body>
</html>
