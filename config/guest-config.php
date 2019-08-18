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

function getAllResultData($key)
{
    global $conn,$antiXss;

    $keys = $antiXss->xss_clean($key);
    $result = mysqli_query($conn,"SELECT id FROM upload_data WHERE kategori LIKE '%$keys%'");
	return mysqli_num_rows($result);
}

function addReq($data)
{
    global $conn,$antiXss;

    $reqtitle = $antiXss->xss_clean($data["reqtitle"]);
    $unitkerja = $antiXss->xss_clean($data["unitkerja"]);
    $name = $antiXss->xss_clean($data["name"]);
    $tujuan = $antiXss->xss_clean($data["tujuan"]);
    $awal = $antiXss->xss_clean($data["awal"]);
    $akhir = $antiXss->xss_clean($data["akhir"]);
    $priority = $antiXss->xss_clean($data["priority"]);

    // tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO `request` VALUES (NULL,'$reqtitle', '$unitkerja', '$name', '$tujuan', '$awal', '$akhir', '$priority')");

	return mysqli_affected_rows($conn);
}

function sendChat($data)
{
    global $conn,$antiXss;

    $id = $antiXss->xss_clean($data["id"]); //id user
    $qnaproduk = $antiXss->xss_clean($data["qnaproduk"]); //produk
    $ask = $antiXss->xss_clean($data["ask"]); //ask

    $check = mysqli_query($conn, "SELECT * FROM qna WHERE produk_id = '$qnaproduk' AND quest LIKE '%$ask%' AND answer IS NOT NULL");
    if (mysqli_num_rows($check) > 0) {
      return $check;
    } else {
      mysqli_query($conn, "INSERT INTO `qna` VALUES (NULL,'$id','$qnaproduk', '$ask', NULL, NULL,current_timestamp())");
      return 0;
    }
}

function allAsking()
{
    global $conn;
    $result = mysqli_query($conn,"SELECT * FROM qna WHERE");
    $rows = [];

	while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }

    return $rows;
}
