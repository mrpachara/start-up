<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<article class="md-content md-padding">
	<md-backdrop ng-if="$comp.progress.count()" class="md-sidenav-backdrop md-opaque md-default-theme md-sidenav-backdrop-custom disabled"></md-backdrop>
	<form name="itemForm" ng-submit="$comp.submit()">
		<fieldset ng-init="$comp.setForm(itemForm)" ng-disabled="$comp.progress.count()">
			<div layout="column">
				<div layout="column" layout-gt-sm="row">
					<md-input-container ng-style="($comp.$mdMedia('gt-sm'))? {'width': '15rem'} : {} ">
						<label>Code</label>
						<input type="text" name="code" ng-model="$comp.self.code" required />
						<div ng-messages="itemForm.code.$error">
							<div ng-message="required">Required</div>
						</div>
					</md-input-container>
					<md-input-container flex-gt-sm>
						<label>Name</label>
						<input type="text" name="name" ng-model="$comp.self.name" required />
						<div ng-messages="itemForm.name.$error">
							<div ng-message="required">Required</div>
						</div>
					</md-input-container>
				</div>
				<div layout="column">
					<md-input-container>
						<label>Data</label>
						<textarea name="data" ng-model="$comp.self.$data" required style="font-family: monospace;"></textarea>
					</md-input-container>
				</div>
			</div>
			<div layout="row">
				<md-button type="submit" class="md-primary">
					<md-icon md-svg-icon="content:ic-save"></md-icon>
					<span>Save</span>
				</md-button>
				<span flex></span>
				<md-button type="button" class="md-accent" ng-click="$comp.changeMode('View')">
					<md-icon md-svg-icon="navigation:ic-cancel"></md-icon>
					<span>Cancel</span>
				</md-button>
			</div>
		</fieldset>
	</form>
</article>
