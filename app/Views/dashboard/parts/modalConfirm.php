<?php if(!isset($modals)){ $modals[] = $modal; }
foreach($modals as $modal){
?>
<div class="modal fade" id="<?= $modal['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= lang('app.confirm-action') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $modal['body'] ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('app.close') ?></button>
        <button class="btn btn-primary modal-continue loadshow"><?= lang('app.continue') ?></button>
      </div>
    </div>
  </div>
</div>
<?php } ?>