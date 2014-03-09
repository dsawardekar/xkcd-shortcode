<?php

class CachedXKCDLoader {

  public $loader;

  function __construct($loader) {
    $this->loader = $loader;
  }

  function load($num = null) {
    if (is_null($num)) {
      return $this->loader->load($num);
    } else {
      return $this->lookup($num);
    }
  }

  function lookup($num) {
    $json = get_option($this->key($num));

    if ($json !== false) {
      return $json;
    } else {
      return $this->load_and_save($num);
    }
  }

  function load_and_save($num) {
    $key = $this->key($num);
    $json = $this->loader->load($num);

    update_option($key, $json);

    return $json;
  }

  function key($num) {
    return "xkcd-shortcode-$num";
  }

}

?>
