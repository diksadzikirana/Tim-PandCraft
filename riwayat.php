<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "koneksi.php";

if(!isset($_GET['id'])){
    echo "ID tidak ditemukan";
    exit;
}

$id = $_GET['id'];

$data = mysqli_query($conn, "
SELECT 
p.*, 
d.jumlah, 
pr.nama_produk, 
pr.gambar,
pb.metode_bayar,
pb.status_pembayaran
FROM tb_pesanan p
JOIN tb_detail_pesanan d ON p.id_pesanan = d.id_pesanan
JOIN tb_produk pr ON d.id_produk = pr.id_produk
JOIN tb_pembayaran pb ON p.id_pesanan = pb.id_pesanan
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
<title>Riwayat Pesanan</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

<h2 class="text-xl font-bold mb-4 text-green-600">Detail Pesanan</h2>

<!-- GAMBAR -->
<img src="gambar_produk/<?php echo $row['gambar']; ?>" 
class="w-40 mb-4 rounded">

<!-- INFO -->
<p><b>Produk:</b> <?php echo $row['nama_produk']; ?></p>
<p><b>Jumlah:</b> <?php echo $row['jumlah']; ?></p>
<p><b>Total:</b> Rp <?php echo number_format($row['total_harga']); ?></p>
<p><b>Status Pesanan:</b> <?php echo $row['status_pesanan']; ?></p>

<hr class="my-4">

<!-- PEMBAYARAN -->
<div class="p-4 rounded bg-gray-100">
    <p><b>Metode:</b> <?php echo $row['metode_bayar']; ?></p>
    <p><b>Status Pembayaran:</b> <?php echo $row['status_pembayaran']; ?></p>
</div>

<br>

<?php if($row['metode_bayar'] == "COD"){ ?>
    <div class="bg-yellow-100 p-4 rounded">
        <p class="font-semibold text-yellow-700">COD</p>
        <p>Bayar saat barang sampai</p>
    </div>
<?php } else { ?>
    <div class="bg-green-100 p-4 rounded">
        <p class="font-semibold text-green-700">Transfer</p>
        <p>Silakan transfer ke:</p>
        <p class="font-bold">BCA - 1234567890</p>
        <p>a.n PandCraft</p>
    </div>
<?php } ?>

<!-- BUTTON -->
<div class="mt-6 text-center">
    <a href="katalog.php"
    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
        ← Kembali ke Katalog
    </a>
</div>

</div>

</body>
</html>