<?php

class XKCDLoader {
  function load($num = null) {
    $url    = $this->build($num);
    $result = $this->fetch($url);
    $body   = $this->verify($result);

    return $this->parse($body);
  }

  function fetch($url) {
    return wp_remote_get($url);
  }

  function verify($result) {
    if (is_wp_error($result)) {
      throw new Exception('XKCDLoader Failed: Could not wp_remote_get');
    }

    $code = $result['response']['code'];
    if ($code != 200) {
      throw new Exception('XKCDLoader Failed: Invalid HTTP Response from server - ' . $code);
    }

    $body = wp_remote_retrieve_body($result);
    if ($body == '') {
      throw new Exception('XKCDLoader Failed: JSON body was empty.');
    }

    return $body;
  }

  function parse($body) {
    $json = json_decode($body);
    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new Exception('XKCDLoader Failed: Invalid JSON returned by server - ' . json_last_error());
    }

    return $json;
  }

  function build($num) {
    if (is_null($num)) {
      return 'http://xkcd.com/info.0.json';
    } else {
      return 'http://xkcd.com/' . $num . '/info.0.json';
    }
  }
}

?>
