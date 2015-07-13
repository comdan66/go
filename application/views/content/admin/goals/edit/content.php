<?php echo render_cell ('admin_frame_cell', 'header'); ?>
<input type='hidden' id='marker' data-lat='<?php echo $goal->latitude;?>' data-lng='<?php echo $goal->longitude;?>' value='<?php echo $goal->id;?>' />

<div id='container'>
  <div class='map'>
    <i></i><i></i><i></i><i></i>
    <div id='map'></div>
    
    <div id='error'>asdasdsd</div>

    <div id='error' <?php echo isset ($message) && $message ? " class='show'":''; ?>>
<?php if (isset ($message) && $message) { ?>
        <?php echo $message;?>
<?php } ?>
    </div>

    <div id='loading_data'>資料讀取中...</div>

    <form id='options' action='<?php echo base_url ('admin', 'goals', 'update', $goal->id);?>' method='post' enctype='multipart/form-data'>
      <input type='text' id='title' name='title' class='title' value='<?php echo $title ? $title : $goal->title;?>' placeholder='請輸入標題..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' />

      <input type='hidden' id='latitude' name='latitude' class='latitude' value='<?php echo $latitude ? $latitude : $goal->latitude;?>' placeholder='請輸入緯度..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' readonly/>
      <input type='hidden' id='longitude' name='longitude' class='longitude' value='<?php echo $longitude ? $longitude : $goal->longitude;?>' placeholder='請輸入經度..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' readonly/>
      <input type='text' id='address' name='address' class='address' value='<?php echo $address ? $address : $goal->address;?>' placeholder='請輸入地址..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' />

      <textarea id='introduction' name='introduction' class='introduction' placeholder='請輸入介紹..'><?php echo $introduction ? $introduction : $goal->introduction;?></textarea>
      
      <div class='tags'>
  <?php foreach (GoalTag::all () as $tag) {?>
          <div class='tag'>
            <input type='checkbox' name='tag_ids[]' id='tag_<?php echo $tag->id;?>' value='<?php echo $tag->id;?>'<?php echo in_array ($tag->id, $tag_ids ? $tag_ids : column_array ($goal->tag_goal_maps, 'goal_tag_id')) ? ' checked' : ''?>/>
            <span class='ckb-check'></span>
            <label for='tag_<?php echo $tag->id;?>'><?php echo $tag->name;?></label>
          </div>
  <?php } ?>
      </div>

      <div id='pics'>
  <?php foreach ($goal->pictures as $picture) { ?>
          <div class='pic'>
            <div class='fanc' href='<?php echo $picture->name->url ();?>' data-fancybox-group='fancybox_group'>
              <input type='hidden' name='pic_ids[]' value='<?php echo $picture->id;?>' />
              <img src='<?php echo $picture->name->url ('50x50c');?>' />
            </div>
            <div class='delete'>&#10006;</div>
          </div>
  <?php } ?>
      </div>

      <div id='pictures'></div>

      <div id='links'>
  <?php foreach ($goal->links as $i => $link) { ?>
          <div class='link'><div class='l'><input type='hidden' name='old_links[<?php echo $i;?>][id]' value='<?php echo $link->id;?>' /><input type='text' name='old_links[<?php echo $i;?>][value]' placeholder='請輸入參考鏈結..' maxlength='200' value='<?php echo $link->value;?>'></div><div class='r'><button type='button'><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path fill="#444444" d="M4 10v20c0 1.1 0.9 2 2 2h18c1.1 0 2-0.9 2-2v-20h-22zM10 28h-2v-14h2v14zM14 28h-2v-14h2v14zM18 28h-2v-14h2v14zM22 28h-2v-14h2v14z"></path><path fill="#444444" d="M26.5 4h-6.5v-2.5c0-0.825-0.675-1.5-1.5-1.5h-7c-0.825 0-1.5 0.675-1.5 1.5v2.5h-6.5c-0.825 0-1.5 0.675-1.5 1.5v2.5h26v-2.5c0-0.825-0.675-1.5-1.5-1.5zM18 4h-6v-1.975h6v1.975z"></path></svg></button></div></div>
  <?php }
        if ($links) {
          foreach ($links as $link) { ?>
            <div class='link'><div class='l'><input type='text' name='links[]' placeholder='請輸入參考鏈結..' maxlength='200' value='<?php echo $link;?>'></div><div class='r'><button type='button'><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path fill="#444444" d="M4 10v20c0 1.1 0.9 2 2 2h18c1.1 0 2-0.9 2-2v-20h-22zM10 28h-2v-14h2v14zM14 28h-2v-14h2v14zM18 28h-2v-14h2v14zM22 28h-2v-14h2v14z"></path><path fill="#444444" d="M26.5 4h-6.5v-2.5c0-0.825-0.675-1.5-1.5-1.5h-7c-0.825 0-1.5 0.675-1.5 1.5v2.5h-6.5c-0.825 0-1.5 0.675-1.5 1.5v2.5h26v-2.5c0-0.825-0.675-1.5-1.5-1.5zM18 4h-6v-1.975h6v1.975z"></path></svg></button></div></div>
    <?php }
        } ?>
      </div>

      <div class='btns'>
        <button type='button' id='choice_picture'>&#10010; 照片</button>
        <button type='button' id='add_links'>&#10010; 鏈結</button>
      </div>
      
      <div class='btns control'>
        <a href='<?php echo base_url ('admin', 'goals');?>'>回列表</a>
        <button type='submit' id='submit'>確定修改</button>
      </div>
    </form>

  </div>
</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
