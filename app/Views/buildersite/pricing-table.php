<style>
.ibox {
	padding: 10px;
}
.ibox .title {
	font-size: 20px;
	text-align: center;
	color: #000;
	font-weight: 700;
}
.ibox .fcon{
    display: flex;
}
.fcon div{
   width:100%;
}
.fcon .price {
	font-size: 48px;
	font-weight: bold;
	width: auto;
	padding: 0 5px;
}
.fcon .ptop {
	margin-top: 15px;
	font-size: 18px;
}
</style>
<?php if ($pricing) : ?>
<div class="inner-row lg-m40 md-m10">
<?php foreach ($pricing as $row) : ?>
<div class="icol col-lg-3 col-sm-12">
<div class="ibox">
<div class="title"><?= $row['name'] ?></div>
<div class="fcon">
    <div></div>
    <div class="price"><?= $row['price'] ?></div>
    <div><div class="ptop">zł</div><div class="pbot">/miesiąc</div></div>
</div>
<div><?= $row['space'] ?> MB</div>
<div><?= ($row['ads'] == 0) ? lang('app.no-ads') : '' ?></div>
<div><?= ($row['domain'] == 0) ? '' : lang('app.own-domain') ?></div>
<div><?= ($row['emails'] == 0) ? '' : $row['emails'].' '.lang('app.email-acc') ?></div>

</div>
</div>
 <?php endforeach ?>
</div>
<?php endif ?>