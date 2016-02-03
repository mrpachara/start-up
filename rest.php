<?php
	define('REST', true);

	require_once 'global.inc.php';
	require_once "include/rest.php";
	require_once "include/config.php";
	require_once "{$conf['rest']['path']}oauth2/service/serviceconfigurated.php";
	//require_once "include/resttoken.php";
	require_once "include/grantservice.php";

	ini_set('display_errors', 0);

	header("Access-Control-Allow-Origin: *");

	//$GLOBALS['_resttoken'] = new \sys\RestToken($conf, $GLOBALS['_pdoconfigurated'], new \sys\SystemUserService($GLOBALS['_pdoconfigurated']));
	$GLOBALS['_grantservice'] = new \sys\GrantService($conf['authoz'], $GLOBALS['_oauth2server']);

	function rest_error($errno, $errstr, $errfile, $errline){
		\sys\Rest::response(array(
			 'errors' => array(
				new Exception($errfile.':'.$errline.':'.$errstr, $errno)
			)
		), null, 500, "Internal Server Error");
	}

	function shutdown_handler(){
		if(($error = error_get_last()) && (($error['type'] & (E_ERROR | E_WARNING | E_PARSE | E_NOTICE)) > 0)){
			rest_error(-1, $error['message'], $error['file'], $error['line']);
		}
		//if($error) echo $error['type'];
	}

	set_error_handler('rest_error');

	register_shutdown_function('shutdown_handler');

	$GLOBALS['_rest'] = new \sys\Rest();

	//if($GLOBALS['_rest']->getService() != 'view') sleep(1);
	//sleep(1);

	if(($GLOBALS['_rest']->getModule() != null) && (file_exists($conf['rest']['path'].$GLOBALS['_rest']->getModule()."/rest.php"))){
		require_once $conf['rest']['path'].$GLOBALS['_rest']->getModule()."/rest.php";
	} else{
		$GLOBALS['_rest']->response(array(
			 'errors' => array(
				  new Exception('module: '.$GLOBALS['_rest']->getModule()." not found", 400)
			)
		), null, 400, 'module: '.$GLOBALS['_rest']->getModule()." not found");
	}
?>
