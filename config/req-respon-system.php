<?php 
// menghubungkan dengan koneksi
require 'db.php';
// menghubungkan dengan library excel reader
require "../vendor/excel_reader2.php";

use voku\helper\AntiXSS;
require_once '../vendor/anti-xss/autoload.php';
$antiXss = new AntiXSS();
?>
<?php 
$idUser = $antiXss->xss_clean($_POST['id']);
$idRequester = $antiXss->xss_clean($_POST['idRequester']);
$reqTitle = $antiXss->xss_clean($_POST['reqTitle']);

$target = basename($_FILES['filepegawai']['name']) ;
move_uploaded_file($_FILES['filepegawai']['tmp_name'], $target);
// beri permisi agar file xls dapat di baca
chmod($_FILES['filepegawai']['name'],0777);
// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['filepegawai']['name'],false);    
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);
// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){

    // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
    $product    = $antiXss->xss_clean($data->val($i, 1));
    $kategori   = $antiXss->xss_clean($data->val($i, 2));

    if($product != "" && $kategori != ""){
        mysqli_query($conn,"INSERT INTO request_data values(NULL,'$idUser','$idRequester','$product','$kategori','$reqTitle')");
        $berhasil++;
    }

}

mysqli_query($conn,"UPDATE `request` SET `status` = '1' WHERE `request`.`name` = '$idRequester' AND `request`.`req_title` = '$reqTitle'");

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['filepegawai']['name']);

// alihkan halaman ke index.php
header("location: ../index.php");