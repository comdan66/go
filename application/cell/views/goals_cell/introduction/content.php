<div id='introduction'>
  <div class='introduction'>
    <div class='introduction_container'>
      <div class='top'>
        <div class='l'>
          <h1 class='title'><?php echo $goal->title;?></h1>
          <div class='address'><?php echo $goal->address;?></div>
        </div>
        <div class='r stars can'>
    <?php foreach ($goal->score_star () as $star) {?>
            <i class='icon-star-<?php echo $star;?>' data-ori='<?php echo $star;?>'></i>
    <?php }?>
        </div>
      </div>
      <article class='center'><?php echo $goal->introduction;?></article>
      <div class='bottom'>
        <div class='fb'><div class="fb-like" data-href="<?php echo base_url ('goal', $goal->id);?>" data-send="false" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></div>
        <div class='count icon-eye'>100</div>
      </div>
    </div>
    <?php echo $goal->pictures ? render_cell ('goals_cell', 'images', $goal) : '';?>
    <div class='left_comment'>
      <?php echo render_cell ('goals_cell', 'comments', $goal);?>
    </div>
  </div>
  <div class='details'>
<?php
    $details = $goal->star_details ();
    $count = $details['count'];
    $details = $details['details'];  ?>
    <div class='details_container'>
      <div class='l'>
        <div class='t'><?php echo round ($goal->score / 20, 1);?></div>
        <div class='b'><?php echo $count;?> 個評分的平均分數</div>
      </div>
      <div class='detail' data-has_loaded='false'>
  <?php foreach ($details as $key => $star_detail) { ?>
          <div class='row'><div><?php echo $key;?></div><div>顆星</div><div data-width='calc((100% - 75px) * <?php echo $star_detail['percent'];?>)'></div><div><?php echo $star_detail['count'];?></div></div>
  <?php } ?>
      </div>
      <div class='stars can'>
  <?php foreach ($goal->score_star () as $star) {?>
          <i class='icon-star-<?php echo $star;?>' data-ori='<?php echo $star;?>'></i>
  <?php }?>
      </div>
    </div>

    <?php echo render_cell ('goals_cell', 'maps', $goal);?>
    <?php echo render_cell ('goals_cell', 'maylike');?>
    <div class='right_comment'>
      <?php echo render_cell ('goals_cell', 'comments', $goal);?>
    </div>
  </div>
</div>