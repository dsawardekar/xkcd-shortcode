<?php
/*
* Plugin Name: xkcd-shortcode
* Description: Provides an [xkcd] shortcode that loads the XKCD webcomic by number.
* Version: 0.1
* Author: Darshan Sawardekar
* Author URI: http://pressing-matters.io/
* Plugin URI: http://wordpress.org/plugins/xkcd-shortcode
**/

require_once(__DIR__ . '/lib/XKCDShortcodePlugin.php');

$xkcd_shortcode_plugin = new XKCDShortcodePlugin();
$xkcd_shortcode_plugin->enable();

?>
