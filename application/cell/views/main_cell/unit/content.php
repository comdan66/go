<div id='unit'>
  <h2>精選1</h2>
  <div class='units'>
<?php
    foreach ($goals as $goal) { ?>
      <a href='' class='unit'>
        <img src='<?php echo $goal->cover ('200x200c');?>' />
        <div class='cover'>
          <div class='pv icon-eye'>123</div>
          <div class='tags'>
            <div class='tag'>asd</div>
            <div class='tag'>asd</div>
            <div class='tag'>asd</div>
          </div>
        </div>
      </a>
<?php
    }?>
  </div>
  <div class='more'>
    <a href=''>MORE</a>
  </div>
</div>