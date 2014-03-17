<?php

class CachedXKCDLoader {

  public $loader;

  function __construct($loader) {
    $this->loader = $loader;
  }

  function load($num = null) {
    $json = get_transient($this->key($num));

    if ($json !== false) {
      return $json;
    } else {
      return $this->load_and_save($num);
    }
  }

  function load_and_save($num) {
    $json = $this->loader->load($num);

    set_transient(
      $this->key($num), $json, $this->duration($num)
    );

    return $json;
  }

  function key($num) {
    if (is_null($num)) {
      return 'xkcd-shortcode-latest';
    } else {
      return "xkcd-shortcode-$num";
    }
  }

  function duration($num) {
    if (is_null($num)) {
      return 60 * 60 * 24;
    } else {
      return 60 * 60 * 24 * 7;
    }
  }

}

?>
