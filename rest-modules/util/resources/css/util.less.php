<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
.util-layout{
	display: block;
	margin: 0px;
	padding: 0px;
	box-sizing: border-box;
}

util-search {
	.util-layout;

	input[name="term"]{
		color: rgba(255,255,255,0.87);
		background-color: transparent;

		border: none;
		border-bottom: 1px solid rgba(255,255,255,0.87);
		outline: none;
	}
}

util-menu {
	.util-layout;

	ul {
		.util-layout;

		list-style: none;
	}

	util-menu-item {
		.util-layout;

		button {
			width: 100%;
			margin: 0px !important;

			border-radius: 0px !important;
		}
	}
}
