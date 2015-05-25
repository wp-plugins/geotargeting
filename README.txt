=== GeoTargeting Lite - WordPress GeoTargeting ===
Contributors: timersys
Donate link: http://wp.timersys.com/geotargeting/
Tags: geolocation, geotargeting, wordpress geotargeting, geo target, geo targeting, ip geo detect
Requires at least: 3.6
Tested up to: 4.2.2
Stable tag: 1.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

GeoTargeting for WordPress will let you country-target your content based on users IP's and Geocountry Ip database

== Description ==

Based on [Maxmind GeoIP2](http://www.maxmind.com/?rId=timersys) data Geo Targeting plugin for WordPress will let you create dynamic content based on your users country.

With a simple shortcode you will be able to specify which countries are capable of seeing the content.

Compatible with [Wordpress Popups Plugin](https://wp.timersys.com/popups/?utm_source=geot-readme&utm_medium=link&utm_term=popus%20premium&utm_campaign=Popups%20premium). You can now geotarget your popups

Now also compatible with *Cloudflare Geolocation*. Simple add define('GEOT_CLOUDFLARE',true); to your wp-config.php file to enable it!

Usage:
`[geot country="Argentina"] Messi is the best! [/geot]`
`[geot country="Portugal"] Cristiano ronaldo is the best! [/geot]`
`[geot exclude_country="Portugal"] This text is seeing by everyone except Portuguese people [/geot]`

> <strong>Premium Version</strong><br>
> 
> Check the **new premium version** available in ([http://wp.timersys.com/geotargeting/](https://wp.timersys.com/geotargeting/?utm_source=geot-readme&utm_medium=link&utm_term=geot%20premium&utm_campaign=Geot%20premium))
>
> * [Maxmind API](https://www.maxmind.com/en/geoip2-precision-services?rId=timersys) keys compatible
> * [Maxmind premium database](https://www.maxmind.com/en/geoip2-city?rId=timersys) compatible
> * GeoTarget cities and states
> * Cloudflare geolocation support
> * Editor button to easily add shortcodes
> * Create multiple regions (group of countries or cities) to use with shortcodes
> * Exclude countries, cities and regions shortcode
> * Dropdown Widget to let users change their country
> * Upcoming integration with other populars plugins
> * Premium support
> 


= Wordpress Popups  =

Best popups plugin ever ([http://wp.timersys.com/popups/](http://wp.timersys.com/popups/?utm_source=wsi-free-plugin&utm_medium=readme))

= Install Multiple plugins at once with WpFavs  =

Bulk plugin installation tool, import WP favorites and create your own lists ([http://wordpress.org/extend/plugins/wpfavs/](http://wordpress.org/extend/plugins/wpfavs/))

= Increase your twitter followers  =

Increase your Twitter followers with Twitter likebox Plugin ([http://wordpress.org/extend/plugins/twitter-like-box-reloaded/](http://wordpress.org/extend/plugins/twitter-like-box-reloaded/))

= Wordpress Social Invitations  =

Enhance your site by letting your users send Social Invitations ([http://wp.timersys.com/wordpress-social-invitations/](http://wp.timersys.com/wordpress-social-invitations/?utm_source=social-popup&utm_medium=readme))

== Installation ==

1. Unzip and Upload the directory 'geo-targeting' to the '/wp-content/plugins/' directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Go to the editor and use as many shortcodes as needed



== Frequently Asked Questions ==

= How can I display content to everyone except some countries =
If you have content that want to be display to USA's users but then you want to show another content to everyone else, you can do the followin:
`[geot country="United States"] USA only content [/geot]`
`[geot exclude_country="United States"] Everyone except USA will see this [/geot]`

== Changelog ==

= 1.1.2 =
* Fixed function country name
* Added fallback in case IP not found

= 1.1.1 =
* Fixed bug with popups integration
* Fixed bug in some shortcodes and functions

= 1.1 =

* Now we use Maxmind API and mmdb database instead of loading mysql server
* No more heavy databases installs on plugin installation
* Added cloudflare geolocation

= 1.0.3 =

* Added support for [Wordpress Popups Plugin](https://wordpress.org/plugins/popups/)
* Added multisite support

= 1.0.2 =

* Added sessions to cache user country and calculate it just once per session
* Updated IP database
* Removed calculate IP in admin area because was not necessary

= 1.0.1 =

* Fixed error uploading data on activation or certain servers
* Fixed error in php functions
* Updated IP database

= 1.0.0 = 

* Plugin launched!
