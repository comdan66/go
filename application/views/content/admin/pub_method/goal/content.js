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
  var _markers = [];
  var _isGetPictures = false;
  var _getPicturesTimer = null;
  var _update = false;

  function getGoals () {
    clearTimeout (_getPicturesTimer);

    _getPicturesTimer = setTimeout (function () {
      if (_isGetPictures)
        return;
      
      $loadingData.addClass ('show');
      _isGetPictures = true;

      var northEast = _map.getBounds().getNorthEast ();
      var southWest = _map.getBounds().getSouthWest ();

      $.ajax ({
        url: $('#get_goals_url').val (),
        data: { NorthEast: {latitude: northEast.lat (), longitude: northEast.lng ()},
                SouthWest: {latitude: southWest.lat (), longitude: southWest.lng ()},
                goal_id: $marker.val ()
              },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {}
      })
      .done (function (result) {
        if (result.status) {
          var markers = result.goals.map (function (t) {
            var markerWithLabel = new MarkerWithLabel ({
                position: new google.maps.LatLng (t.lat, t.lng),
                draggable: false,
                raiseOnDrag: false,
                clickable: true,
                labelContent: t.title,
                labelAnchor: new google.maps.Point (50, 0),
                labelClass: "marker_label",
                icon: '/resource/image/map/spotlight-poi-blue.png'
              });
            return {
              id: t.id,
              markerWithLabel: markerWithLabel
            };
          });

          var deletes = _markers.diff (markers);
          var adds = markers.diff (_markers);
          var delete_ids = deletes.map (function (t) { return t.id; });
          var add_ids = adds.map (function (t) { return t.id; });

          deletes.map (function (t) { t.markerWithLabel.setMap (null); });
          adds.map (function (t) { t.markerWithLabel.setMap (_map); });

          _markers = _markers.filter (function (t) { return $.inArray (t.id, delete_ids) == -1; }).concat (markers.filter (function (t) { return $.inArray (t.id, add_ids) != -1; }));

          $loadingData.removeClass ('show');
          _isGetPictures = false;
        }
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) {});
    }, 500);
  }

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

    google.maps.event.addListener(_map, 'zoom_changed', getGoals);
    google.maps.event.addListener(_map, 'idle', getGoals);
    
    getGoals ();
  }

  google.maps.event.addDomListener (window, 'load', initialize);
});