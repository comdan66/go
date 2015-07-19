
<?php
  if ($goal->links || $goal->tags) { ?>
    <div class='links<?php echo $goal->links ? '' : ' no';?>'>
      <div class='title'>
        <div class='l'>
      <?php 
          foreach ($goal->tags as $tag) { ?>
            <a href='' class='tag'><?php echo $tag->name;?></a>
      <?php 
          }?>
        </div>
        <div class='r'>相關引用及參考</div>
      </div>
<?php foreach ($goal->links as $link) {?>
        <div class='link'> - <a href='<?php echo $link->value;?>' target='_blank'><?php echo $link->value;?></a></div>
<?php } ?>
    </div>
<?php
  }