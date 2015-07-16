<div id='boxs'>
  <div class='map'>
    <i></i><i></i><i></i><i></i>
    <div id='map'></div>
    <div class='loading_data'>資料讀取中...</div>
  </div>
  <div class='r'>
    <div class='comments'>
      <h2>熱門回應</h2>
  <?php foreach ($comments as $comment) { ?>
          <div class='comment'>
            <div class='ll'>
              <a href='' class='imgLiquid_top'>
                <img src='<?php echo $comment->user->avatar ();?>' />
              </a>
            </div>
            <div class='rr'>
              <div class='lll'>
                <div class='value'><?php echo $comment->content;?></div>
                <a href='' class='more'>更多詳細內容..</a>
              </div>
              <div class='rrr'>
                <a href='' class='imgLiquid_center'>
                  <img src='<?php echo $comment->goal->cover ('100x100c');?>' />
                </a>
              </div>
            </div>
          </div>
        <?php
        }?>
    </div>
  </div>
</div>