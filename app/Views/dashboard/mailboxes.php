<div class="container mcon">
<?php if ($rows) : ?>
<div class="row row-cols-1 row-cols-md-3">
   <?php foreach ($rows as $row) : ?> 
          <div class="col mb-4">
        <div class="card h-100 bs sitecard">
        <h5 class="card-title h3c"><?= $row['name'] ?>@<?= $site['domain'] ?></h5>
          
          <div class="card-body text-center">


<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
  
  <?php if($privileges->can('mailbox_change') || $privileges->can('mailbox_delete')): ?>
  <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?= lang('app.options') ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      
      <?php if($privileges->can('mailbox_change')): ?>
      <form method="get" action="<?= namedRoute('dashboard/mailbox/change/'.$site['id']) ?>" class="dropdown-item">
      <input type="hidden" name="mailbox" value="<?= $row['id'] ?>"/>
      <button type="submit" class="btn"><?= lang('app.change-password') ?></button>
      </form>
      <?php endif ?>
      
      <?php if($privileges->can('mailbox_delete')): ?>
      <form method="post" action="<?= namedRoute('dashboard/mailbox/delete/'.$site['id']) ?>" class="dropdown-item">
      <?= csrf_field() ?>
      <input type="hidden" name="mailbox" value="<?= $row['id'] ?>"/>
      <button type="submit" data-toggle="modal" data-target="#delete" class="btn modal-confirm"><?= lang('app.delete') ?></button>
      </form>
        <?php endif ?>
        
    </div>
  </div>
<?php endif ?>   
  
  <a href="<?= $webmail ?>" target="_blank" class="btn btn-primary"><?= lang('app.open-mailbox') ?></a> 
</div>


            
          </div>
        </div>
      </div>
   <?php endforeach ?>     
    </div>
<?php endif ?> 

<?php if($privileges->can('mailbox_add')): ?>
<a href="<?= namedRoute('dashboard/mailbox/add/'.$site['id']) ?>" class="btn btn-danger"><?= lang('app.add-new-mailbox') ?></a>
<?php endif ?> 

</div>