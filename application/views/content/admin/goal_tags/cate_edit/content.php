<?php echo render_cell ('admin_frame_cell', 'header');?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
<?php echo render_cell ('admin_frame_cell', 'sides', $frame_sides);?>
  <div class='contents'>
<?php
    if (isset ($message) && $message) { ?>
      <div class='error'><?php echo $message;?></div>
<?php
    } ?>

    <form action='<?php echo base_url (array ('admin', 'goal_tags', 'cate_update', $goal_tag_category->id));?>' method='post' enctype='multipart/form-data'>
      <table class='table-form'>
        <tbody>
          <tr>
            <th>名稱</th>
            <td>
              <input type='text' name='name' value='<?php echo $name ? $name : $goal_tag_category->name;?>' placeholder='請輸入名稱..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' />
            </td>
          </tr>
          <tr>
            <th>標簽</th>
            <td>
        <?php foreach ($goal_tag_category->tags as $tag) { ?>
                <div class='tag'>
                  <input type='checkbox' name='tag_ids[]' id='tag_<?php echo $tag->id;?>' value='<?php echo $tag->id;?>'<?php echo !$tag_ids || ($tag_ids && in_array ($tag->id, $tag_ids)) ? ' checked' : ''?>/>
                  <span class='ckb-check'></span>
                  <label for='tag_<?php echo $tag->id;?>'><?php echo $tag->name;?></label>
                </div>
        <?php }
              foreach (GoalTag::all (array ('conditions' => array ('goal_tag_category_id = ?', 0))) as $tag) { ?>
                <div class='tag'>
                  <input type='checkbox' name='tag_ids[]' id='tag_<?php echo $tag->id;?>' value='<?php echo $tag->id;?>'<?php echo $tag_ids && in_array ($tag->id, $tag_ids) ? ' checked' : ''?>/>
                  <span class='ckb-check'></span>
                  <label for='tag_<?php echo $tag->id;?>'><?php echo $tag->name;?></label>
                </div>
        <?php } ?>
            </td>
          </tr>
          <tr>
            <td colspan='2'>
              <a href='<?php echo base_url ('admin', 'goal_tags', 'cate_index');?>'>回列表</a>
              <button type='reset' class='button'>重填</button>
              <button type='submit' class='button'>確定</button>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
