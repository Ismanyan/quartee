<?php require'../config/config.php';?>
<?php require'../config/uploader-config.php';?>
<?php $users = query("SELECT * FROM users");?>
<?php $user_id = $_SESSION['data']['id'];?>
<?php $uploadHis = query("SELECT * FROM upload_date WHERE upload_user_id = $user_id");?>
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
			<input name="upload" type="submit" value="Import">
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
			</div>
		</div>
	</div>
</div>
