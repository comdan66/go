<?php echo render_cell ('admin_frame_cell', 'header'); ?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
<?php
  echo render_cell ('admin_frame_cell', 'sides', $frame_sides);
?>

  <div class='contents'>

  </div>
</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
