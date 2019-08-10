<?php 
session_start();

if(!isset($_SESSION["login"]) ) {
	header("Location: public/login");
	exit;
}
if(isset($_SESSION["login"]) ) {
	header("Location: public/home");
	exit;
}