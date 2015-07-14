<?php echo render_cell ('admin_frame_cell', 'header'); ?>

<div id='container'>
  <table class='table-form'>
    <tbody>
      <tr>
        <th>ID</th>
        <td>
          <?php echo $goal->id;?>
        </td>
      </tr>
      <tr>
        <th>新增者</th>
        <td>
          <?php echo $goal->user->name;?>（<?php echo $goal->user->id;?>）
        </td>
      </tr>
      <tr>
        <th>標題</th>
        <td>
          <?php echo $goal->title;?>
        </td>
      </tr>
      <tr>
        <th>地址</th>
        <td>
          <?php echo $goal->address;?>
        </td>
      </tr>
      <tr>
        <th>分數</th>
        <td>
          <?php echo $goal->score;?><br/>
        </td>
      </tr>
      <tr>
        <th>分數</th>
        <td>
          <?php ;?><br/>
        </td>
      </tr>
      <tr>
        <th>PV</th>
        <td>
          <?php echo $goal->pageview;?><br/>
        </td>
      </tr>
      <tr>
        <th>留言數</th>
        <td>
          <?php echo count ($goal->comments);?><br/>
        </td>
      </tr>
      <tr>
        <th>緯度</th>
        <td>
          <?php echo $goal->latitude;?><br/>
        </td>
      </tr>
      <tr>
        <th>經度</th>
        <td>
          <?php echo $goal->longitude;?><br/>
        </td>
      </tr>
      <tr>
        <th>介紹</th>
        <td style='word-break:break-all;'>
          <?php echo $goal->introduction;?>
        </td>
      </tr>
      <tr>
        <th>標籤</th>
        <td>
          <?php echo $goal->tags ? implode ('', array_map (function ($tag) {return '<div class="tag">' . $tag . '</div>';}, column_array ($goal->tags, 'name'))) : '(無標簽)';?>
        </td>
      </tr>
      <tr>
        <th>照片</th>
        <td>
          <?php echo $goal->pictures ? implode ('', array_map (function ($picture) {return '<div class="pic" href="' . $picture->name->url () . '" data-fancybox-group="fancybox_group">' . img ($picture->name->url ('50x50c')) . '</div>';}, $goal->pictures)) : '(無照片)';?>
        </td>
      </tr>
      <tr>
        <th>地圖</th>
        <td>
          <?php echo img ($goal->picture ('200x150'), false, "data-id='" . $goal->id . "' class='fancybox_goal'");?>
        </td>
      </tr>
      <tr>
        <th>街景</th>
        <td>
          <?php echo $goal->view ? img ($goal->view->picture ('200x150', 110), false, "data-id='" . $goal->id . "' class='fancybox_view'") : anchor (base_url ('admin', 'goals', 'view', $goal->id), '未設定');?>
        </td>
      </tr>
      <tr>
        <td colspan='2'>
          <a href='<?php echo base_url ('admin', 'goals');?>'>回列表</a>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
