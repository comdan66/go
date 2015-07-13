<?php echo render_cell ('admin_frame_cell', 'header'); ?>
<input type='hidden' id='marker' data-lat='<?php echo $goal->latitude;?>' data-lng='<?php echo $goal->longitude;?>' value='<?php echo $goal->id;?>' />

<div id='container'>
  <div class='map'>
    <i></i><i></i><i></i><i></i>
    <div id='view'></div>
    <div id='map'></div>
    <div id='alert'></div>
    <form id='control' action='<?php echo base_url ('admin', 'goals', 'panorama', $goal->id);?>' method='post'>
      <input type='hidden' name='latitude' id='latitude' value='<?php echo $latitude ? $latitude : ($goal->view ? $goal->view->latitude : $goal->latitude);?>' />
      <input type='hidden' name='longitude' id='longitude' value='<?php echo $longitude ? $longitude : ($goal->view ? $goal->view->longitude : $goal->longitude);?>' />
      
      <input type='hidden' name='heading' id='heading' value='<?php echo $heading ? $heading : ($goal->view ? $goal->view->heading : 0);?>' />
      <input type='hidden' name='pitch' id='pitch' value='<?php echo $pitch ? $pitch : ($goal->view ? $goal->view->pitch : 0);?>' />
      <input type='hidden' name='zoom' id='zoom' value='<?php echo $zoom ? $zoom : ($goal->view ? $goal->view->zoom : 0);?>' />

      <a href='<?php echo base_url ('admin', 'goals');?>'>回列表</a>
      <button type='submit' id='submit'>確定取景</button>
    </form>
    <div id='error' <?php echo isset ($message) && $message ? " class='show'":''; ?>>
<?php if (isset ($message) && $message) { ?>
        <?php echo $message;?>
<?php } ?>
    </div>
  </div>
</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
