<div class="container mcon">
<?= $search ?>
<?php if ($rows) : ?>
<table class="table table-bordered bs vali-m c-gray">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?= lang('app.user'); ?></th>
      <th scope="col"><?= lang('app.directory'); ?></th>
      <th scope="col"><?= lang('app.domain'); ?></th>
      <th scope="col"><?= lang('app.template'); ?></th>
      <th scope="col"><?= lang('app.package'); ?></th>
      <th scope="col"><?= lang('app.status'); ?></th>
      <th scope="col"><?= lang('app.expires'); ?></th>
      <th scope="col"><?= lang('app.options'); ?></th>
    </tr>
  </thead>
  <tbody>
  
  <?php foreach ($rows as $row) : ?>

    <tr>
      <th scope="row"><?= $row['id'] ?></th>
      <th><?= $row['username'] ?></th>
      <th><a class="normal" href="<?= $row['previewLink'] ?>"><?= $row['directory'] ?></a></th>
      <th><a class="normal" href="//<?= $row['domain'] ?>"><?= $row['domain'] ?></a></th>
      <th><?= $row['theme'] ?></th>
      <th><?= $pricing[$row['package']]['name'] ?></th>
      <th><?= $row['status'] ?></th>
      <th><?= date('Y-m-d H:i',$row['expire']) ?></th>
      <th>
      <a role="button" href="<?= namedRoute('admin/sites/edit/'.$row['id']) ?>" class="btn btn-sm btn-primary ew"><?= lang('app.edit') ?></a>
      
      <form method="post" action="<?= namedRoute('builder') ?>">
    <?= csrf_field() ?>
      <input type="hidden" name="site" value="<?= $row['id'] ?>"/>
      <input type="hidden" name="admin_mode" value="true"/>
      <button type="submit" class="btn btn-sm btn-primary ew"><?= lang('app.edit-in-builder') ?></button>
      </form>
      
      <form method="post" action="<?= namedRoute('admin/sites/delete') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
      <button data-toggle="modal" data-target="#delete" type="submit" class="btn btn-sm btn-danger ew modal-confirm"><?= lang('app.delete') ?></button>
      </form>
      
      </th>
    </tr>

<?php endforeach ?>
  </tbody>
</table>
<?= $pager->links() ?>
<?php else: ?> 
          <div class="container">
          <div class="alert alert-warning alert-top" role="alert">
            <?= lang('app.no-records-found'); ?>
          </div>
          </div>
<?php endif; ?>          

</div>