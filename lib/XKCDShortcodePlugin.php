<?php

require_once(__DIR__ . '/XKCDShortcode.php');

class XKCDShortcodePlugin {
  public $shortcode = null;

  function enable() {
    add_shortcode('xkcd', array($this, 'callback'));
  }

  function disable() {
    remove_shortcode('xkcd');
  }

  function getShortcode() {
    if (is_null($this->shortcode)) {
      $this->shortcode = new XKCDShortcode();
    }

    return $this->shortcode;
  }

  function callback($params) {
    return $this->getShortcode()->render($params);
  }
}

?>
