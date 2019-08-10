<?php require '../config/guest-config.php';?>
<!-- Upload Check -->

<!-- Breadcrumbs-->
<ol class="breadcrumb mb-5">
   <li class="breadcrumb-item">Guest Page</li>
   <li class="breadcrumb-item active">Request Data</li>
</ol>

<div class="mb-5">
    <p class="">Want to request Data ?</p>
    <a href="" class="btn btn-primary">Create Manual Request</a>
</div>

<div class="row justify-content-md-center">
    <div class="col-lg-12">
        <form action="guest/result.php" method="post">
            <div class="form-group mx-auto">
                <label for="produk">Produk</label>
                <select class="form-control" id="produk" required name="produk">
                    <?php foreach(getAllProduk() as $row) : ?>
                    <?php var_dump($row); ?>
                    <option value="<?= $row['name_produk']?>"><?= $row['name_produk']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mx-auto">
                <label for="kategori">Kategori</label>
                <select class="form-control" id="kategori" required name="kategori">
                    <?php foreach(getAllKategori() as $row) : ?>
                    <?php var_dump($row); ?>
                    <option value="<?= $row['kategori_name']?>"><?= $row['kategori_name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Bulan Awal</label>
                <input id="datepicker" class="form-control" required name="awal"/>          
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Bulan AKhir</label>
                <input id="datepickers" class="form-control" required name="akhir"/>          
            </div>
            <button type="submit" class="w-100 btn btn-primary mb-5" name='run'>RUN REPORT</button>
        </form>
    </div>
</div>
