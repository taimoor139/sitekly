<div class="container mcon">
<?php if ($stats) : ?>
	<div class="row" id="varcount">
    
    <?php if(is_array($package) && $privileges->can('system','admin_info')){ ?>
            <div class="col mb-4">
			<div class="card h-100 bs sitecard">
				<h5 class="card-title h3c">
					<?= lang('app.system'); ?>
				</h5>
				<div class="card-body">
                    <ul class="list-group list-group-flush">
                    	<li class="list-group-item d-flex justify-content-between align-items-center">
                    		<?= lang('app.package'); ?> <span><span class="badge badge-light"><?= $package['package'] ?></span></span>
                    	</li>
                        <?php if($version == $package['newest']) { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                        		<?= lang('app.version'); ?><span><span class="badge badge-light"><?= $version ?></span><span class="badge badge-success"><?= $package['newest'] ?></span></span>
                        	</li>
                        <?php } else { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                        		<?= lang('app.version'); ?><span><span class="badge badge-light"><?= $version ?></span><span class="badge bg-warning text-dark"><?= $package['newest'] ?></span></span>
                                <a href="http://sitekly.com/update/<?= $package['public_key'] ?>/<?= $version ?>" class="btn btn-warning btn-sm" role="button"><?= lang('app.update'); ?></a> 
                        	</li>
                        <?php } ?>
                        
                        
                        
                        
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                    		<?= lang('app.site-limit'); ?> <span><span class="badge badge-light"><?= ($package['limit'] != '-1') ? $package['used'].' / ' : '' ?> <?= ($package['limit'] != '-1') ? $package['limit'] : lang('app.unlimited') ?></span></span>
                    	</li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                    		<?= lang('app.updates-until'); ?> <span><span class="badge badge-light"><?= ($package['updates'] != '-1') ? date('d.m.Y',$package['updates']) : lang('app.lifetime') ?></span></span>
                    	</li>
                    </ul>
                    <div class="text-right">
                    	<a href="http://sitekly.com/upgrade/<?= $package['public_key'] ?>" class="btn btn-primary btn-sm" role="button"><?= lang('app.upgrade'); ?></a>
                    </div>
				</div>
			</div>
		</div>
    <?php } ?>
    
	<?php

     foreach ($stats as $stat) : ?>	
    <?php if(!$privileges->can('stat_'.$stat['label'],'admin_info')) continue; ?>
    <?php echo $stat['label'] == 'income-statistics' ? '</div><div class="row row-cols-1"><div class="col mb-4 col-md-4 col-12">' :'<div class="col mb-4">'; ?>
			<div class="card h-100 bs sitecard">
				<h5 class="card-title h3c">
					<?= lang('app.'.$stat['label']); ?>
				</h5>
				<div class="card-body">
					<ul class="list-group list-group-flush">
					
                    <?php foreach ($stat['stats'] as $k=>$data) : ?>	
                    
                    <li class="list-group-item d-flex justify-content-between align-items-center">
							<?= lang($data['label']); ?>
							<span>
                            <span class="badge badge-light">
								<?= isset($data['thisFormated']) ? $data['thisFormated'] : '0' ?> <?= isset($data['unit']) ? $data['unit'] : '' ?>
							</span>
                          <?php if (isset($data['change'])) : ?>	  
                            <span class="badge badge-<?= $data['change']['type'] ?>">
								<?= $data['change']['value'] ?>%
							</span>
                          <?php endif ?>   
                            </span>
						</li>
                    
                    <?php endforeach ?> 
					</ul>
                    <?php if ($stat['button']) : ?>
                    <div class="text-right">
                    <a href="<?= namedRoute($stat['button']['link']) ?>" class="btn btn-primary btn-sm" role="button"><?= lang($stat['button']['label']) ?></a>
                    </div>
                    <?php endif ?>
				</div>
			</div>
		</div>
     <?php endforeach ?>   
        
	
    <?php if($privileges->can('stat_income-statistics','admin_info')) { ?>
     <div class="col mb-4 col-md-8 col-12">
 
 
			<div class="card h-100 bs sitecard">
				<h5 class="card-title h3c"><?= lang('app.income-last-month'); ?> (<?= $currency; ?>)</h5>
				<div class="card-body">
				<canvas id="chLine" width="400" height="150"></canvas>	
				</div>
			</div>

</div>

<?php } ?>
    
    </div>
  <?php endif ?>   

<style>
@media screen and (max-width: 800px) {
#varcount .col{
-ms-flex: 0 0 100%;
flex: 0 0 100%;
max-width: 100%;
}
}
</style>

<?php if($privileges->can('stat_income-statistics','admin_info')) : ?>
<script src="<?= base_url('app/js/Chart.bundle.min.js') ?>"></script>
<script>
var colors = ['#007bff','#28a745','#333333','#c3e6cb','#dc3545','#6c757d'];
var chLine = document.getElementById("chLine");
var chartData = {
  labels: <?= json_encode($fullstats['labels'][0]) ?>,
  labels_full: <?= json_encode($fullstats['labels']) ?>,
  datasets: [
  {
     data: <?= json_encode($fullstats['this']) ?>,
     backgroundColor: 'transparent', //colors[3],
     borderColor: colors[1],
     borderWidth: 4,
     pointBackgroundColor: colors[1]
   },
   <?php if (isset($fullstats['prev'])) : ?>
   {
    data: <?= json_encode($fullstats['prev']) ?>,
    backgroundColor: 'transparent',
    borderColor: colors[0],
    borderWidth: 2,
  //  pointRadius: 1,
    pointBackgroundColor: colors[0],
  }
   <?php endif ?>   
  ]
};
if (chLine) {
  new Chart(chLine, {
  type: 'line',
  data: chartData,
  options: {
    scales: {
      xAxes: [{
        
        ticks: {
          beginAtZero: false
        }
        
        
      }]
    },
            tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {

                    var day = chartData['labels_full'][tooltipItem.datasetIndex][tooltipItem.index];
                    
                    return day+": "+tooltipItem.yLabel;
                },
                
                    title: function(tooltipItems, data) {
                return '';
                },
            }
        },
    legend: {
      display: false
    },
    responsive: true
  }
  });
}
</script>
<?php endif ?> 
</div>