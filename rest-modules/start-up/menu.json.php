<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}

	header("Content-Type: application/json; charset=utf-8");
	ob_start();
?>
{
	"name": "My Test",
	"action": null,
	"sections": [
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
			"sections": [
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
			"sections": [
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
<?php
	$data = ob_get_clean();
?>
