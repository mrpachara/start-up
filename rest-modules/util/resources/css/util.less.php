<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
.util-cp-search-box{
	input[name="term"]{
		color: rgba(255,255,255,0.87);
		background-color: transparent;

		border: none;
		border-bottom: 1px solid rgba(255,255,255,0.87);
		outline: none;
	}
}
