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
if (isset($_GET['produk'])&&isset($_GET['kategori'])) {
	// code...
	$produk = $antiXss->xss_clean($_GET["produk"]);
	$kategori = $antiXss->xss_clean($_GET["kategori"]);
	$start = $antiXss->xss_clean($_GET["awal"]);
	$end = $antiXss->xss_clean($_GET["akhir"]);
	$arr = explode(",", $kategori);
	$count_arr =  count($arr,COUNT_RECURSIVE);
	$month = array(
	 0 => 0, //jan
	 1 => 0, //feb
	 2 => 0, //mar
	 3 => 0, //apr
	 4 => 0, //may
	 5 => 0, //jun
	 6 => 0, //jul
	 7 => 0, //aug
	 8 => 0, //sep
	 9 => 0, //oct
	 10 => 0, //nov
	 11 => 0 //des
	);
	if ($count_arr > 1) {
		for ($i=0; $i < $count_arr; $i++) {
			$query[$i] = "SELECT * FROM upload_data
			WHERE
			product_id = '$produk' AND
			kategori = '$arr[$i]' AND
			created_at >= '$start' AND
			created_at <= '$end'
			";
			$result[$i] = mysqli_query($conn, $query[$i]);
			foreach($result[$i] as $row) {
			 if ($row['month'] == 'Jan') {
		     $month[0]++;
		   }
		   if ($row['month'] == 'Feb'){
		     $month[1]++;
		   }
		   if ($row['month'] == 'Mar') {
		     $month[2]++;
		   }
		   if ($row['month'] == 'Apr'){
		     $month[3]++;
		   }
		   if ($row['month'] == 'May') {
		     $month[4]++;
		   }
		   if ($row['month'] == 'Jun'){
		     $month[5]++;
		   }
		   if ($row['month'] == 'Jul') {
		     $month[6]++;
		   }
		   if ($row['month'] == 'Aug'){
		     $month[7]++;
		   }
		   if ($row['month'] == 'Sep'){
		     $month[8]++;
		   }
		   if ($row['month'] == 'Oct'){
		     $month[9]++;
		   }
		   if ($row['month'] == 'Nov'){
		     $month[10]++;
		   }
		   if ($row['month'] == 'Dec'){
		     $month[11]++;
		   }
			}
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Excel</title>
</head>
<body>
	<table border="1" width="100%" cellspacing="0">
			<thead>
					<tr style="background-color: yellow;">
							<th>Priode</th>
							<th>Jumlah</th>
							<th>Product</th>
							<th>Kategori</th>
					</tr>
			</thead>
			<tbody>
				<?php if($count_arr >1) : ?>
					<?php for ($i=0; $i < $count_arr; $i++):  ?>
						<?php foreach ($result[$i] as $row): ?>
								<tr>
									<td><?php echo $row['month'] ?></td>
									<td><?php echo mysqli_num_rows($result[$i]); ?></td>
									<td><?php echo $row['product_id'] ?></td>
									<td><?php echo $row['kategori'] ?></td>
								</tr>
						<?php endforeach;?>
					<?php endfor; ?>
				<?php endif; ?>
				<?php if($count_arr <=1) : ?>
					<?php foreach ($result as $row): ?>
							<tr>
								<td><?php echo $row['month'] ?></td>
								<td><?php echo mysqli_num_rows($result); ?></td>
								<td><?php echo $row['product_id'] ?></td>
								<td><?php echo $row['kategori'] ?></td>
							</tr>
					<?php endforeach;?>
				<?php endif; ?>
			</tbody>
	</table>

</body>
</html>
