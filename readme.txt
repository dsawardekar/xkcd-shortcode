=== xkcd-shortcode ===
Contributors: dsawardekar
Donate link: http://pressing-matters.io/
Tags: xkcd, shortcode
Requires at least: 3.5.0
Tested up to: 3.8.1
Stable tag: 0.8.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds an [xkcd] shortcode that loads the XKCD webcomic by number.

== Description ==

This plugin adds an `[xkcd]` shortcode tag to WordPress. You can use it
to embed the [XKCD](http://xkcd.com) webcomic into your posts and pages.

It takes a `num` attribute that specifies the number of the XKCD comic
to embed. For Eg:- To embed the 100th comic use,

        [xkcd num='100']

When the `num` attribute is omitted the latest XKCD comic is shown
instead.

        [xkcd]

== Installation ==

1. Upload the `xkcd-shortcode` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use `[xkcd]` shortcodes in your posts or pages.

== Frequently Asked Questions ==

= Does it download the xkcd images? =

No. The images are hotlinked to the [XKCD website](http://xkcd.com)

== Upgrade Notice ==

* Initial Release

== Screenshots ==

1. The XKCD Webcomic #1 embedded in a Post.

== Changelog ==

= 0.8.0 =

* Adds caching. Comics are now cached as transients.
* Fixes version numbering

= 0.7 =

* Fixes readme.

= 0.6 =
* Fixes usage with scatter_deploy.

= 0.1 =
* Initial Release
