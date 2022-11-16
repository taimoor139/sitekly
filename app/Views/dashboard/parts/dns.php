<style>
    .zonerow {
        display: flex;
    }

    .form-group {
        width: 100%;
        padding: 5px;
    }

    .options {
        max-width: 160px;
        text-align: center;
        margin-top: 45px;
    }
</style>
<script>
    function zoneType(select) {
        var val = $(select).val().toLowerCase();
        var form = $(select).closest('form');
        form.find('.form-group.optional').hide();
        form.find('.form-group.' + val).show();
    }
</script>
<main class="content">
    <div class="row align-items-center">
        <div class="col-12 formcol bg-white from-wrapper bs">
            <div class="container">
                <h3><?= $title ?></h3>
                <hr>
                <?php if (isset($validation)) : ?>

                    <div class="alert alert-danger" role="alert">
                        <?= isset($validation->customView) ? $validation->listErrors($validation->customView) : $validation->listErrors() ?>
                    </div>

                <?php endif; ?>
                <div class="row mt-4">

                    <?php foreach ($zones as $k => $zone) : ?>
                        <form method="post" class="zonerow">
                            <?= csrf_field() ?>
                            <input type="hidden" name="site" value="<?= set_value('site', '') ?>" />

                            <input type="hidden" name="line" value="<?= $zone['line'] ?>" />
                            <div class="form-group">
                                <label><?= lang('app.name') ?></label>
                                <input class="form-control" type="text" name="name" value="<?= $zone['name'] ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= lang('app.type') ?></label>
                                <?= form_dropdown("type", array_combine($rtypes, $rtypes), set_value("type", $zone['type']), ['class' => 'form-control record-type', 'onchange' => "zoneType(this)"]);  ?>
                            </div>

                            <div class="form-group a aaaa optional" style="<?= in_array($zone['type'], ['A', 'AAAA']) ? "" : 'display:none' ?>">
                                <label><?= lang('_app.ip') ?></label>
                                <input class="form-control" type="text" name="address" value="<?= $zone['address'] ?>" />
                            </div>
                            <div class="form-group cname optional" style="<?= $zone['type'] == 'CNAME' ? "" : 'display:none' ?>">
                                <label><?= lang('app.domain') ?></label>
                                <input class="form-control" type="text" name="cname" value="<?= $zone['record'] ?>" />
                            </div>
                            <div class="form-group mx optional" style="<?= $zone['type'] == 'MX' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.priority') ?></label>
                                <input class="form-control" type="text" name="preference" value="<?= $zone['preference'] ?>" />
                            </div>
                            <div class="form-group mx optional" style="<?= $zone['type'] == 'MX' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.destination') ?></label>
                                <input class="form-control" type="text" name="exchange" value="<?= $zone['exchange'] ?>" />
                            </div>

                            <div class="form-group srv optional" style="<?= $zone['type'] == 'SRV' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.priority') ?></label>
                                <input class="form-control" type="text" name="priority" value="<?= $zone['priority'] ?>" />
                            </div>
                            <div class="form-group srv optional" style="<?= $zone['type'] == 'SRV' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.weight') ?></label>
                                <input class="form-control" type="text" name="weight" value="<?= $zone['weight'] ?>" />
                            </div>
                            <div class="form-group srv optional" style="<?= $zone['type'] == 'SRV' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.port') ?></label>
                                <input class="form-control" type="text" name="port" value="<?= $zone['port'] ?>" />
                            </div>
                            <div class="form-group srv optional" style="<?= $zone['type'] == 'SRV' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.target') ?></label>
                                <input class="form-control" type="text" name="target" value="<?= $zone['target'] ?>" />
                            </div>

                            <div class="form-group txt optional" style="<?= $zone['type'] == 'TXT' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.txtdata') ?></label>
                                <input class="form-control" type="text" name="txtdata" value="<?= $zone['txtdata'] ?>" />
                            </div>

                            <div class="form-group caa optional" style="<?= $zone['type'] == 'CAA' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.flag') ?></label>
                                <select class="form-control" name="flag">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <div class="form-group caa optional" style="<?= $zone['type'] == 'CAA' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.tag') ?></label>
                                <select class="form-control" name="tag">
                                    <option value="issue">issue</option>
                                    <option value="issuewild">issuewild</option>
                                    <option value="iodef">iodef</option>
                                </select>
                            </div>
                            <div class="form-group caa optional" style="<?= $zone['type'] == 'CAA' ? "" : 'display:none' ?>">
                                <label><?= lang('_app.value') ?></label>
                                <input class="form-control" type="text" name="value" value="<?= $zone['value'] ?>" />
                            </div>


                            <div class="form-group options">
                                <?php if ($k == 0) : ?>
                                    <button type="submit" name="add" value="true" class="btn btn-primary "><?= isset($button) ? $button : lang('app.add-new') ?></button>
                                <?php else : ?>
                                    <button type="submit" name="save" class="btn btn-primary "><?= isset($button) ? $button : lang('app.save') ?></button>
                                    <button type="submit" name="delete" value="true" class="btn btn-danger"><?= isset($button) ? $button : lang('app.delete') ?></button>
                                <?php endif ?>


                            </div>

                        </form>

                    <?php endforeach; ?>

                </div>

                <div class="row mt-4">

                    <div class="col-12 col-sm-4">
                        <a href="<?= namedRoute($back['path']) ?>"><?= $back['label'] ?></a>
                    </div>

                    <div class="col-12 col-sm-8 text-right">

                    </div>

                </div>

            </div>
        </div>
    </div>
</main>