<?php
session_start();

if(!isset($_SESSION["login"]) ) {
	header("Location: ../login");
	exit;
}

require '../../config/guest-config.php';

$user_name = $antiXss->xss_clean($_GET['name']); //id user
if (isset($_POST['sendChat']) && sendChat($_POST) >0) {
    echo "<script>
        alert('Pertanyaan telah di kirim');
        document.location.href = '../home';
        </script>";
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
    <a class="navbar-brand ml-1" href="home">Quartee</a>

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
        <a class="nav-link" href="home">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mb-5">
          <li class="breadcrumb-item active"><a href="../../home">back</a></li>
        </ol>

        <form action="" method="post">
            <div class="form-group mx-auto">
                <label for="produk">Produk</label>
                <select class="form-control" id="produk" required name="produk">
                    <?php foreach(getAllProduk() as $row) : ?>
                    <option value="<?= $row['name_produk']?>"><?= $row['name_produk']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-5" name="getQna">Cari Pertanyaan</button>
        </form>

        <?php if(isset(($_POST['produk'])) ): ?>
            <?php if(count(getQnaAll($_POST['produk']))>0) : ?>
                <?php foreach(getQnaAll($_POST['produk']) as $row) : ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h3>Answer</h3>
                        <?php if($row['answer'] == NULL) : ?>
                        <i>pertanyaan ini belum terjawab</i>
                            <?php else: ?>
                            <?= $row['answer'] ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="alert alert-warning">
                    Pertanyaan yang anda cari belum tersedia pada layanan kami. Silahkan ajukan pertanyaan anda kepada kami
                </div>
            <?php endif; ?>
            <button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#tanya">
            Ajukan Pertanyaan
            </button>
            <!-- Modal -->
            <div class="modal fade" id="tanya" tabindex="-1" role="dialog" aria-labelledby="tanyaLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tanyaLabel">Ajukan Pertanyaan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $_SESSION['data']['id'] ?>">
                                <select class="form-control mb-3" required name="qnaproduk" value="<?= $_POST['produk'] ?>">
                                    <?php foreach(getAllProduk() as $row) : ?>
                                    <option value="<?= $row['name_produk']?>"><?= $row['name_produk']?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="pertanyaan anda.." name="quest" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="sendChat">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Quartee 2019</span>
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

</body>

</html>
