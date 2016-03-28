<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
sleep(3);
	header("Content-Type: application/json; charset=utf-8");
?>
{
	"name": "My Test",
	"action": null,
	"items": [
		{
			"name": "Action 01",
			"action": "xxx"
		},
		{
			"name": "Action 02",
			"action": "xxx"
		},
		{
			"name": "Menu 01",
			"action": "xxx",
			"items": [
				{
					"name": "Sub-Menu 01",
					"action": "xxx"
				},
				{
					"name": "Sub-Menu 02",
					"action": "xxx"
				},
				{
					"name": "Sub-Menu 03",
					"action": "xxx"
				}
			]
		},
		{
			"name": "Menu 02",
			"action": "xxx",
			"items": [
				{
					"name": "Sub-Menu 01",
					"action": "xxx"
				},
				{
					"name": "Sub-Menu 02",
					"action": "xxx"
				},
				{
					"name": "Sub-Menu 03",
					"action": "xxx"
				}
			]
		}
	]
}
