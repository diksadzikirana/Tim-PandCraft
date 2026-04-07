<?php
include "koneksi.php";

// ambil dari form checkout
$id_produk = $_POST['id_produk'];
$jumlah    = $_POST['jumlah'];
$nama      = $_POST['nama'];
$no_hp     = $_POST['no_hp'];
$alamat    = $_POST['alamat'];

// ambil data produk
$produk = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id_produk='$id_produk'");
$data_produk = mysqli_fetch_array($produk);

$harga = $data_produk['harga'];
$total = $harga * $jumlah;
// =====================
// 1. SIMPAN KE tb_pesanan
// =====================
mysqli_query($conn, "INSERT INTO tb_pesanan
(id_pembeli, tgl_pesanan, total_harga, jumlah_pesanan, status_pesanan)
VALUES
('$id_pembeli', NOW(), '$total', '$jumlah', 'Menunggu')");

// ambil id pesanan terakhir
$id_pesanan = mysqli_insert_id($conn);

// =====================
// 2. SIMPAN KE tb_detail_pesanan
// =====================
mysqli_query($conn, "INSERT INTO tb_detail_pesanan
(id_pesanan, id_produk, jumlah, harga)
VALUES
('$id_pesanan', '$id_produk', '$jumlah', '$harga')");

// =====================
// 3. UPDATE STOK PRODUK
// =====================
$stok_baru = $data_produk['stok'] - $jumlah;

mysqli_query($conn, "UPDATE tb_produk SET stok='$stok_baru' WHERE id_produk='$id_produk'");

// =====================
// 4. REDIRECT
// =====================
echo "<script>alert('Pesanan berhasil dibuat!'); window.location='katalog.php';</script>";

?>