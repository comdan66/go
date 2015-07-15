<?php echo render_cell ('admin_frame_cell', 'header');?>

<div id='container'>

<?php
  if (isset ($message) && $message) { ?>
    <div class='info'><?php echo $message;?></div>
<?php
  } ?>
  <form action='<?php echo base_url ('admin', 'goals');?>' method='get'>
    <div class='conditions'>
      <div class='l'>
        <input type='text' name='id' value='<?php echo isset ($columns['id']) ? $columns['id'] : '';?>' placeholder='請輸入ID..' />
        <input type='text' name='title' value='<?php echo isset ($columns['title']) ? $columns['title'] : '';?>' placeholder='請輸入標題..' />
        <input type='text' name='address' value='<?php echo isset ($columns['address']) ? $columns['address'] : '';?>' placeholder='請輸入住址..' />
        <button type='submit'>尋找</button>
      </div>
      <div class='r'>
        <a class='new' href='<?php echo base_url ('admin', 'goals', 'add');?>'>新增</a>
      </div>
    </div>
  </form>

  <table class='table-list'>
    <thead>
      <tr>
        <th width='60'>ID</th>
        <th width='120'>標題</th>
        <th >介紹</th>
        <th width='150'>標籤</th>
        <th width='185'>照片</th>
        <th width='200'>地址</th>
        <th width='70'>地點</th>
        <th width='70'>街景</th>
        <th width='100'>編輯</th>
      </tr>
    </thead>
    <tbody>
  <?php
      if ($goals) {
        foreach ($goals as $i => $goal) { ?>
          <tr>
            <td><?php echo $goal->id;?></td>
            <td class='left'><?php echo mb_strimwidth ($goal->title, 0, 30, '…','UTF-8');?></td>
            <td class='left'><?php echo mb_strimwidth ($goal->introduction, 0, 100, '…','UTF-8');?></td>
            <td class='left'><?php echo $goal->tags ? implode ('', array_map (function ($tag) {return '<div class="tag">' . $tag . '</div>';}, column_array ($goal->tags, 'name'))) : '(無標簽)';?></td>
            <td class='left'><?php echo $goal->pictures ? implode ('', array_map (function ($picture) use ($i) {return '<div class="pic" href="' . $picture->name->url () . '" data-fancybox-group="fancybox_group_' . $i . '">' . img ($picture->name->url ('50x50c')) . '</div>';}, $goal->pictures)) : '(無照片)';?></td>
            <td class='left'><?php echo $goal->address;?></td>
            <td class='map'><?php echo img ($goal->pic->url ('50x50c'), false, "data-id='" . $goal->id . "' class='fancybox_goal'");?></td>
            <td class='map'><?php echo $goal->view ? img ($goal->view->pic->url ('50x50c'), false, "data-id='" . $goal->id . "' class='fancybox_view'") : anchor (base_url ('admin', 'goals', 'view', $goal->id), '未設定');?></td>
            <td class='edit'>
              <a href='<?php echo base_url ('admin', 'goals', 'show', $goal->id);?>'><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48" height="48" viewBox="0 0 48 48"><path fill="#444444" d="M17.995 24c0 3.311 2.689 6 6 6s6-2.689 6-6v-0.050c-0.641 0.65-1.52 1.050-2.5 1.050-1.931 0-3.5-1.57-3.5-3.5 0-1.39 0.819-2.6 1.99-3.16-0.62-0.22-1.29-0.34-1.99-0.34-3.31 0-6 2.69-6 6zM46.655 20.59c-3.72-4.73-12.78-12.59-22.65-12.59-9.88 0-18.949 7.86-22.67 12.59-0.84 1.080-1.3 2.25-1.33 3.41 0.030 1.16 0.49 2.33 1.33 3.41 3.721 4.731 12.78 12.59 22.66 12.59s18.939-7.859 22.66-12.59c0.85-1.080 1.31-2.25 1.34-3.41-0.030-1.16-0.49-2.33-1.34-3.41zM23.995 34c-5.52 0-10-4.48-10-10s4.48-10 10-10 10 4.48 10 10c-0 5.52-4.48 10-10 10z"></path></svg></a>
              /
              <a href='<?php echo base_url ('admin', 'goals', 'view', $goal->id);?>'><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28" height="28" viewBox="0 0 28 28"><path fill="#444444" d="M22 24q0 0.984-0.961 1.773t-2.562 1.266-3.516 0.719-3.961 0.242-3.961-0.242-3.516-0.719-2.562-1.266-0.961-1.773q0-0.766 0.516-1.383t1.422-1.039 1.844-0.695 2.047-0.461q0.406-0.078 0.75 0.164t0.406 0.648q0.078 0.406-0.164 0.75t-0.648 0.406q-0.906 0.156-1.656 0.367t-1.195 0.398-0.758 0.367-0.43 0.305-0.133 0.187q0.047 0.172 0.422 0.414t1.141 0.516 1.781 0.508 2.508 0.391 3.148 0.156 3.148-0.156 2.508-0.391 1.781-0.516 1.141-0.523 0.422-0.43q-0.016-0.063-0.133-0.172t-0.43-0.297-0.758-0.367-1.195-0.391-1.656-0.367q-0.406-0.063-0.648-0.406t-0.164-0.75q0.063-0.406 0.406-0.648t0.75-0.164q1.109 0.187 2.047 0.461t1.844 0.695 1.422 1.039 0.516 1.383zM16 10v6q0 0.406-0.297 0.703t-0.703 0.297h-1v6q0 0.406-0.297 0.703t-0.703 0.297h-4q-0.406 0-0.703-0.297t-0.297-0.703v-6h-1q-0.406 0-0.703-0.297t-0.297-0.703v-6q0-0.828 0.586-1.414t1.414-0.586h6q0.828 0 1.414 0.586t0.586 1.414zM14.5 4q0 1.453-1.023 2.477t-2.477 1.023-2.477-1.023-1.023-2.477 1.023-2.477 2.477-1.023 2.477 1.023 1.023 2.477z"></path></svg></a>
              <hr/>
              <a href='<?php echo base_url ('admin', 'goals', 'edit', $goal->id);?>'><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path fill="#444444" d="M12 20l4-2 14-14-2-2-14 14-2 4zM9.041 27.097c-0.989-2.085-2.052-3.149-4.137-4.137l3.097-8.525 4-2.435 12-12h-6l-12 12-6 20 20-6 12-12v-6l-12 12-2.435 4z"></path></svg></a>
              /
              <a href='<?php echo base_url ('admin', 'goals', 'destroy', $goal->id);?>'><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path fill="#444444" d="M4 10v20c0 1.1 0.9 2 2 2h18c1.1 0 2-0.9 2-2v-20h-22zM10 28h-2v-14h2v14zM14 28h-2v-14h2v14zM18 28h-2v-14h2v14zM22 28h-2v-14h2v14z"></path><path fill="#444444" d="M26.5 4h-6.5v-2.5c0-0.825-0.675-1.5-1.5-1.5h-7c-0.825 0-1.5 0.675-1.5 1.5v2.5h-6.5c-0.825 0-1.5 0.675-1.5 1.5v2.5h26v-2.5c0-0.825-0.675-1.5-1.5-1.5zM18 4h-6v-1.975h6v1.975z"></path></svg></a>
            </td>
          </tr>
  <?php }
      } else { ?>
        <tr><td colspan='9'>目前沒有任何資料。</td></tr>
  <?php
      } ?>
    <tbody>
  </table>

<?php echo $pagination;?>

</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
