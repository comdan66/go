<?php
  if ($sides_list) { ?>
    <div class='sides'>
<?php foreach ($sides_list as $title => $sides) { ?>
        <div class='side'>
    <?php if ($sides) {
            if ($title) { ?>
              <div class='title'><?php echo $title;?></div>
      <?php } 
            foreach ($sides as $side) { ?>
              <a <?php echo $side['href'] == current_url () ? "class='active' " : '';?>href='<?php echo $side['href'];?>'><?php echo $side['name'];?></a>
      <?php }
          } ?>
        </div>
<?php } ?>
    </div>
<?php
  }?>