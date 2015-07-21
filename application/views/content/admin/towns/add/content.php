<?php echo render_cell ('admin_frame_cell', 'header');?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
<?php echo render_cell ('admin_frame_cell', 'sides', $frame_sides);?>
  <div class='contents'>
<?php
    if (isset ($message) && $message) { ?>
      <div class='error'><?php echo $message;?></div>
<?php
    } ?>

    <form action='<?php echo base_url (array ('admin', 'towns', 'create'));?>' method='post' enctype='multipart/form-data'>
      <table class='table-form'>
        <tbody>
          <tr>
            <th>名稱</th>
            <td>
              <input type='text' id='name' name='name' value='<?php echo $name;?>' placeholder='請輸入名稱..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' />
            </td>
          </tr>
          <tr>
            <th>郵遞區號</th>
            <td>
              <input type='text' id='postal_code' name='postal_code' value='<?php echo $postal_code;?>' placeholder='請輸入郵遞區號..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' />
            </td>
          </tr>
          <tr>
            <th>緯度</th>
            <td>
              <input type='text' id='latitude' name='latitude' value='<?php echo $latitude;?>' placeholder='請輸入緯度..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' />
            </td>
          </tr>
          <tr>
            <th>緯度</th>
            <td>
              <input type='text' id='longitude' name='longitude' value='<?php echo $longitude;?>' placeholder='請輸入緯度..' maxlength='200' pattern='.{1,200}' required title='輸入 1~200 個字元!' />
            </td>
          </tr>
          <tr>
            <th>地圖</th>
            <td>
              <div class='map'>
                <i></i><i></i><i></i><i></i>
                <div id='map'></div>
                <div id='loading_data'>資料讀取中...</div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan='2'>
              <a href='<?php echo base_url ('admin', 'towns');?>'>回列表</a>
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
