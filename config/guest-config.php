<?php 

require 'db.php';

use voku\helper\AntiXSS;
require_once 'anti-xss/autoload.php';
$antiXss = new AntiXSS();

function getAllProduk()
{
    global $conn;
    $result = mysqli_query($conn,"SELECT name_produk FROM produk");
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
	}
    return $rows;
}


function getAllKategori()
{
    global $conn;
    $result = mysqli_query($conn,"SELECT kategori_name FROM kategori");
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
	}
    return $rows;
}
