<div class="container mcon">
<?= $search ?>
<?php if ($rows) : ?>
<table class="table table-bordered bs vali-m c-gray">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?= lang('app.login'); ?></th>
      <th scope="col"><?= lang('app.email'); ?></th>
      <th scope="col"><?= lang('app.registered'); ?></th>
      <th scope="col"><?= lang('app.last-visit'); ?></th>
      <th scope="col"><?= lang('app.sites'); ?></th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $i = 1;
  foreach ($rows as $row) : ?>

    <tr>
      <th scope="row"><?= $i++ ?></th>
      <th><?= $row['username'] ?></th>
      <th><?= $row['email'] ?></th>
      <th><?= date('d.m.Y',$row['created_at']) ?></th>
      <th><?= date('d.m.Y',$row['last_visit']) ?></th>
      <th><?= $row['sitesCount'] ?><br>
      <a role="button" href="<?= namedRoute('dashboard/users/'.$row['id']) ?>" class="btn btn-sm btn-primary ew"><?= lang('app.login') ?></a>
      </th>
    </tr>

<?php endforeach ?>
  </tbody>
</table>
<?= $pager->links() ?>
<?php endif ?> 

</div>