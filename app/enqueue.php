<?php

namespace Ranalytics;

if (!defined('HERBERT_AUTOLOAD')) {
	exit;
}
// Exit if accessed directly

/** @var \Herbert\Framework\Enqueue $enqueue */
$enqueue->admin([
	'as'     => 'Select2',
	'src'    => Helper::assetUrl('/js/select2.min.js'),
	'filter' => ['panel' => 'ranalytics-roles'],
]);
$enqueue->admin([
	'as'     => 'Select2CSS',
	'src'    => Helper::assetUrl('/css/select2.min.css'),
	'filter' => ['panel' => 'ranalytics-roles'],
]);

$enqueue->admin([
	'as'     => 'BootstrapGrid',
	'src'    => Helper::assetUrl('/css/bsgrid.css'),
	'filter' => ['panel' => '*'],
]);

add_action('wp_head', function () {
	if (isTrackable() && get_option('ranalytics-tracking-key', false) && get_option('ranalytics-enabled')) {
		$code           = get_option('ranalytics-tracking-key', null);
		$analytics_code = "
        <!-- Google Analytics -->
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		ga('create', '{$code}', 'auto');
		ga('send', 'pageview');
        console.info('Analytics: Active. with {$code}')
		</script>
		<!-- End Google Analytics -->
		";
		echo $analytics_code;
	}
});
function isTrackable() {
	global $wp_roles;
	global $current_user;

	if (is_404()) {
		if (!get_option('ranalytics-track-fourofour', false)) {
			return false;
		}
	}
	//if user is not logged in TRACK EM.
	if (!is_user_logged_in()) {
		return true;
	} else if ($roles = get_option('ranalytics-track-from')) {
		foreach ($current_user->roles as $role) {
			if (in_array($role, $roles)) {
				return true;
			}
		}
		return false;
	}
}
