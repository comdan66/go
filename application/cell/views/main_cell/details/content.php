<div id='details'>
  <?php 
  foreach ($goals as $goal) {
    $details = $goal->star_details ();
    $count = $details['count'];
    $details = $details['details']; ?>
    <a href='' class='detail_unit imgLiquid_top'>
      <img src='<?php echo $goal->cover ();?>' />
      <div class='detail'>
        <div class='l'>
          <div class='score'><?php echo round ($goal->score / 20, 1);?></div>
          <div class='desc'><?php echo $count;?> 個評分的平均分數</div>
        </div>
        <div class='r'>
      <?php foreach ($details as $key => $star_detail) { ?>
              <div class='row'><div><?php echo $key;?></div><div>顆星</div><div data-width='<?php echo $star_detail['percent'] * 100;?>'></div><div><?php echo $star_detail['count'];?></div></div>
      <?php } ?>
        </div>
      </div>
    </a>
  <?php 
  }
  ?>
</div>