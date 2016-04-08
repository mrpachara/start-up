<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<md-dialog style="min-width: 80%;" aria-label="{{ $dialog.name }} Dialog">
	<md-toolbar>
		<div class="md-toolbar-tools">
			<h2>{{ $dialog.name }}</h2>
		</div>
	</md-toolbar>
	<!--
	<md-dialog-content>{{ $dialog.contentUrl }}</md-dialog-content>
	-->
	<md-dialog-content ng-include="$dialog.contentUrl"></md-dialog-content>
	<md-dialog-actions>
		<md-button ng-click="$dialog.$mdDialog.hide()" class="md-primary">Close</md-button>
	</md-dialog-actions>
</md-dialog>
