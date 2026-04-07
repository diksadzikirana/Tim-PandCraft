<?php
include "session.php";
include "koneksi.php";

$user = getValidSession();

if (!$user) {
    echo "<script>alert('Session habis! Silakan login ulang'); window.location='logpemilik.php';</script>";
    exit();
}

/* SIMPAN / UPDATE */
if(isset($_POST['simpan'])){
    $id = $_POST['id_produk'];
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $status = $_POST['status_produk'];

    // upload gambar
    $namaFile = $_FILES['gambar']['name'];
    $tmpFile = $_FILES['gambar']['tmp_name'];

    if($namaFile != ""){
        move_uploaded_file($tmpFile, "gambar_produk/".$namaFile);
    }

    if($id == ""){
        mysqli_query($conn,"INSERT INTO tb_produk 
        (nama_produk,harga,stok,status_produk,gambar)
        VALUES('$nama','$harga','$stok','$status','$namaFile')");
    } else {
        if($namaFile != ""){
            mysqli_query($conn,"UPDATE tb_produk SET
            nama_produk='$nama',
            harga='$harga',
            stok='$stok',
            status_produk='$status',
            gambar='$namaFile'
            WHERE id_produk='$id'");
        } else {
            mysqli_query($conn,"UPDATE tb_produk SET
            nama_produk='$nama',
            harga='$harga',
            stok='$stok',
            status_produk='$status'
            WHERE id_produk='$id'");
        }
    }

    echo "<script>window.location='kelola_produk.php';</script>";
}

/* HAPUS */
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn,"DELETE FROM tb_produk WHERE id_produk='$id'");
    echo "<script>window.location='kelola_produk.php';</script>";
}

/* AMBIL DATA */
$data = mysqli_query($conn,"SELECT * FROM tb_produk");
?>

<!DOCTYPE html>
<html>
<head>
<title>Kelola Produk</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans m-0 p-0 
bg-[linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),url('anyam.png')] bg-cover">

<h3 class="text-center text-white mt-6 text-3xl font-bold">
Kelola Data Produk Kerajinan Daun Pandan
</h3>

<div class="w-4/5 mx-auto mt-5">
<a href="dashboardpemilik.php"
class="bg-white text-green-800 px-4 py-2 rounded font-bold shadow">
← Kembali
</a>
</div>

<hr class="w-4/5 mx-auto my-6">

<h2 class="text-center text-green-100 text-xl font-semibold">
Tambah / Edit Produk
</h2>

<!-- FORM -->
<form method="POST" enctype="multipart/form-data"
class="w-4/5 mx-auto my-5 bg-white p-6 rounded-lg shadow">

<input type="hidden" name="id_produk" id="id_produk">

<label class="font-semibold">Nama Produk:</label>
<select name="nama_produk" id="nama_produk"
class="w-full border p-2 rounded mt-1 mb-3">
<option value="">Pilih Produk</option>
<option value="Tas Anyam Pandan">Tas Anyam Pandan</option>
<option value="Keranjang Anyam Pandan">Keranjang Anyam Pandan</option>
<option value="Dompet Anyam Pandan">Dompet Anyam Pandan</option>
<option value="Tikar Anyam Pandan">Tikar Anyam Pandan</option>
</select>

<label class="font-semibold">Harga:</label>
<input type="number" name="harga" id="harga"
class="w-full border p-2 rounded mt-1 mb-3">

<label class="font-semibold">Stok:</label>
<input type="number" name="stok" id="stok"
class="w-full border p-2 rounded mt-1 mb-3">

<label class="font-semibold">Status Produk:</label>
<input type="text" name="status_produk" id="status_produk"
class="w-full border p-2 rounded mt-1 mb-3">

<label class="font-semibold">Foto Produk:</label>
<input type="file" name="gambar"
class="w-full border p-2 rounded mt-1 mb-4">

<button type="submit" name="simpan"
class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded">
Simpan Produk
</button>

<button type="reset"
class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded ml-2">
Reset
</button>

</form>

<hr class="w-4/5 mx-auto my-6">

<h2 class="text-center text-green-100 text-xl font-semibold">
Daftar Produk
</h2>

<!-- TABEL -->
<table class="w-4/5 mx-auto my-5 border-collapse bg-white shadow rounded">

<tr class="bg-green-700 text-white">
<th class="p-3">ID</th>
<th class="p-3">Nama</th>
<th class="p-3">Harga</th>
<th class="p-3">Stok</th>
<th class="p-3">Status</th>
<th class="p-3">Foto</th>
<th class="p-3">Aksi</th>
</tr>

<?php while($row = mysqli_fetch_array($data)){ ?>
<tr class="text-center border-b hover:bg-gray-100">
<td class="p-2"><?php echo $row['id_produk']; ?></td>
<td><?php echo $row['nama_produk']; ?></td>
<td><?php echo $row['harga']; ?></td>
<td><?php echo $row['stok']; ?></td>
<td><?php echo $row['status_produk']; ?></td>

<td>
<img src="gambar_produk/<?php echo $row['gambar']; ?>" width="60">
</td>

<td class="space-x-2">
<button onclick="editProduk(
'<?php echo $row['id_produk']; ?>',
'<?php echo $row['nama_produk']; ?>',
'<?php echo $row['harga']; ?>',
'<?php echo $row['stok']; ?>',
'<?php echo $row['status_produk']; ?>'
)" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
Edit
</button>

<a href="kelola_produk.php?hapus=<?php echo $row['id_produk']; ?>"
onclick="return confirm('Hapus produk?')"
class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
Hapus
</a>
</td>
</tr>
<?php } ?>

</table>

<script>
function editProduk(id,nama,harga,stok,status){
document.getElementById('id_produk').value = id;
document.getElementById('nama_produk').value = nama;
document.getElementById('harga').value = harga;
document.getElementById('stok').value = stok;
document.getElementById('status_produk').value = status;
}
</script>

</body>
</html>