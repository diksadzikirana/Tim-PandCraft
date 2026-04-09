<?php
include "koneksi.php";

$id = $_POST['id'];
$status = $_POST['status'];

mysqli_query($conn, "
UPDATE tb_pesanan 
SET status_pesanan='$status' 
WHERE id_pesanan='$id'
");

header("Location: admin_pesanan.php");
?>