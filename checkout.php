<?php
include "koneksi.php";

$id = $_POST['id_produk'];
$jumlah = $_POST['jumlah'];

$data = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id_produk='$id'");
$produk = mysqli_fetch_array($data);

$total = $produk['harga'] * $jumlah;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- HEADER -->
<div class="flex justify-between items-center px-10 py-5 bg-white shadow">
    <h1 class="text-2xl font-bold text-green-500">Checkout</h1>
    <div class="space-x-6 text-gray-500">
        <span>Cart</span>
        <span>Review</span>
        <span class="text-orange-500 font-semibold">Checkout</span>
    </div>
</div>

<!-- CONTAINER -->
<div class="max-w-6xl mx-auto mt-10 grid md:grid-cols-2 gap-10">

    <!-- LEFT: FORM -->
    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-lg font-bold mb-4">Data Pembeli</h2>

        <form action="proses_pesanan.php" method="POST">

            <input type="hidden" name="id_produk" value="<?php echo $id; ?>">
            <input type="hidden" name="jumlah" value="<?php echo $jumlah; ?>">
            <input type="hidden" name="total" value="<?php echo $total; ?>">

            <!-- NAMA -->
            <label class="text-sm">Nama Lengkap</label>
            <input type="text" name="nama" required
            class="w-full border p-2 rounded mb-3">

            <!-- NO HP -->
            <label class="text-sm">No HP</label>
            <input type="text" name="no_hp" required
            class="w-full border p-2 rounded mb-3">

            <!-- ALAMAT -->
            <label class="text-sm">Alamat</label>
            <textarea name="alamat" required
            class="w-full border p-2 rounded mb-3"></textarea>

            <!-- METODE PEMBAYARAN -->
            <h2 class="text-lg font-bold mt-5 mb-3">Pembayaran</h2>

            <select name="metode" class="w-full border p-2 rounded mb-4">
                <option value="COD">COD (Bayar di Tempat)</option>
                <option value="Transfer">Transfer Bank</option>
            </select>

            <!-- BUTTON -->
            <button type="submit"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-semibold">
                Bayar Sekarang
            </button>

        </form>

    </div>

    <!-- RIGHT: RINGKASAN -->
    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-lg font-bold mb-4">Ringkasan Pesanan</h2>

        <!-- PRODUK -->
        <div class="flex items-center gap-4 mb-4">

            <img src="gambar_produk/<?php echo $produk['gambar']; ?>"
            class="w-20 h-20 object-cover rounded">

            <div>
                <p class="font-semibold">
                    <?php echo $produk['nama_produk']; ?>
                </p>
                <p class="text-sm text-gray-500">
                    Qty: <?php echo $jumlah; ?>
                </p>
            </div>

            <div class="ml-auto font-semibold">
                Rp <?php echo number_format($produk['harga']); ?>
            </div>

        </div>

        <hr class="my-4">

        <!-- TOTAL -->
        <div class="flex justify-between text-sm mb-2">
            <span>Subtotal</span>
            <span>Rp <?php echo number_format($total); ?></span>
        </div>

        <div class="flex justify-between text-sm mb-2">
            <span>Ongkir</span>
            <span>Rp 10,000</span>
        </div>

        <hr class="my-3">

        <div class="flex justify-between text-lg font-bold">
            <span>Total</span>
            <span class="text-orange-500">
                Rp <?php echo number_format($total + 10000); ?>
            </span>
        </div>

    </div>

</div>

</body>
</html>