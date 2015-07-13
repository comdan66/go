<input type='hidden' id='marker' 
data-lat='<?php echo $goal->latitude;?>' 
data-lng='<?php echo $goal->longitude;?>' 
data-latitude='<?php echo $goal->view ? $goal->view->latitude : $goal->latitude;?>' 
data-longitude='<?php echo $goal->view ? $goal->view->longitude : $goal->longitude;?>' 
data-heading='<?php echo $goal->view ? $goal->view->heading : 0;?>' 
data-pitch='<?php echo $goal->view ? $goal->view->pitch : 0;?>' 
data-zoom='<?php echo $goal->view ? $goal->view->zoom : 0;?>' 
value='<?php echo $goal->id;?>' />

<div class='map'>
  <i></i><i></i><i></i><i></i>
  <div id='view'></div>
  <div id='map'></div>
  <div id='alert'></div>
</div>

