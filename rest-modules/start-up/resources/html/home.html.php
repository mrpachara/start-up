<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
<article>
	<md-button type="button" ng-click="$comp.incBoxSize()">
		<span>++</span>
	</md-button>
	<div id="app-mytest">
		<style type="text/css" scoped="scoped">
#app-mytest {
	border: 1px solid black;
	height: {{ $comp.boxSize() }}px;
}
		</style>
		<div>abcd</div>
	</div>
</article>
