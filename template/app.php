<?php
	if(!defined("APPPATH")){
		header("HTTP/1.1 404 Not Found");
		exit;
	}

	define("BASEPATH", dirname(APPPATH).'/');

	//header("Content-Type: text/plain; charset=UTF-8");

	//var_dump($_SERVER);
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

		<link rel="stylesheet" type="text/css" href="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/angular-material/angular-material.css" />
		<link rel="stylesheet/less" type="text/css" href="<?= htmlspecialchars(BASEPATH) ?>css/less/app.less" />

		<script type="application/javascript">
var RESOURCEBASE = <?= json_encode(BASEPATH) ?>;
var APPCONFIGFILE = RESOURCEBASE  +  <?= json_encode($infra['rest']['base'].$conf['app']['context'].'/configuration') ?>;
		</script>

		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/less/dist/less.js" data-env="development" data-async="true"></script>
		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/jquery/dist/jquery.js"></script>

		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/angular/angular.js"></script>
		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/angular-aria/angular-aria.js"></script>
		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/angular-animate/angular-animate.js"></script>
		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/angular-messages/angular-messages.js"></script>
		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/angular-material/angular-material.js"></script>
		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/node_modules/@angular/router/angular1/angular_1_router.js"></script>

		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/link-driven/angular-core.js"></script>
		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/lib/bower_components/link-driven/angular-service.js"></script>

		<script type="application/javascript" src="<?= htmlspecialchars(BASEPATH) ?>js/app-bootstrap.js"></script>
	</head>
	<body ng-controller="AppController as app">
		<div class="app-ly-app" ng-include="app.layout.url('layout')" style="height: 100%;">
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
		</div>
	</body>
</html>
