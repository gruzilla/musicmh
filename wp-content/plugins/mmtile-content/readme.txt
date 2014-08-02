=== MMTile Post Type ===
Contributors: downstairsdev, garyj
Tags: mmtile, post type
Requires at least: 3.4
Tested up to: 3.6
Stable tag: 0.6.0
License: GPLv2 or later

== Description ==

This plugin registers a custom post type for mmtile items.  It also registers separate mmtile taxonomies for tags and categories.  If featured images are selected, they will be displayed in the column view.  The mmtile image used in the dashboard was designed by Ben Dunkle, who also did the other UI icons in WordPress.

This plugin doesn't change how mmtile items are displayed in your theme.  You'll need to add templates for archive-mmtile.php and single-mmtile.php if you want to customize the display of mmtile items.

== Installation ==

Just install and activate.

== Frequently Asked Questions ==

= How can I display mmtile items differently than regular posts? =

You will need to get your hands dirty with a little code and create a archive-mmtile.php template (for displaying multiple items) and a single-mmtile.php (for displaying the single item).

= Why did you make this? =

To allow users of MMTile Press to more easily migrate to a new theme.  And hopefully, to save some work for other folks trying to set a mmtile.

= Is this code on GitHub? =

Of course: [https://github.com/devinsays/mmtile-post-type](https://github.com/devinsays/mmtile-post-type)

== Changelog ==

= 0.6 =

* Added @garyj as a contributor (Welcome!)
* Updated to proper coding standards
* Updated inline documentation
* New filters for taxonomy arguments
* Added body classes for custom taxonomy terms
* Refactored code to be more DRY
* Added not_found label to mmtile tag taxonomy
* Updated translations.pot

= 0.5 =

* Use show_admin_column for taxonomies (http://make.wordpress.org/core/2012/12/11/wordpress-3-5-admin-columns-for-custom-taxonomies/) rather than a custom function
* Add author field custom post type
* Allows $args to be filtered (https://github.com/devinsays/mmtile-post-type/issues/8)

= 0.4 =

* Update to use classes
* Update supports to include custom fields and excerpts

= 0.3 =

* Added category to column view
* Added mmtile count to "right now" dashboard widget (props @nickhamze)
* Added contextual help on mmtile edit screen (props @nickhamze)
* Now flushes rewrite rules on plugin activation

= 0.2 =

* Fixes for mmtile tag label
* Fixes for column display of mmtile items

= 0.1 =

* Initial release