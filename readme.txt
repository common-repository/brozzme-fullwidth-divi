=== Brozzme Fullwidth and Automatic Layout in Divi ===
Contributors: Benoti
Tags: divi, fullwidth, tools, manage, content, sidebar, dot, navigation, layout, automatic, workflow
Donate link: https://brozzme.com/
Requires at least: 4.8
Tested up to: 5.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fullwidth page and other layout options made easy with Divi theme, save all your new content without worry of this, update in one click all your content with predefined settings.


== Description ==
**Brozzme Fullwidth and Automatic Layout in Divi** is made to simplify the workflow when new content are created. Choose the predefined layout type and apply it on each post, page or product.
You can also, hide or display the post title.
A tools page in the setting panel allows administrator to modify whole website layout type in one click.

To use this plugin, Divi theme must be activated.

**Options:**

1. Choose the layout : fullwidth, left sidebar, right sidebar
2. Apply changes to Woocommerce products
3. Show or hide title on layout (only available for posts - Divi restriction)
4. Apply dot navigation
5. Apply hide nav bar before scroll

**Tools**
1. Apply layout type in one click
2. Apply post title visibility in one click
3. Apply dot navigation in one click
4. Apply hide nav bar before scroll in one click

[Benoti](https://brozzme.com/ "Brozzme") and [WPServeur](https://www.wpserveur.net/?refwps=221 "WPServeur WordPress Hosting").

== Installation ==
1. Upload the archive  into the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.

== Frequently Asked Questions ==
= I want to apply the layout to another post type =
There is a special filter to add any post type to the tools
Just add this in your functions.php
add_filter("bfd_layout_tools_post_types", "your_function");
    function your_function($post_types){
    $my_new_post_types = array("project", "event");
    $post_types = array_merge($post_types, $my_new_post_types);
    return $post_types;
}


== Screenshots ==
1. Setting options screenshot-1.png.
2. Tools page screenshot-2.png.

== Changelog ==
=1.1=
* bug fixes
* new editor compatibility (partial)
* add new option
=1.0 =
* Initial release.