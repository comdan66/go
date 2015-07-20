<div class='to_comment'>
  <textarea class='comment' placeholder='<?php echo identity ()->user () ? '你覺得這個景點如何..' : '登入留言吧！';?>' maxLength='250'<?php echo identity ()->user () ? '' : ' readonly';?>></textarea>
  <div class='bottom'>
    <div class='l'></div>
    <div class='r'>
<?php if (identity ()->user ()) { ?>
        <button>留言</button>
<?php } else { ?>
        <a href='<?php echo facebook ()->login_url ('platform', 'fb_sign_in', 'goal', $goal->id);?>'>登入</a>
<?php }?>
    </div>
  </div>
</div>
<div class='comment_list'>
  <h2>最新留言</h2>
  <div class='comments'>
    <div class='loading' data-next_id='0'><div></div></div>
    <div class='more'>查看更多留言</div>
  </div>
</div>