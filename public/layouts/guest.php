<?php require '../config/guest-config.php';?>
<?php
    if (isset($_POST['req']) && addReq($_POST)>0) {
     echo "<script>
            alert('Request Data Sukses');
            document.location.href = 'home';
         </script>";
    }
?>
<!-- Upload Check -->

<style>
    /* Hide prev/next buttons and month name*/
    .datepicker-days>table>thead>tr>th.prev,
    .datepicker-days>table>thead>tr>th.datepicker-switch,
    .datepicker-days>table>thead>tr>th.next {
        display: none;
    }

    /* Hide days of previous month */
    td.old.day{
        visibility: hidden;
    }

    /* Hide days of next month */
    td.new.day{
        display: none;
    }
</style>

<!-- Breadcrumbs-->
<ol class="breadcrumb mb-5">
   <li class="breadcrumb-item">Guest Page</li>
   <li class="breadcrumb-item active">Request Data</li>
</ol>

<!-- SLIDER -->
<div id="carouselExampleControls" class="carousel slide mb-5" data-ride="carousel">
    <div class="carousel-inner">
    <div class="carousel-item active">
        <img class="d-block w-100" src="../resources/img/RUNNING BANNER 1.png" alt="First slide">
    </div>
    <div class="carousel-item">
        <img class="d-block w-100" src="../resources/img/RUNNING BANNER 2.png" alt="Second slide">
    </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<?php $name = $_SESSION['data']['name']; ?>

<?php if(getAnswerCheck($name) > 0) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    Request anda belum kami respon. Mohon untuk menunggu beberapa saat
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <?php elseif(getAnswerCheck($name) === 0) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
    Request anda telah kami respon. Silahkan <a href="guest/req-data.php?name=<?= $name ?>" class="alert-link">klik disini</a> untuk melihat
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
<?php endif; ?>
<div class="my-5 ">
    <p class="">Want to request Data ?</p>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#req">
    Request
    </button>
</div>

<div class="alert alert-info alert-dismissible fade show mb-5" role="alert">
    Jika ada pertanyaan tentang produk kami. Silahkan <a href="guest/qna.php?name=<?= $name ?>" class="alert-link">klik disini</a>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="row justify-content-md-center">
    <div class="col-lg-12">
        <form action="guest/result.php" method="post">
            <div class="form-group mx-auto">
                <label for="produk">Produk</label>
                <select class="form-control" id="produk" required name="produk">
                    <?php foreach(getAllProduk() as $row) : ?>
                    <option value="<?= $row['name_produk']?>"><?= $row['name_produk']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mx-auto">
                <label for="kategori">Kategori</label>
                <select class="form-control" id="kategori" required name="kategori[]" multiple size = 6>
                    <?php foreach(getAllKategori() as $row) : ?>
                    <option value="<?= $row['kategori_name']?>"><?= $row['kategori_name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Bulan Awal</label>
                <input id="bulanAwal" class="form-control" required name="awal"/>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Bulan AKhir</label>
                <input id="bulanAkhir" class="form-control" required name="akhir"/>
            </div>
            <button type="submit" class="w-100 btn btn-primary mb-5" name='run'>RUN REPORT</button>
        </form>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="req" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
        <div class="modal-body">
            <div class="form-group">
                <label for="title">Judul Permintaan</label>
                <input type="text" class="form-control" id="title" placeholder="Judul permainan..." name="reqtitle" required>
            </div>
            <div class="form-group">
                <label for="uk">Posisi</label>
                <input type="text" class="form-control" id="uk" placeholder="Unit kerja..."  value="GUEST" readonly>
                <input type="hidden" class="form-control" id="uk" placeholder="Unit kerja..." name="unitkerja" value="<?=$_SESSION['data']['role_id'];?>">
            </div>
            <div class="form-group">
                <label for="name_user">Nama</label>
                <input type="text" class="form-control" id="name_user" placeholder="Nama..." name="name" value="<?= $_SESSION['data']['name']?>" readonly>
            </div>
            <div class="form-group">
                <label for="tujuan">Tujuan Permintaan</label>
                <input type="text" class="form-control" id="tujuan" placeholder="Tujuan permintaan..." name="tujuan" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Bulan Awal</label>
                <input id="awalBulan" class="form-control" required name="awal"/>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Bulan AKhir</label>
                <input id="akhirBulan" class="form-control" required name="akhir"/>
            </div>
            <div class="form-group">
                <label for="priode">Priority</label>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="Urgent">Urgent</option>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="req">Request</button>
        </div>
      </form>
    </div>
  </div>
</div>
