<div class="container">
  <div class="row align-items-center h100vh">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 formcol bg-white from-wrapper">
      <div class="container">
        <h3>Reset password</h3>
        <hr>
        <?php if (session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <form class="" method="post">
            <?= csrf_field() ?>
          <div class="form-group">
           <label for="email">Email</label>
           <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email') ?>">
          </div>

          <?php if (isset($validation)): ?>
            <div class="col-12">
              <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary"><?= lang('app.reset') ?></button>
            </div>
            <div class="col-12 col-sm-8 text-right">
            <?php if($privileges->guestCan('register')): ?>
              <a href="<?= namedRoute('dashboard/register') ?>"><?= lang('app.no-acc-yet') ?></a>
              <?php endif; ?>
            </div>
          </div>
        </form>
      </div>
      <?= getView('dashboard/parts/langSelect') ?> 
      
    </div>
  </div>
</div>
