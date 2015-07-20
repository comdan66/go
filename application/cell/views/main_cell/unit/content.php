<div id='unit'>
  <h2>精選1</h2>
  <div class='units'>
<?php
    $name = '';
    foreach ($goals as $goal) { ?>
      <a href='<?php echo base_url ('goal', $goal->id);?>' class='unit'>
        <img src='<?php echo $goal->cover ('400x400c');?>' />
        <div class='cover'>
          <div class='pv icon-eye'><?php echo $goal->pageview;?></div>
          <div class='tags'>
      <?php foreach ($goal->tags as $tag) { ?>
              <div class='tag'><?php echo $name = $tag->name;?></div>
      <?php } ?>
          </div>
        </div>
        <div class='title'><?php echo $goal->title;?></div>
        <div class='mobile_pv icon-eye'><?php echo $goal->pageview;?></div>
      </a>
<?php
    }?>
  </div>
  <div class='more'>
    <?php
    if ($name) { ?>
      <a href='<?php echo base_url ('search') . '?q=' . $name;?>'>MORE</a>
<?php
    } ?>
  </div>
</div>