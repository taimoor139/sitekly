<?= getView('dashboard/parts/head') ?>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="<?= base_url() ?>" style="text-align: center;">
          <span class="align-middle"><img src="https://sitekly.com/demo/editor/images/logo.png"/></span>
        </a>

				<ul class="sidebar-nav">

					<li class="sidebar-item">
		  <a class="sidebar-link" href="<?= namedRoute('admin') ?>">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle"><?= lang('app.dashboard') ?></span>
            </a>
          </li>
          <?php if($privileges->can('view','admin_templates')): ?>          
              <li class="sidebar-item">
			<a class="sidebar-link" href="<?= namedRoute('admin/templates') ?>">
              <i class="align-middle" data-feather="layout"></i> <span class="align-middle"><?= lang('app.templates') ?></span>
            </a>                      
              </li>
          <?php endif; ?>   
          
          <?php if($privileges->can('admin_pricing_manage')): ?>        
          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= namedRoute('admin/pricing') ?>">
              <i class="align-middle" data-feather="package"></i> <span class="align-middle"><?= lang('app.pricing') ?></span>
            </a>
          </li>
          <?php endif; ?> 
          <?php if($privileges->can('view','admin_users')): ?> 
          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= namedRoute('admin/users') ?>">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle"><?= lang('app.users') ?></span>
            </a>
          </li>
          <?php endif; ?> 
          <?php if($privileges->can('admin_sites_manage')): ?> 
          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= namedRoute('admin/sites') ?>">
              <i class="align-middle" data-feather="archive"></i> <span class="align-middle"><?= lang('app.sites') ?></span>
            </a>
          </li>
          <?php endif; ?> 
        <li class="sidebar-item">
						<a class="sidebar-link" href="<?= namedRoute('dashboard/logout'); ?>">
              <i class="align-middle" data-feather="log-out"></i> <span class="align-middle"><?= lang('app.logout') ?></span>
            </a>
					</li>
				
				</ul>

			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
                
                
                	<ul class="navbar-nav navbar-align">
                    

                  <div class="nav-item dropdown">
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
    <?= langList()['current'] ?>
  </a>

  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
  <?php foreach(langList()['supported'] as $k=>$data){ ?>
  <li><a class="dropdown-item" href="<?= namedRoute('lang/'.$k.'/1') ?>"><?= $data[0] ?></a></li>
  <?php } ?>
  </ul>
</div> 

						<li class="nav-item dropdown">


							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" data-bs-toggle="dropdown">
               <span class="text-dark"><?= session()->get('user_username') ?></span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="<?= namedRoute('dashboard/logout'); ?>"><?= lang('app.logout') ?></a>
							</div>
						</li>
					</ul>
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
        
       
