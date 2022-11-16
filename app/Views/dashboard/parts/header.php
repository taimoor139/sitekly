<?= getView('dashboard/parts/head') ?>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="<?= base_url() ?>" style="text-align: center;">
          <span class="align-middle"><img src="https://sitekly.com/demo/editor/images/logo.png"/></span>
        </a>

				<ul class="sidebar-nav">

                    <li class="sidebar-item">
						<a class="sidebar-link" href="<?= namedRoute('dashboard') ?>">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle"><?= lang('app.dashboard',[2]) ?></span>
            </a>
					</li>

                    
              
                    
                    <?php if($privileges->can('site_add') && !session()->get('designerHide')): ?>
                                        <li class="sidebar-item">
						<a class="sidebar-link" href="<?= namedRoute('templates') ?>">
              <i class="align-middle" data-feather="book"></i> <span class="align-middle"><?= lang('app.add-new-website') ?></span>
            </a>
					</li>
                    <?php endif ?> 
                    
                                        <li class="sidebar-item">
						<a class="sidebar-link" href="<?= namedRoute('dashboard/contact') ?>">
              <i class="align-middle" data-feather="help-circle"></i> <span class="align-middle"><?= lang('app.help') ?></span>
            </a>
					</li>
                    
                    
                    <?php if($privileges->can('profile_edit')): ?>
                                        <li class="sidebar-item">
						<a class="sidebar-link" href="<?= namedRoute('dashboard/profile') ?>">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle"><?= lang('app.profile') ?></span>
            </a>
					</li>
                    <?php endif ?> 
             
             <?php if(session()->get('designer_mode')): ?>       
            <li class="sidebar-item">
						<a class="sidebar-link" href="<?= namedRoute('dashboard/users') ?>">
              <i class="align-middle" data-feather="log-out"></i> <span class="align-middle"><?= lang('app.logout') ?> (<?= session()->get('user_display_name') ?>)</span>
            </a>
            </li>
            <?php endif ?>
            
					<li class="sidebar-item">
						<a class="sidebar-link" href="<?= namedRoute('dashboard/logout'); ?>">
              <i class="align-middle" data-feather="log-out"></i> <span class="align-middle"><?= lang('app.logout') ?></span>
            </a>
					</li>
                    
            



				
				</ul>

				<div class="sidebar-cta">
					<div class="sidebar-cta-content">
						<strong class="d-inline-block mb-2"><?= lang('app.need-help') ?></strong>
						<div class="mb-3 text-sm">
							<?= lang('app.need-help-sub') ?>
						</div>
						<div class="d-grid">
							<a href="<?= namedRoute('dashboard/contact') ?>" class="btn btn-primary"><?= lang('app.contact-us') ?></a>
						</div>
					</div>
				</div>
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
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
               <span class="text-dark"><?= session()->get('user_display_name') ?></span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
                            <?php if($privileges->can('profile_edit')): ?>
								<a class="dropdown-item" href="<?= namedRoute('dashboard/profile') ?>"><i class="align-middle me-1" data-feather="user"></i> <?= lang('app.profile') ?></a>
                            <?php endif ?> 
                            
								<a class="dropdown-item" href="<?= namedRoute('dashboard/contact') ?>"><i class="align-middle me-1" data-feather="help-circle"></i> <?= lang('app.help') ?></a>
								<div class="dropdown-divider"></div>
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
        
       
