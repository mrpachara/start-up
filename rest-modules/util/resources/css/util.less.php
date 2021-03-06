<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
._p(@prop, @value) {
	-webkit-@{prop}: @value;
	-ms-@{prop}: @value;
	-o-@{prop}: @value;
	@{prop}: @value;
}

._v(@prop, @value) {
	@{prop}: ~"-webkit-@{value}";
	@{prop}: ~"-ms-@{value}";
	@{prop}: ~"-o-@{value}";
	@{prop}: @value;
}

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

		width: 100%;
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

			.util-menu-toggle-icon.util-menu-toggle-expand {
				._p(transition, all @util-menu-time ease);
				._p(transform, rotateX(0.5turn));
			}
		}
	}
}

@util-menu-time: 0.25s;
util-menu {
	overflow: hidden;

	&.ng-hide-add,
	&.ng-hide-remove {
		._p(transition, all @util-menu-time ease);

		&>* {
			._p(transition, margin-top @util-menu-time ease);
		}

	}

	&.ng-hide-add.ng-hide-add-active,
	&.ng-hide-remove:not(.ng-hide-remove-active) {
		&>* {
			/*must specific in script to determime outter-height*/
			/*margin-top: -100%;*/
			/*margin-top: -attr(menu-height px);*/
		}
	}
}
