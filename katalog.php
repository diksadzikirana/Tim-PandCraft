<?php
include "koneksi.php";

// Ambil data produk yang tersedia
$data = mysqli_query($conn, "SELECT * FROM tb_produk WHERE status_produk='Tersedia'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Katalog Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

<!-- HEADER -->
<div class="flex justify-between items-center px-10 py-5 bg-white shadow">
    <h1 class="text-2xl font-bold green-600">Katalog</h1>
    <div class="space-x-6 text-grey-600">
    </div>



        <!-- LOGOUT BUTTON -->
        <a href="logoutpembeli.php" 
        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded ml-4">
            Logout
        </a>
    </div>
</div>
</div>

<!-- TITLE -->
<h2 class="text-5xl font-bold px-10 mt-10">Produk</h2>

<!-- GRID PRODUK -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-10 py-10">

<?php while($row = mysqli_fetch_array($data)){ ?>

<div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">

    <!-- GAMBAR -->
    <div class="h-48 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden">
        <img src="gambar_produk/<?php echo $row['gambar']; ?>" 
        class="h-full object-contain">
    </div>

    <!-- NAMA PRODUK -->
    <h3 class="mt-4 text-lg font-semibold">
        <?php echo $row['nama_produk']; ?>
    </h3>

    <!-- DESKRIPSI -->
    <p class="text-sm text-gray-500">
        Produk kerajinan daun pandan
    </p>

    <!-- HARGA -->
    <p class="mt-2 font-bold text-green-700">
        Rp <?php echo number_format($row['harga']); ?>
    </p>

    <!-- STOK -->
    <p class="text-sm text-gray-500">
        Stok: <?php echo $row['stok']; ?>
    </p>

    <!-- BUTTON -->
    <?php if($row['stok'] > 0){ ?>
        <a href="detail_produk.php?id=<?php echo $row['id_produk']; ?>"
class="block text-center mt-3 w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-full">
    Beli
</a>
    <?php } else { ?>
        <button class="mt-3 w-full bg-gray-400 text-white py-2 rounded-full" disabled>
            Stok Habis
        </button>
    <?php } ?>

</div>

<?php } ?>

</div>

</body>
</html>