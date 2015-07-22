<?php echo render_cell ('admin_frame_cell', 'header'); ?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
<?php echo render_cell ('admin_frame_cell', 'sides', $frame_sides);?>
  <div class='contents'>
  <?php
    if (isset ($message) && $message) { ?>
      <div class='info'><?php echo $message;?></div>
  <?php
    } ?>
    <form action='<?php echo base_url ('admin', 'index_tabs');?>' method='get'>
      <div class='conditions'>
        <div class='l'>
          <input type='text' name='id' value='<?php echo isset ($columns['id']) ? $columns['id'] : '';?>' placeholder='請輸入ID..' />
          <input type='text' name='name' value='<?php echo isset ($columns['name']) ? $columns['name'] : '';?>' placeholder='請輸入名稱..' />
          <button type='submit'>尋找</button>
        </div>
        <div class='r'>
          <a class='new' href='<?php echo base_url ('admin', 'index_tabs', 'add');?>'>新增</a>
        </div>
      </div>
    </form>

    <table class='table-list'>
      <thead>
        <tr>
          <th width='60'>ID</th>
          <th width='120'>名稱</th>
          <th>景點</th>
          <th width='100'>編輯</th>
        </tr>
      </thead>
      <tbody>
    <?php
        if ($index_tabs) {
          foreach ($index_tabs as $i => $goal) { ?>
            <tr>
              <td><?php echo $goal->id;?></td>
              <td class='left'><?php echo mb_strimwidth ($goal->title, 0, 30, '…','UTF-8');?></td>
              <td class='left'><?php echo mb_strimwidth ($goal->title, 0, 30, '…','UTF-8');?></td>
              <td class='edit'>
                <a href='<?php echo base_url ('admin', 'index_tabs', 'edit', $goal->id);?>' class='icon-pencil2'></a>
                /
                <a href='<?php echo base_url ('admin', 'index_tabs', 'destroy', $goal->id);?>' class='icon-bin'></a>
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
