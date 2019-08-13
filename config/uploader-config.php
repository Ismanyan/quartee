<?php 

require 'db.php';

use voku\helper\AntiXSS;
require 'anti-xss/autoload.php';
$antiXss = new AntiXSS();

function allData(){
    global $conn;
    $result = mysqli_query($conn,"SELECT * FROM upload_data");
    $rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
    return $rows;
}

function addTableNew($data)
{
    global $conn,$antiXss;

    $produk = $antiXss->xss_clean($data['produk']);
    $kategori = $antiXss->xss_clean($data['kategori']);
    $id_user = $antiXss->xss_clean($data['id_user']);
    $M = date('M');
	$x = date('Y-m-d');
    mysqli_query($conn,"INSERT into upload_data values(NULL,'$produk', '$kategori', '$M', '$x', NULL, $id_user)");
    
	return mysqli_affected_rows($conn);
}

function addProduk($data)
{
    global $conn,$antiXss;

    $produk = $antiXss->xss_clean($data['produk']);
    $kategori = $antiXss->xss_clean($data['kategori']);
    $id_user = $antiXss->xss_clean($data['id_user']);
    $M = date('M');
	$x = date('Y-m-d');
    if (substr($kategori, -1) === ",") {
        $arr = explode(",", $kategori);
        $count_arr =  count($arr,COUNT_RECURSIVE) - 1;
        if ($count_arr >0) {
            for ($i=0; $i <$count_arr ; $i++) { 
                $datas[$i] = str_replace(',','',$arr[$i]);
                mysqli_query($conn,"INSERT into upload_data values(NULL,'$produk', '$datas[$i]', '$M', '$x', NULL, $id_user)");
            }
        }
    } else {
        echo "<script>
			alert('Tambahkan (,) di akhir kata');
			document.location.href = 'data';
			</script>";
	    return false;
    }
    return mysqli_affected_rows($conn);
}

function allReqData()
{
    global $conn;
    $result = mysqli_query($conn,"SELECT * FROM request");
    $rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
    return $rows;
}