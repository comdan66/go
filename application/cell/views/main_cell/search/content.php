<div id='search' class='<?php echo $is_search ? ' is_search' : '';?>'>
  <a href='' class='l'>
    <div class='logo'><span>Go!</span> Taiwan</div>
    <div class='title'>台灣景點地圖</div>
  </a>
  <div class='c'>
    <input type='text' name='search' value='' class='search' placeholder='快來搜尋一下好玩的景點吧！' autofocus />
    <div class='color_picker'>
      <div class='icon-eyedropper'></div>
      <div class='colors'>
  <?php foreach ($colors as $color) { ?>
          <div style='background-color: rgb(<?php echo implode (', ', $color);?>);'></div>
  <?php };?>
        <div></div>
      </div>
    </div>
    <button class='go_search'>搜尋</button>
  </div>
  <div class='r'>
    <img src='<?php echo base_url ('resource', 'image', 'map', '10d.png');?>' />
    <div class='title'>台北</div>
    <div class='temperature'>32℃</div>
  </div>
</div>
<div id='bg_cover'></div>
