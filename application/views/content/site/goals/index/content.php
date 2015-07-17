<?php echo render_cell ('site_frame_cell', 'header', array ()); ?>

<div id='container'>
  <?php echo render_cell ('goals_cell', 'banner', array ()); ?>
  <?php echo render_cell ('goals_cell', 'user', array ()); ?>
  <?php echo render_cell ('goals_cell', 'introduction', $goal); ?>

</div>

<?php echo render_cell ('site_frame_cell', 'footer', array ()); ?>
