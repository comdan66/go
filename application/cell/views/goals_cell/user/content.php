<div id='user'>
  <div class='avatar imgLiquid_center'>
    <img src='<?php echo $goal->user->avatar ();?>' />
  </div>
  <a class='follow icon-uniE610'></a>
  <div class='name'>
    <a href=''><?php echo $goal->user->name;?></a>
    <div class='fb'>
      <div class="fb-like" data-href="<?php echo base_url ('goal', $goal->id);?>" data-send="false" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
    </div>
  </div>
</div>