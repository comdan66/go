<div id='banner'>
  <div class='banners<?php echo count ($goal->covers ()) > 3 ? ' can' : '';?>'>
    <?php
    foreach ($goal->covers () as $cover) { ?>
      <div class='banner imgLiquid_center'>
        <img src='<?php echo $cover;?>' />
      </div>
    <?php
    } ?>
  </div>
  <?php
  if (count ($goal->covers ()) > 3) { ?>
    <div class='arrow left icon-chevron-left'></div>
    <div class='arrow right icon-chevron-right'></div>
  <?php
  } ?>
  <div class='bottom'></div>
</div>