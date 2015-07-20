<div class='tags'>
  <?php
  foreach ($tags as $tag) { ?>
    <a href='<?php echo base_url ('search') . '?q=' . $tag->name;?>' class='tag'><?php echo $tag->name;?></a>
  <?php
  }
  ?>
</div>