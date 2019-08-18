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

<!-- Breadcrumbs-->
<ol class="breadcrumb mb-5">
   <li class="breadcrumb-item">Guest Page</li>
   <li class="breadcrumb-item active">Request Data</li>
</ol>

<div class="mb-5">
    <p class="">Want to request Data ?</p>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#req">
    Request
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
