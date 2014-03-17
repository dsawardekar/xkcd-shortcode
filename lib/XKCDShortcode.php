<?php

require_once(__DIR__ . '/XKCDLoader.php');
require_once(__DIR__ . '/CachedXKCDLoader.php');

class XKCDShortcode {
  public $loader;
  public $defaults = array(
    "num" => null
  );

  function __construct() {
    $this->loader = new CachedXKCDLoader(new XKCDLoader());
  }

  function render($params) {
    try {
      $params   = $this->parse($params);
      $xkcd_num = $params['num'];
      $json     = $this->load($xkcd_num);

      return $this->renderJSON($json);
    } catch (Exception $e) {
      $message = $e->getMessage();
      if (preg_match('/404/', $message)) {
        $message = 'Unknown XKCD Comic: ' . $xkcd_num;
      }

      return '<p class="error error-xkcd">' . $message . '</p>';
    }
  }

  function parse($params) {
    return shortcode_atts($this->defaults, $params);
  }

  function load($xkcd_num) {
    return $this->loader->load($xkcd_num);
  }

  function renderJSON($json) {
    $src = $json->img;
    $href = 'http://xkcd.com/' . $json->num;

    // alt in html => title in json
    $alt = $json->title;

    // title in html => alt in json
    $title = $json->alt;

    $html = <<<EOT
      <a href="$href" class="link-xkcd">
        <img src="$src" alt="$alt" title="$title" class="img img-xkcd">
      </a>
EOT;

    return $html;
  }
}

?>
