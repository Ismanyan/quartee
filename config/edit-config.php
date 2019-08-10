<?php 
require 'config.php';
use voku\helper\AntiXSS;
require_once '../vendor/anti-xss/autoload.php';
$antiXss = new AntiXSS();

$id = $antiXss->xss_clean($_GET['id']);
$query = "SELECT * FROM users WHERE id =$id";
$datas = query($query)[0];
echo json_encode($datas);
?>