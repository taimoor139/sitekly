  <div class="dropdown lang_con abs">
  <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
    <?= $langs['current'] ?>
  </a>

  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
  <?php foreach($langs['supported'] as $k=>$data){ ?>
  <li><a class="dropdown-item" href="<?= namedRoute('lang/'.$k.'/1') ?>"><?= $data[0] ?></a></li>
  <?php } ?>
  </ul>
</div> 