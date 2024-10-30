=== LH Oembed White List ===
Contributors: shawfactor
Donate link: https://lhero.org/portfolio/lh-oembed-white-list/
Tags: oembed, links, gui
Requires at least: 3.0.
Tested up to: 5.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Makes adding Oembed providers as easy as filling in a form

== Description ==

The plugin basically adds a GUI to the wp oembed add provider function such that administrators or super administrators can add oembed providers to the individual site or network.

== Frequently Asked Questions ==

= How does this plugin behave when network activated? =
When network activated the admin is moved under network admin and is stored as a site_option

= How do I configure the plugin? =
The New provider format is the domain and optionally the directory of the provider urls you are adding, e.g. https://*.mydomain.com/*
To find the New provider endpoint, visit one of the urls you are trying to embed and find the endpoint link tag in the meta e.g. https://mydomain.com/wp-json/oembed/1.0/embed


== Installation ==

1. Upload the entire `lh-oembed-white-list` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. If local site activated navigate to to Settings->Oembed White List, if network activated navigate to Network Admnin->Settings->Oembed White List
1. Add Oembed provider(s), more info here: https://codex.wordpress.org/Function_Reference/wp_oembed_add_provider


== Changelog ==

**1.00 June 22, 2017**  
Initial release.

**1.01 September 17, 2018**  
Singleton Pattern.

**1.02 September 17, 2019**  
Minor improvements.