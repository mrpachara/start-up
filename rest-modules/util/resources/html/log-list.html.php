<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<md-list class="md-dense" ng-controller="UtilLogListController as log">
	<md-list-item class="md-3-line md-long-text" ng-repeat="item in log.items">
		<md-icon ng-class="{'md-primary': (item.type === 'info'), 'md-warn': (item.type === 'error')}" md-svg-icon="{{ (item.type === 'info')? 'action:ic-info' : 'alert:ic-error' }}"></md-icon>
		<div class="md-list-item-text">
			<h3>{{ item.message }}</h3>
			<h4 class="app-cl-code">{{ item.timestamp|date:'yyyy-MM-dd HH:mm:ss.sss' }}</h4>
			<p style="white-space: pre;">{{ (item.data.error_trace)? item.data.error_trace : (item.data.error_exception)? item.data.error_exception : '&nbsp;' }}</p>
		</div>
		<md-divider></md-divider>
	</md-list-item>
</md-list>
