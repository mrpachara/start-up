<?php
	error_reporting(E_ALL);

	require_once 'BASEPATH.php';

	require_once 'config.inc.php';

	require_once 'include/pdoconfigurated.php';
	require_once 'include/dataservice.php';
	require_once 'include/systemuser.php';
	require_once 'include/generatorservice.php';

	$GLOBALS['_pdoconfigurated'] = new \sys\PDOConfigurated($conf['db']);
	$GLOBALS['_tokenpdoconfigurated'] = new \sys\PDOConfigurated($conf['db']);
?>
