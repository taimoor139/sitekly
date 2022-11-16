<main class="content">
    <div class="container-fluid p-0">


        <?php if ($rows) : ?>
            <div class="row row-cols-xs-1 row-cols-sm-2 row-cols-md-4 justify-content-center justify-content-md-start">

                <?php foreach ($rows as $row) : ?>
                    <?php $privileges->extendByPackage($row['package']) ?>
                    <div class="col mb-4 project-card">
                        <div class="card h-100 bs sitecard">
                            <h5 class="card-title h3c"><a href="<?= $row['titleLink'] ?>"><?= $row['title'] ?></a></h5>
                            <a href="<?= $row['titleLink'] ?>" class="site_thumb" style="background-image: url('<?= $row['thumb'] ?>');"></a>
                            <div class="card-body">


                                <ul class="list-group list-group-flush">


                                    <?php if ($privileges->can('space', 'site_info')) : ?>
                                        <div class="progress" style="height: 2px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $row['space']['used%'] ?>%;" aria-valuenow="<?= $row['space']['used%'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?= lang('app.space-used') ?>
                                            <span class="badge badge-light"><?= $row['space']['used%'] ?>%</span>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($privileges->can('status', 'site_info')) : ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?= lang('app.status') ?>
                                            <span class="badge badge-<?= $row['statusType'] ?>"><?= $row['status'] ?></span>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($privileges->can('package', 'site_info')) : ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?= lang('app.package') ?>
                                            <span class="badge badge-light"><?= $pricing[$row['package']]['name'] ?></span>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($privileges->can('expire', 'site_info')) : ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?= empty($row['subscription']) ? lang('app.expire-date') : lang('app.renewal-date') ?>
                                            <span class="badge badge-light "><?= $row['expireDate'] ?></span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="text-right">
                                    <div class="btn-group text-right">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?= lang('app.options') ?>
                                        </button>
                                        <div class="dropdown-menu">

                                            <?php if ($privileges->can('site_preview')) : ?>
                                                <a class="dropdown-item" href="<?= $row['previewLink'] ?>"><?= lang('app.preview') ?></a>
                                            <?php endif; ?>

                                            <?php if ($privileges->can('site_edit')) : ?>
                                                <form method="post" action="<?= namedRoute('builder') ?>" class="dropdown-item">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="site" value="<?= $row['id'] ?>" />
                                                    <button type="submit" class="btn"><?= lang('app.edit') ?></button>
                                                </form>
                                            <?php endif; ?>
                                            <?php if ($privileges->can('site_export')) : ?>
                                                <form method="get" action="<?= namedRoute('dashboard/export') ?>" class="dropdown-item">
                                                    <input type="hidden" name="site" value="<?= $row['id'] ?>" />
                                                    <button type="submit" class="btn"><?= lang('app.export-files') ?></button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if ($privileges->can('subscription_manage')) : ?>
                                                <?php if (empty($row['subscription'])) { ?>
                                                    <form method="post" action="<?= namedRoute('dashboard/payment') ?>" class="dropdown-item">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="site" value="<?= $row['id'] ?>" />
                                                        <button type="submit" class="btn"><?= lang('app.manage-subscription') ?></button>
                                                    </form>
                                                <?php } else { ?>
                                                    <form method="post" action="<?= namedRoute('dashboard/payment') ?>" class="dropdown-item">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="site" value="<?= $row['id'] ?>" />
                                                        <input type="hidden" name="action" value="cancel" />
                                                        <button type="submit" data-toggle="modal" data-target="#cancel" class="btn modal-confirm"><?= lang('app.cancel-subscription') ?></button>
                                                    </form>
                                                <?php } ?>
                                            <?php endif; ?>

                                            <?php if ($privileges->can('domain_manage')) : ?>
                                                <form method="post" action="<?= namedRoute('dashboard/domain') ?>" class="dropdown-item">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="site" value="<?= $row['id'] ?>" />
                                                    <button type="submit" class="btn"><?= lang('app.manage-domain') ?></button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if ($privileges->can('domain_manage')) : ?>
                                                <form method="post" action="/dashboard/dns" class="dropdown-item">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="site" value="<?= $row['id'] ?>" />
                                                    <button type="submit" class="btn"><?= lang('_app.manage-zones') ?></button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if ($privileges->can('mailbox_view') && $row['panel_reseller'] != 'local') : ?>
                                                <a class="dropdown-item" href="<?= namedRoute('dashboard/mailbox/list/' . $row['id']) ?>"><?= lang('app.manage-mailboxes') ?></a>
                                            <?php endif; ?>



                                            <?php if ($privileges->can('site_delete')) : ?>
                                                <div class="dropdown-divider"></div>
                                                <form method="post" action="<?= namedRoute('dashboard/delete') ?>" class="dropdown-item">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="site" value="<?= $row['id'] ?>" />
                                                    <button type="submit" data-toggle="modal" data-target="#delete" class="btn modal-confirm"><?= lang('app.delete-website') ?></button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <?php if ($privileges->can('site_add')) : ?>
            <a role="button" href="<?= namedRoute('templates') ?>" class="btn btn-danger"><?= lang('app.add-new-website') ?></a>
        <?php endif ?>

    </div>
</main>