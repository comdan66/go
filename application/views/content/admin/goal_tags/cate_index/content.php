<?php echo render_cell ('admin_frame_cell', 'header');?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
<?php echo render_cell ('admin_frame_cell', 'sides', $frame_sides);?>
  <div class='contents'>
  <?php
    if (isset ($message) && $message) { ?>
      <div class='info'><?php echo $message;?></div>
  <?php
    } ?>
    <form action='<?php echo base_url ('admin', 'goal_tags', 'cate_index');?>' method='get'>
      <div class='conditions'>
        <div class='l'>
          <input type='text' name='id' value='<?php echo isset ($columns['id']) ? $columns['id'] : '';?>' placeholder='請輸入ID..' />
          <input type='text' name='name' value='<?php echo isset ($columns['name']) ? $columns['name'] : '';?>' placeholder='請輸入名稱..' />
          <button type='submit'>尋找</button>
        </div>
        <div class='r'>
          <a class='new' href='<?php echo base_url ('admin', 'goal_tags', 'cate_add');?>'>新增</a>
        </div>
      </div>
    </form>

    <table class='table-list'>
      <thead>
        <tr>
          <th width='60'>ID</th>
          <th >名稱</th>
          <th width='400'>標簽</th>
          <th width='100'>編輯</th>
        </tr>
      </thead>
      <tbody>
    <?php
        if ($goal_tag_categories) {
          foreach ($goal_tag_categories as $goal_tag_category) { ?>
            <tr>
              <td><?php echo $goal_tag_category->id;?></td>
              <td><?php echo $goal_tag_category->name;?></td>
              <td class='left'><?php echo $goal_tag_category->tags ? implode ('', array_map (function ($tag) {return '<div class="tag">' . $tag . '</div>';}, column_array ($goal_tag_category->tags, 'name'))) : '(無標簽)';?></td>
              <td class='edit'>
                <a href='<?php echo base_url ('admin', 'goal_tags', 'cate_edit', $goal_tag_category->id);?>' class='icon-pencil2'></a>
                /
                <a href='<?php echo base_url ('admin', 'goal_tags', 'cate_destroy', $goal_tag_category->id);?>' class='icon-bin'></a>
              </td>
            </tr>
    <?php }
        } else { ?>
          <tr><td colspan='4'>目前沒有任何資料。</td></tr>
    <?php
        } ?>
      <tbody>
    </table>

  <?php echo $pagination;?>

  </div>
</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
