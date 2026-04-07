<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "koneksi.php";

// =====================
// 1. AMBIL DATA
// =====================
$id_produk = $_POST['id_produk'];
$jumlah    = $_POST['jumlah'];

$nama      = $_POST['nama'];
$no_hp     = $_POST['no_hp'];
$alamat    = $_POST['alamat'];
$metode    = $_POST['metode'];

// validasi
if(empty($id_produk) || empty($jumlah) || empty($nama)){
    echo "<script>alert('Data tidak lengkap!');history.back();</script>";
    exit;
}

// =====================
// 2. AMBIL PRODUK
// =====================
$produk = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id_produk='$id_produk'");
$data_produk = mysqli_fetch_array($produk);

if(!$data_produk){
    echo "<script>alert('Produk tidak ditemukan!');history.back();</script>";
    exit;
}

$harga = $data_produk['harga'];
$stok  = $data_produk['stok'];

if($jumlah > $stok){
    echo "<script>alert('Stok tidak mencukupi!');history.back();</script>";
    exit;
}

$total = $harga * $jumlah;

// =====================
// 3. SIMPAN PEMBELI
// =====================
mysqli_query($conn, "INSERT INTO tb_pembeli (nama_pembeli,no_hp,alamat)
VALUES ('$nama','$no_hp','$alamat')");

$id_pembeli = mysqli_insert_id($conn);

// =====================
// 4. SIMPAN PESANAN
// =====================
mysqli_query($conn, "INSERT INTO tb_pesanan
(id_pembeli, tgl_pesanan, total_harga, jumlah_pesanan, status_pesanan, status)
VALUES
('$id_pembeli', NOW(), '$total', '$jumlah', 'Menunggu', '$metode')");

$id_pesanan = mysqli_insert_id($conn);

// =====================
// 5. SIMPAN DETAIL
// =====================
mysqli_query($conn, "INSERT INTO tb_detail_pesanan
(id_pesanan, id_produk, jumlah, harga_satuan)
VALUES
('$id_pesanan', '$id_produk', '$jumlah', '$harga')");

// =====================
// 6. SIMPAN PEMBAYARAN (INI YANG BARU 🔥)
// =====================
$status_bayar = ($metode == "COD") ? "Belum Dibayar" : "Menunggu Transfer";

mysqli_query($conn, "INSERT INTO tb_pembayaran
(id_pesanan, metode_bayar, tgl_bayar, status_pembayaran)
VALUES
('$id_pesanan', '$metode', NOW(), '$status_bayar')");

// =====================
// 7. UPDATE STOK
// =====================
$stok_baru = $stok - $jumlah;

mysqli_query($conn, "UPDATE tb_produk
SET stok='$stok_baru'
WHERE id_produk='$id_produk'");

// =====================
// 8. REDIRECT
// =====================
echo "<script>
alert('Pesanan berhasil dibuat!');
window.location='riwayat.php?id=$id_pesanan';
</script>";
?>