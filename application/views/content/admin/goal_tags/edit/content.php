<?php echo render_cell ('admin_frame_cell', 'header');?>

<div id='container'>

<?php
    if (isset ($message) && $message) { ?>
      <div class='error'><?php echo $message;?></div>
<?php
    } ?>

    <form action='<?php echo base_url (array ('admin', 'goal_tags', 'update', $goal_tag->id));?>' method='post' enctype='multipart/form-data'>
      <table class='table-form'>
        <tbody>
          <tr>
            <th>分類</th>
            <td>
              <select name='goal_tag_category_id'>
                <option value='0'>未分類</option>
          <?php if ($goal_tag_categories = GoalTagCategory::all (array ('order' => 'id DESC'))) {
                  foreach ($goal_tag_categories as $goal_tag_category) { ?>
                    <option value='<?php echo $goal_tag_category->id;?>'<?php echo $goal_tag_category->id == ($goal_tag_category_id ? $goal_tag_category_id : ($goal_tag->category ? $goal_tag->category->id : -1)) ? ' selected' : '';?>><?php echo $goal_tag_category->name;?></option>
            <?php }
                } ?>
              </select>
            </td>
          </tr>
          <tr>
            <th>名稱</th>
            <td>
              <input type='text' name='name' value='<?php echo $name ? $name : $goal_tag->name;?>' placeholder='請輸入名稱..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' />
            </td>
          </tr>
          <tr>
            <td colspan='2'>
              <a href='<?php echo base_url ('admin', 'goal_tags');?>'>回列表</a>
              <button type='reset' class='button'>重填</button>
              <button type='submit' class='button'>確定</button>
            </td>
          </tr>
        </tbody>
      </table>
    </form>

</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
