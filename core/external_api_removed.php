<?php
/**
 * All listed external APIs are disconnected for this environment.
 */
if (!defined('EXTERNAL_APIS_REMOVED')) {
	define('EXTERNAL_APIS_REMOVED', true);
}

if (!function_exists('mdrc_external_api_removed')) {
	function mdrc_external_api_removed()
	{
		return defined('EXTERNAL_APIS_REMOVED') && EXTERNAL_APIS_REMOVED;
	}
}

if (!function_exists('mdrc_is_blocked_external_url')) {
	function mdrc_is_blocked_external_url($url)
	{
		$url = (string) $url;
		$hosts = array(
			'3.109.103.148',
			'lis6.mdrcindia.com',
			'182.156.200.228',
			'crm.mdrcindia.com',
			'crm.mdrcindia.net',
			'api-in21.leadsquared.com',
			'files-in21.leadsquared.com',
			'api.razorpay.com',
			'checkout.razorpay.com',
			'secure.ccavenue.com',
			'control.msg91.com',
			'txtguru.in',
			'mdrc-landingpage-backend.onrender.com',
			'maps.google.com',
			'maps.googleapis.com',
			'challenges.cloudflare.com',
			'fcm.googleapis.com',
			'oauth2.googleapis.com',
		);
		foreach ($hosts as $host) {
			if (stripos($url, $host) !== false) {
				return true;
			}
		}
		if (preg_match('#(^|/)(BookingAPI|HomeAPI|PatientLabReport|LeadManagement|Lead\.Capture)#i', $url)) {
			return true;
		}
		return false;
	}
}

if (!function_exists('mdrc_curl_exec')) {
	function mdrc_curl_exec($ch)
	{
		if (mdrc_external_api_removed() && $ch) {
			$url = (string) curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
			if ($url === '' || mdrc_is_blocked_external_url($url)) {
				return false;
			}
		}
		return curl_exec($ch);
	}
}
