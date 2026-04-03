<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Website PandCraft</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col items-center gap-6 bg-cover bg-center"
style="background-image: linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),url('anyam.png');">

<header class="w-full bg-[#1e1e1e] px-6 py-4 border-b-4 border-[#2e7d32] text-[#2e7d32] font-bold text-xl">
Website PandCraft
</header>

<h2 class="text-white text-3xl mt-5">Selamat Datang</h2>
<div class="bg-white p-6 w-80 rounded-xl text-center shadow-lg">

<h3 class="mb-4 font-semibold">Login Sebagai</h3>

<!-- Pemilik -->
<button onclick="window.location.href='logpemilik.php'" 
class="w-full p-3 bg-green-500 text-white rounded mb-2">
Pemilik
</button>

<!-- Pembeli -->
<button onclick="window.location.href='logpembeli.php'" 
class="w-full p-3 bg-green-500 text-white rounded mb-2">
Pembeli
</button>

<!-- Admin -->
<button onclick="window.location.href='logadmin.php'" 
class="w-full p-3 bg-green-500 text-white rounded">
Admin
</button>

</div>