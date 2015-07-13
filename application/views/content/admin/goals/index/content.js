/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $('.fancybox_map').click (function () {
    $.fancybox ({
        href: '/admin/pub_method/map/' + $(this).data ('id'),
        type: 'iframe',
        padding: 0,
        margin: 100,
        width: '100%',
        maxWidth: '1200'
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