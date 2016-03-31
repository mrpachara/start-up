<?php
	if(!defined("APPPATH")){
		header("HTTP/1.1 404 Not Found");
		exit;
	}

	define("BASEPATH", dirname(APPPATH).'/');

	//header("Content-Type: text/plain; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<meta charset="UTF-8" />
		<meta http-equiv="Content-Language" content="en_US, th_TH" />
		<title><?= htmlspecialchars($conf['app']['name']) ?> Application</title>

		<base href="<?= htmlspecialchars(APPPATH.'/') ?>" />

		<link rel="icon" type="image/png" href="../favicon.png" />

		<link rel="stylesheet/less" type="text/css" href="<?= htmlspecialchars(BASEPATH) ?>css/less/app.less" />
		<link rel="stylesheet/less" type="text/css" href="<?= htmlspecialchars(BASEPATH) ?>css/less/app-fixed.less" />

		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>rest/util/bower_components/less/dist/less.js" data-env="development" data-async="true"></script>
		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>rest/util/bower_components/jquery/dist/jquery.js"></script>

		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>rest/util/bower_components/angular/angular.js" data-module-id="ng"></script>

		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>rest/util/bower_components/link-driven/angular-core.js" data-module-id="ldrvn"></script>
		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>rest/util/bower_components/link-driven/angular-service.js" data-module-id="ldrvn.service"></script>

		<script type="application/javascript">
(function(){
	var RESOURCEBASE = <?= json_encode(BASEPATH) ?>;
	var APPCONFIGFILE = RESOURCEBASE  +  <?= json_encode($infra['rest']['base'].$conf['app']['context'].'/configuration') ?>;
	var APPNAME = <?= json_encode($conf['app']['name']) ?>;

	var appConfig = angular.module('app.config', []).constant('config', {
		'appName': APPNAME,
		'configURI': APPCONFIGFILE,
	});
})();
		</script>

		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/app-bootstrap.js"></script>
	</head>
	<body>
		<div id="app-cp-loading" class="app-ly-app" style="height: 100%;">
			<style type="text/css" scoped="scoped" style="display: none !important;">
#app-cp-loading {
	display: -webkit-flex;
	display: -ms-flex;
	display: -o-flex;
	display: flex;

	-webkit-flex-direction: column;
	-ms-flex-direction: column;
	-o-flex-direction: column;
	flex-direction: column;

	-webkit-align-items: center;
	-ms-align-items: center;
	-o-align-items: center;
	align-items: center;

	-webkit-justify-content: space-around;
	-ms-justify-content: space-around;
	-o-justify-content: space-around;
	justify-content: space-around;
}
			</style>
			<div>
<?php include "loading3.php" ?>
				<div style="height: 0px;">
					<div style="font-size: large; font-weight: bold; margin-top: 1em;">Loading...</div>
				</div>
			</div>
		</div>
	</body>
</html>
