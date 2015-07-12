<?php
require 'vendor/autoload.php';
// use facebook\Mailgun;
use Facebook\FacebookApp;
use Facebook\SignedRequest;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */
// require_once 'facebook_api.php';

class Fb {
  private $CI = null;
  private $fb = null;
  private $accessToken = null;

  public function __construct ($config = array ()) {
    $this->CI =& get_instance ();
    $this->CI->load->helper ('oa');
    $this->CI->load->library ("cfg");
    
    $this->fb = new Facebook\Facebook ([
      'app_id' => Cfg::system ('facebook', 'appId'),
      'app_secret' => Cfg::system ('facebook', 'secret'),
      'default_graph_version' => Cfg::system ('facebook', 'version')
      ]);
  }

  public function login_url () {
    session_start ();
    $helper = $this->fb->getRedirectLoginHelper ();
    $permissions = Cfg::system ('facebook', 'scope'); // optional
    return $helper->getLoginUrl (base_url (func_get_args ()), $permissions);
  }

  public function login () {
    session_start ();
    $helper = $this->fb->getRedirectLoginHelper ();

    try {
      $this->accessToken = $helper->getAccessToken();
      return true;
    } catch(Exception $e) {
      return false;
    }
    return false;
  }
  public function me () {
    if (!($this->fb && $this->accessToken))
      return null;

    $this->fb->setDefaultAccessToken($this->accessToken);
    $response = $this->fb->get ('/me');

    return $response->getGraphUser ();
  }
}