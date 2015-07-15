<div id='banner'>
  <div class='banners'>
<?php
    foreach ($pictures as $picture) { ?>
        <a href='' class='banner imgLiquid_top' data-title='<?php echo $picture->goal->title;?>'>
          <img src='<?php echo $picture->name->url ();?>' />
        </a>
<?php
    } ?>
    <div class='arrow left icon-chevron-left'></div>
    <div class='arrow right icon-chevron-right'></div>
    <div class='bottom'></div>
  </div>
  <div class='r'>
    <h2>熱門關鍵字</h2>
<?php 
    foreach ($tags as $tag) { ?>
        <a class='tag <?php echo 't' . sprintf ('%02d', rand (1, 5));?>' href=''><?php echo $tag->name;?></a>
<?php 
    } ?>
  </div>
</div>