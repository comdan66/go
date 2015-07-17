/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $map = $('#map');
  var $marker = $('#marker');
  var $options = $('#options');
  var $title = $('#title');
  var $latitude = $('#latitude');
  var $longitude = $('#longitude');
  var $address = $('#address');
  var $pictures = $('#pictures');
  var $pictureLinks = $('#picture_links');
  var $links = $('#links');
  var $error = $('#error');
  var $loading = $('<div />').attr ('id', 'loading')
                             .append ($('<div />'))
                             .appendTo ('#container');
  
  var _map = null;
  var _marker = null;

  function updateLatLng (position) {
    $latitude.val (position.lat ());
    $longitude.val (position.lng ());

    new google.maps.Geocoder ().geocode ({'latLng': position}, function (result, status) {
      if ((status == google.maps.GeocoderStatus.OK) && result.length)
        $address.val (result[0].formatted_address);
    });
    mapGo (_map, position);
  }

  function initMarker (position) {
    updateLatLng (position);
    
    if (_marker)
      return _marker.setPosition (position);
    
    _marker = new google.maps.Marker ({
        map: _map,
        draggable: true,
        position: position
      });

    google.maps.event.addListener (_marker, 'dragend', function () {
      updateLatLng (_marker.position);
    });
    
    $options.addClass ('show');
  }

  function initialize () {
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

    var last = getStorage ('goal_admin_map');

    if (last) {
      _map.setCenter (new google.maps.LatLng (last.lat, last.lng));
      _map.setZoom (last.zoom);
    } else {
      navigator.geolocation.getCurrentPosition (function (position) {
        _map.setZoom (14);
        mapGo (_map, new google.maps.LatLng (position.coords.latitude, position.coords.longitude), function (map) {
          setStorage.apply (this, ['goal_admin_map', {
            lat: map.center.lat (),
            lng: map.center.lng (),
            zoom: map.zoom
          }]);
        });
      });
    }

    if ($latitude.val () && $longitude.val ()) {
      _map.setCenter (new google.maps.LatLng ($latitude.val (), $longitude.val ()));
      initMarker (_map.center);
    }
    google.maps.event.addListener(_map, 'click', function (e) {
      initMarker (e.latLng);
    });

    google.maps.event.addListener(_map, 'zoom_changed', getGoals.bind (this, _map, $marker.val (), $('#loading_data'), true));
    google.maps.event.addListener(_map, 'idle', getGoals.bind (this, _map, $marker.val (), $('#loading_data'), true));

    $options.submit (function () {

      if (!($latitude.val () && $longitude.val ())) {
        $error.text ('請點選地圖，選擇地點！').addClass ('show');
        return false;
      }

      if (!$title.val ()) {
        $error.text ('請輸入標題！').addClass ('show');
        return false;
      }

      return true;
    });

    $('.pic .fanc').imgLiquid ({verticalAlign: 'center'})
             .fancybox ({
                padding: 0,
                helpers: {
                  overlay: { locked: false },
                  title: { type: 'over' },
                  thumbs: { width: 50, height: 50 }
                }
             });

    $('#choice_picture').click (function () {
      $('<div />').addClass ('picture')
                  .append ($('<div />').addClass ('l').append ($('<input />').attr ('type', 'file').attr ('name', 'pictures[]').attr ('accept', 'image/gif, image/jpeg, image/png').val ('')))
                  .append ($('<div />').addClass ('r').append ($('<button />').append ('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path fill="#444444" d="M4 10v20c0 1.1 0.9 2 2 2h18c1.1 0 2-0.9 2-2v-20h-22zM10 28h-2v-14h2v14zM14 28h-2v-14h2v14zM18 28h-2v-14h2v14zM22 28h-2v-14h2v14z"></path><path fill="#444444" d="M26.5 4h-6.5v-2.5c0-0.825-0.675-1.5-1.5-1.5h-7c-0.825 0-1.5 0.675-1.5 1.5v2.5h-6.5c-0.825 0-1.5 0.675-1.5 1.5v2.5h26v-2.5c0-0.825-0.675-1.5-1.5-1.5zM18 4h-6v-1.975h6v1.975z"></path></svg>')))
                  .appendTo ($pictures).find ('input').last ().click ();
    });
    $pictures.on ('click', 'button', function () {
      $(this).parents ('.picture').remove ();
    });

    $('#add_links').click (function () {
      var link = prompt ('請輸入參考鏈結..', '');
      $('<div />').addClass ('link')
                  .append ($('<div />').addClass ('l').append ($('<input />').attr ('type', 'text').attr ('name', 'links[]').attr ('placeholder', '請輸入參考鏈結..').val (link)))
                  .append ($('<div />').addClass ('r').append ($('<button />').append ('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path fill="#444444" d="M4 10v20c0 1.1 0.9 2 2 2h18c1.1 0 2-0.9 2-2v-20h-22zM10 28h-2v-14h2v14zM14 28h-2v-14h2v14zM18 28h-2v-14h2v14zM22 28h-2v-14h2v14z"></path><path fill="#444444" d="M26.5 4h-6.5v-2.5c0-0.825-0.675-1.5-1.5-1.5h-7c-0.825 0-1.5 0.675-1.5 1.5v2.5h-6.5c-0.825 0-1.5 0.675-1.5 1.5v2.5h26v-2.5c0-0.825-0.675-1.5-1.5-1.5zM18 4h-6v-1.975h6v1.975z"></path></svg>')))
                  .appendTo ($links);
    });
    $links.on ('click', 'button', function () {
      $(this).parents ('.link').remove ();
    });
    $('#choice_picture_link').click (function () {
      var link = prompt ('請輸入照片鏈結..', '');
      $('<div />').addClass ('picture_link')
                  .append ($('<div />').addClass ('l').append ($('<input />').attr ('type', 'text').attr ('name', 'picture_links[]').attr ('placeholder', '請輸入照片鏈結..').val (link)))
                  .append ($('<div />').addClass ('r').append ($('<button />').append ('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path fill="#444444" d="M4 10v20c0 1.1 0.9 2 2 2h18c1.1 0 2-0.9 2-2v-20h-22zM10 28h-2v-14h2v14zM14 28h-2v-14h2v14zM18 28h-2v-14h2v14zM22 28h-2v-14h2v14z"></path><path fill="#444444" d="M26.5 4h-6.5v-2.5c0-0.825-0.675-1.5-1.5-1.5h-7c-0.825 0-1.5 0.675-1.5 1.5v2.5h-6.5c-0.825 0-1.5 0.675-1.5 1.5v2.5h26v-2.5c0-0.825-0.675-1.5-1.5-1.5zM18 4h-6v-1.975h6v1.975z"></path></svg>')))
                  .appendTo ($pictureLinks);
    });
    $pictureLinks.on ('click', 'button', function () {
      $(this).parents ('.picture_link').remove ();
    });

    $('#pics').on ('click', '.delete', function () {
      $(this).parents ('.pic').fadeOut (function () {
        $(this).remove ();
      });
    });

    $loading.fadeOut (function () {
      $(this).hide (function () {
        $(this).remove ();
        getGoals (_map, $marker.val (), $('#loading_data'), true);
      });
    });
  }

  google.maps.event.addDomListener (window, 'load', initialize);
});