<?php echo render_cell ('admin_frame_cell', 'header'); ?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
<?php echo render_cell ('admin_frame_cell', 'sides', $frame_sides);?>
  <div class='contents'>
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
    <?php foreach (GoalTagCategory::detail_tags () as $category => $tags) {
            if ($category) { ?>
              <div class='category'><?php echo $category;?></div>
      <?php }
            foreach ($tags as $tag) { ?>
              <div class='tag'>
                <input type='checkbox' name='tag_ids[]' id='tag_<?php echo $tag->id;?>' value='<?php echo $tag->id;?>'<?php echo in_array ($tag->id, $tag_ids ? $tag_ids : column_array ($goal->tag_goal_maps, 'goal_tag_id')) ? ' checked' : ''?>/>
                <span class='ckb-check'></span>
                <label for='tag_<?php echo $tag->id;?>'><?php echo $tag->name;?></label>
              </div>
      <?php }
          } ?>
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
        <div id='picture_links'>
    <?php if ($picture_links) {
            foreach ($picture_links as $picture_link) { ?>
              <div class='picture_link'><div class='l'><input type='text' name='picture_links[]' placeholder='請輸入照片鏈結..' value='<?php echo $picture_link;?>'></div><div class='r'><button type='button' class='icon-bin'></button></div></div>
      <?php }
          } ?>
        </div>

        <div id='links'>
    <?php foreach ($goal->links as $i => $link) { ?>
            <div class='link'><div class='l'><input type='hidden' name='old_links[<?php echo $i;?>][id]' value='<?php echo $link->id;?>' /><input type='text' name='old_links[<?php echo $i;?>][value]' placeholder='請輸入參考鏈結..' value='<?php echo $link->value;?>'></div><div class='r'><button type='button' class='icon-bin'></button></div></div>
    <?php }
          if ($links) {
            foreach ($links as $link) { ?>
              <div class='link'><div class='l'><input type='text' name='links[]' placeholder='請輸入參考鏈結..' value='<?php echo $link;?>'></div><div class='r'><button type='button' class='icon-bin'></button></div></div>
      <?php }
          } ?>
        </div>

        <div class='btns feature'>
          <button type='button' id='choice_picture_link'>&#10010; 照片鏈結</button>
          <button type='button' id='choice_picture'>&#10010; 上傳照片</button>
          <button type='button' id='add_links'>&#10010; 參考鏈結</button>
        </div>
        
        <div class='btns control'>
          <a href='<?php echo base_url ('admin', 'goals');?>'>回列表</a>
          <button type='submit' id='submit'>確定修改</button>
        </div>
      </form>

    </div>
  </div>
</div>

  <?php echo render_cell ('admin_frame_cell', 'footer');?>
