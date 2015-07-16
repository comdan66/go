<div id='unit'>
  <h2>精選1</h2>
  <div class='units'>
<?php
    foreach ($goals as $goal) { ?>
      <a href='' class='unit'>
        <img src='<?php echo $goal->cover ('400x400c');?>' />
        <div class='cover'>
          <div class='pv icon-eye'><?php echo $goal->pageview;?></div>
          <div class='tags'>
      <?php foreach ($goal->tags as $tag) { ?>
              <div class='tag'><?php echo $tag->name;?></div>
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
    <a href=''>MORE</a>
  </div>
</div>