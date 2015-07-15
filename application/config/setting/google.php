<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$google['development'] = array (
    'client_key' => $google['client_key'],
    'server_key' => 'AIzaSyCCrpVf7v9_ST0ghGYwdWwINgjjpjec-B0',
  );
$google['staging'] = array (
    'client_key' => '',
    'server_key' => '',
  );
$google['production'] = array (
    'client_key' => 'AIzaSyAMcUyizNT-Fx_j9siF-PhkIYyld4hgMb0',
    'server_key' => 'AIzaSyApiD1RhfC-z8M42zBnWOCbzndwlwgHh-Y',
  );

$google['client_js_url'] = 'https://maps.googleapis.com/maps/api/js?key=' . $google[ENVIRONMENT]['client_key'] . '&v=3.exp&sensor=false&language=zh-TW';