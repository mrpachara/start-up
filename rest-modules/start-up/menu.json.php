<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
//sleep(1);
	header("Content-Type: application/json; charset=utf-8");
?>
{
	"name": "My Test",
	"action": null,
	"items": [
		{
			"name": "Home",
			"action": ["Home"]
		},
		{
			"name": "Data 01",
			"action": ["Service01", "Data01", "List"]
		},
		{
			"name": "Menu 01",
			"action": "toggle",
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
			"action": "toggle",
			"items": [
				{
					"name": "Sub-Menu 01",
					"action": "xxx"
				},
				{
					"name": "Sub-Menu 02",
					"action": "toggle",
					"items": [
						{
							"name": "Sub-Menu 02.01",
							"action": "xxx"
						},
						{
							"name": "Sub-Menu 02.02",
							"action": "xxx"
						},
						{
							"name": "Sub-Menu 02.03",
							"action": "xxx"
						}
					]
				},
				{
					"name": "Sub-Menu 03",
					"action": "xxx"
				}
			]
		},
		{
			"name": "Menu 03",
			"action": "toggle",
			"items": [
				{
					"name": "Sub-Menu 01",
					"action": "xxx"
				},
				{
					"name": "Sub-Menu 02",
					"action": "toggle",
					"items": [
						{
							"name": "Sub-Menu 02.01",
							"action": "xxx"
						},
						{
							"name": "Sub-Menu 02.02",
							"action": "xxx"
						},
						{
							"name": "Sub-Menu 02.03",
							"action": "xxx"
						}
					]
				},
				{
					"name": "Sub-Menu 03",
					"action": "xxx"
				}
			]
		}
	]
}
