/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var enableUpdateGoal = false;
  var enableUpdateView = false;

  var $map = $('#map');
  var $view = $('#view');
  var $alert = $('#alert');
  var $marker = $('#marker');

  var _map = null;
  var _panorama = null;
  var _updateGoal = false;
  var _updateView = false;
  var _povChangedTimer = null;
  var _hasView = false;

  function updateGoal (id, position) {
    if (_updateGoal)
      return;

    _updateGoal = true;

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
        _updateGoal = false;
      });
    });
  }

  function updateView (id) {
    if (!enableUpdateView)
      return;

    if (_updateView)
      return;

    _updateView = true;

    if (_hasView && _panorama.getPosition ().lat () && _panorama.getPosition ().lng () && (_panorama.getPov().heading + '') && (_panorama.getPov().pitch + '') && (_panorama.getPov().zoom + ''))
      $.ajax ({
        url: $('#update_view_position_url').val (),
        data: { id: id,
                lat: _panorama.getPosition ().lat (),
                lng: _panorama.getPosition ().lng (),
                heading: _panorama.getPov().heading,
                pitch: _panorama.getPov().pitch,
                zoom: _panorama.getPov().zoom
              },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { }
      })
      .done (function (result) {})
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) {
        _updateView = false;
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

    _panorama = new google.maps.StreetViewPanorama ($view.get (0), {
      linksControl: true,
      addressControl: false,
      pov: {
        heading: parseInt ($marker.data ('heading'), 10),
        pitch: parseInt ($marker.data ('pitch'), 10),
        zoom: parseInt ($marker.data ('zoom'), 10)
      }
    });

    _map = new google.maps.Map ($map.get (0), {
        zoom: 17,
        zoomControl: true,
        scrollwheel: true,
        scaleControl: true,
        streetView: _panorama,
        mapTypeControl: false,
        navigationControl: true,
        center: marker.position,
        streetViewControl: true,
        disableDoubleClickZoom: true,
      });
    _map.mapTypes.set ('map_style', styledMapType);
    _map.setMapTypeId ('map_style');
    
    google.maps.event.addListener (_panorama, 'visible_changed', function () {
      if (!this.getVisible ()) {
        _hasView = false;
        $alert.text ('此處沒有任何街景！').attr ('class', 'show');
      } else {
        _hasView = true;
        $alert.text ('').attr ('class', '');
      }

      mapGo (_map, this.getPosition ());
    });

    _panorama.setPosition (new google.maps.LatLng ($marker.data ('latitude'), $marker.data ('longitude')));

    new google.maps.StreetViewService ().getPanoramaByLocation (marker.position, 10, function (data, status) {
      if (status != google.maps.StreetViewStatus.OK) {
        _hasView = false;
        $alert.text ('此處沒有任何街景！').attr ('class', 'show');
      } else {
        _hasView = true;
        $alert.text ('').attr ('class', '');
      }
    });

    marker.setMap (_map);

    google.maps.event.addListener (marker, 'dragend', function () {
      updateGoal ($marker.val (), marker.position);
    });

    google.maps.event.addListener(_map, 'zoom_changed', getGoals.bind (this, _map, $marker.val (), $('#loading_data'), true));
    google.maps.event.addListener(_map, 'idle', getGoals.bind (this, _map, $marker.val (), $('#loading_data'), true));
    
    google.maps.event.addListener (_panorama, 'position_changed', function () {
      updateView ($marker.val ());
    });

    google.maps.event.addListener (_panorama, 'pov_changed', function () {
      clearTimeout (_povChangedTimer);
      _povChangedTimer = setTimeout (function () {
        updateView ($marker.val ());
      }, 500);
    });
    
    getGoals ( _map, $marker.val (), $('#loading_data'), true);
  }

  google.maps.event.addDomListener (window, 'load', initialize);
});