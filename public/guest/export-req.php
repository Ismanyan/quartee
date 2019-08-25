<?php
session_start();

if(!isset($_SESSION["login"]) ) {
	header("Location: ../login");
	exit;
}


// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=report.xls");

require '../../config/guest-config.php';

$user_name = $antiXss->xss_clean($_GET['name']); //id user

$result = mysqli_query($conn,"SELECT * FROM `request_data` WHERE `id_requester` = '$user_name'");
$rows = [];
while( $row = mysqli_fetch_assoc($result) ) {
    $rows[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="REPORTING PORTAL HALO BCA">
	<meta name="author" content="Quarte">
	<link rel="shortcut icon" href="../../resources/img/favicon.png">


  <title>Inf | Quartee</title>

</head>

<body id="page-top">

    <table width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produk</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($rows as $key) : ?>
                <tr>
                <td><?= $key['id']; ?></td>
                <td><?= $key['produk']; ?></td>
                <td><?= $key['kategori']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>
