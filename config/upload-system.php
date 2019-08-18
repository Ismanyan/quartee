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
$check = mysqli_query($conn,"SELECT month_add FROM upload_date  WHERE month_add = $month AND upload_user_id = $idUsers");
if(mysqli_fetch_assoc($check)) {
	mysqli_query($conn,"DELETE FROM `upload_data` WHERE `upload_data`.`upload_user_id` = '$idUsers' AND  `upload_data`.`month` = '$monthM'");
	mysqli_query($conn,"DELETE FROM `upload_date` WHERE `upload_date`.`upload_user_id` = '$idUsers' AND  `upload_date`.`month_add` = '$month'");
}
// upload file xls
$target = basename($_FILES['filepegawai']['name']);
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
	$product    = $data->val($i, 1);
	$kategori   = $data->val($i, 2);
	$idUser = $antiXss->xss_clean($_POST['id']);
	$date = date('m-d-Y');
	$M = date('M');
	$x = date('Y-m-d');

	if($product != "" && $kategori != ""){
		mysqli_query($conn,"INSERT INTO upload_data values(NULL,'$product','$kategori','$M','$date',NULL,'$idUser')");
		$checksameproduk = mysqli_query($conn,"SELECT name_produk FROM produk WHERE name_produk = '$product'");
		$checksamekategori = mysqli_query($conn,"SELECT kategori_name FROM kategori WHERE kategori_name = '$kategori'");
		// ADD Produk
		if(mysqli_num_rows($checksameproduk) == 0) {
			mysqli_query($conn,"INSERT INTO produk values(NULL,'$product')");
		}
		//Add Kategori
		if (mysqli_num_rows($checksamekategori) == 0) {
			mysqli_query($conn,"INSERT INTO kategori values(NULL,'$kategori')");
		}

		//Add TOP10
		if (mysqli_num_rows($checksamekategori) == 0) {
			mysqli_query($conn,"INSERT INTO top10 values(NULL,'$product','$kategori',1)");
		} else {
			$top10 = mysqli_query($conn,"SELECT `total` FROM `top10` WHERE `produk` = '$product' AND `kategori` = '$kategori'");
			if(mysqli_num_rows($top10) > 0) {
				$resss = mysqli_fetch_assoc($top10);
				$allDataS = $resss['total'] + 1;
				mysqli_query($conn,"UPDATE `top10` SET `total` = '$allDataS' WHERE `produk` = '$product' AND `kategori` = '$kategori'");
			}
		}
		$berhasil++;
	}
	if ($i<3) {
		mysqli_query($conn,"INSERT INTO upload_date values(NULL,'$product','$date','$month','$idUser')");
	}
}

$checkData = mysqli_query($conn,"SELECT total_data FROM data_per_month WHERE `month` = '$monthM'");

if(mysqli_num_rows($checkData) > 0)
{
	$ress=mysqli_fetch_assoc($checkData);
	$allData = $ress['total_data'] + $jumlah_baris - 1;
	mysqli_query($conn,"UPDATE `data_per_month` SET `total_data` = '$allData' WHERE `data_per_month`.`month` = '$M' ");
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['filepegawai']['name']);

// alihkan halaman ke index.php
header("location: ../index.php");
?>
