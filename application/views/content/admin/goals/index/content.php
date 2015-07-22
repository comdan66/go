<?php echo render_cell ('admin_frame_cell', 'header'); ?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
<?php echo render_cell ('admin_frame_cell', 'sides', $frame_sides);?>
  <div class='contents'>
  <?php
    if (isset ($message) && $message) { ?>
      <div class='info'><?php echo $message;?></div>
  <?php
    } ?>
    <form action='<?php echo base_url ('admin', 'goals');?>' method='get'>
      <div class='conditions'>
        <div class='l'>
          <input type='text' name='id' value='<?php echo isset ($columns['id']) ? $columns['id'] : '';?>' placeholder='請輸入ID..' />
          <input type='text' name='title' value='<?php echo isset ($columns['title']) ? $columns['title'] : '';?>' placeholder='請輸入標題..' />
          <input type='text' name='address' value='<?php echo isset ($columns['address']) ? $columns['address'] : '';?>' placeholder='請輸入住址..' />
          <button type='submit'>尋找</button>
        </div>
        <div class='r'>
          <a class='new' href='<?php echo base_url ('admin', 'goals', 'add');?>'>新增</a>
        </div>
      </div>
    </form>

    <table class='table-list'>
      <thead>
        <tr>
          <th width='60'>ID</th>
          <th width='120'>標題</th>
          <th >介紹</th>
          <th width='150'>標籤</th>
          <th width='185'>照片</th>
          <th width='70'>地點</th>
          <th width='70'>街景</th>
          <th width='100'>編輯</th>
        </tr>
      </thead>
      <tbody>
    <?php
        if ($goals) {
          foreach ($goals as $i => $goal) { ?>
            <tr>
              <td><?php echo $goal->id;?></td>
              <td class='left'><?php echo mb_strimwidth ($goal->title, 0, 30, '…','UTF-8');?></td>
              <td class='left'><?php echo mb_strimwidth ($goal->introduction, 0, 100, '…','UTF-8');?></td>
              <td class='left'><?php echo $goal->tags ? implode ('', array_map (function ($tag) {return '<div class="tag">' . $tag . '</div>';}, column_array ($goal->tags, 'name'))) : '(無標簽)';?></td>
              <td class='left'><?php echo $goal->pictures ? implode ('', array_map (function ($picture) use ($i) {return '<div class="pic" href="' . $picture->name->url () . '" data-fancybox-group="fancybox_group_' . $i . '">' . img ($picture->name->url ('50x50c')) . '</div>';}, $goal->pictures)) : '(無照片)';?></td>
              <td class='map'><?php echo img ($goal->pic->url ('50x50c'), false, "data-id='" . $goal->id . "' class='fancybox_goal'");?></td>
              <td class='map'><?php echo $goal->view ? img ($goal->view->pic->url ('50x50c'), false, "data-id='" . $goal->id . "' class='fancybox_view'") : anchor (base_url ('admin', 'goals', 'view', $goal->id), '未設定');?></td>
              <td class='edit'>
                <a href='<?php echo base_url ('admin', 'goals', 'show', $goal->id);?>' class='icon-eye2'></a>
                /
                <a href='<?php echo base_url ('admin', 'goals', 'view', $goal->id);?>' class='icon-street-view'></a>
                <hr/>
                <a href='<?php echo base_url ('admin', 'goals', 'edit', $goal->id);?>' class='icon-pencil2'></a>
                /
                <a href='<?php echo base_url ('admin', 'goals', 'destroy', $goal->id);?>' class='icon-bin'></a>
              </td>
            </tr>
    <?php }
        } else { ?>
          <tr><td colspan='8'>目前沒有任何資料。</td></tr>
    <?php
        } ?>
      <tbody>
    </table>

  <?php echo $pagination;?>
  </div>
</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
