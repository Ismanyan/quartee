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

function getAllResultData()
{
    global $conn;
    $result = mysqli_query($conn,"SELECT id FROM upload_data");
	return mysqli_num_rows($result);
}

function addReq($data)
{
    global $conn,$antiXss;

    $reqtitle = $antiXss->xss_clean($data["reqtitle"]);
    $unitkerja = $antiXss->xss_clean($data["unitkerja"]);
    $name = $antiXss->xss_clean($data["name"]);
    $tujuan = $antiXss->xss_clean($data["tujuan"]);
    $priode = $antiXss->xss_clean($data["priode"]);
    $priority = $antiXss->xss_clean($data["priority"]);

    // tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO `request` VALUES (NULL,'$reqtitle', '$unitkerja', '$name', '$tujuan', '$priode', '$priority')");

	return mysqli_affected_rows($conn);
}

function sendChat($data)
{
    global $conn,$antiXss;

    $id = $antiXss->xss_clean($data["id"]);
    $qnaproduk = $antiXss->xss_clean($data["qnaproduk"]);
    $ask = $antiXss->xss_clean($data["ask"]);

    // tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO `qna` VALUES (NULL,'$id','$qnaproduk', '$ask', NULL, NULL)");

	return mysqli_affected_rows($conn);
}

function allAsking()
{
    global $conn;
    $result = mysqli_query($conn,"SELECT * FROM qna");
    $rows = [];
    
	while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    
    return $rows;
}