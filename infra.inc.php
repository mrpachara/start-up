<?php
	$conf  = [];

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

	$conf['authoz'] = [
		'default' => 'ALL',
		'superusername' => 'root',
		'superuserrole' => 'ROOT',
		'forbidden_code' => 403,
		'forbidden_message' => 'Forbidden',
		'rolenames' => [
			'ADMIN' => 'Administrator',
			'MANAGER' => 'Manager',
			'STAFF' => 'Staff',
			'USER' => 'User',
			'EDUSERVICES_MANAGER' => 'Eduservices Manager',
			'EDUSERVICES_STAFF' => 'Eduservices Staff',
			'PUBLIC' => 'Public Data Accessible',
		],
		'specialroles' => ['ADMIN'],
	];

	$conf['rest'] = [
		'path' => 'rest-modules/',
		'base' => 'rest/',
		'cookiename' => 'RESTTOKEN',
	];

	$conf['generator'] = [];
	$conf['generator']['length'] = 4;
	$conf['generator']['seperator'] = '-';
?>
