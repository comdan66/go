<!-- Hello World!
      <a href='<?php echo facebook ()->login_url ('platform', 'fb_sign_in', 'main');?>'>asd</a>
 -->
<?php echo render_cell ('site_frame_cell', 'header', array ()); ?>

<div id='container'>
  <?php echo render_cell ('main_cell', 'search', array ()); ?>

  <?php echo render_cell ('main_cell', 'tagview', array ()); ?>

  <?php echo render_cell ('main_cell', 'banner', array ()); ?>
</div>

<?php echo render_cell ('site_frame_cell', 'footer', array ()); ?>
