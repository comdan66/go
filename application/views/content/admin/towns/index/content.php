<?php echo render_cell ('admin_frame_cell', 'header'); ?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
<?php echo render_cell ('admin_frame_cell', 'sides', $frame_sides);?>
  <div class='contents'>
  <?php
    if (isset ($message) && $message) { ?>
      <div class='info'><?php echo $message;?></div>
  <?php
    } ?>
    <form action='<?php echo base_url ('admin', 'towns');?>' method='get'>
      <div class='conditions'>
        <div class='l'>
          <input type='text' name='id' value='<?php echo isset ($columns['id']) ? $columns['id'] : '';?>' placeholder='請輸入ID..' />
          <input type='text' name='name' value='<?php echo isset ($columns['name']) ? $columns['name'] : '';?>' placeholder='請輸入名稱..' />
          <input type='text' name='postal_code' value='<?php echo isset ($columns['postal_code']) ? $columns['postal_code'] : '';?>' placeholder='請輸入郵遞區號..' />
          <button type='submit'>尋找</button>
        </div>
        <div class='r'>
          <a class='new' href='<?php echo base_url ('admin', 'towns', 'add');?>'>新增</a>
        </div>
      </div>
    </form>

    <table class='table-list'>
      <thead>
        <tr>
          <th width='60'>ID</th>
          <th >名稱</th>
          <th width='100'>郵遞區號</th>
          <th width='100'>緯度</th>
          <th width='100'>經度</th>
          <th width='100'>縣市</th>
          <th width='70'>地點</th>
          <th width='100'>編輯</th>
        </tr>
      </thead>
      <tbody>
    <?php
        if ($towns) {
          foreach ($towns as $town) { ?>
            <tr>
              <td><?php echo $town->id;?></td>
              <td><?php echo $town->name;?></td>
              <td><?php echo $town->postal_code;?></td>
              <td><?php echo $town->latitude;?></td>
              <td><?php echo $town->longitude;?></td>
              <td><?php echo $town->category->name;?></td>
              <td class='map'><?php echo img ($town->pic->url ('50x50c'), false, "data-id='" . $town->id . "' class='fancybox_town'");?></td>
              <td class='edit'>
                <a href='<?php echo base_url ('admin', 'towns', 'edit', $town->id);?>' class='icon-pencil2'></a>
                /
                <a href='<?php echo base_url ('admin', 'towns', 'destroy', $town->id);?>' class='icon-bin'></a>
              </td>
            </tr>
    <?php }
        } else { ?>
          <tr><td colspan='7'>目前沒有任何資料。</td></tr>
    <?php
        } ?>
      <tbody>
    </table>

  <?php echo $pagination;?>

  </div>
</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
