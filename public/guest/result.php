<?php 
session_start();
require '../../config/guest-config.php';
    
if(isset($_POST['run'])){
    
    $produk = $antiXss->xss_clean($_POST["produk"]);
    $kategori = $antiXss->xss_clean($_POST["kategori"]);
    $start = $antiXss->xss_clean($_POST["awal"]);
    $end = $antiXss->xss_clean($_POST["akhir"]);
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
    
} else {
    header('Location: ../../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Result | Quartee</title>

  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../resources/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
    <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand ml-1" href="index.html">Logo Here</a>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto">
      
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i> <?= $_SESSION['data']['name']?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#"><?= $_SESSION['data']['name']?></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="../home">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">
        
        <!-- Breadcrumbs-->
        <ol class="breadcrumb mb-3">
          <li class="breadcrumb-item"><a href="../home">Back</a></li>
        </ol>

        <!-- add modal -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
          Create New Produk
        </button>

        <div class="card mb-3" id="card">
            <div class="card-header">
            <i class="fas fa-table"></i>
            Users Table</div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Priode</th>
                            <th>Jumlah</th>
                            <th>Product</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($rows as $row) : ?>
                        <?php 
                            $z = $row['month'];
                            $all = mysqli_query($conn, "SELECT COUNT(`month`) FROM upload_data WHERE 
                                    `month` = '$z' AND 
                                    product_id = '$produk' AND
                                    kategori = '$kategori' AND
                                    created_at >= '$start' AND 
                                    created_at <= '$end' 
                                    ");
                            $alls = mysqli_fetch_assoc($all);
                        ?>
                            <tr>
                                <td><?= $row['month']?></td>
                                <td><?= $alls['COUNT(`month`)']?></td> 
                                <td><?= $row['product_id']?></td> 
                                <td><?= $row['kategori']?></td>  
                            </tr>
                            <?php $i++;?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- add Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ADD PRODUCT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <input type="hidden"value="<?= $_SESSION['data']['id'] ?>" name="id_user" required>  
            <div class="form-group">
              <label for="product">Product</label>
              <input type="text" class="form-control" id="product" placeholder="Product..." name="produk" required>
            </div>
            <div class="form-group">
              <label for="kategori">Kategori</label>
              <textarea class="form-control" id="kategori" rows="5" name="kategori" required></textarea>
            </div>
            <button type="submit" class="w-100 btn btn-primary" name="addProduk">Save Change</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  

  <!-- Bootstrap core JavaScript-->
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../../resources/js/sb-admin.min.js"></script>
   <script src="../../resources/js/demo/datatables-demo.js"></script>
  <script src="../../resources/js/demo/chart-area-demo.js"></script>
</body>

</html>
