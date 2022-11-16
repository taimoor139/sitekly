<main class="content">
<div class="row">
						<div class="col-md-10 col-xl-8 mx-auto">
						
                        <?php if($showPackages): ?>  
                        <h1 class="text-center"><?= lang('app.choose-your-plan') ?> </h1>
							<p class="lead text-center mb-4"><?= lang('app.pricing-custom-message') ?></p>
                         <?php endif ?>
                         
                        <?php if(!$showPackages): ?>  
                          
                         <?php if($privileges->can('package_change')): ?>
                            <div class="text-center"><button type="submit" data-show='Request a package change' data-hide='Use current package' id="packageToggle" class="btn btn-primary mb-3">Request a package change</button></div>
                           <?php endif; ?> 
                         <div class="periodSelect row justify-content-center mt-3 mb-2">
								<div class="col-auto">
									<nav class="nav btn-group">
                                    <?php if($currentPackage['price_monthly_month'] != -1): ?>
										<button data-period="1" data-total='<?= $currentPackage['pricing']['1']['total_formated_code'] ?>' class="btn btn-outline-primary"><?= lang('app.monthly-billing') ?></button>
                                    <?php endif ?>
                                    <?php if($currentPackage['price_monthly_year'] != -1): ?>
										<button data-period="12" data-total='<?= $currentPackage['pricing']['12']['total_formated_code'] ?>' class="btn btn-outline-primary"><?= lang('app.annual-billing') ?></button>
                                    <?php endif ?>
									</nav>
								</div>
							</div>	
             
                        <?php endif ?>

                    <div class="packageSelect <?= $showPackages ? '' : 'd-none' ?>">
                            <div class="row justify-content-center mt-3 mb-2">
								<div class="col-auto">
									<nav class="nav btn-group">
										<a href="#monthly" class="btn btn-outline-primary active" data-bs-toggle="tab"><?= lang('app.monthly-billing') ?></a>
										<a href="#annual" class="btn btn-outline-primary" data-bs-toggle="tab"><?= lang('app.annual-billing') ?></a>
									</nav>
								</div>
							</div>	
                        
							<div class="tab-content" >
                        
							<?php foreach(['monthly'=>['class'=>'active show','period'=>'1'],'annual'=>['class'=>'','period'=>'12']] as $type=>$periodArray){ ?>	
                            	<div class="tab-pane fade <?= $periodArray['class'] ?>" id="<?= $type ?>">
									<div class="row py-4 pricing flex-wrap flex-md-nowrap">
								 <?php foreach ($pricing as $row) : ?>	
                                 <?php if(!isset($row['pricing'][$periodArray['period']]) ) continue;
                                 $formated = $row['pricing'][$periodArray['period']];
                                 ?>
                                    	<div class="mb-3 mb-md-0">
											<div class="card text-center h-100">
												<div class="card-body d-flex flex-column">
													<div class="mb-4">
														<h5><?= $row['name'] ?></h5>
														<span class="display-4"><?= $formated['month_formated'] ?></span>
														<span class="text-small4">/<?= lang('app.month-short') ?></span>
													</div>
													<ul class="list-unstyled">
														<li class="mb-2"><?= lang('app.disk-space') ?>: <?= $row['space'] ?> MB</li>
														<li class="mb-2"><?= ($row['ads'] == 0) ? lang('app.no-ads') : '' ?></li>
                                                        <li class="mb-2"><?= ($row['domain'] == 1) ? lang('app.use-own-domain') : '' ?></li>
                                                        <li class="mb-2"><?= ($row['emails'] > 0) ? lang('app.email-accounts').': '.$row['emails'] : ''?></li>
                                                        <?php foreach(explode(PHP_EOL,$row['custom']) as $line): ?>
                                                        <li class="mb-2"><?= $line ?></li>
                                                        <?php endforeach ?>
                                                        
													</ul>
													<div class="mt-auto">
														<button data-package="<?= $row['id'] ?>" data-period="<?= $periodArray['period'] ?>" class="btn btn-lg btn-primary package-select"><?= lang('app.pick-this') ?></button>
													</div>
												</div>
											</div>
										</div>
                                   <?php endforeach ?>    
									</div>
								</div>
                           <?php } ?>     
							</div>
          </div>
           
                <div class="alert-window" style="display: none;">
            <div class="col-12">
              <div class="alert alert-danger" role="alert">
               
              </div>
            </div>
            </div>

                <form method="post" id="payform" action="" onresponse="payform">
                <?= csrf_field() ?>
                <input type="hidden" name="site" value="<?= $site['id'] ?>" />
                <input type="hidden" id="step" name="step" value="1" />
                <input type="hidden" id="package" name="package" value="<?= $site['package'] ?>" />
                <input type="hidden" id="period" name="period" value="1" />
        
        <div class="part2 text-center d-none">

            <div class="paymentMethodsCon">
            <h3 class="mt-5">Choose a payment method</h3>
            <div class="row py-4" id="paymentMethods">
                  <?php foreach($paymentMethods as $id=>$label): ?>
                  <div class="mb-3 mb-md-0 method <?= array_key_first($paymentMethods) == $id ? 'active' : '' ?>" id="<?= $id ?>"><img src="<?= base_url('app/img/payments/'.$id.'.svg') ?>"/></div>
                  <?php endforeach; ?>
            </div> 
            <input type="hidden" id="method" name="method" value="<?= array_key_first($paymentMethods) ?>" />
            </div>    
 <div class="total" style="display: none;">
<?= lang('app.total-amount') ?>: <span class="amount"></span>
 </div> 
 
 
  <button type="submit" name="payment" value="1" class="btn btn-primary ajax btn-lg mt-3 mb-5 px-7"><?= lang('app.continue') ?></button>
</div>  
  
</form>
    <?= getView('dashboard/parts/faq') ?>            
                            
						</div>
					</div>
</main>

<?= $initMethods ?>
