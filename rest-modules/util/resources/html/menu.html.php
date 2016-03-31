<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<ul>
	<style type="text/css">
util-menu#{{ menu.id }}.ng-hide-add.ng-hide-add-active>*,
util-menu#{{ menu.id }}.ng-hide-remove:not(.ng-hide-remove-active)>* {
	margin-top: -{{ menu.menuHeight() }}px;
}
	</style>
	<li ng-repeat="item in menu.item().items">
		<util-menu-item data="item" index="$index"></util-menu-item>
	</li>
</ul>
