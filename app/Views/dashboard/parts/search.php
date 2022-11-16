<div class="container">
  <div class="row align-items-center">
    <div class="col-12 col-md-6 offset-md-6">
      <div class="container">
        <form class="" method="post">
        <?= csrf_field() ?>
          <div class="row">
            <div class="col-12 search-form">
              <div class="form-group">
               <input type="text" class="form-control" name="search" value="<?= set_value('search') ?>">
              </div>
              <button type="submit" class="btn btn-primary"><?= lang('app.search') ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>