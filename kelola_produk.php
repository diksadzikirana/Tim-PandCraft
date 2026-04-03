<?php
include "session.php";

$user = getValidSession();

//  kalau belum login
if (!$user) {
    echo "<script>alert('Session habis! Silakan login ulang'); window.location='logpemilik.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans m-0 p-0 
bg-[linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),url('anyam.png')]">

<!-- Judul -->
<h3 class="text-center text-white mt-[20px] text-[26px] 
[text-shadow:2px_2px_6px_rgba(0,0,0,0.6)]">
    Kelola Data Produk Kerajinan Daun Pandan
</h3>

<!-- Tombol kembali -->
<div class="w-[80%] mx-auto mt-[20px] flex justify-between">

    <!-- Kembali -->
    <a href="dashboardpemilik.php"
    class="bg-white text-[#1b5e20] px-[15px] py-[8px] no-underline rounded-[8px] font-bold 
    shadow-[0_4px_12px_rgba(0,0,0,0.2)] hover:bg-[#dcedc8]">
        ← Kembali
    </a>

</div>

<hr class="w-[80%] mx-auto my-[20px]">

<!-- Sub Judul -->
<h2 class="text-center text-[#e8f5e9]">
    Tambah / Edit Produk
</h2>

<!-- Form -->
<form id="formProduk" novalidate
class="w-[80%] mx-auto my-[20px] bg-[#fdfdfd] p-[25px] rounded-[12px] 
shadow-[0_10px_25px_rgba(0,0,0,0.25)]">

<input type="hidden" id="id_produk">

<label>Nama Produk:</label><br>
<select id="nama_produk"
class="w-full p-[10px] mt-[5px] mb-[15px] rounded-[8px] border border-[#bbb]">
    <option value="">Pilih Produk</option>
    <option value="Tas Anyam Pandan">Tas Anyam Pandan</option>
    <option value="Keranjang Anyam Pandan">Keranjang Anyam Pandan</option>
    <option value="Dompet Anyam Pandan">Dompet Anyam Pandan</option>
    <option value="Tikar Anyam Pandan">Tikar Anyam Pandan</option>
</select>

<label>Kategori:</label><br>
<select id="kategori" required
class="w-full p-[10px] mt-[5px] mb-[15px] rounded-[8px] border border-[#bbb]">
    <option value="">Pilih Kategori</option>
    <option value="Tas">Tas</option>
    <option value="Keranjang">Keranjang</option>
    <option value="Dompet">Dompet</option>
    <option value="Tikar">Tikar</option>
</select>

<label>Harga (Rp):</label><br>
<input type="number" id="harga" min="0" required
class="w-full p-[10px] mt-[5px] mb-[15px] rounded-[8px] border border-[#bbb]">

<label>Stok:</label><br>
<input type="number" id="stok" min="0" required
class="w-full p-[10px] mt-[5px] mb-[15px] rounded-[8px] border border-[#bbb]">

<label>Status Produk:</label><br>
<textarea id="status_produk" required
class="w-full p-[10px] mt-[5px] mb-[15px] rounded-[8px] border border-[#bbb]"></textarea>

<button type="submit"
class="px-[18px] py-[10px] border-none rounded-[8px] bg-[#2e7d32] text-white font-bold cursor-pointer hover:bg-[#145a1f]">
    Simpan Produk
</button>

<button type="reset"
class="px-[18px] py-[10px] border-none rounded-[8px] bg-[#2e7d32] text-white font-bold cursor-pointer hover:bg-[#145a1f] ml-[10px]">
    Reset
</button>

<button type="button"
class="px-[18px] py-[10px] border-none rounded-[8px] bg-red-600 text-white font-bold cursor-pointer hover:bg-[#145a1f] ml-[10px]">
    Hapus
</button>

</form>

<hr class="w-[80%] mx-auto my-[20px]">

<!-- Daftar Produk -->
<h2 class="text-center text-[#e8f5e9]">
    Daftar Produk
</h2>

<!-- Table -->
<table id="tabelProduk"
class="w-[80%] mx-auto my-[20px] border-collapse bg-white rounded-[12px] overflow-hidden 
shadow-[0_10px_25px_rgba(0,0,0,0.25)]">

<thead>
<tr class="bg-[#1b5e20] text-white">
    <th class="p-[12px]">ID</th>
    <th class="p-[12px]">Nama</th>
    <th class="p-[12px]">Kategori</th>
    <th class="p-[12px]">Harga</th>
    <th class="p-[12px]">Stok</th>
    <th class="p-[12px]">Status Produk</th>
</tr>
</thead>

<tbody>
    <!-- Data produk -->
</tbody>

</table>

<script src="pandcraft.js"></script>

</body>
</html>