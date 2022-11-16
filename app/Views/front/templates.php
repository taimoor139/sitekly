<div class="container">
<?php if ($templates) : ?>
<div class="row" id="template-list">

<?php foreach ($templates as $template) : ?>

<div class="imgcon">
<div class="img" tsrc="<?= $template['FullThumb'] ?>" style="background-image: url('<?= $template['FullThumb'] ?>')">
<div class="overbox">
<a class="button" href="<?= base_url($template['Link']) ?>">Preview</a>
<form method="post" action="<?= namedRoute('dashboard/newsite') ?>">
<?= csrf_field() ?>
    <input type="hidden" name="theme" value="<?= $template['id'] ?>"/>
    <button type="submit" class="button"><?= lang('app.use-this') ?></button>
</form>

</div>
</div>
</div>
 <?php endforeach ?>
</div>
</div>

<?php endif ?>