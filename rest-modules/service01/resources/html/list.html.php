<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<article>
	<md-list class="md-dense">
		<md-list-item ng-repeat-start="item in $comp.self" class="md-3-line"
			ng-click="$comp.view(item.id)">
			<md-icon md-svg-icon="action:ic-print"></md-icon>
			<div class="md-list-item-text">
				<h3>{{ item.code }}</h3>
				<h4>{{ item.name }}</h4>
				<util-links-action ctrl="$comp" class="md-secondary" ng-click aria-label="More Action"
					ng-include="$comp.$ae.service('template', 'list-more-action.html')"></util-links-action>
			</div>
		</md-list-item>
		<md-divider ng-repeat-end></md-divider>
	</md-list>
</article>
