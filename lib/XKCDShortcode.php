<?php

require_once(__DIR__ . '/XKCDLoader.php');

class XKCDShortcode {
  public $defaults = array(
    "num" => null
  );

  function __construct() {
    $this->loader = new XKCDLoader();
  }

  function render($params) {
    try {
      $params = $this->parse($params);
      $json = $this->loader->load($params['num']);

      return $this->renderJSON($json);
    } catch (Exception $e) {
      return '<p class="error error-xkcd">' . $e->getMessage() . '</p>';
    }
  }

  function parse($params) {
    return shortcode_atts($this->defaults, $params);
  }

  function renderJSON($json) {
    $src = $json->img;
    $alt = $json->title;
    $transcript = $json->transcript;

    $html  = '<img ';
    $html .= 'src="' . $src . '" ';
    $html .= 'alt="' . $alt . '" ';
    $html .= 'title="' . $transcript . '" ';
    $html .= 'class="img img-xkcd" ';
    $html .= '>';

    return $html;
  }
}

?>
