/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {

  var $boxs = $('#boxs');
  var $map = $boxs.find ('#map');
  var $loadingData = $boxs.find ('.loading_data');

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
    _map = new google.maps.Map ($map.get (0), {
        zoom: 14,
        zoomControl: true,
        scrollwheel: true,
        scaleControl: true,
        mapTypeControl: false,
        navigationControl: true,
        streetViewControl: false,
        disableDoubleClickZoom: true,
        center: new google.maps.LatLng (25.04, 121.55),
      });
    _map.mapTypes.set ('map_style', styledMapType);
    _map.setMapTypeId ('map_style');

    var last = getLastPosition ('goal_site_map');

    if (last) {
      _map.setCenter (new google.maps.LatLng (last.lat, last.lng));
      _map.setZoom (last.zoom);
    } else {
      navigator.geolocation.getCurrentPosition (function (position) {
        _map.setZoom (14);
        mapGo (_map, new google.maps.LatLng (position.coords.latitude, position.coords.longitude), function (map) {
          setStorage.apply (this, ['goal_site_map', {
            lat: map.center.lat (),
            lng: map.center.lng (),
            zoom: map.zoom
          }]);
        });
      });
    }

    google.maps.event.addListener(_map, 'zoom_changed', getGoals.bind (this, _map, 0, $loadingData));
    google.maps.event.addListener(_map, 'idle', getGoals.bind (this, _map, 0, $loadingData));
  }

  $(window).scroll (function () {
    if ($boxs.data ('has_loaded') || ($(this).scrollTop () + $(this).height () < $boxs.offset ().top))
      return;
    $boxs.data ('has_loaded', true);

    initialize ();
  });
});