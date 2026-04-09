<?php
include "koneksi.php";

$id = $_POST['id'];
$status = $_POST['status_pembayaran'];

mysqli_query($conn, "
UPDATE tb_pembayaran 
SET status_pembayaran='$status'
WHERE id_pesanan='$id'
");

header("Location: admin_pesanan.php");
?>