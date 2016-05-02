<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<div style="position: fixed; right: 0px; bottom: 0px;">
	<md-button ng-if="$action.items.length === 1"
		ng-init="action = $action.items[0]"
		ng-class="action.classes"
		class="md-fab md-fab-bottom-right"
		ng-click="action.execute($event)">
		<md-tooltip md-direction="left" md-visible="tooltipVisible">{{ action.title }}</md-tooltip>
		<md-icon md-svg-icon="{{ action.icon }}" aria-label="{{ action.title }}"></md-icon>
	</md-button>
	<md-fab-speed-dial ng-if="$action.items.length > 1"
		md-direction="up" class="md-scale md-fab-bottom-right">
		<md-fab-trigger>
			<md-button aria-label="menu" class="md-fab md-primary">
				<md-tooltip md-direction="left" md-visible="tooltipVisible">Menu</md-tooltip>
				<md-icon md-svg-icon="navigation:ic-menu" aria-label="menu"></md-icon>
			</md-button>
		</md-fab-trigger>
		<md-fab-actions>
			<div ng-repeat="action in $action.items">
				<md-button aria-label="{{ action.title }}" class="md-fab md-raised md-mini"
					ng-class="action.classes"
					ng-click="action.execute($event)">
					<md-tooltip md-direction="left" md-visible="tooltipVisible" md-autohide="false">{{ action.title }}</md-tooltip>
					<md-icon md-svg-icon="{{ action.icon }}" aria-label="{{ action.title }}"></md-icon>
				</md-button>
			</div>
		</md-fab-actions>
	</md-fab-speed-dial>
</div>
