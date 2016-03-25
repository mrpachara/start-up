<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<div layout="row" flex class="app-ly-app" style="height: 100%;">
	<md-sidenav md-component-id="app-cp-side-nav" md-is-locked-open="app.$mdMedia('gt-md')"
		class="md-sidenav-left md-whiteframe-z2" layout="column">
		<!-- ng-controller="SidenavController as sidenav" -->
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
			<!--
			<md-content id="app-ly-container-navigation" flex layout="column">
				<nav id="app-cp-navigation" ng-controller="NavController as nav" ng-click="sidenav.service.close()">
					<div ng-repeat="section in nav.getSections()">
						<app-menu-nav menus="section.menus"></app-menu-nav>
						<md-divider ng-if="!$last"></md-divider>
					</div>
				</nav>
			</md-content>
			-->
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
				<h2>
					<span>Module</span>
				</h2>
				<div layout="row" flex>
					<form method="get" id="app-cp-search-box" ng-if="toolbar.search.enabled()" ng-submit="toolbar.doSearch($event)" layout="row" layout-align="end center" flex>
							<md-button type="button" class="md-icon-button" aria-label="show search" ng-click="toolbar.showSearch($event)">
								<md-icon md-svg-icon="action:ic-search" alt="search"></md-icon>
							</md-button>
							<div class="app-cp-search-box-search" layout="row" flex>
								<input type="search" name="searchTerm" aria-label="search input" ng-model="toolbar.model.searchTerm" flex />
								<md-button type="button" class="md-icon-button" ng-click="toolbar.clearSearch($event)" aria-label="clear search">
									<md-icon md-svg-icon="content:ic-clear" alt="clear"></md-icon>
								</md-button>
							</div>
					</form>
				</div>
				<md-menu>
					<md-button type="button" class="md-icon-button" aria-label="more action" ng-click="$mdOpenMenu()">
						<md-icon md-menu-origin md-svg-icon="navigation:ic-more-vert" alt="more vertical"></md-icon>
					</md-button>
					<md-menu-content width="4" style="padding-top: 0px;">
						<md-menu-item>
							<div layout="row" layout-align="start center" style="padding-right: 8px;">
								<span>Command</span>
								<span flex></span>
								<md-icon md-menu-align-target md-svg-icon="navigation:ic-more-vert" alt="more action"></md-icon>
							</div>
						</md-menu-item>
						<md-menu-divider style="margin-top: 0px;"></md-menu-divider>
						<md-menu-item>
							<md-button type="button" aria-label="show log" ng-click="app.utilService.showLog($event)">
								<md-icon md-svg-icon="action:ic-info-outline" alt="show log"></md-icon>
								<span>Display logs</span>
							</md-button>
						</md-menu-item>
					</md-menu-content>
				</md-menu>
			</header>
			<!-- ng-class="{'app-st-active': toolbar.appProgress.loading}" -->
			<md-progress-linear id="app-cp-progress-loading" md-mode="indeterminate" ng-show="toolbar.appProgress.isLoading()" class="md-accent"></md-progress-linear>
		</md-toolbar>
		<md-content id="app-ly-container-content" layout="column" flex>
			<!-- ng-controller="ContentController as content" -->
			<main class="app-cp-content md-content md-padding" layout="column" flex>
				<div ng-viewport layout="column" flex></div>
			</main>
		</md-content>
	</div>
</div>
