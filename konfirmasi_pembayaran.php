<?php
include "koneksi.php";

$id = $_GET['id'];

mysqli_query($conn, "
UPDATE tb_pembayaran 
SET status_pembayaran='Lunas' 
WHERE id_pesanan='$id'
");

echo "<script>
alert('Pembayaran dikonfirmasi!');
window.location='admin_pesanan.php';
</script>";
?>