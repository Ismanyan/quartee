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

function getAllResultData($key,$type,$start,$end)
{
    global $conn,$antiXss;
    
    $keys = $antiXss->xss_clean($key);
    $type = $antiXss->xss_clean($type);
    $query = "SELECT id FROM upload_data WHERE kategori LIKE '%$keys%' AND product_id = '$type' AND created_at >= '$start' AND created_at <= '$end'";
    $result = mysqli_query($conn,$query);
	return mysqli_num_rows($result);
}

function getAllResultDataOne($key,$type,$start,$end)
{
    global $conn,$antiXss;
    
    $keys = $antiXss->xss_clean($key);
    $type = $antiXss->xss_clean($type);
    $query = "SELECT id FROM upload_data WHERE kategori LIKE '%$keys%' AND product_id = '$type' AND created_at >= '$start' AND created_at <= '$end'";
    $result = mysqli_query($conn,$query);
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
	mysqli_query($conn, "INSERT INTO `request` VALUES (NULL,'$reqtitle', '$unitkerja', '$name', '$tujuan', '$awal', '$akhir', '$priority',0)");

	return mysqli_affected_rows($conn);
}

function sendChat($data)
{
    global $conn,$antiXss;

    $id = $antiXss->xss_clean($data["id"]); //id user
    $qnaproduk = $antiXss->xss_clean($data["qnaproduk"]); //produk
    $ask = $antiXss->xss_clean($data["quest"]); //ask
    mysqli_query($conn, "INSERT INTO `qna` VALUES (NULL,'$id','$qnaproduk', '$ask', NULL, NULL,current_timestamp())");
    
    return mysqli_affected_rows($conn);
}

function getAnswer($id){
    global $conn,$antiXss;
    $id_user = $antiXss->xss_clean($id); //id user
    $check = mysqli_query($conn, "SELECT * FROM qna WHERE id_user = '$id_user' AND answer IS NOT NULL");
    return $check;
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

function getAnswerCheck($name)
{
    global $conn;
    $answerCheck = mysqli_query($conn,"SELECT `id` FROM `request` WHERE `name` = '$name' AND `status` = 0");
        
    if (mysqli_num_rows($answerCheck)>0) {
        return 1;
    } 
    elseif (mysqli_num_rows($answerCheck )=== 0) {
        return 0;
    }
    else {
        return NULL;
    }
}

function getQnaAll($produk)
{
    global $conn;
    $result = mysqli_query($conn,"SELECT * FROM qna WHERE produk_id = '$produk'");
    $rows = [];

	while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}