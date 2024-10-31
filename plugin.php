<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * @wordpress-plugin
 * Plugin Name:       Rocket24 Analytics
 * Description:       Google analytics plugin.
 * Version:           1.0.0
 * Author:            Rocket24
 * Author URI:	      //rocket24.nl
 * License:           MIT
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php';

register_deactivation_hook(__FILE__, function () {
	unregister_setting("ranalytics-roles", "ranalytics-track-from");
	unregister_setting("ranalytics-roles", "ranalytics-enabled");
	unregister_setting("ranalytics-roles", "ranalytics-track-fourofour");
	unregister_setting("ranalytics-configure", "ranalytics-manual");
	unregister_setting("ranalytics-configure", "ranalytics-tracking-key");
	unregister_setting("ranalytics-configure", "ranalytics-link-data");
	unregister_setting("ranalytics-configure", "ranalytics-google-access-token");

	delete_transient('analyticsLastMonth');
	delete_transient('analyticsThisMonth');
	delete_transient('topententhismonth');
	delete_transient('topentenlastmonth');
});