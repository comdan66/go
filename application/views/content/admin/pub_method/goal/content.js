/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var enableUpdateGoal = false;

  var $map = $('#map');
  var $marker = $('#marker');
  var $loadingData = $('#loading_data');

  var _map = null;
  var _update = false;

  function updateGoal (id, position) {
    if (_update)
      return;

    _update = true;

    new google.maps.Geocoder ().geocode ({'latLng': position}, function (result, status) {
      var address = ((status == google.maps.GeocoderStatus.OK) && result.length) ? result[0].formatted_address : '';

      $.ajax ({
        url: $('#update_goal_position_url').val (),
        data: { id: id, lat: position.lat (), lng: position.lng (), addr: address },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { }
      })
      .done (function (result) {})
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) {
        _update = false;
      });
    });
  }

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
        draggable: enableUpdateGoal,
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

    google.maps.event.addListener (marker, 'dragend', function () {
      updateGoal ($marker.val (), marker.position);
    });

    google.maps.event.addListener(_map, 'zoom_changed', getGoals.bind (this, _map, $marker.val (), $('#loading_data'), true));
    google.maps.event.addListener(_map, 'idle', getGoals.bind (this, _map, $marker.val (), $('#loading_data'), true));
    
    getGoals ( _map, $marker.val (), $('#loading_data'), true);
  }

  google.maps.event.addDomListener (window, 'load', initialize);
});