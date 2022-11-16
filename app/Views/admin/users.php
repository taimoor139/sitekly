<div class="container mcon">
<?= $search ?>
<?php if ($rows) : ?>
<table class="table table-bordered bs vali-m c-gray">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?= lang('app.login'); ?></th>
      <th scope="col"><?= lang('app.email'); ?></th>
      <th scope="col"><?= lang('app.status'); ?></th>
      <th scope="col"><?= lang('app.privileges'); ?></th>
      <th scope="col"><?= lang('app.registered'); ?></th>
      <th scope="col"><?= lang('app.last-visit'); ?></th>
      <th scope="col"><?= lang('app.sites'); ?></th>
      <th scope="col"><?= lang('app.designer'); ?></th>
      <th scope="col"><?= lang('app.options'); ?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $row) : ?>

    <tr>
      <th scope="row"><?= $row['id'] ?></th>
      <th><?= $row['username'] ?></th>
      <th><?= $row['email'] ?></th>
      <th><?= $row['status'] ?></th>
      <th><?= $row['role'] ?></th>
      <th><?= date('d.m.Y',$row['created_at']) ?></th>
      <th><?= date('d.m.Y',$row['last_visit']) ?></th>
      <th><?= $row['sitesCount'] ?></th>
      <th>
      <?= $row['designer'] ?>

           <?php if(in_array($row['status'], ['user','autoUser']) && $privileges->can('manage','admin_users')) : ?>
           <br />
      <a role="button" href="<?= namedRoute('admin/users/assign/'.$row['id']) ?>" class="btn btn-sm btn-primary ew"><?= lang('app.manage') ?></a>
      <?php endif; ?>

      </th>
     
      
      <?php if($privileges->can('manage','admin_users')){ ?>
       <th>
      <a role="button" href="<?= namedRoute('admin/users/save/'.$row['id']) ?>" class="btn btn-sm btn-primary ew"><?= lang('app.edit') ?></a>
     <?php if($row['status'] != 'admin') : ?>
      <a role="button" href="<?= namedRoute('admin/users/login/'.$row['id']) ?>" class="btn btn-sm btn-primary ew"><?= lang('app.login') ?></a>
      <?php endif; ?>
      <form method="post" action="<?= namedRoute('admin/users/delete') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
      <button data-toggle="modal" data-target="#delete" type="submit" class="btn btn-sm btn-danger ew modal-confirm"><?= lang('app.delete') ?></button>
      </form>
        
      </th>
      <?php } ?>
    </tr>

<?php endforeach ?>
  </tbody>
</table>
<?= $pager->links() ?>
<?php endif ?> 

<a role="button" href="<?= namedRoute('admin/users/save') ?>" class="btn btn-danger"><?= lang('app.add-new-user') ?></a>


</div>