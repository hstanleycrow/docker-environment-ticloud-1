<?php
	if(!isset($debug))
		$debug = false;
	if($debug):
		error_reporting(E_ALL ^ E_WARNING);
		ini_set('display_errors', '1');
	endif;
	if(!$debug):
		error_reporting(0);
		ini_set('display_errors', '0');
	endif;
