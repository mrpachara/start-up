<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<main ng-outlet class="app-cp-content app-ly-scroll md-content md-padding" layout="column" layout-align="center center" flex style="height: 100%;"></main>
