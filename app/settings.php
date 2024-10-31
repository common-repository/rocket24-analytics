<?php

if (!defined('HERBERT_AUTOLOAD')) {
	exit;
}
// Exit if accessed directly

add_action('admin_init', function () {

	add_settings_section(
		'ranalytics',
		'',
		function () {}, //empty callback
		'ranalytics-configure'
	);
	asf('ranalytics-manual');
	asf('ranalytics-tracking-key', function ($input) {
		if ($input == "") {
			return "";
		}
		return $input;
	});
	asf('ranalytics-google-app-key', function ($input) {
		if (empty($input)) {
			add_settings_error(
				'ranalytics-google-app-key',
				esc_attr('settings_updated'),
				"Please enter a google authentication code.",
				"error"
			);
			return "Paste code here.";
		}
		if ($input == "Paste code here.") {
			return "Paste code here.";
		}
		// Bush do yer thing
		$client = (new \Ranalytics\Apis\GoogleApi)->getClient();
		$client->authenticate($input);
		update_option('ranalytics-google-access-token', $client->getAccessToken());
		return "Paste code here.";
	});
	asf('ranalytics-track-from', function ($input) {
		$return = [];
		if (!empty($input)) {
			foreach ($input as $key => $val) {
				$return[$key] = sanitize_text_field(strtolower($val));
			}
			return $return;
		}
		return;
	}, 'ranalytics-roles');
	asf('ranalytics-enabled', function ($input) {
		if ($input == "true") {
			return true;
		} else if ($input == "false") {
			return false;
		}
	}, 'ranalytics-roles');
	asf('ranalytics-track-fourofour', function ($input) {
		if ($input == "true") {
			return true;
		} else if ($input == "false") {
			return false;
		}
	}, 'ranalytics-roles');
});

//add settings field
function asf($name, $sanitizer = null, $page = 'ranalytics-configure') {
	if ($sanitizer == null) {
		$sanitizer = function ($input) {return $input;};
	}
	add_settings_field(
		$name,
		'',
		function () {}, //empty callback
		$page
	);
	register_setting($page, $name, $sanitizer);
}
