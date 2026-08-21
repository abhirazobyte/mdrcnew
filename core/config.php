<?php
	/*===== Do PHP Version check. We need at least PHP 5.0.0 ========= */
	if (version_compare(PHP_VERSION, '5.0.0', '<'))
	{
		trigger_error("This system requires PHP 5.0.0 or above to work. <br/>You have PHP ".PHP_VERSION." in this system", E_USER_ERROR);
	}
	/*=================================================================*/

	define("__CONFIG__","1");
	/*================= Dont touch here ====================*/
	date_default_timezone_set("Asia/Kolkata");
	
	ini_set("date.timezone", "UTC");
	ini_set("display_errors", "off");
	error_reporting(E_ALL);
	/*=======================================================*/

	/*==================== Absolute path ====================*/
	define("ABS_PATH","/home/mdrcindia.com/html");
	/*=======================================================*/

	/*=============== Debug leve (1 to 4) ===================*/
	if(!defined("DEBUG"))
	{
		define("DEBUG",3);
	}
	define("DISPLAY_XPM4_ERRORS", true);
	if(!defined("ERROR_LOG"))
	{
		define("ERROR_LOG", ABS_PATH."logs/error_log.txt");
	}
	/*=======================================================*/

	/*======= Cache directory (to store cached files) =======*/
	if(!defined("CACHE_DIR"))
	{
		define("CACHE_DIR", ABS_PATH."cache");
	}
	/*=======================================================*/

	/*============= Cache time in seconds  ==================*/
	if(!defined("CACHE_TIME"))
	{
		define("CACHE_TIME", 60);
	}
	define("API_URL", "http://3.109.103.148/");
	define("LIS_API_URL", "https://lis6.mdrcindia.com/mdrcnew/api"); 

	define("CRM_URL", "http://crm.mdrcindia.com:8069"); 
	define("CRM_DB", "MDRC"); 
	define("CRM_EMAIL", "leadscrm@mdrcindia.com"); 
	define("CRM_PASSWORD", "Crm@infonoble363"); 
	
	/*=======================================================*/

	/*================= DB Connection Info ==================*/
	define("DB_HOST","localhost");
	if(isset($_SESSION['admin']) && $_SESSION['admin']==5)
	{
		define("DB_DATABASE","mdrcindia_db_test");
		define("DB_USERNAME","mdrcindia_test");
		define("DB_PASSWORD","MdrcTest@2026#Secure");	
	}
	else
	{
		define("DB_DATABASE","mdrcindia_db_test");
		define("DB_USERNAME","mdrcindia_test");
		define("DB_PASSWORD","MdrcTest@2026#Secure");
	}
	


	/*=======================================================*/

	define("PROJECT_TILLE","MDRC");
	define("FOOTER_COPY_RIGHT_PROJECT","www.mdrc.com");
	define("PROJECT_CITY","");
	define("PROJECT_STATE","");

	/*==========Default paramters for paging ================*/
	define("RECORD_PER_PAGE",15);
	define("SEGMENT_LENGTH",5);
	define("p_name_limit",50);
	/*=======================================================*/

	/*============== Default Meta Tags ======================*/
	define("DEFAULT_TITLE","MDRC");
	define("DEFAULT_KEYWORDS","MDRC");
	define("DEFAULT_DESCRIPTION","MDRC");
	/*=======================================================*/

	function isMobile() {
		return preg_match("/(android|iphone|ipad|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
	
	/*=============== Relative to ABS_PATH path ============*/
	if(!defined("VIR_DIR"))
	{
		if(isMobile()) {
			define("VIR_DIR","m/");
		}
		else {
			define("VIR_DIR","");
		}
	}
	/*=======================================================*/

	/*==== Access URL or Server Root of the application =====*/
	//define("SERVER_ROOT","https://".$_SERVER['SERVER_NAME'].'');
	define("SERVER_ROOT","https://server.razobyte.com");
	define("M_SERVER_ROOT","https://server.razobyte.com");
	/*=======================================================*/

	/*=== FTP Information - Needed for fileupload process ===*/
	if(!defined("USE_FTP"))
	{
		define("USE_FTP", false);
	}
	if(!defined("FTP_HOST"))
	{
		define("FTP_HOST", "localhost");
	}
	if(!defined("FTP_USERNAME"))
	{
		define("FTP_USERNAME", "");
	}
	if(!defined("FTP_PASSWORD"))
	{
		define("FTP_PASSWORD", "");
	}
	if(!defined("FTP_WWWDIR"))
	{
		define("FTP_WWWDIR", "");
	}
	/*=======================================================*/

	/*============== mail template storage path =============*/
	define("MAIL_TEMPLATE_PATH", "mail_templates");
	/*=======================================================*/

	/*== Automatically TRIP Post Variables in MySQL Query ===*/
	define("AUTO_TRIM", true);
	/*=======================================================*/

	/*================ Ccavenue Payment Getway ==============*/
	define("CCA_MERCHANT_ID", "381290");
	define("CCA_ACCESS_CODE", "AVWU07ID80BT16UWTB");
	define("CCA_WORKING_KEY", "636CC2C22573FA93F70D751324881CB1");
	define("CCA_RETURN_URL", "https://www.mdrcindia.com/payment-process");
	define("CCA_CANCEL_URL", "https://www.mdrcindia.com/payment-process");
	define("M_CCA_RETURN_URL", "https://www.mdrcindia.com/payment-process");
	define("M_CCA_CANCEL_URL", "https://www.mdrcindia.com/payment-process");
	define("CCA_URL", "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction");
	/*=======================================================*/


	/*=======================================================*/
    /*================= Mail server settings ================*/

    if(!defined("SMTPDIRECT")){
            define("SMTPDIRECT", "0");
    }
    if(!defined("SMTPHOST")){
            //define("SMTPHOST", "smtp.zoho.in");
			define("SMTPHOST", "smtp-relay.brevo.com");
    }
    if(!defined("SMTPPORT")){
            //define("SMTPPORT", "465");
			define("SMTPPORT", "465");
    }
    //SMTP Connection encryption type. Possible values are: tls, ssl, sslv2 or sslv3
    if(!defined("SMTPSECURITY")){
            define("SMTPSECURITY", "ssl");
    }
    if(!defined("SMTPUSER")){
            define("SMTPUSER", "795eda002@smtp-brevo.com");
    }
    if(!defined("SMTPPASS")){
            define("SMTPPASS", "wyF2jKB1Jz7OCpTQ");
    }
    if(!defined("FROM_EMAIL")){
            define("FROM_EMAIL", "no-reply@mdrcindia.com");
    }
    if(!defined("FROM_NAME")){
            define("FROM_NAME", "MDRC India");
    }
    if(!defined("ENC_KEY")){
            //define("ENC_KEY", "1234567890123456");
			define("ENC_KEY", "1234567890123456");
    }
	define("CRM_ACCESS_ID", 'u$rc2f00ef6fe1d0fb266468766c80938f6');
	define("CRM_SECRET_KEY", "25ebf5a0fce5340a762c92064065b41cdfb35e41");

	/** Frappe method URL: no API secrets in query string—only path. Auth: Authorization: token api_key:api_secret */
	define("FRAPPE_WEBSITE_ENQUIRY_URL", "https://crm.mdrcindia.net/api/method/crm.integrations.website.webhooks.ingest_website_enquiry");
	// Legacy: shared secret (body field auth_token or e.g. ?auth_token=) — not used; keep commented if you need to re-enable
	// define("FRAPPE_WEBSITE_ENQUIRY_AUTH_TOKEN", "FXBTaq5oHv7dzJKC6Wfig2xOxwMpoDxw7mOQEj");
	/** Frappe user API key + secret (User → API Access). Sent as: Authorization: token key:secret */
	define("FRAPPE_WEBSITE_INTEGRATION_API_KEY", "2236b2f73d1cb2b");
	define("FRAPPE_WEBSITE_INTEGRATION_API_SECRET", "a7a99e414903e5d");
	/** Sent to Frappe as form field "source" for routing / reporting */
	define("FRAPPE_ENQUIRY_SOURCE_TEST_BOOKING", "test_booking_enquiry");
	define("FRAPPE_ENQUIRY_SOURCE_COLLECTION", "collection_appointment");
	define("FRAPPE_ENQUIRY_SOURCE_CORPORATE", "corporate_tieup_enquiry");

	define("RAZOR_PAY_KEY", 'rzp_live_SXp7NrguqIFLLC');
	define("RAZOR_PAY_SECRET", "bACqM1TrjZpTx8xAOkcTiAMX");

    /*=======================================================*/


	/*================= Mail server settings ================*/
	// if(!defined("SMTPDIRECT"))
	// {
	// 	define("SMTPDIRECT", "0");
	// }
	// if(!defined("SMTPHOST"))
	// {
	// 	define("SMTPHOST", "");
	// }
	// if(!defined("SMTPPORT"))
	// {
	// 	define("SMTPPORT", "");
	// }
	//SMTP Connection encryption type. Possible values are: tls, ssl, sslv2 or sslv3
	// if(!defined("SMTPSECURITY"))
	// {
	// 	define("SMTPSECURITY", "");
	// }
	// if(!defined("SMTPUSER"))
	// {
	// 	define("SMTPUSER", "");
	// }
	// if(!defined("SMTPPASS"))
	// {
	// 	define("SMTPPASS", "");
	// }
	// if(!defined("FROM_EMAIL"))
	// {
	// 	define("FROM_EMAIL", "info@mdrc.com");
	// }
	// if(!defined("FROM_NAME"))
	// {
	// 	define("FROM_NAME", "MDRC");
	// }
	/*=======================================================*/
?>
