<?php require '../config/config.php';?>
<?php require '../config/uploader-config.php';?>
<?php $users = query("SELECT * FROM users");?>
<?php $user_id = $_SESSION['data']['id'];?>
<?php $uploadHis = query("SELECT * FROM upload_date WHERE upload_user_id = $user_id");?>
<?php
// Check if already data in mysql
$idUsers = $antiXss->xss_clean($_SESSION['data']['id']);
$month = date("m");
$check = mysqli_query($conn,"SELECT month_add FROM upload_date  WHERE month_add = $month AND upload_user_id = $idUsers");
?>
<!-- Upload Check -->


<!-- Breadcrumbs-->
<ol class="breadcrumb mb-5">
   <li class="breadcrumb-item">Uploader Page</li>
   <li class="breadcrumb-item active">Upload Data</li>
</ol>

<!-- Progress -->
<div class="progress mb-3" style="display:none;">
  <div id="progressBar" class="progress-bar progress-bar-striped bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
    <span class="sr-only">0%</span>
  </div>
</div>
<div class="msg alert alert-info text-left" style="display:none;"></div>
<!-- End Progress -->

<div class="row">
	<div class="col-md-12">
		<form class="formUpload" method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?=$_SESSION['data']['id']?>" name="id">
			<input name="filepegawai" type="file" required="required" class="btn btn-primary">
			<?php if(mysqli_fetch_assoc($check)) :?>
			<button name="upload" type="submit" class="btn btn-primary" onclick="return confirm('Upload Bulanan ini telah selesai ! Yakin ingin melanjutkan dan akan menghapus datamu pada bulan ini?');">Import</button>
			<?php else:?>
			<button name="upload" type="submit" class="btn btn-primary">Import</button>
			<?php endif; ?>
		</form>

		  <div class="card mt-3" id="card">
            <div class="card-header">
            <i class="fas fa-table"></i>
            UPLOAD HISTORY</div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Tanggal Upload</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($uploadHis as $row) : ?>
                        <tr>
                            <td><?= $row['month_add'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td><a href="#" class="badge badge-warning" data-toggle="modal" data-target="#addtable<?= $row['id'] ?>">Edit</a></td>
              							<!-- add Modal -->
              							<div class="modal fade" id="addtable<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="addtableLabel" aria-hidden="true">
              								<div class="modal-dialog" role="document">
              									<div class="modal-content">
              									<div class="modal-header">
              										<h5 class="modal-title" id="addtableLabel">Edit Upload Data</h5>
              										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              										<span aria-hidden="true">&times;</span>
              										</button>
              									</div>
              									<form method="post" enctype="multipart/form-data" action="../config/edit-upload-system.php">
              										<div class="modal-body">
              										<input type="hidden" value="<?=$_SESSION['data']['id']?>" name="id">
              										<input type="hidden" value="<?= $row['created_at'] ?>" name="created_at">
              										<div class="form-group" >
              											<label for="product">Tanggal Upload</label>
              											<input type="text" class="form-control" id="product" placeholder="Product..." value="<?= $row['created_at'] ?>" readonly>
              										</div>
              										<div class="form-group">
              											<input name="filepegawai" type="file" required="required">
              										</div>
              										<button type="submit" class="w-100 btn btn-primary" name="upload" onclick="return confirm('Yakin ingin melanjutkan dan akan menghapus datamu pada bulan ini?');">Save Change</button>
              										</div>
              									</form>
              									</div>
              								</div>
              							</div>
                        </tr>
                         <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
       	  </div>
	</div>
	<div class="col-md-12">
		<div class="card my-5">
			<div class="card-header">
				<div class="card mt-3" id="sip">
					<div class="card-header">
					<i class="fas fa-table"></i>
					LIST MANUAL PERMINTAAN</div>
					<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Requester Name</th>
									<th>Awal Bulan</th>
									<th>Akhir Bulan</th>
									<th>Priority</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach(allReqData() as $row) : ?>
								<tr>
									<td><?= $row['name'] ?></td>
									<td><?= $row['awal_bulan'] ?></td>
									<td><?= $row['akhir_bulan'] ?></td>
									<td><?= $row['priority'] ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
