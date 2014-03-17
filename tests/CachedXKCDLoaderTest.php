<?php

require_once(__DIR__ . '/../lib/CachedXKCDLoader.php');
require_once(__DIR__ . '/../lib/XKCDLoader.php');

class CachedXKCDLoaderTest extends WP_UnitTestCase {

  function setUp() {
    $this->xkcd_loader = new XKCDLoader();
    $this->cached_loader = new CachedXKCDLoader($this->xkcd_loader);
  }

  function tearDown() {
    delete_transient('xkcd-shortcode-latest');
  }

  function stub($json) {
    $stub = $this->getMock('XKCDLoader');
    $stub->expects($this->any())
         ->method('load')
         ->will($this->returnValue($json));

    $this->cached_loader->loader = $stub;
  }

  function test_it_saves_loader_object() {
    $this->assertEquals($this->xkcd_loader, $this->cached_loader->loader);
  }

  function test_it_can_build_key_from_xkcd_number() {
    $this->assertEquals('xkcd-shortcode-5', $this->cached_loader->key(5));
  }

  function test_it_can_load_meta_and_save_as_option() {
    $json = array('foo' => 'bar');
    $this->stub($json);

    $result = $this->cached_loader->load_and_save(5);

    $this->assertEquals($json, $result);
    $saved = get_transient('xkcd-shortcode-5');
    $this->assertEquals($json, $saved);
  }

  function _test_it_can_lookup_cached_xkcd_comic() {
    $json = array('foo' => 'bar');
    set_transient('xkcd-shortcode-10', $json, 60);

    $result = $this->cached_loader->lookup(10);
    $this->assertEquals($json, $result);
  }

  function _test_it_can_lookup_non_cached_xkcd_comic() {
    $json = array('lorem' => 'ipsum');
    $this->stub($json);

    $result = $this->cached_loader->lookup(15);
    $this->assertEquals($json, $result);
  }

  function test_it_can_load_cached_xkcd_comic() {
    $json = array('foo' => 'bar');
    set_transient('xkcd-shortcode-11', $json, 60);

    $result = $this->cached_loader->load(11);
    $this->assertEquals($json, $result);
  }

  function test_it_can_load_non_cached_xkcd_comic() {
    $json = array('lorem' => 'ipsum');
    $this->stub($json);

    $result = $this->cached_loader->load(12);
    $this->assertEquals($json, $result);
  }

  function test_it_can_load_latest_comic_without_caching() {
    $json = array('lorem' => 'ipsum');
    $this->stub($json);

    $result = $this->cached_loader->load(null);
    $this->assertEquals($json, $result);
  }

}

?>
