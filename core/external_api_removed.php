<?php
/**
 * Staging isolation: block only old MDRC/LIS production endpoints.
 * Payments, SMS, Maps, captcha, and other required third-party APIs stay enabled.
 */
if (!defined('MDRC_LIS_PRODUCTION_BLOCKED')) {
	define('MDRC_LIS_PRODUCTION_BLOCKED', true);
}

if (!function_exists('mdrc_lis_production_blocked')) {
	function mdrc_lis_production_blocked()
	{
		return defined('MDRC_LIS_PRODUCTION_BLOCKED') && MDRC_LIS_PRODUCTION_BLOCKED;
	}
}

/** @deprecated Use mdrc_lis_production_blocked() */
if (!function_exists('mdrc_external_api_removed')) {
	function mdrc_external_api_removed()
	{
		return mdrc_lis_production_blocked();
	}
}

if (!function_exists('mdrc_staging_disabled_message')) {
	function mdrc_staging_disabled_message()
	{
		return 'External integration disabled on staging.';
	}
}

if (!function_exists('mdrc_is_blocked_external_url')) {
	function mdrc_is_blocked_external_url($url)
	{
		$url = (string) $url;
		if ($url === '') {
			return false;
		}
		$hosts = array(
			'lis6.mdrcindia.com',
			'182.156.200.228',
			'3.109.103.148',
			'crm.mdrcindia.com',
			'crm.mdrcindia.net',
			'api-in21.leadsquared.com',
			'files-in21.leadsquared.com',
		);
		foreach ($hosts as $host) {
			if (stripos($url, $host) !== false) {
				return true;
			}
		}
		if (preg_match('#(^|/)(BookingAPI|HomeAPI|PatientLabReport|TestStatusAPI|LeadManagement|Lead\.Capture)#i', $url)) {
			return true;
		}
		return false;
	}
}

if (!function_exists('mdrc_curl_exec')) {
	function mdrc_curl_exec($ch)
	{
		if (mdrc_lis_production_blocked() && $ch) {
			$info = curl_getinfo($ch);
			$url = '';
			if (is_array($info) && !empty($info['url'])) {
				$url = (string) $info['url'];
			}
			if ($url === '') {
				$url = (string) curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
			}
			if (mdrc_is_blocked_external_url($url)) {
				return false;
			}
		}
		return curl_exec($ch);
	}
}
