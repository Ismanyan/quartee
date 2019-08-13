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
<div class="row">
	<div class="col-md-6">
		<form method="post" enctype="multipart/form-data" action="../config/upload-system.php">
			<input type="hidden" value="<?=$_SESSION['data']['id']?>" name="id">
			<input name="filepegawai" type="file" required="required"> 
			<?php if(mysqli_fetch_assoc($check)) :?>
			<input name="upload" type="submit" value="Import" onclick="return confirm('Upload Bulanan ini telah selesai ! Yakin ingin melanjutkan dan akan menghapus datamu pada bulan ini?');">
			<?php else:?>
			<input name="upload" type="submit" value="Import">
			<?php endif; ?>
		</form>

		<h5 class="text-center mt-5 mb-3">UPLOAD HISTORY</h5>
		<ul class="list-group text-center">
			<?php foreach($uploadHis as $row) : ?>
			<li class="list-group-item"><?= $row['created_at']?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h4>LIST MANUAL PERMINTAAN</h4>
				<hr>
				<ul class="list-group">
					<?php foreach(allReqData() as $row) : ?>
					<li class="list-group-item ">
						<div class="row align-center">
							<div class="col-auto text-left bg-success"><?= $row['req_title']?> </div>
							<div class="col-auto text-center bg-warning"><?= $row['priode']?></div>
							<div class="col-auto text-right bg-danger"><?= $row['priority']?></div>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
