<?php require'../config/config.php';?>
<?php require'../config/admin-config.php';?>
<?php $users = query("SELECT * FROM users");?>

<!-- Upload Check -->
<?php if(isset($_POST['submit'])) : ?>
    <?php if(addUser($_POST)>0) : ?>
    <?= "<script>
            alert('Add User Success');
            document.location.href = 'home';
        </script>"?>
    <?php else:?>
    <?= "<script>
            alert('Add User Failed');
            document.location.href = 'home';
        </script>"?>
    <?php endif; ?>
<?php endif; ?>
<?php if(isset($_POST['edit'])) : ?>
    <?php if(editUser($_POST)>0) : ?>
    <?= "<script>
            alert('Edit User Success');
            document.location.href = 'home';
        </script>"?>
    <?php else:?>
    <?= "<script>
            alert('Edit User Failed');
            document.location.href = 'home';
        </script>"?>
    <?php endif; ?>
<?php endif; ?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">Admin Page</li>
   <li class="breadcrumb-item active">Users Management</li>
</ol>

<!-- Add button -->
<a href="#" class="btn btn-success mb-3" data-toggle="modal" data-target="#add">Add New User <i class="fas fa-plus-square"></i></a>


<!-- Icon Cards-->
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-primary o-hidden h-100">
        <div class="card-body">
        <div class="card-body-icon">
            <i class="fas fa-fw fa-user-friends"></i>
        </div>
        <div class="mr-5"><?= allUsers();?> User in Database</div>
        </div>
    </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-warning o-hidden h-100">
        <div class="card-body">
        <div class="card-body-icon">
            <i class="fas fa-fw fa-file-upload"></i>
        </div>
        <div class="mr-5"><?= allUploader();?> Uploader in Database</div>
        </div>
    </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-success o-hidden h-100">
        <div class="card-body">
        <div class="card-body-icon">
            <i class="fas fa-fw fa-user-tie"></i>
        </div>
        <div class="mr-5"><?= allGuest();?> Guest in Database</div>
        </div>
    </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-danger o-hidden h-100">
        <div class="card-body">
        <div class="card-body-icon">
            <i class="fas fa-fw fa-database"></i>
        </div>
        <div class="mr-5"><?= allData();?> Data in Database</div>
        </div>
    </div>
    </div>
</div>

<!-- DataTables User -->
<div class="card mb-3" id="card">
    <div class="card-header">
    <i class="fas fa-table"></i>
    Users Table</div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Posisi</th>
                    <th>Unit Kerja</th>
                    <th>NIP</th>
                    <th>TTL</th>
                    <th>Domain</th>
                    <th>Job Title</th>
                    <th>Tanggal Buat</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $num = 0; foreach($users as $row) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?php foreach (getRole($row['role_id']) as $key) {echo $key['role_name'];}?></td>
                    <td><?= $row['unit_kerja'] ?></td>
                    <td><?= $row['nip'] ?></td>
                    <td><?= $row['ttl'] ?></td>
                    <td><?= $row['domain'] ?></td>
                    <td><?php foreach (getRole($row['role_id']) as $key) {echo $key['rol_job'];}?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['password'] ?></td>
                    <td><a href="#" class="badge badge-warning edit-data" data-toggle="modal" data-target="#edit" data-id="<?= $row['id']?>">Edit</a></td>
                </tr>
                <?php $num++; endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
</div>

<!-- add Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabel">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" required name="name">
                </div>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1" required name="role">
                        <option selected disabled>Posisi</option>
                        <option value="1">Admin</option>
                        <option value="2">Uploader</option>
                        <option value="3">Guest</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Unit Kerja" required name="ut">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control validate" placeholder="NIP" required name="nip">
                </div>
                <div class="form-group">
                    <input id="datepicker" class="form-control" required name="ttl"/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Domain" required name="domain">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" required name="username">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Password" required name="password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" class="form-control" placeholder="Name" required name="id" id="id" value="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" required name="name" id="name" value="">
                </div>
                <div class="form-group">
                    <select class="form-control" id="role" required name="role">
                        <option selected disabled>Unit Kerja</option>
                        <option value="1">Admin</option>
                        <option value="2">Uploader</option>
                        <option value="3">Guest</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Unit Kerja" id="ut" required name="ut">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control validate" placeholder="NIP" required name="nip" id="nip" value="">
                </div>
                <div class="form-group">
                    <input id="datepickers" class="form-control datepicker" required name="ttl" id="name" value=""/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Domain" required name="domain" id="domain" value="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" required name="username" id="username" value="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Password" required name="password" id="password" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="edit">Save changes</button>
            </div>
        </form>
    </div>
  </div>
</div>
