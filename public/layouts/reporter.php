<?php require '../config/reporter-config.php';?>
<?php 
    if (isset($_POST['sendanswer']) && sendAnswer($_POST)>0) {
        echo "<script>
            alert('Sukses di jawab');
            document.location.href = 'home';
         </script>";
    }
?>
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
                    <th>Product</th>
                    <th>Pertanyaan</th>
                    <th>Created</th>
                    <th>Jawab</th>
                    <th>Answer</th>
            <tbody>
                <?php foreach(getAllQna() as $row) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['produk_id'] ?></td>
                    <td><?= $row['quest'] ?></td>
                    <td><?= $row['created'] ?></td>
                    <td><?= $row['answer'] ?></td>
                    <td><a href="#" class="badge badge-primary" data-toggle="modal" data-target="#exampleModal<?=$row['id'] ?>">Answer</a></td>
                </tr>        
                <!-- Modal -->
                <div class="modal fade" id="exampleModal<?=$row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Answer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" method="post">
                                <input type="hidden" name="ids" value="<?= $_SESSION['data']['id']?>">
                                <input type="hidden" name="idask" value="<?= $row['id']?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="answer"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="sendanswer">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
</div>
