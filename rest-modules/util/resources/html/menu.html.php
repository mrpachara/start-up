<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<ul>
	<li ng-repeat="item in menu.service.menu().sections">
		<util-menu-item item=""></util-menu-item>
	</li>
</ul>
