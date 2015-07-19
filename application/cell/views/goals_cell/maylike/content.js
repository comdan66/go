/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {

  var ids = getStorage ('goal_site_viewed');
  if (!ids) ids = [];
  else ids = ids.map (function (t) { return parseInt (t.id, 10); });

  var $marker = $('#marker');
  var $maylike = $('#maylike');
  var $maylikes = $maylike.find ('.maylikes');
  var $loading = $maylikes.find ('.loading');
  var _count = 0, maxCount = 3;
  
  function setMaylikeFeature ($obj) {
      $obj.imgLiquid ({verticalAlign: 'top'});

      if ($.inArray ($obj.data ('id'), ids) != -1)
        $obj.addClass ('viewed');
      return $obj;
  }

  function loadMaylike () {
    if ($maylikes.data ('next_id') < 0)
      return;

      $.ajax ({
        url: $('#load_maylike_url').val (),
        data: { id: $marker.val (), next_id: $maylikes.data ('next_id') },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { }
      })
      .done (function (result) {
        if (result.status) {
          result.maylikes.map (function (t) {
            setMaylikeFeature ($(t).insertBefore ($loading));
          });

          $maylikes.data ('next_id', result.next_id);

          if ((_count === 0) && (result.next_id < 0))
            return $maylike.remove ();

          if ((maxCount <= ++_count) || (result.next_id < 0))
            return $loading.remove ();

          $maylikes.data ('has_loaded', false);
          $(window).scroll ();
        }
      }.bind (this))
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
  }
  
  var top = $maylike.offset ().top;

  $(window).scroll (function () {
    if ($(this).scrollTop () > top - 57)
      $maylike.addClass ('fix');
    else
      $maylike.removeClass ('fix');

    if ($maylikes.data ('has_loaded') || !$loading.is (':visible') || ($(this).scrollTop () + $(this).height () < $loading.offset ().top - 50))
      return;
    $maylikes.data ('has_loaded', true);

    loadMaylike ();
  });
});