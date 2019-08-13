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
session_start();
require '../../config/guest-config.php';


    $produk = $antiXss->xss_clean($_GET["produk"]);
    $kategori = $antiXss->xss_clean($_GET["kategori"]);
    $start = $antiXss->xss_clean($_GET["awal"]);
    $end = $antiXss->xss_clean($_GET["akhir"]);
    $query = "SELECT * FROM upload_data
			  WHERE
			  product_id = '$produk' OR
              kategori = '$kategori' AND
              created_at >= '$start' AND 
              created_at <= '$end' 
            ";
        
    $result = mysqli_query($conn, $query);
    // check data
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }

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

    for ($b=0; $b < count($rows); $b++) { 
      if ($rows[$b]['month'] == 'Jan') {
        $month[0]++;
      } 
      if ($rows[$b]['month'] == 'Feb'){
        $month[1]++;
      }
      if ($rows[$b]['month'] == 'Mar') {
        $month[2]++;
      } 
      if ($rows[$b]['month'] == 'Apr'){
        $month[3]++;
      }
      if ($rows[$b]['month'] == 'May') {
        $month[4]++;
      } 
      if ($rows[$b]['month'] == 'Jun'){
        $month[5]++;
      }
      if ($rows[$b]['month'] == 'Jul') {
        $month[6]++;
      } 
      if ($rows[$b]['month'] == 'Aug'){
        $month[7]++;
      }
      if ($rows[$b]['month'] == 'Sep'){
        $month[8]++;
      }
      if ($rows[$b]['month'] == 'Oct'){
        $month[9]++;
      }
      if ($rows[$b]['month'] == 'Nov'){
        $month[10]++;
      }
      if ($rows[$b]['month'] == 'Dec'){
        $month[11]++;
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
    <table border='1' width="100%" cellspacing="0">
        <thead>
            <tr style="background-color:yellow;">
                <th>Priode</th>
                <th>Jumlah</th>
                <th>Product</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach($rows as $row) : ?>
                <tr>
                    <td><?= $row['month']?></td>
                    <?php if($row['month'] == 'Jan') : ?>
                    <td><?= $month[0] ?></td> 
                    <?php elseif($row['month'] == 'Feb') : ?>
                    <td><?= $month[1] ?></td>
                    <?php elseif($row['month'] == 'Mar') : ?>
                    <td><?= $month[2] ?></td>
                    <?php elseif($row['month'] == 'Apr') : ?>
                    <td><?= $month[3] ?></td>
                    <?php elseif($row['month'] == 'May') : ?>
                    <td><?= $month[4] ?></td>
                    <?php elseif($row['month'] == 'Jun') : ?>
                    <td><?= $month[5] ?></td>
                    <?php elseif($row['month'] == 'Jul') : ?>
                    <td><?= $month[6] ?></td>
                    <?php elseif($row['month'] == 'Aug') : ?>
                    <td><?= $month[7] ?></td>
                    <?php elseif($row['month'] == 'Sep') : ?>
                    <td><?= $month[8] ?></td>
                    <?php elseif($row['month'] == 'Oct') : ?>
                    <td><?= $month[9] ?></td>
                    <?php elseif($row['month'] == 'Nov') : ?>
                    <td><?= $month[10] ?></td>
                    <?php elseif($row['month'] == 'Dec') : ?>
                    <td><?= $month[11] ?></td>
                    <?php endif; ?>
                    <td><?= $row['product_id']?></td> 
                    <td><?= $row['kategori']?></td>  
                </tr>
                <?php $i++;?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>