<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<article>
	<md-toolbar>
		<h1 class="md-toolbar-tools" layout-align="center center">
			<span style="white-space: nowrap;">Login Form</span>
		</h1>
		<md-progress-linear id="app-cp-progress-loading" md-mode="indeterminate" class="md-accent" ng-style="(vm.isProgressing())? {'visibility': 'visible'} : {'visibility': 'hidden'}"></md-progress-linear>
	</md-toolbar>
	<form name="loginForm" ng-submit="vm.submit()" class="app-cl-layout">
		<fieldset ng-disabled="vm.isProgressing()" class="app-cl-layout">
			<div layout="column" layout-align="center center">
				<md-input-container>
					<label>Username</label>
					<input type="text" name="username" required ng-model="vm.model.username" />
					<div ng-messages="loginForm.username.$error">
						<div ng-message="required">Required!</div>
					</div>
				</md-input-container>
				<md-input-container>
					<label>Password</label>
					<input type="password" name="password" required ng-model="vm.model.password" />
					<div ng-messages="loginForm.password.$error">
						<div ng-message="required">Required!</div>
					</div>
				</md-input-container>
				<md-button type="submit" class="md-primary">
					<md-icon md-svg-icon="action:ic-exit-to-app" alt="sign in"></md-icon>
					<span>Sign-in</span>
				</md-button>
			</div>
		</fieldset>
	</form>
</article>
