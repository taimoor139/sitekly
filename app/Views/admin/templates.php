<div class="container mcon">

  <?php if ($privileges->can('builder_templates', 'admin_templates')) { ?>
    <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link <?= $type == 1 ? 'active' : '' ?>" aria-current="page" href="<?= namedRoute('admin/templates') ?>"><?= lang('app.user') ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $type == 2 ? 'active' : '' ?>" href="<?= namedRoute('admin/templates/builder') ?>"><?= lang('app.builder') ?></a>
      </li>

    </ul>
  <?php } ?>
  <?php if ($templates) : ?>
    <table class="table table-bordered bs vali-m c-gray">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col"><?= lang('app.preview'); ?></th>
          <th scope="col"><?= lang('app.status'); ?></th>
          <th scope="col"><?= lang('app.space-used'); ?></th>
          <th scope="col"><?= lang('app.options'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($templates as $template) : ?>

          <tr class="bg-white">
            <th scope="row"><?= $template['id'] ?></th>
            <th><a href="<?= base_url($template['Link']) ?>"><img class="sthumb" src="<?= $template['Thumb'] ?>" /></a></th>

            <th>
              <div class="text-cap"><?= lang('app.' . $template['statusChange'][3]) ?></div>

              <?php if ($template['statusChange'][2]) { ?>

                <?php if ($privileges->can('status', 'admin_templates')) { ?>
                  <form method="post" action="<?= namedRoute('admin/templates/status') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $template['id'] ?>" />
                    <input type="hidden" name="val" value="<?= $template['statusChange'][0] ?>" />
                    <button type="submit" class="btn btn-sm text-cap ew btn-<?= $template['statusChange'][1]  ?>"><?= lang('app.' . $template['statusChange'][2]) ?></button>
                  </form>
                <?php } ?>
              <?php } ?>

            </th>
            <th>
              <ul class="list-group list-group-flush">
                <div class="progress" style="height: 2px;">
                  <div class="progress-bar" role="progressbar" style="width: <?= $template['space']['usedp'] ?>%;" aria-valuenow="<?= $template['space']['usedp'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <li class="list-group-item d-flex justify-content-between align-items-center"><?= $template['space']['used'] ?>MB <span class="badge badge-light" style="background-color: transparent;"><?= $template['space']['usedp'] ?>%</span>
                </li>
              </ul>
            </th>
            <th>
              <?php if ($privileges->can('edit', 'admin_templates')) { ?>
                <form method="post" action="<?= namedRoute('builder') ?>" class="mb-0">
                  <?= csrf_field() ?>
                  <input type="hidden" name="site" value="<?= $template['id'] ?>" />
                  <input type="hidden" name="admin_mode" value="false" />

                  <button type="submit" class="btn btn-sm btn-primary ew"><?= lang('app.edit') ?></button>
                </form>
                <a href="<?= namedRoute('admin/templates/settings/' . $template['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill ew"><?= lang('app.settings') ?></a>
              <?php } ?>
              <?php if ($privileges->can('delete', 'admin_templates')) { ?>
                <form method="post" action="<?= namedRoute('admin/templates/delete') ?>">
                  <?= csrf_field() ?>
                  <input type="hidden" name="id" value="<?= $template['id'] ?>" />
                  <button data-toggle="modal" data-target="#delete" type="submit" class="btn btn-sm btn-danger ew modal-confirm"><?= lang('app.delete') ?></button>
                </form>
              <?php } ?>
            </th>
          </tr>

        <?php endforeach ?>
      </tbody>
    </table>
  <?php endif ?>
  <?= $pager->links() ?>

  <?php if ($privileges->can('add_new', 'admin_templates')) { ?>
    <a role="button" href="<?= namedRoute('templates') ?>" class="btn btn-danger"><?= lang('app.add-new-template') ?></a>
  <?php } ?>
  <?php if ($privileges->can('translate', 'admin_templates')) { ?>
    <a role="button" href="<?= namedRoute('admin/templates/translate') ?>" class="btn btn-primary"><?= lang('app.translations') ?></a>
  <?php } ?>

</div>