<?php
include "koneksi.php";

if(!isset($_GET['id'])){
    echo "ID tidak ditemukan";
    exit;
}

$id = $_GET['id'];

$data = mysqli_query($conn, "
SELECT 
p.*,
pb.nama_pembeli,
pb.no_hp,
pb.alamat,
d.jumlah,
pr.nama_produk,
pr.gambar,
pay.metode_bayar,
pay.status_pembayaran
FROM tb_pesanan p
JOIN tb_pembeli pb ON p.id_pembeli = pb.id_pembeli
JOIN tb_detail_pesanan d ON p.id_pesanan = d.id_pesanan
JOIN tb_produk pr ON d.id_produk = pr.id_produk
LEFT JOIN tb_pembayaran pay ON p.id_pesanan = pay.id_pesanan
WHERE p.id_pesanan='$id'
");

$row = mysqli_fetch_array($data);

if(!$row){
    echo "Data tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Pesanan (Admin)</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

<h2 class="text-xl font-bold text-green-600 mb-4">
📦 Detail Pesanan (Admin)
</h2>

<!-- PRODUK -->
<div class="flex gap-4 mb-4">
    <img src="gambar_produk/<?php echo $row['gambar']; ?>"
    class="w-32 rounded">

    <div>
        <p class="font-bold"><?php echo $row['nama_produk']; ?></p>
        <p>Jumlah: <?php echo $row['jumlah']; ?></p>
        <p>Total: Rp <?php echo number_format($row['total_harga']); ?></p>
    </div>
</div>

<hr class="my-4">

<!-- DATA PEMBELI -->
<h3 class="font-bold mb-2">Data Pembeli</h3>
<p>Nama: <?php echo $row['nama_pembeli']; ?></p>
<p>No HP: <?php echo $row['no_hp']; ?></p>
<p>Alamat: <?php echo $row['alamat']; ?></p>

<hr class="my-4">

<!-- STATUS -->
<h3 class="font-bold mb-2">Status Pesanan</h3>
<p><?php echo $row['status_pesanan']; ?></p>

<!-- PEMBAYARAN -->
<h3 class="font-bold mt-4 mb-2">Pembayaran</h3>
<p>Metode: <?php echo $row['metode_bayar']; ?></p>
<p>Status: <?php echo $row['status_pembayaran']; ?></p>

<!-- BUTTON BACK -->
<div class="mt-6">
    <a href="kelola_pesanan.php"
    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
        ← Kembali ke Kelola Pesanan
    </a>
</div>

</div>

</body>
</html>