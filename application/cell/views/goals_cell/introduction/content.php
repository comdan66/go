<div id='introduction'>
  <div class='introduction'>
    <div class='introduction_container'>
      <div class='top'>
        <div class='l'>
          <h1 class='title'><?php echo $goal->title;?></h1>
          <div class='address'><?php echo $goal->address;?></div>
        </div>
        <div class='r stars can'>
          <i class='icon-star-2' data-ori='2'></i>
          <i class='icon-star-2' data-ori='2'></i>
          <i class='icon-star-1' data-ori='1'></i>
          <i class='icon-star-0' data-ori='0'></i>
          <i class='icon-star-0' data-ori='0'></i>
        </div>
      </div>
      <article class='center'><?php echo $goal->introduction;?></article>
      <div class='bottom'>
        <div class='fb'><div class="fb-like" data-href="<?php echo base_url ('goal', $goal->id);?>" data-send="false" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></div>
        <div class='count icon-eye'>100</div>
      </div>
    </div>
    <?php echo $goal->pictures ? render_cell ('goals_cell', 'images', $goal) : '';?>
  </div>
  <div class='details'>
    <div class='details_container'>
      <div class='l'>
        <div class='t'>2.5</div>
        <div class='b'>6 個評分的平均分數評分的平均分數</div>
      </div>
      <div class='detail' data-has_loaded='false'>
        <div class='row'><div>1</div><div>顆星</div><div data-width='calc((100% - 75px) * 1)'></div><div>10</div></div>
        <div class='row'><div>1</div><div>顆星</div><div data-width='calc((100% - 75px) * 0.2)'></div><div>10</div></div>
        <div class='row'><div>1</div><div>顆星</div><div data-width='calc((100% - 75px) * 0.5)'></div><div>10</div></div>
        <div class='row'><div>1</div><div>顆星</div><div data-width='calc((100% - 75px) * 0.7)'></div><div>10</div></div>
        <div class='row'><div>1</div><div>顆星</div><div data-width='calc((100% - 75px) * 0.1)'></div><div>10</div></div>
      </div>
      <div class='stars can'>
        <i class='icon-star-2' data-ori='2'></i>
        <i class='icon-star-2' data-ori='2'></i>
        <i class='icon-star-1' data-ori='1'></i>
        <i class='icon-star-0' data-ori='0'></i>
        <i class='icon-star-0' data-ori='0'></i>
      </div>
    </div>
    <?php echo render_cell ('goals_cell', 'maps', $goal);?>
    <?php echo render_cell ('goals_cell', 'maylike');?>
  </div>
</div>