<style>
.logo-con {
	text-align: center;
	margin: 30px 0;
}
.scount {
	text-align: right;
}
.t2 {
	font-size: 14px;
	color: #797979;
	font-weight: normal;
	line-height: 1.3;
	margin-bottom: 20px;
}
input, select {
	color: #797979 !important;
}
.langcon {
	text-align: center;
	margin-top: 10px;
}
.container.vcenter {
	flex-direction: column;
	flex: 0;
}
</style>
 <div class="container vcenter">
 <div class="logo-con"><a href="https://sitekly.com"><img src="http://sitekly.com/images/logo-install.png"/></a></div>
  <div class="row align-items-center">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 formcol bg-white from-wrapper bs">
      <div class="container">
      <div class="scount"><?= lang('install.step').' '.$step.'/'.$laststep?></div>
        <h4><?= $title ?></h4>
        <hr>
        <h5 class="t2"><?= $description ?></h5>
        
        <form class="" method="post" id="<?= isset($formid) ? $formid : '' ?>">
         <?= csrf_field() ?>
          <div class="row">
 
           <?php foreach($rules as $key=>$data): ?>
           
           <? 
           $row[$key] = isset($row[$key]) ? $row[$key] : '';
           $row[$key] = (isset($data['default']) && empty($row[$key])) ? $data['default'] : $row[$key];
           
           $itype = isset($data['itype']) ? $data['itype'] : 'text';
           if(isset($data['type']) && $data['type'] == 'hidden') {
            echo form_input(['type'=>'hidden','name'=>$key,'id'=>$key,'class'=>'form-control','value'=>set_value($key,$row[$key])]);
            continue;
            } ?>
            <div class="col-<?= isset($data['size']) ? $data['size'] : 12 ?>">
              <div class="form-group">
               <label for="<?= $key ?>"><?= $data['label'] ?></label>
               <? if(isset($data['type'])) {
                   if($data['type'] == 'select'){
                   $options = isset($data['options']) ? $data['options'] : ['0' =>lang('app.no'),'1' => lang('app.yes')];
                   echo form_dropdown($key, $options, set_value($key,$row[$key]),['class'=>'form-control','id'=>$key]); 
                   }
                   else if($data['type'] == 'radio'){
                   $value = set_value($key,$row[$key]);
                   $value = empty($value) ? $data['checked'] : $value;
                   $options = isset($data['options']) ? $data['options'] : ['0' =>lang('app.no'),'1' => lang('app.yes')];
                   foreach($options as $name=>$label){ 
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
                   
             
                   }
                   else if($data['type'] == 'tsDate'){
                   echo form_input(['type'=>'date','name'=>$key,'id'=>$key,'class'=>'form-control','value'=>set_value($key,date('Y-m-d',$row[$key]))]);     
                   } else if($data['type'] == 'disabled'){
                   echo form_input(['disabled'=>'true','name'=>$key,'id'=>$key,'class'=>'form-control','value'=>set_value($key,$row[$key])]);   
                   }
               } else {
                    
  
                    echo form_input(['type'=>$itype,'name'=>$key,'id'=>$key,'class'=>'form-control','value'=>set_value($key,$row[$key])]); 
                }
                if(isset($data['details'])){
                    echo '<span class="t2">'.$data['details'].'</span>';
                }
                ?>
              </div>
            </div>
           <?php endforeach; ?>
             
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
            <?php 
            if(!empty($prevstep)) { ?>
              <a class="btn btn-secondary btn-sm" href="<?= $prevstep ?>"><?= lang('install.prev-step')  ?></a>
              <?php } ?>
            </div>
            
            <div class="col-12 col-sm-8 text-right">
            <?php if($skip) { ?>
              <a class="btn btn-secondary btn-sm" href="?skip"><?= lang('install.skip-step')  ?></a>
              <?php } ?>
              <button type="submit" class="btn btn-primary loadshow btn-sm"><?= lang('install.next-step') ?></button>
            </div>
            
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <div class="langcon"><a class="btn btn-sm" href="?lang=en">English</a><a class="btn btn-sm" href="?lang=pl">Polski</a></div>
  
</div>          