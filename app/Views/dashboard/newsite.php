<div class="container">
  <div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3><?= lang('app.register') ?></h3>
        <hr>
        <form class="" action="/register" method="post">
        <?= csrf_field() ?>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
               <label for="user"><?= lang('app.username') ?></label>
               <input type="text" class="form-control" name="username" id="user" value="<?= set_value('username') ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
               <label for="email"><?= lang('app.email-addr') ?></label>
               <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email') ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
               <label for="password"><?= lang('app.password') ?></label> 
               <input type="password" class="form-control" name="password" id="password" value="">
             </div>
           </div>
          <?php if (isset($validation)): ?>
            <div class="col-12">
              <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
              </div>
            </div>
          <?php endif; ?>
          </div>

          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary"><?= lang('app.register') ?></button>
            </div>
            <div class="col-12 col-sm-8 text-right">
              <a href="/"><?= lang('app.have-acc') ?></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
