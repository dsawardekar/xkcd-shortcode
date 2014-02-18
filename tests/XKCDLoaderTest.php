<?php

require_once(__DIR__ . '/../lib/XKCDLoader.php');

class XKCDLoaderTest extends WP_UnitTestCase {
  function setUp() {
    $this->loader = new XKCDLoader();
  }

  function test_it_can_build_api_url_without_number() {
    $url = $this->loader->build(null);
    $this->assertEquals('http://xkcd.com/info.0.json', $url);
  }

  function test_it_can_build_api_url_with_number() {
    $url = $this->loader->build(5);
    $this->assertEquals('http://xkcd.com/5/info.0.json', $url);
  }

  function test_it_can_parse_valid_json() {
    $body = '{ "num": 1 }';
    $json = $this->loader->parse($body);
    $this->assertEquals(1, $json->num);
  }

  function test_it_throws_exception_with_invalid_json() {
    $this->setExpectedException('Exception');
    $body = '{ "num: 1 }';
    $json = $this->loader->parse($body);
  }

  function test_it_throws_an_exception_on_wp_errors() {
    $this->setExpectedException('Exception');
    $this->loader->verify(new WP_Error());
  }

  function test_it_throws_an_exception_unless_200_response() {
    $this->setExpectedException('Exception');
    $this->loader->verify(array("response" => array("code" => 404)));
  }

  function test_it_throws_an_exception_if_body_is_empty() {
    $this->setExpectedException('Exception');
    $this->loader->verify('');
  }

  function test_it_can_fetch_json_for_current_comic() {
    $json = $this->loader->load();
    $this->assertGreaterThanOrEqual(1331, $json->num);
  }

  function test_it_can_fetch_json_for_specified_comic() {
    $json = $this->loader->load(101);
    $this->assertEquals(101, $json->num);
  }

  function test_it_throws_an_exception_for_unknown_comic() {
    $this->setExpectedException('Exception');
    $this->loader->load(1000000);
  }

}

?>
