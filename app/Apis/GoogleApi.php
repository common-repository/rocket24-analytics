<?php
namespace Ranalytics\Apis;

class GoogleApi {
	public function getAnalytics($access_token = null) {
		return new \Google_Service_Analytics($this->getClient($access_token));
	}
	public function getClient($access_token = null) {
		$creds = [
			'client_id'     => '555054823622-fdqq73gqm0dh389jjjeibqqe67jb7gg0.apps.googleusercontent.com',
			'client_secret' => '9qCHkKxT9KurKY_tvpr3XU2z',
		];
		$client = new \Google_Client();
		$client->setClientId($creds['client_id']);
		$client->setClientSecret($creds['client_secret']);
		$client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
		$client->setScopes('https://www.googleapis.com/auth/analytics.readonly');
		$client->setAccessType('offline');
		$client->setApprovalPrompt('force');
		if ($access_token != null) {
			$client->setAccessToken($access_token);
			if ($client->isAccessTokenExpired()) {
				$client->refreshToken($access_token['refresh_token']);
			}
		}
		return $client;
	}
}