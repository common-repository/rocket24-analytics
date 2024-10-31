<?php

namespace Ranalytics;

if (!defined('HERBERT_AUTOLOAD')) {
	exit;
}
// Exit if accessed directly

use Herbert\Framework\Http;
use Ranalytics\Apis\GoogleApi;
$namespace = '/api/analytics';
$router->get([
	'uri'  => $namespace . '/topTenLastMonth',
	'uses' => function () {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			if ($data = get_transient('topentenlastmonth')) {
				return json_encode($data);
			}
			$analytics = (new GoogleApi)->getAnalytics(get_option('ranalytics-google-access-token', null));
			if ($profile = get_option('ranalytics-link-data', null)) {
				if ($profileId = $profile['profile']) {
					$res = $analytics->data_ga->get(
						'ga:' . $profileId,
						date("Y-m-d", strtotime("first day of previous month")),
						date("Y-m-d", strtotime("last day of previous month")),
						'ga:pageviews, ga:uniquePageviews',
						[
							'dimensions'  => 'ga:pagePath,ga:pageTitle',
							'filters'     => 'ga:hostname==' . preg_replace('#^http(s)?://#', '', site_url()),
							'max-results' => 10,
						]
					);
					$data               = [];
					$data['totalViews'] = $res->totalsForAllResults['ga:pageviews'];
					if ($res->getRows() == null) {
						$data['rows'] = [];
					} else {
						foreach ($res->getRows() as $row) {
							$data['rows'][] = [
								'path'        => $row[0],
								'title'       => $row[1],
								'views'       => (int) $row[2],
								'uniqueViews' => (int) $row[3],
							];
						}
					}
					set_transient('topentenlastmonth', $data, 60 * 30);
					return json_encode($data);
				}
			}
		} else {
			header('HTTP/1.0 403 Forbidden');
			return "Go away here be dragons!";
		}
	},
]);
$router->get([
	'uri'  => $namespace . '/topTenThisMonth',
	'uses' => function () {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			if ($data = get_transient('topententhismonth')) {
				return json_encode($data);
			}
			$analytics = (new GoogleApi)->getAnalytics(get_option('ranalytics-google-access-token', null));
			if ($profile = get_option('ranalytics-link-data', null)) {
				if ($profileId = $profile['profile']) {
					$res = $analytics->data_ga->get(
						'ga:' . $profileId,
						date("Y-m-01"),
						'today',
						'ga:pageviews, ga:uniquePageviews',
						[
							'dimensions'  => 'ga:pagePath,ga:pageTitle',
							'filters'     => 'ga:hostname==' . preg_replace('#^http(s)?://#', '', site_url()),
							'max-results' => 10,
						]
					);
					$data               = [];
					$data['totalViews'] = $res->totalsForAllResults['ga:pageviews'];
					if ($res->getRows() == null) {
						$data['rows'] = [];
					} else {
						foreach ($res->getRows() as $row) {
							$data['rows'][] = [
								'path'        => $row[0],
								'title'       => $row[1],
								'views'       => (int) $row[2],
								'uniqueViews' => (int) $row[3],
							];
						}
					}
					set_transient('topententhismonth', $data, 60 * 30);
					return json_encode($data);
				}
			}
		} else {
			header('HTTP/1.0 403 Forbidden');
			return "Go away here be dragons!";
		}
	},
]);
$router->get([
	'uri'  => $namespace . '/thisMonth',
	'uses' => function () {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			if ($data = get_transient('analyticsThisMonth')) {
				return json_encode($data);
			}
			$analytics = (new GoogleApi)->getAnalytics(get_option('ranalytics-google-access-token', null));
			if ($profile = get_option('ranalytics-link-data', null)) {
				if ($profileId = $profile['profile']) {
					$res = $analytics->data_ga->get(
						'ga:' . $profileId,
						date("Y-m-01"),
						'today',
						'ga:sessions,ga:pageviews',
						[
							'dimensions' => 'ga:day',
							'filters'    => 'ga:hostname==' . preg_replace('#^http(s)?://#', '', site_url()),
						]
					);
					$data                  = [];
					$data['totalSessions'] = $res->totalsForAllResults['ga:sessions'];
					$data['totalViews']    = $res->totalsForAllResults['ga:pageviews'];
					foreach ($res->getRows() as $row) {
						$data['rows'][] = [
							'day'      => (int) $row[0],
							'views'    => (int) $row[2],
							'sessions' => (int) $row[1],
						];
					}
					set_transient('analyticsThisMonth', $data, 60 * 30);
					return json_encode($data);
				}
			}
		} else {
			header('HTTP/1.0 403 Forbidden');
			return "Go away here be dragons!";
		}
	},
]);
$router->get([
	'uri'  => $namespace . '/lastMonth',
	'uses' => function () {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			if ($data = get_transient('analyticsLastMonth')) {
				return json_encode($data);
			}
			$analytics = (new GoogleApi)->getAnalytics(get_option('ranalytics-google-access-token', null));
			if ($profile = get_option('ranalytics-link-data', null)) {
				if ($profileId = $profile['profile']) {
					$res = $analytics->data_ga->get(
						'ga:' . $profileId,
						date("Y-m-d", strtotime("first day of previous month")),
						date("Y-m-d", strtotime("last day of previous month")),
						'ga:sessions,ga:pageviews',
						[
							'dimensions' => 'ga:day',
							'filters'    => 'ga:hostname==' . preg_replace('#^http(s)?://#', '', site_url()),
						]
					);
					$data                  = [];
					$data['totalSessions'] = $res->totalsForAllResults['ga:sessions'];
					$data['totalViews']    = $res->totalsForAllResults['ga:pageviews'];
					foreach ($res->getRows() as $row) {
						$data['rows'][] = [
							'day'      => (int) $row[0],
							'views'    => (int) $row[2],
							'sessions' => (int) $row[1],
						];
					}
					set_transient('analyticsLastMonth', $data, 60 * 30);
					return json_encode($data);
				}
			}
		} else {
			header('HTTP/1.0 403 Forbidden');
			return "Go away here be dragons!";
		}
	},
]);
$router->get([
	'uri'  => $namespace . '/mode',
	'uses' => function () {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			return json_encode(['MANUAL_ENABLED' => get_option('ranalytics-manual') == 1]);
		} else {
			header('HTTP/1.0 403 Forbidden');
			return "Go away here be dragons!";
		}
	},
]);
// GET : /KEY
$router->get([
	'uri'  => $namespace . '/key',
	'uses' => function () {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			return json_encode(
				[
					'key'   => get_option('ranalytics-tracking-key', null),
					'nonce' => wp_create_nonce('update_tracking_key'),
				]);
		} else {
			header('HTTP/1.0 403 Forbidden');
			return "Go away here be dragons!";
		}
	},
]);
// POST : /KEY
$router->post([
	'uri'  => $namespace . '/key',
	'uses' => function (Http $http) {
		if (is_user_logged_in() && current_user_can('manage_options') && wp_verify_nonce($http->input('nonce'), 'update_tracking_key')) {
			update_option('ranalytics-manual', 1);
			if (update_option('ranalytics-tracking-key', $http->input('key'))) {
				//change to manual mode
				return json_encode(
					[
						'key' => get_option('ranalytics-tracking-key', $http->input('key')),
					]);
			}
		} else {
			header('HTTP/1.0 403 Forbidden');
			return "Go away here be dragons!";
		}
	},
]);
// GET : NewAccessRefresh
$router->get([
	'uri'  => $namespace . '/NewAccessRefresh',
	'uses' => function (Http $http) {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			return json_encode(
				[
					'uri'    => (new GoogleApi)->getClient()->createAuthUrl(),
					'nonce'  => wp_create_nonce('_get_access_refresh_token_'),
					'authed' => null != get_option('ranalytics-google-access-token', null),
				]);
		} else {
			header('HTTP/1.0 403 Forbidden');
			return "Go away here be dragons!";
		}
	},
]);
// POST : NewAccessRefresh
$router->post([
	'uri'  => $namespace . '/NewAccessRefresh',
	'uses' => function (Http $http) {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			if (wp_verify_nonce($http->input('nonce'), '_get_access_refresh_token_')) {
				$client = (new GoogleApi)->getClient();
				$client->authenticate($http->input('code'));
				$code = $client->getAccessToken();
				if (update_option('ranalytics-google-access-token', $code)) {
					update_option('ranalytics-manual', false);
					return 'success';
				} else {
					return 'something went wrong';
				}
			} else {
				return 'nonce was wrong';
			}
		}
		header('HTTP/1.0 403 Forbidden');
		return "Go away here be dragons!";
	},
]);
// GET : ConfigureAccounts
$router->get([

	'uri'  => $namespace . '/ConfigureAccounts',
	'uses' => function () {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			if (null == get_option('ranalytics-google-access-token', null)) {
				return "Error please try re-authenticate";
			}
			if ($data = get_transient('configureAccountsData')) {
				return json_encode($data);
			}
			$client = (new GoogleApi)->getClient(get_option('ranalytics-google-access-token', null));
			$data   = [
				'nonce'    => wp_create_nonce(")configure_Accounts("),
				'accounts' => getArrayThing($client),
			];
			set_transient('configureAccountsData', $data, 60 * 5);
			return json_encode($data);
		} else {
			header('HTTP/1.0 403 Forbidden');
			return "Go away here be dragons!";
		}
	},
]);
// POST : ConfigureAccounts
// wp_verify_nonce($http->input('nonce'), ')configure_Accounts(')
/** @var \Herbert\Framework\Router $router */
$router->post([
	'uri'  => $namespace . '/ConfigureAccounts',
	'uses' => function (Http $http) {
		if (is_user_logged_in() && current_user_can('manage_options')) {
			if (wp_verify_nonce($http->input('nonce'), ')configure_Accounts(')) {
				$account  = $http->input('account');
				$property = $http->input('property');
				$profile  = $http->input('profile');
				$data     = [
					'account'  => $account,
					'property' => $property,
					'profile'  => $profile,
				];
				update_option('ranalytics-tracking-key', $property);
				update_option('ranalytics-manual', false);
				update_option('ranalytics-link-data', $data);

				//Delete existing analytics cache
				delete_transient('analyticsLastMonth');
				delete_transient('analyticsThisMonth');
				delete_transient('topententhismonth');
				delete_transient('topentenlastmonth');
				return "success";
			}
		}
		header('HTTP/1.0 403 Forbidden');
		return "Go away here be dragons!";
	},
]);

//not finished yet

function getArrayThing(&$client) {
	$analytics = new \Google_Service_Analytics($client);

	// Get the list of accounts for the authorized user.
	$accounts_array = [];
	$accounts       = $analytics->management_accounts->listManagementAccounts();
	if (count($accounts->getItems()) < 1) {
		throw new Exception('No accounts found for this user.');
	}
	foreach ($accounts->getItems() as $account) {
		$properties_array = [];
		$properties       = $analytics->management_webproperties
			->listManagementWebproperties($account->getId());

		if (count($properties->getItems()) < 0) {
			throw new Exception('No properties found for this user.');
		}
		foreach ($properties->getItems() as $property) {
			$profiles_array = [];
			$profiles       = $analytics->management_profiles
				->listManagementProfiles($account->getId(), $property->getId());

			if (count($profiles->getItems()) < 1) {
				throw new Exception('No views (profiles) found for this user.');
			}
			foreach ($profiles as $profile) {
				$profiles_array[] = [
					'id'   => $profile->getId(),
					'name' => $profile->getName(),
				];
			}
			$properties_array[] = [
				'id'       => $property->getId(),
				'name'     => $property->getName(),
				'profiles' => $profiles_array,
			];
		}
		$accounts_array[] =
			[
			'id'         => $account->getId(),
			'name'       => $account->getName(),
			'properties' => $properties_array,
		];

	}
	return $accounts_array;
}
unset($namespace);
