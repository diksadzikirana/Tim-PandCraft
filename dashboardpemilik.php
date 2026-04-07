<?php
include "session.php";

$user = getValidSession();

//  kalau belum login / session habis
if (!$user) {
    echo "<script>alert('Session habis! Silakan login ulang'); window.location='logpemilik.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pemilik</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen 
bg-[linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),url('anyam.png')] 
bg-cover bg-center">

<!--  Tombol Logout -->
<a href="logoutpemilik.php"
class="absolute top-5 right-5 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
    Logout
</a>

<div class="flex flex-col justify-center items-center min-h-screen text-center text-white">

    <!-- Judul -->
    <h1 class="text-5xl font-bold mb-4">
        Dashboard Pemilik
    </h1>

    <!-- Info user -->
    <!-- <p class="mb-6 text-green-200">
        Login sebagai: <b><?php echo $user['user']; ?></b>
    </p> -->

    <hr class="w-1/2 mb-6 border-white/30">

    <h2 class="text-2xl mb-6">Menu Utama</h2>

    <div class="bg-white/20 backdrop-blur-lg p-10 rounded-2xl grid grid-cols-2 gap-5 shadow-lg">

        <a href="kelola_produk.php"
        class="p-4 bg-green-700 rounded-xl hover:bg-green-800">
            Kelola Produk
        </a>

        <a href="#"
        class="p-4 bg-green-700 rounded-xl hover:bg-green-800">
            Kelola Pesanan
        </a>

        <a href="#"
        class="p-4 bg-green-700 rounded-xl hover:bg-green-800">
            Kelola Pembayaran
        </a>

        <a href="#"
        class="p-4 bg-green-700 rounded-xl hover:bg-green-800">
            Riwayat Penjualan
        </a>

    </div>

</div>

</body>
</html>