<div class="container mcon">
<?php if ($pricing) : ?>
<table class="table table-bordered bs vali-m c-gray">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?= lang('app.name2'); ?></th>
      <th scope="col"><?= lang('app.disk-space'); ?></th>
      <th scope="col"><?= lang('app.ads'); ?></th>
      <th scope="col"><?= lang('app.subdomain'); ?></th>
      <th scope="col"><?= lang('app.user-domain'); ?></th>
      <th scope="col"><?= lang('app.email-accounts'); ?></th>
      <th scope="col"><?= lang('app.sites-limit'); ?></th>
      <th scope="col"><?= lang('app.price-admin-mo-month'); ?></th>
      <th scope="col"><?= lang('app.price-admin-mo-year'); ?></th>
      <th scope="col"><?= lang('app.options'); ?></th>
    </tr>
  </thead>
  <tbody>
  
  <?php foreach ($pricing as $row) : ?>

    <tr>
      <th scope="row"><?= $row['id'] ?></th>
      <th><?= $row['name'] ?></th>
      <th><?= $row['space'] ?></th>
      <th><?= ($row['ads'] == 0) ? lang('app.no') : lang('app.yes') ?></th>
      <th><?= ($row['subdomain'] == 0) ? lang('app.no') : lang('app.yes') ?></th>
      <th><?= ($row['domain'] == 0) ? lang('app.no') : lang('app.yes') ?></th>
      <th><?= $row['emails'] ?></th>
      <th><?= $row['site_limit'] == -1 ? '&#8734;' : $row['site_limit'] ?></th>
      <th><?= $row['price_monthly_month'] == -1 ? lang('app.disabled') : $row['price_monthly_month'] ?></th>
      <th><?= $row['price_monthly_year'] == -1 ? lang('app.disabled') : $row['price_monthly_year'] ?></th>
      <th>
      <a role="button" href="<?= namedRoute('admin/pricing/save/'.$row['id']) ?>" class="btn btn-sm btn-primary ew"><?= lang('app.edit') ?></a>
      
     <?php if($row['id'] !=1){ ?>
      <form method="post" action="<?= namedRoute('admin/pricing/delete') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
      <button data-toggle="modal" data-target="#delete" type="submit" class="btn btn-sm btn-danger ew modal-confirm"><?= lang('app.delete') ?></button>
      </form>
      <?php } ?>
      </th>
    </tr>

<?php endforeach ?>
  </tbody>
</table>
<?php endif ?> 

<a role="button" href="<?= namedRoute('admin/pricing/save') ?>" class="btn btn-danger"><?= lang('app.add-new-package') ?></a>


</div>