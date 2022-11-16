<div class="container">
  <div class="row align-items-center h100vh">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 formcol bg-white from-wrapper">
      <div class="container">
       <?php if($privileges->guestCan('demologin')): ?>
        <a style="float: right;" href="<?= namedRoute('dashboard/demologin') ?>"><?= lang('app.try-demo') ?></a>
         <?php endif; ?>
        <h3><?= lang('app.login') ?></h3>
        <hr>
        <?php if (session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <form class=""  method="post">
        <?= csrf_field() ?>
          <div class="form-group">
           <label for="username"><?= lang('app.username') ?></label>
           <input type="text" class="form-control" name="username" id="username" value="<?= set_value('username') ?>">
          </div>
          <div class="form-group">
           <label for="password"><?= lang('app.password') ?></label>
           <input type="password" class="form-control" name="password" id="password" value="">
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
              <button type="submit" class="btn btn-primary"><?= lang('app.login') ?></button>
            </div>
            <div class="col-12 col-sm-8 text-right">
            <?php if($privileges->guestCan('resetPassword')): ?>
              <a class="block" href="<?= namedRoute('dashboard/reset') ?>"><?= lang('app.forgot-pass') ?></a>
              <?php endif; ?>
              <?php if($privileges->guestCan('register')): ?>
              <a class="block" href="<?= namedRoute('dashboard/register') ?>"><?= lang('app.no-acc-yet') ?></a>
              <?php endif; ?>
            </div>
          </div>
        </form>
        
      </div>
      
 
<?= getView('dashboard/parts/langSelect') ?> 
   
   
   
    </div>
    
  


    
  </div>
</div>
