/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $('.fancybox_goal').click (function () {
    $.fancybox ({
        href: '/admin/pub_method/goal/' + $(this).data ('id') + '?t=' + new Date ().getTime (),
        type: 'iframe',
        padding: 0,
        margin: 100,
        width: '100%',
        maxWidth: '1200',
        afterClose: function () {
          // location.reload ();
        }
    });
  });
  $('.fancybox_view').click (function () {
    $.fancybox ({
        href: '/admin/pub_method/view/' + $(this).data ('id') + '?t=' + new Date ().getTime (),
        type: 'iframe',
        padding: 0,
        margin: 100,
        width: '100%',
        maxWidth: '1200',
        afterClose: function () {
          // location.reload ();
        }
    });
  });
  
  $('.pic').imgLiquid ({verticalAlign: 'center'})
                 .fancybox ({
                    padding: 0,
                    helpers: {
                      overlay: { locked: false },
                      title: { type: 'over' },
                      thumbs: { width: 50, height: 50 }
                    }
                 });
});