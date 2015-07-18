/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $detail = $('#introduction .detail');
  var $stars = $('#introduction .stars.can');
  var $star = $stars.find ('i');

  $(window).scroll (function () {
  var $that = $(this);
    $detail.each (function () {
      if ($(this).data ('has_loaded') || ($that.scrollTop () + $that.height () < $(this).offset ().top))
        return;
      $(this).data ('has_loaded', true);

      setTimeout (function () {
        $(this).find ('.row div[data-width]').each (function () {
          $(this).css ({'width': $(this).data ('width')});
        });
      }.bind ($(this)), 500);
    });
  }).scroll ();

  $star.mouseenter (function () {
    $star.attr ('class', 'icon-star-0');
    $(this).prevAll ().andSelf ().addClass ('icon-star-2');
  });
  $stars.mouseleave (function () {
    $star.each (function () {
      $(this).attr ('class', 'icon-star-' + $(this).data ('ori'));
    });
  });

  var $marker = $('#marker');
  var $to_comment = $('.to_comment');
  var $comment_list = $('.comment_list');
  var $loading = $comment_list.find ('.loading');
  var $comments = $comment_list.find ('.comments');
  var $more = $comment_list.find ('.more');
  autosize ($to_comment.find ('.comment'));

  function setCommentFeature ($obj) {
    $obj.find ('.imgLiquid_top').imgLiquid ({verticalAlign: 'center'});
    $obj.find ('.created_at').timeago ();
    return $obj.show ();
  }

  $to_comment.find ('button').click (function () {
    var $comment = $(this).parents ('.to_comment').find ('.comment');
    if (!$comment.val ().trim ().length)
      return;

    $.ajax ({
      url: $('#post_comment_url').val (),
      data: { id: $marker.val (), content: $comment.val ().trim () },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {
        $(this).prop ('disabled', true);
      }.bind ($(this))
    })
    .done (function (result) {
      if (result.status) {
        if ($comment_list.hasClass ('hide'))
          $comment_list.removeClass ('hide');

        $comment.val ('');
        setCommentFeature ($(result.comment).prependTo ($comments).hide ());
        $loading.data ('next_id', result.next_id);
      }
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) {
      $(this).prop ('disabled', false);
    }.bind ($(this)));
  });
  
  function loadComment () {
    if ($loading.data ('next_id') < 0)
      return;

    $.ajax ({
      url: $('#load_comment_url').val (),
      data: { id: $marker.val (), next_id: $loading.data ('next_id') },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {
        $loading.show ();
      }
    })
    .done (function (result) {
      if (result.status) {
        result.comments.map (function (t) {
          setCommentFeature ($(t).insertBefore ($loading).hide ());
        });

        $loading.data ('next_id', result.next_id);

        if (result.next_id < 0)
          $('.comment_list .more').remove ();

        if ($comment_list.find ('.comment').length < 1)
          $comment_list.addClass ('hide');
      }
    }.bind ($(this)))
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) {
      $loading.hide ();
    });
  }
  $more.click (loadComment);

  $(window).scroll (function () {
    var $that = $(this);
    $more.each (function () {
      if ($(this).data ('has_loaded') || !$(this).is (':visible') || ($that.scrollTop () + $that.height () < $(this).offset ().top - 200))
        return;
      $(this).data ('has_loaded', true);

      $(this).click ();
    });
  });
});