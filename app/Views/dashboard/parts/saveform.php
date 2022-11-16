<main class="content">
  <div class="row align-items-center">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 formcol bg-white from-wrapper bs">
      <div class="container">
        <h3><?= $title ?></h3>
        <hr>
        <form class="" method="post" id="<?= isset($formid) ? $formid : '' ?>">
          <?= csrf_field() ?>
          <div class="row mt-4">

            <?php foreach ($rules as $key => $data) : ?>

              <?
              $row[$key] = isset($row[$key]) ? $row[$key] : '';
              $itype = isset($data['itype']) ? $data['itype'] : 'text';
              if (isset($data['type']) && $data['type'] == 'hidden') {
                echo form_input(['type' => 'hidden', 'name' => $key, 'id' => $key, 'class' => 'form-control', 'value' => set_value($key, $row[$key])]);
                continue;
              } ?>
              <div class="col-<?= isset($data['size']) ? $data['size'] : 12 ?>">
                <div class="form-group">
                  <label for="<?= $key ?>"><?= $data['label'] ?></label>
                  <? if (isset($data['type'])) {
                    if ($data['type'] == 'select') {
                      $options = isset($data['options']) ? $data['options'] : ['0' => lang('app.no'), '1' => lang('app.yes')];
                      echo form_dropdown($key, $options, set_value($key, $row[$key]), ['class' => 'form-control', 'id' => $key]);
                    } else if ($data['type'] == 'multiselect') {
                      $options = isset($data['options']) ? $data['options'] : [];
                      echo form_multiselect($key . '[]', $options, $row[$key], ['class' => 'form-control select2', 'id' => $key]);
                    } else if ($data['type'] == 'radio') {
                      $value = set_value($key, $row[$key]);
                      $value = empty($value) ? $data['checked'] : $value;
                      $options = isset($data['options']) ? $data['options'] : ['0' => lang('app.no'), '1' => lang('app.yes')];
                      foreach ($options as $name => $label) {
                        $checked = ($value == $name) ? 'checked' : '';
                  ?>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="<?= $key ?>" id="<?= $name ?>" value="<?= $name ?>" <?= $checked ?>>
                          <label class="form-check-label" for="<?= $name ?>">
                            <?= $label ?>
                          </label>
                        </div>
                  <?php
                      }
                    } else if ($data['type'] == 'textarea') {
                      echo form_textarea(['name' => $key, 'id' => $key, 'class' => 'form-control', 'value' => set_value($key, $row[$key])]);
                    } else if ($data['type'] == 'tsDate') {
                      echo form_input(['type' => 'date', 'name' => $key, 'id' => $key, 'class' => 'form-control', 'value' => set_value($key, date('Y-m-d', $row[$key]))]);
                    } else if ($data['type'] == 'disabled') {
                      echo form_input(['disabled' => 'true', 'name' => $key, 'id' => $key, 'class' => 'form-control', 'value' => set_value($key, $row[$key])]);
                    }
                  } else {
                    echo form_input(['type' => $itype, 'name' => $key, 'id' => $key, 'class' => 'form-control', 'value' => set_value($key, $row[$key])]);
                  }
                  ?>
                </div>
              </div>
            <?php endforeach; ?>

            <?php if (isset($validation)) : ?>

              <div class="col-12">
                <div class="alert alert-danger" role="alert">
                  <?= isset($validation->customView) ? $validation->listErrors($validation->customView) : $validation->listErrors() ?>
                </div>
              </div>
            <?php endif; ?>


          </div>

          <div class="row mt-4">

            <div class="col-12 col-sm-4">
              <a href="<?= namedRoute($back['path']) ?>"><?= $back['label'] ?></a>
            </div>

            <div class="col-12 col-sm-8 text-right">
              <button type="submit" class="btn btn-primary loadshow"><?= isset($button) ? $button : lang('app.save') ?></button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
    background-color: #222E3C;
    color: white;
  }

  .select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #ced4da;
  }
</style>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    $.getScript("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js", function(data, textStatus, jqxhr) {
      $("select.select2").select2({
        tags: true
      });
    });

  });
</script>