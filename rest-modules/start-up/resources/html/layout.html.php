<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<div ng-if="app.isAuthenticated()" layout="row" flex class="app-ly-app" style="height: 100%;">
	<md-sidenav md-component-id="app-cp-side-nav" md-is-locked-open="app.$mdMedia('gt-md')"
		class="md-sidenav-left md-whiteframe-z2" layout="column">
		<aside id="app-cp-side-nav"
			md-swipe-left="app.$mdSidenav('app-cp-side-nav').close()"
			flex layout="column" class="app-cl-layout">
			<md-toolbar class="md-primary">
				<h1 class="md-toolbar-tools">
					<span style="white-space: nowrap;">{{ app.name() }}</span>
				</h1>
				<!--
				<div ng-controller="UserController as user">
					<app-menu-nav menus="user.getMenus()"></app-menu-nav>
				</div>
				-->
			</md-toolbar>
			<!-- ng-controller="NavController as nav" -->
			<md-content id="app-ly-container-navigation" flex layout="column">
				<nav id="app-cp-navigation" ng-click="$event.originalEvent.commandComplete &amp;&amp; app.$mdSidenav('app-cp-side-nav').close()"
					style="width=100%;">
					<util-menu util-id="app-nav-menu" service="app.$ae"></util-menu>
				</nav>
			</md-content>
		</aside>
	</md-sidenav>
	<div layout="column" flex class="app-cl-layout">
		<!-- ng-controller="ToolbarController as toolbar" -->
		<md-toolbar class="md-primary">
			<header id="app-ly-header" class="md-toolbar-tools">
				<div layout-align="start center" layout="row">
					<md-button ng-show="!app.$mdSidenav('app-cp-side-nav').isLockedOpen()"
						ng-click="app.$mdSidenav('app-cp-side-nav').open()"
						class="md-icon-button" aria-label="show navigation menu">
						<md-icon md-svg-icon="navigation:ic-menu" alt="navigation menu"></md-icon>
					</md-button>
				</div>
				<h2 ng-show="!app.$ae.prop('search-activated')">
					<span>{{ app.$ae.prop('name') }}</span>
				</h2>
				<div layout="row" flex>
					<util-search service="app.utilSearchService" flex></util-search>
				</div>
				<md-menu>
					<md-button type="button" class="md-icon-button" aria-label="more action" ng-click="$mdOpenMenu($event)">
						<md-icon md-menu-origin md-svg-icon="navigation:ic-more-vert" alt="more vertical"></md-icon>
					</md-button>
					<md-menu-content width="4" style="padding-top: 0px;">
						<md-menu-item style="height: 36px; min-height: 36px;">
							<h4 layout="row" layout-align="start center" style="padding-right: 0px;">
								<span>Command</span>
								<span flex></span>
								<md-icon md-menu-align-target md-svg-icon="navigation:ic-more-vert" alt="more action"
									style="margin-right: 0px;"></md-icon>
							</h4>
						</md-menu-item>
						<md-menu-divider style="margin-top: 0px;"></md-menu-divider>
						<md-menu-item>
							<md-button type="button" aria-label="show log" ng-click="app.$ae.cmd('showLog', $event)">
								<md-icon md-svg-icon="action:ic-info-outline" alt="show log"></md-icon>
								<span>Display logs</span>
							</md-button>
						</md-menu-item>
					</md-menu-content>
				</md-menu>
			</header>
			<md-progress-linear id="app-cp-progress-loading" md-mode="indeterminate" ng-show="toolbar.appProgress.isLoading()" class="md-accent"></md-progress-linear>
		</md-toolbar>
		<md-content id="app-ly-container-content" layout="column" flex>
			<main ng-outlet class="app-cp-content"></main>
		</md-content>
	</div>
</div>
