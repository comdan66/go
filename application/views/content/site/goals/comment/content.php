<div class='comment'>
  <div class='l'>
    <div class='avatar imgLiquid_top'>
      <img src='<?php echo $comment->user->avatar ();?>' />
    </div>
  </div>
  <div class='r'>
    <div class='content'><?php echo $comment->content;?></div>
    <div class='created_at' data-time='<?php echo $comment->created_at;?>'><?php echo $comment->created_at;?></div>
  </div>
</div>