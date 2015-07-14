<div id="header_right_slide" class="close">
  <div class="right_slide_container">
    <a class="sub" href="baishatun.html">白沙屯即時</a>
    <a class="sub" href="literature.html">部分文獻</a>
    <a class="sub" href="03-19.html">三月十九</a>
    <a class="sub" href="position.html">交通資訊</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
    <a class="sub" href="food.html">旅遊美食</a>
  </div>
</div>

<div id="header_slide_cover"></div>

<div id="header">
  <div class='header_container'>
    <div class="l">
      <a class='home icon-home' href='<?php echo base_url ();?>'></a>
<?php foreach ($left_links as $link) {
        if ($link['show']) {?>
        <a <?php echo $link['href'] == current_url () ? "class='active' " : '';?>href="<?php echo $link['href'];?>"<?php echo isset ($link['target']) && $link['target'] ? ' target="_blank"' : '';?>><?php echo $link['name'];?></a>
  <?php }
      }?>
    </div>
    <div class="c">Go! Taiwan</div>
    <div class="r">
<?php foreach ($right_links as $link) {
        if ($link['show']) {?>
          <a <?php echo $link['href'] == current_url () ? "class='active' " : '';?>href="<?php echo $link['href'];?>"<?php echo isset ($link['target']) && $link['target'] ? ' target="_blank"' : '';?>><?php echo $link['name'];?></a>
  <?php }
      }?>
      <a class='option icon-th-menu'></a>
    </div>
  </div>
</div>