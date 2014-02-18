<?php

require_once(__DIR__ . '/../lib/XKCDLoader.php');
require_once(__DIR__ . '/../lib/XKCDShortcodePlugin.php');

class XKCDShortcodePluginTest extends WP_UnitTestCase {
  function setUp() {
    $this->plugin = new XKCDShortcodePlugin();
  }

  function tearDown() {
    $this->plugin->disable();
  }

  function test_it_registers_an_xkcd_shortcode() {
    $this->plugin->enable();
    $this->assertTrue(shortcode_exists('xkcd'));
  }

  function test_it_does_auto_register_an_xkcd_shortcode() {
    $this->assertFalse(shortcode_exists('xkcd'));
  }

  function test_it_creates_a_shortcode_object_on_demand() {
    $this->assertNull($this->plugin->shortcode);
    $this->assertInstanceOf('XKCDShortcode', $this->plugin->getShortcode());
  }

  function test_it_shows_current_xkcd_comic_from_shortcode() {
    $loader = new XKCDLoader();
    $json = $loader->load();

    $matcher = array(
      'tag' => 'img',
      'attributes' => array(
        'src' => $json->img,
        'alt' => $json->alt,
        'class' => 'img img-xkcd'
      )
    );

    $this->plugin->enable();
    $html = do_shortcode('[xkcd]');
    $this->assertTag($matcher, $html);
  }

  function test_it_shows_specified_xkcd_comic_from_shortcode() {
    $loader = new XKCDLoader();
    $json = $loader->load(101);

    $matcher = array(
      'tag' => 'img',
      'attributes' => array(
        'src' => $json->img,
        'alt' => $json->alt,
        'class' => 'img img-xkcd'
      )
    );

    $this->plugin->enable();
    $html = do_shortcode("[xkcd num='101']");
    $this->assertTag($matcher, $html);
  }

  function test_it_shows_error_for_unknown_comic() {
    $this->plugin->enable();
    $html = do_shortcode("[xkcd num='1000000']");
    $this->assertRegExp("/XKCDLoader Failed/", $html);
  }
}

?>
