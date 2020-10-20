<?php
include('connect.php'); //including the database connection

$tpl = 'includes/templates/'; //Template Route
$css = 'layout/css/'; //Css dirctory
$js = 'layout/js/'; //js dirctory
$func = 'includes/functions/'; //function route


include $func . 'funcs.php';
include $tpl . 'header.php';

if(!isset($noNavbar)){
	include $tpl . 'navbar.php';
}
?>