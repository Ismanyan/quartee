<?php 

require'db.php';

use voku\helper\AntiXSS;
require_once '../vendor/anti-xss/autoload.php';
$antiXss = new AntiXSS();

function addUser($data)
{
    global $conn,$antiXss;

    $name = strtolower(stripslashes($antiXss->xss_clean($data["name"])));
	$role = strtolower(stripslashes($antiXss->xss_clean($data["role"])));
	$ut = strtolower(stripslashes($antiXss->xss_clean($data["ut"])));
    $nip = strtolower(stripslashes($antiXss->xss_clean($data["nip"])));
    $ttl = strtolower(stripslashes($antiXss->xss_clean($data["ttl"])));
    $domain = strtolower(stripslashes($antiXss->xss_clean($data["domain"])));
    $username = $antiXss->xss_clean($data["username"]);
    $password = $antiXss->xss_clean($data["password"]);

	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert('username sudah terdaftar!')
		      </script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO users VALUES(NULL, '$name', '$username', '$password', '$role', '$nip', '$ttl', '$domain', current_timestamp(), '$ut')");

	return mysqli_affected_rows($conn);
}

function editUser($data)
{
	global $conn,$antiXss;
	
	$id = $antiXss->xss_clean($data["id"]);
    $name = strtolower(stripslashes($antiXss->xss_clean($data["name"])));
    $role = strtolower(stripslashes($antiXss->xss_clean($data["role"])));
	$nip = strtolower(stripslashes($antiXss->xss_clean($data["nip"])));
	$ut = strtolower(stripslashes($antiXss->xss_clean($data["ut"])));
    $ttl = strtolower(stripslashes($antiXss->xss_clean($data["ttl"])));
    $domain = strtolower(stripslashes($antiXss->xss_clean($data["domain"])));
    $username = $antiXss->xss_clean($data["username"]);
    $password = $antiXss->xss_clean($data["password"]);

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	mysqli_query($conn, "UPDATE `users` SET 
	`name` = '$name' ,
	`username` = '$username' ,
	`password` = '$password' ,
	`role_id` = '$role' ,
	`nip` = '$nip' ,
	`ttl` = '$ttl' ,
	`domain` = '$domain' ,
	`unit_kerja` = '$ut'
	WHERE `id` = $id");

	return mysqli_affected_rows($conn);
}

function allUsers(){
    global $conn;
    $result = mysqli_query($conn,"SELECT * FROM users");
    return mysqli_num_rows($result);
}

function allUploader(){
    global $conn;
    $result = mysqli_query($conn,"SELECT * FROM users WHERE role_id = 2");
    return mysqli_num_rows($result);
}


function allGuest(){
    global $conn;
    $result = mysqli_query($conn,"SELECT * FROM users WHERE role_id = 3");
    return mysqli_num_rows($result);
}


function allData(){
    global $conn;
    $result = mysqli_query($conn,"SELECT id FROM upload_data");
    return mysqli_num_rows($result);
}

function getRole($id){
	global $conn;

    $result = mysqli_query($conn,"SELECT * FROM `role` WHERE `id` = '$id'");
    $rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}
