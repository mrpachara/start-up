<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	$GLOBALS['_grantservice']->authozExcp();

	$request = \OAuth2\Request::createFromGlobals();
	$response = new \OAuth2\Response();

	$data = false;

	if($GLOBALS['_oauth2server']->verifyResourceRequest($request, $response)){
		$accessToken = $GLOBALS['_oauth2server']->getAccessTokenData($request);

		$jwtAccessTokenObj = new \OAuth2\ResponseType\JwtAccessToken($GLOBALS['_oauth2storage']);
		//$client_id, $user_id, $scope = null, $includeRefreshToken = true
		$jwtAccessToken = $jwtAccessTokenObj->createAccessToken(
			  $accessToken['client_id']
			, $accessToken['user_id']
			, $accessToken['scope']
			, false
		);
		$data = $jwtAccessToken;
	} else{
		$response->send();
		exit();
	}
?>
