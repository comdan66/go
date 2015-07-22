<?php echo render_cell ('admin_frame_cell', 'header');?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
<?php echo render_cell ('admin_frame_cell', 'sides', $frame_sides);?>
  <div class='contents'>
  <?php
    if (isset ($message) && $message) { ?>
      <div class='info'><?php echo $message;?></div>
  <?php
    } ?>
    <form action='<?php echo base_url ('admin', 'users');?>' method='get'>
      <div class='conditions'>
        <div class='l'>
          <input type='text' name='id' value='<?php echo isset ($columns['id']) ? $columns['id'] : '';?>' placeholder='請輸入ID..' />
          <input type='text' name='uid' value='<?php echo isset ($columns['uid']) ? $columns['uid'] : '';?>' placeholder='請輸入UID..' />
          <input type='text' name='name' value='<?php echo isset ($columns['name']) ? $columns['name'] : '';?>' placeholder='請輸入名稱..' />
        </div>
        <div class='r'>
          <button type='submit'>尋找</button>
        </div>
      </div>
    </form>

    <table class='table-list'>
      <thead>
        <tr>
          <th width='60'>ID</th>
          <th width='200'>UID</th>
          <th >名稱</th>
          <th width='100'>刪除</th>
        </tr>
      </thead>
      <tbody>
    <?php
        if ($users) {
          foreach ($users as $user) { ?>
            <tr>
              <td><?php echo $user->id;?></td>
              <td><?php echo $user->uid;?></td>
              <td><?php echo $user->name;?></td>
              <td class='edit'>
                <a href='<?php echo base_url ('admin', 'users', 'destroy', $user->id);?>' class='icon-bin'></a>
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
