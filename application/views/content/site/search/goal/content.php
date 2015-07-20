<a href='<?php echo base_url ('goal', $goal->id);?>' class='goal'>
  <div class='img'>
    <img src='<?php echo isset ($picture) ? $picture->name->url () : $goal->cover ();?>' />
  </div>
  
  <div class='user'>
    <div class='avatar'>
      <img src='<?php echo isset ($users) ? $users[$goal->user_id]->avatar () : $goal->user->avatar ();?>' />
    </div>
    
    <div class='title'><?php echo $goal->title;?></div>

    <div class='stars'>
<?php foreach ($goal->score_star () as $star) {?>
          <i class='icon-star-<?php echo $star;?>'></i>
<?php }?>
    </div>
  </div>
  <div class='introduction'><?php echo mb_strimwidth ($goal->introduction, 0, rand(100, 500), '…','UTF-8');?></div>
  <div class='created_at' data-time="<?php echo $goal->created_at;?>"><?php echo $goal->created_at;?></div>
</a>
