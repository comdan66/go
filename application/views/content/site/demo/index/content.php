<?php
  foreach ($pics as $pic) { ?>
    <a href='<?php echo base_url ('search') . '/?rgb[0]=' . $pic->color_red . '&rgb[1]=' . $pic->color_green . '&rgb[2]=' . $pic->color_blue . '';?>' class='color'>
      <img src='<?php echo $pic->name->url ('100x100c');?>'>
      <div class='c' style='background-color: rgb(<?php echo $pic->color_red;?>, <?php echo $pic->color_green;?>, <?php echo $pic->color_blue;?>)'></div>
      <div class='count'><?php echo $pic->count;?></div>

    </a>
<?php
  }
?>