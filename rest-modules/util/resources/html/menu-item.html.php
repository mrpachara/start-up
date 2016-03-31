<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<div>
	<md-button type="button" layout="row" layout-align="start center"
		ng-click="menuItem.action($event)"
		ng-style="{'padding-left': (12*(menuItem.depth() - 1) + 6) + 'px'}">
		<span>{{ menuItem.item().name }}</span>
		<span flex></span>
		<md-icon ng-if="menuItem.item().action === 'toggle'" md-svg-icon="navigation:ic-expand-less"
			class="util-menu-toggle-icon" ng-class="{'util-menu-toggle-expand': menuItem.isExpand()}"
			alt="navigation menu"></md-icon>
	</md-button>
	<util-menu ng-attr-id="{{ menuItem.utilMenuCtrl.id + '_' + menuItem.index }}" ng-if="menuItem.item().items" ng-show="menuItem.isExpand()" data="menuItem.item()"></util-menu>
</div>
