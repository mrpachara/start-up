<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<article class="md-content md-padding">
	<div layout="row">
		<util-links-action ctrl="$comp" ng-include="$comp.template('view-action.html')"></util-links-action>
		<div flex></div>
		<md-button type="button" ng-click="$comp.back($event)">
			<md-icon md-svg-icon="navigation:ic-chevron-left"></md-icon>
			<span>Back</span>
		</md-button>
	</div>
	<form name="itemForm">
		<fieldset>
			<div layout="column">
				<div layout="column" layout-gt-sm="row">
					<md-input-container ng-style="($comp.$mdMedia('gt-sm'))? {'width': '15rem'} : {} ">
						<label>Code</label>
						<input type="text" name="code" ng-model="$comp.self.code" readonly />
					</md-input-container>
					<md-input-container flex-gt-sm>
						<label>Name</label>
						<input type="text" name="name" ng-model="$comp.self.name" readonly />
					</md-input-container>
				</div>
				<div layout="column">
					<md-input-container>
						<label>Data</label>
						<textarea name="data" readonly ng-model="$comp.self.$data" style="font-family: monospace;"></textarea>
					</md-input-container>
				</div>
			</div>
		</fieldset>
	</form>
</article>
