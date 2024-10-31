<?php
namespace Ranalytics\Controllers;

class Analytics {
	public function __construct() {

	}
	public function roleSetup() {
		ob_start();
		settings_fields('ranalytics-roles');
		do_settings_sections('ranalytics-roles'); //pass slug name of page
		$html = ob_get_clean();
		return view('@Ranalytics/roleSetup.twig', [
			'selectMenu' => $this->renderSelectMenu(),
			'markup'     => $html,
			'enabled'    => get_option('ranalytics-enabled'),
			"trackfor"   => get_option('ranalytics-track-fourofour'),
		]);
	}
	public function Index() {
		if (get_option('ranalytics-manual', true)) {
			return view("@Ranalytics/Analytics/Manual.twig");
		} else {
			if (get_option('ranalytics-link-data', null) == null) {
				return view('@Ranalytics/Analytics/NotConfigured.twig');
			}
			return view("@Ranalytics/Analytics/Analytics.twig");
		}
	}
	public function Configure() {
		ob_start();
		settings_fields('ranalytics-configure');
		do_settings_sections('ranalytics-configure'); //pass slug name of page
		$html = ob_get_clean();

		return view("@Ranalytics/Configure.twig", [
			'manual'       => get_option('Ranalytics-manual', true),
			'markup'       => $html,
			'tracking_key' => get_option('ranalytics-tracking-key', ''),
			'app_key'      => get_option('ranalytics-google-app-key'),
			'client_id'    => "555054823622-fdqq73gqm0dh389jjjeibqqe67jb7gg0.apps.googleusercontent.com",
		]);
	}

	public function renderSelectMenu() {
		global $wp_roles;

		$selected = "";
		$html     = "<h4>Track users with the following roles: </h4>";
		$html .= "<select style='min-width: 350px;' size='5' class='ranalytics-track-from' name='ranalytics-track-from[]' id='ranalytics-track-from' multiple>";
		foreach ($wp_roles->roles as $role => $roledata) {
			$rolename = $roledata['name'];
			// Temp fix I can't get the wordpress `selected` function to work properly
			if ($roles = get_option('ranalytics-track-from')) {
				if (in_array(strtolower($rolename), $roles)) {
					$selected = "selected='selected'";
				} else {
					$selected = "";
				}
			}
			$html .= "<option value='{$rolename}' " . $selected . ">{$rolename}</option>";
		}
		$html .= "</select>";
		return $html;
	}
}
