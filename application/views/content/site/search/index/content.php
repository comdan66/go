<?php echo render_cell ('site_frame_cell', 'header', array ()); ?>

<div id='container'>
  <?php echo render_cell ('main_cell', 'search', array ()); ?>
  <div class='line'><div></div><div>Go!</div><div></div></div>
  <div id='goals' data-next_id='0'></div>
  <div class='loading'><div></div></div>
  <div class='no_data'>
    <div class='title'>您可以試著搜尋..</div>
    <div class='tag'>asddas</div>
    <div class='tag'>asddas</div>
    <div class='tag'>asddas</div>
    <div class='tag'>asddas</div>
    <div class='tag'>asddas</div>
  </div>
</div>

<?php echo render_cell ('site_frame_cell', 'footer', array ()); ?>
