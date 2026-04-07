<?php
include "koneksi.php";

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id_produk='$id'");
$produk = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- HEADER -->
<div class="flex justify-between items-center px-10 py-5 bg-white shadow">
    <h1 class="text-2xl font-bold text-green-700">Katalog</h1>
    <div class="space-x-6 text-gray-600">
        <a href="katalog.php">Home</a>
    </div>
</div>

<!-- CONTAINER -->
<div class="max-w-6xl mx-auto mt-10 grid md:grid-cols-2 gap-10">

    <!-- GAMBAR PRODUK -->
    <div class="bg-white p-6 rounded-xl shadow flex items-center justify-center">
        <img src="gambar_produk/<?php echo $produk['gambar']; ?>" 
        class="h-80 object-contain">
    </div>

    <!-- DETAIL PRODUK -->
    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-2xl font-bold mb-2">
            <?php echo $produk['nama_produk']; ?>
        </h2>

        <p class="text-gray-500 mb-3">
            Produk kerajinan daun pandan berkualitas
        </p>

        <!-- HARGA -->
        <p class="text-3xl font-bold text-green-600 mb-4">
            Rp <?php echo number_format($produk['harga']); ?>
        </p>

        <!-- STOK -->
        <p class="text-sm text-gray-500 mb-4">
            Stok tersedia: <?php echo $produk['stok']; ?>
        </p>

        <!-- FORM BELI -->
        <form action="checkout.php" method="POST">

            <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">

            <!-- JUMLAH -->
            <label class="font-semibold">Jumlah</label>
            <input type="number" name="jumlah" 
            min="1" max="<?php echo $produk['stok']; ?>"
            required
            class="w-full border p-2 rounded mt-1 mb-4">

            <!-- BUTTON -->
            <button type="submit"
            class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg text-lg font-semibold">
                Beli Sekarang
            </button>

        </form>

        <!-- INFO TAMBAHAN -->
        <div class="mt-6 border-t pt-4 text-sm text-gray-500">
            <p>✔ Produk handmade</p>
            <p>✔ Bahan daun pandan asli</p>
            <p>✔ Kualitas terbaik</p>
        </div>

    </div>

</div>

<!-- DESKRIPSI BAWAH -->
<div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-bold mb-3">Deskripsi Produk</h3>
    <p class="text-gray-600">
        Produk ini merupakan kerajinan tangan berbahan dasar daun pandan 
        yang dibuat dengan teknik anyaman tradisional. Cocok digunakan 
        untuk kebutuhan sehari-hari maupun souvenir.
    </p>
</div>

</body>
</html>