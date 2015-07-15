<div id='tabview'>
  <div class='tabview_items'>
<?php 
    foreach (array_keys ($data) as $item) { ?>
      <div class='item'><?php echo $item;?></div>
<?php 
    } ?>
  </div>
  <div class='tabview_contents'>
<?php
    foreach ($data as $goals) { ?>
      <div class='content'>
        <?php 
        foreach ($goals as $i => $goal) {
          if ($i % 2 == 0) { ?>
            <a class='row' href=''>
    <?php } ?>
              <div class='<?php echo $i % 2 == 0 ? 'l' : 'r';?>'>
                <div class='ll'>
                  <div class='imgLiquid'>
                    <img src='<?php echo $goal->cover ();?>' />
                  </div>
                </div>
                <div class='rr'>
                  <div class='title'>
                    <h3><?php echo $goal->title;?></h3>
                    <div class='rrr'>
                      <?php 
                      foreach ($goal->score_star () as $star) {?>
                        <i class='icon-star-<?php echo $star;?>'></i>
                      <?php 
                      }?>
                    </div>
                  </div>
                  <article>
                    <?php echo mb_strimwidth ($goal->introduction, 0, 310, '…','UTF-8');?>
                  </article>
                  <div class='created_at' data-time='2013-10-20 12:12:12'>2013-10-20 12:12:12</div>
                </div>
              </div>
    <?php if ($i % 2 == 1) { ?>
            </a>
    <?php }
        } ?>
      </div>
<?php 
    } ?>
  </div>
</div>