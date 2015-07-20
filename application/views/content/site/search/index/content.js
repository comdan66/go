/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $container = $('#container');
  var $goals = $('#goals');
  var $line = $container.find ('.line');
  var $loading = $container.find ('.loading');
  var $no_data = $container.find ('.no_data');
  var $search_color = $('#search_color');
  var $key = $('#search_key');
  var $input = $('#search .search').val ($key.length ? $key.val ().trim () : '');
  var _count = 0;

  if ($search_color.length) {
    $input.val ($search_color.val ());
    $('#search .icon-eyedropper').addClass ('choice').css ({
      'background-color': $search_color.val ()
    });
  }

  var masonry = new Masonry ($goals.selector, {
                  itemSelector: '.goal',
                  columnWidth: 1,
                  transitionDuration: '0.3s',
                  visibleStyle: {
                    opacity: 1,
                    transform: 'none'
                  }});

  var setGoalFeature = function ($obj) {
    $obj.imagesLoaded (function () {
      $obj.find ('.img').css ({'height': $obj.show ().find ('.img img').css ('height')}).imgLiquid ({verticalAlign: 'center'});
      $obj.find ('.created_at').timeago ();
      $obj.find ('.avatar').imgLiquid ({verticalAlign: 'top'});

      masonry.appended ($obj.get (0));
      return $obj;
    });
  };
  function loadGoals () {
    var key = $key.val ().trim ();
    var colors = $search_color.length ? $search_color.val ().match (/^rgb\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/i).slice (1, 4) : [];

    if (!(key.length || colors.length))
      return;

    if ($goals.data ('next_id') > -1) {
      $.ajax ({
        url: $('#load_goals_url').val (),
        data: {
          key: key,
          colors: colors,
          next_id: $goals.data ('next_id')
        },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {
          $loading.fadeIn ();
        }
      })
      .done (function (result) {
        if (result.status) {
          if (result.goals.length) {
            $line.addClass ('show');
          }
          result.goals.map (function (t) {
            setGoalFeature ($(t).appendTo ($goals).hide ());
          });
          $goals.data ('next_id', result.next_id);

          if ((_count++ === 0) && (result.next_id < 0) && !result.goals.length)
            $no_data.addClass ('show');

          if (result.next_id < 0)
            return $loading.fadeOut (function () { $(this).remove (); });
          
          $goals.data ('has_loaded', false);
          $(window).scroll ();
        }
      }.bind (this))
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  }
  if ($input.val ().trim ().length) {
    $loading.addClass ('show');

    $(window).scroll (function () {
      if (!$goals.data ('has_loaded') && ($(window).height () + $(window).scrollTop () > $goals.height () + $goals.offset ().top - 50)) {
        $goals.data ('has_loaded', true);
        loadGoals ();
      }
    }).scroll ();
  } else {
    $no_data.addClass ('show');
  }
});