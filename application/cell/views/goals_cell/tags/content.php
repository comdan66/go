<?php 
  if (!$goal->tags)
    return;
?>
<div id='tags'>
  <h2>分類標簽</h2>
  <div class='tags'>
<?php 
    foreach ($goal->tags as $tag) { ?>
      <a href='' class='tag'><?php echo $tag->name;?></a>
<?php 
    }?>
  </div>
</div>