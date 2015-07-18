<div id='images'>
  <h2>景點照片</h2>
  <div class='images'>
<?php
    foreach ($goal->pictures as $picture) { ?>
      <a class='image fancybox imgLiquid_center' href='<?php echo $picture->name->url ();?>' data-fancybox-group='fancybox_group'>
        <img src='<?php echo $picture->name->url ('200x200c');?>' />
      </a>
<?php
    } ?>
  </div>
</div>