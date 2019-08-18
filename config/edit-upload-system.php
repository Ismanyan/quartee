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
// Check if already data in mysql
$idUsers = $antiXss->xss_clean($_POST['id']);
$month = date("m");
$monthM = date("M");
$created_at = $antiXss->xss_clean($_POST['created_at']);
$check = mysqli_query($conn,"SELECT * FROM upload_date  WHERE created_at = '$created_at' AND upload_user_id = '$idUsers'");

if(mysqli_num_rows($check) >0) {

    mysqli_query($conn,"DELETE FROM `upload_date` WHERE `upload_date`.`upload_user_id` = '$idUsers' AND  `upload_date`.`created_at` = '$created_at'");
    mysqli_query($conn,"DELETE FROM `upload_data` WHERE `upload_data`.`upload_user_id` = '$idUsers' AND  `upload_data`.`created_at` = '$created_at'");
    // upload file xls
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
        $product     = $antiXss->xss_clean($data->val($i, 1));
        $kategori   = $antiXss->xss_clean($data->val($i, 2));
        $idUser = $antiXss->xss_clean($_POST['id']);
        $date = date('m-d-Y');
        $M = date('M');
        $x = date('Y-m-d');
        
        if($product != "" && $kategori != ""){
            mysqli_query($conn,"INSERT into upload_data values(NULL,'$product','$kategori','$M','$date',NULL,'$idUser')");
            $checksameproduk = mysqli_query($conn,"SELECT name_produk FROM produk WHERE name_produk = '$product'");
            $checksamekategori = mysqli_query($conn,"SELECT kategori_name FROM kategori WHERE kategori_name = '$kategori'");
            if(mysqli_num_rows($checksameproduk)==0 && mysqli_num_rows($checksamekategori)==0) {
                mysqli_query($conn,"INSERT into produk values(NULL,'$product')");
                mysqli_query($conn,"INSERT into kategori values(NULL,'$kategori')");
            }
            $berhasil++;
        }
        if ($i<3) {
            mysqli_query($conn,"INSERT into upload_date values(NULL,'$product','$date','$month','$idUser')");
        }
    
    }
    
    // hapus kembali file .xls yang di upload tadi
    unlink($_FILES['filepegawai']['name']);
    
    // alihkan halaman ke index.php
    header("location: ../index.php");
} else {
    echo 'sukses';
}




?>