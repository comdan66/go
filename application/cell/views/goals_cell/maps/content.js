/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $maps = $('#maps');
  var $panorama = $('#panorama');
  var $view_button = $maps.find ('.view_button');
  var $map = $maps.find ('#map');
  var $view = $maps.find ('#view');
  var $marker = $('#marker');
  var $loading = $('<div />').addClass ('loading')
                             .append ($('<div />'))
                             .appendTo ($maps);

  function initialize () {
    var styledMapType = new google.maps.StyledMapType ([
      { featureType: 'transit.station.bus',
        stylers: [{ visibility: 'off' }]
      }, {
        featureType: 'poi',
        stylers: [{ visibility: 'off' }]
      }, {
        featureType: 'poi.attraction',
        stylers: [{ visibility: 'on' }]
      }, {
        featureType: 'poi.school',
        stylers: [{ visibility: 'on' }]
      }
    ]);

    var marker = new google.maps.Marker ({
        draggable: false,
        position: new google.maps.LatLng ($marker.data ('lat'), $marker.data ('lng')),
      });

    _map = new google.maps.Map ($map.get (0), {
        zoom: 14,
        zoomControl: true,
        scrollwheel: true,
        scaleControl: true,
        mapTypeControl: false,
        navigationControl: true,
        center: marker.position,
        streetViewControl: false,
        disableDoubleClickZoom: true,
      });
    _map.mapTypes.set ('map_style', styledMapType);
    _map.setMapTypeId ('map_style');

    marker.setMap (_map);


    if ($panorama.length) {

      var panorama = new google.maps.StreetViewPanorama ($view.get (0), {
        linksControl: true,
        addressControl: false,
        position: new google.maps.LatLng ($panorama.data ('lat'), $panorama.data ('lng')),
        pov: {
          heading: parseInt ($panorama.data ('heading'), 10),
          pitch: parseInt ($panorama.data ('pitch'), 10),
          zoom: parseInt ($panorama.data ('zoom'), 10),
        }
      });
      _map.setStreetView (panorama);

      new google.maps.StreetViewService ().getPanoramaByLocation (panorama.position, 10, function (data, status) {
        if (status == google.maps.StreetViewStatus.OK)
          $view_button.click (function () {
            if ($maps.hasClass ('panorama')) {
              $maps.removeClass ('panorama');
              $(this).text ('查看街景');
            } else {
              $maps.addClass ('panorama');
              $(this).text ('查看地圖');
            }
          });
        else
          $view_button.remove ();
      });
    } else {
      $view_button.remove ();
    }

    $loading.fadeOut (function () {
      $(this).hide (function () {
        $(this).remove ();
      });
    });
  }

  $(window).scroll (function () {
    if ($maps.data ('has_loaded') || ($(this).scrollTop () + $(this).height () < $maps.offset ().top))
      return;
    $maps.data ('has_loaded', true);

    initialize ();
  });
});