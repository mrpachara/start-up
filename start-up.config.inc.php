<?php
	$conf  = [];

	$conf['app'] = [
		'name' => 'Startup Project',
		'context' => 'start-up',
	];

	$conf['db'] = [
		'dns' => 'pgsql:host=localhost;dbname=erpbase',
		'username' => 'startup',
		'password' => '1234',
		'options' => [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_EMULATE_PREPARES => false,
			//\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
			//\PDO::ATTR_AUTOCOMMIT => false,
			\PDO::ATTR_ORACLE_NULLS => \PDO::NULL_EMPTY_STRING,
			//\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8, time_zone = '+00:00'",
		],
	];

	$conf['rest'] = [
		'path' => 'rest-modules/',
		'base' => 'rest/',
		'cookiename' => 'RESTTOKEN',
	];
?>
