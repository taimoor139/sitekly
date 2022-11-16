<?php $builderBase = '{base-replace}'; ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $meta['title']; ?></title>
		<meta name="description" content="<?php echo $meta['description']; ?>">
		<meta name="keywords" content="<?php echo $meta['keywords']; ?>">
        <base href="/">
        
                 <?php 
         if(!empty($meta['altlang'])){
            $altlang = explode("|",$meta['altlang']);
            echo '<link rel="alternate" href="'.SITE_URL.$altlang[1].'" hreflang="'.$altlang[0].'" />';
         }
         ?> 
        
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" href="<?= $builderBase; ?>/template/css/style.css" rel="stylesheet"> 
        
        <link type="text/css" href="style.css<?php echo '?v='.hash('crc32',  @filemtime('style.css')) ?>" rel="stylesheet">

	</head>
	<body>

 <div class="sitekly-container">
 <?php echo $content;?>
 </div>
 {fonts-replace}        
        <link rel="stylesheet" href="<?= $builderBase; ?>/template/line-awesome/1.3.0/css/line-awesome.min.css">
        <link href="<?= $builderBase; ?>/template/css/animate.min.css" rel="stylesheet"> 
        
		<script src="<?= $builderBase; ?>/template/js/jquery.js" ></script>
        <script src="//f.vimeocdn.com/js/froogaloop2.min.js" defer></script>
		<script src="<?= $builderBase; ?>/template/js/site.js" defer></script>
 </body>
</html>