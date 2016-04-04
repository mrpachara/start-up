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
				<md-menu class="md-secondary" ng-click aria-label="More Action">
					<md-icon md-menu-origin md-svg-icon="navigation:ic-more-vert" ng-click="$mdOpenMenu($event)" alt="more action"></md-icon>
					<md-menu-content width="4">
						<md-menu-item>
							<h4 layout="row" layout-align="start center" style="padding-right: 0px;">
								<span flex>More Action</span>
								<md-icon md-menu-align-target md-svg-icon="navigation:ic-more-vert" alt="more action"
									style="margin-right: 0px;"></md-icon>
							</h4>
						</md-menu-item>
						<md-menu-divider></md-menu-divider>
						<md-menu-item>
							<md-button type="button">
								<span>action 01</span>
							</md-button>
						</md-menu-item>
						<md-menu-item>
							<md-button type="button">
								<span>action 02</span>
							</md-button>
						</md-menu-item>
					</md-menu-content>
				</md-menu>
			</div>
		</md-list-item>
		<md-divider ng-repeat-end></md-divider>
	</md-list>
</article>
