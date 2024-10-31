=== Plugin Name ===
Contributors: tortlewortle
Tags: google analytics, analytics, panel, preview, google
Requires at least: 4.0
Tested up to: 4.6.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
This plugin provides an easy way to link google analytics and decide on which users to track.
It also provides a basic interface on this and last months stats.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

### Setup
In the setup you find two options to set the plugin up: Manual and Automatic.

In manual mode you paste the google analytics code in the field and click "change key".
(note: manual mode disables the analytics page)

In automatic mode you have to link your google account.
to do this you click on the "login to google" link above the input field.
after authorizing the google account with the analytics you copy the code and paste it in the input field and click authorize a success popup should appear. shortly after clicking close a configuration window should appear, please follow the steps and click "save selection" this will link the proper values and automatically embed the proper javascript tracking code into each page. (see Settings for more options)

### Settings
"Enable google analytics?" if the plugin should embed the tracking code. yes or no.
"Track 404 not found pages?" if the tracking code should be embedded in 404 not found pages. yes or 
"Track users with the following roles:" select what roles the plugin should track. (E.G everything but admin will embed the tracking code for all users except for admins) the plugin will always track non-logged in users.

### Modes
There are two modes available: automatic and manual.

In both manual and automatic modes you can choose which user roles and if 404 (not found) pages will be tracked.

== Changelog ==

- 1.0
    - Release!.