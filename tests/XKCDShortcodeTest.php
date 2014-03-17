<?php

require_once(__DIR__ . '/../lib/XKCDShortcode.php');

class XKCDShortcodeTest extends WP_UnitTestCase {
  function setUp() {
    $this->shortcode = new XKCDShortcode();
  }

  function tearDown() {
    delete_transient('xkcd-shortcode-latest');
  }

  function json($text) {
    return json_decode($text);
  }

  function test_it_defaults_to_current_comic() {
    $params = $this->shortcode->parse(shortcode_parse_atts(''));
    $this->assertNull($params['num']);
  }

  function test_it_picks_up_specified_comic_num() {
    $params = $this->shortcode->parse(shortcode_parse_atts('num="5"'));
    $this->assertEquals('5', $params['num']);
  }

  function test_it_renders_img_src_from_json() {
    $json = $this->json('{ "num": 1, "img": "comic-src", "title": "comic-title", "alt": "" }');
    $html = $this->shortcode->renderJSON($json);

    $this->assertRegExp('/src="comic-src"/', $html);
  }

  function test_it_renders_alt_tag_from_json() {
    $json = $this->json('{ "num": 1, "img": "comic-src", "title": "comic-alt", "alt": "" }');
    $html = $this->shortcode->renderJSON($json);

    $this->assertRegExp('/alt="comic-alt"/', $html);
  }

  function test_it_renders_title_tag_from_json() {
    $json = $this->json('{ "num": 1, "img": "comic-src", "title": "comic-alt", "alt": "comic-transcript" }');
    $html = $this->shortcode->renderJSON($json);

    $this->assertRegExp('/title="comic-transcript"/', $html);
  }

  function test_it_renders_img_tag_for_current_comic() {
    $params = shortcode_parse_atts('');
    $html = $this->shortcode->render($params);
    $matcher = array(
      'tag' => 'img'
    );

    $this->assertTag($matcher, $html);
  }
}

?>
