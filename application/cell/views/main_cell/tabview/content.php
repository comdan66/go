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
    foreach ($data as $goals) {
      if (count ($goals) >= 4) { ?>
        <div class='content'>
          <?php 
          foreach ($goals as $i => $goal) {
            if ($i % 2 == 0) { ?>
              <div class='row'>
      <?php } ?>
                <div class='<?php echo $i % 2 == 0 ? 'l' : 'r';?>'>
                  <div class='ll'>
                    <a class='imgLiquid_top' href='<?php echo base_url ('goal', $goal->id);?>'>
                      <img src='<?php echo $goal->cover ('200x200c');?>' />
                    </a>
                  </div>
                  <div class='rr'>
                    <div class='title'>
                      <a href='<?php echo base_url ('goal', $goal->id);?>'><h3><?php echo $goal->title;?></h3></a>
                      <div class='rrr'>
                  <?php foreach ($goal->score_star () as $star) {?>
                          <i class='icon-star-<?php echo $star;?>'></i>
                  <?php }?>
                      </div>
                    </div>
                    <article>
                      <?php echo mb_strimwidth ($goal->introduction, 0, 310, '…','UTF-8');?>
                    </article>
                    <div class='created_at' data-time='<?php echo $goal->created_at;?>'><?php echo $goal->created_at;?></div>
                  </div>
                </div>
      <?php if ($i % 2 == 1) { ?>
              </div>
      <?php }
          } ?>
        </div>
<?php 
      }
    } ?>
  </div>
</div>