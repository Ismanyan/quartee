<?php require'../../config/auth-config.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Quartee</title>
    <meta name="description" content="REPORTING PORTAL HALO BCA">
  	<meta name="author" content="Quarte">
  	<link rel="shortcut icon" href="../resources/img/favicon.png">
    <link rel="stylesheet" type="text/css" href="../vendor/ioform/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/ioform/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/ioform/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="../vendor/ioform/css/iofrm-theme14.css">
</head>
<body>
    <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3 class="mb-5">Login Panel</h3>
                        <form method="post">
                            <input class="form-control" type="text" name="username" placeholder="Username" required name="username">
                            <input class="form-control" type="password" name="password" placeholder="Password" required name="password">
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn w-100 py-2" name="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../vendor/ioform/js/jquery.min.js"></script>
<script src="../vendor/ioform/js/bootstrap.min.js"></script>
<script src="../vendor/ioform/js/popper.min.js"></script>
<script src="../vendor/ioform/js/main.js"></script>
</body>
</html>
