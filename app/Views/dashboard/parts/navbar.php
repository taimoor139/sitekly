    <?php
      $uri = service('uri');
     ?>
    <nav class="navbar navbar-expand-lg navbar-white bg-white bs">
      <div class="container">
      <a class="navbar-brand" href="<?= base_url().localebase() ?>">Faddishbuilder</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?= ($uri->getSegment(1) == 'dashboard' ? 'active' : null) ?>">
            <a class="nav-link"  href="<?= base_url(); ?>/dashboard"><?= lang('app.dashboard') ?></a>
          </li>
          <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url(); ?>/dashboard/profile"><?= lang('app.profile') ?></a>
          </li>
        </ul>
        <ul class="navbar-nav my-2 my-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>/dashboard/logout"><?= lang('app.logout') ?></a>
          </li>
        </ul>
      </div>
      </div>
    </nav>
    
                <?php if (session()->get('success')): ?>
          <div class="container">
          <div class="alert alert-success alert-top" role="alert">
            <?= session()->get('success') ?>
          </div>
          </div>
        <?php endif; ?>
        
                    <?php if (session()->get('info')): ?>
          <div class="container">
          <div class="alert alert-info alert-top" role="alert">
            <?= session()->get('info') ?>
          </div>
          </div>
        <?php endif; ?>
                            <?php if (session()->get('fail')): ?>
          <div class="container">
          <div class="alert alert-warning alert-top" role="alert">
            <?= session()->get('fail') ?>
          </div>
          </div>
        <?php endif; ?>