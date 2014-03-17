<?php
/*
Plugin Name: xkcd-shortcode
Description: Adds an [xkcd] shortcode that loads the XKCD webcomic by number.
Version: 0.8.0
Author: Darshan Sawardekar
Author URI: http://pressing-matters.io/
Plugin URI: http://wordpress.org/plugins/xkcd-shortcode
License: GPLv2
*/

require_once(__DIR__ . '/lib/XKCDShortcodePlugin.php');

$xkcd_shortcode_plugin = new XKCDShortcodePlugin();
$xkcd_shortcode_plugin->enable();

?>
