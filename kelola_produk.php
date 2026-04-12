<?php
include "session.php";
include "koneksi.php";

$user = getValidSession();

// Jika session tidak aktif
if (!$user) {
    // Cek apakah ada Cookie "Remember Me"
    if (isset($_COOKIE['remember_token'])) {
        // Jika ada cookie, langsung lempar ke login page diam-diam (tanpa alert)
        header("Location: logpemilik.php");
        exit();
    } else {
        // Jika TIDAK ADA cookie, munculkan alert dan kembalikan ke login
        echo "<script>
            alert('Sesi Anda telah berakhir. Silakan login kembali.'); 
            window.location='logpemilik.php';
        </script>";
        exit();
    }
}

/* SIMPAN / UPDATE */
if(isset($_POST['simpan'])){
    $id = $_POST['id_produk'];
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $status = $_POST['status_produk'];

    // AUTO STOK
    if($status == "Tidak Tersedia"){
        $stok = 0;
    } else {
        $stok = $_POST['stok'];
    }

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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - PandCraft</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        brand: {
                            light: '#f0fdf4',
                            DEFAULT: '#2e7d32',
                            dark: '#1b4332',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Select styling */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }
    </style>
</head>

<body class="font-sans bg-brand-light bg-[url('ok.jpeg')] bg-cover bg-fixed bg-center min-h-screen text-gray-800 flex flex-col">

    <nav class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-green-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="text-2xl font-serif font-bold text-brand-dark">
                    PandCraft<span class="text-brand">.</span>
                </div>
                <div class="h-6 w-px bg-gray-300"></div>
                <span class="text-sm font-medium text-gray-500 tracking-wide uppercase">Panel Pemilik</span>
            </div>
            
            <a href="dashboardpemilik.php" class="flex items-center gap-2 text-sm font-medium text-brand-dark hover:text-brand bg-green-50 hover:bg-green-100 border border-green-200 px-5 py-2.5 rounded-xl transition duration-300 shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="flex-grow p-6">
        <div class="max-w-6xl mx-auto mt-6">
            
            <div class="flex items-center mb-8">
                <div class="bg-brand text-white w-14 h-14 rounded-2xl flex items-center justify-center shadow-md shadow-green-200 mr-4 text-2xl">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-serif font-bold text-brand-dark mb-1">Kelola Produk</h2>
                    <p class="text-sm text-gray-500">Tambah, edit, atau hapus data produk kerajinan PandCraft.</p>
                </div>
            </div>

            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-xl border border-green-50 overflow-hidden mb-10">
                <div class="bg-green-50/50 px-8 py-5 border-b border-green-100 flex items-center gap-3">
                    <i class="fa-solid fa-pen-to-square text-brand"></i>
                    <h3 class="text-lg font-semibold text-brand-dark">Formulir Produk</h3>
                </div>
                
                <form method="POST" enctype="multipart/form-data" class="p-8">
                    <input type="hidden" name="id_produk" id="id_produk">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
                            <select name="nama_produk" id="nama_produk" required
                                class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand/50 focus:border-brand transition-colors bg-white">
                                <option value="">-- Pilih Produk --</option>
                                <option value="Tas Anyam Pandan">Tas Anyam Pandan</option>
                                <option value="Keranjang Anyam Pandan">Keranjang Anyam Pandan</option>
                                <option value="Dompet Anyam Pandan">Dompet Anyam Pandan</option>
                                <option value="Tikar Anyam Pandan">Tikar Anyam Pandan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-medium">Rp</span>
                                <input type="number" name="harga" id="harga" required placeholder="Contoh: 50000"
                                    class="w-full border border-gray-300 pl-12 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand/50 focus:border-brand transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status Produk</label>
                            <select name="status_produk" id="status_produk" onchange="toggleStok()" required
                                class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand/50 focus:border-brand transition-colors bg-white">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Tidak Tersedia">Tidak Tersedia</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Stok</label>
                            <input type="number" name="stok" id="stok" required placeholder="0"
                                class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand/50 focus:border-brand transition-colors disabled:bg-gray-100 disabled:text-gray-400">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Produk (Biarkan kosong jika tidak diubah)</label>
                            <input type="file" name="gambar" accept="image/*"
                                class="w-full text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-brand hover:file:bg-green-100 transition-colors border border-gray-300 rounded-xl bg-white cursor-pointer">
                        </div>

                    </div>

                    <div class="mt-8 flex gap-4 pt-6 border-t border-gray-100">
                        <button type="submit" name="simpan"
                            class="bg-brand hover:bg-brand-dark text-white font-medium px-8 py-3 rounded-xl shadow-md shadow-green-200 transition-all duration-300 flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                        </button>
                        <button type="reset" onclick="resetForm()"
                            class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium px-8 py-3 rounded-xl transition-all duration-300 flex items-center gap-2">
                            <i class="fa-solid fa-rotate-left"></i> Batal / Reset
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-xl border border-green-50 overflow-hidden mb-8">
                <div class="bg-green-50/50 px-8 py-5 border-b border-green-100 flex items-center gap-3">
                    <i class="fa-solid fa-list text-brand"></i>
                    <h3 class="text-lg font-semibold text-brand-dark">Daftar Produk</h3>
                </div>

                <div class="overflow-x-auto p-4">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 font-medium text-sm uppercase tracking-wider border-b border-gray-200">
                                <th class="px-6 py-4 rounded-tl-xl text-center">ID</th>
                                <th class="px-6 py-4">Info Produk</th>
                                <th class="px-6 py-4">Harga</th>
                                <th class="px-6 py-4 text-center">Stok</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            
                            <?php while($row = mysqli_fetch_array($data)){ ?>
                            <tr class="hover:bg-green-50/30 transition duration-200 group">
                                <td class="px-6 py-4 text-center text-gray-500 font-medium">#<?php echo $row['id_produk']; ?></td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <?php if($row['gambar']): ?>
                                            <img src="gambar_produk/<?php echo $row['gambar']; ?>" class="w-14 h-14 object-cover rounded-xl shadow-sm border border-gray-100" alt="Produk">
                                        <?php else: ?>
                                            <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 border border-gray-200">
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                        <span class="font-semibold text-gray-800 text-base"><?php echo $row['nama_produk']; ?></span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <span class="text-brand font-bold">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                                </td>
                                
                                <td class="px-6 py-4 text-center">
                                    <span class="font-medium text-gray-700 bg-gray-100 px-3 py-1 rounded-lg"><?php echo $row['stok']; ?></span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="px-4 py-1.5 rounded-full text-xs font-bold border
                                    <?php echo ($row['status_produk']=='Tersedia') 
                                    ? 'bg-green-50 text-green-700 border-green-200' 
                                    : 'bg-red-50 text-red-600 border-red-200'; ?>">
                                        <?php echo $row['status_produk']; ?>
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button onclick="editProduk(
                                            '<?php echo $row['id_produk']; ?>',
                                            '<?php echo $row['nama_produk']; ?>',
                                            '<?php echo $row['harga']; ?>',
                                            '<?php echo $row['stok']; ?>',
                                            '<?php echo $row['status_produk']; ?>'
                                        )" title="Edit" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <a href="kelola_produk.php?hapus=<?php echo $row['id_produk']; ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" title="Hapus"
                                        class="w-9 h-9 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php if(mysqli_num_rows($data) == 0): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="text-gray-300 mb-3"><i class="fa-solid fa-box-open text-4xl"></i></div>
                                    <p class="font-medium">Belum ada produk.</p>
                                    <p class="text-sm mt-1">Silakan tambahkan produk baru melalui formulir di atas.</p>
                                </td>
                            </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <footer class="pb-8 text-center text-sm text-gray-500">
                &copy; <?= date("Y") ?> PandCraft. Hak Cipta Dilindungi.
            </footer>

        </div>
    </main>

    <script>
    function toggleStok(){
        let status = document.getElementById("status_produk").value;
        let stok = document.getElementById("stok");

        if(status === "Tidak Tersedia"){
            stok.value = 0;
            stok.disabled = true;
            // Tambahkan class visual untuk field disabled
            stok.classList.add('bg-gray-100', 'text-gray-400');
        } else {
            stok.disabled = false;
            // Hapus class visual disabled
            stok.classList.remove('bg-gray-100', 'text-gray-400');
        }
    }

    function editProduk(id, nama, harga, stokVal, status){
        document.getElementById('id_produk').value = id;
        document.getElementById('nama_produk').value = nama;
        document.getElementById('harga').value = harga;
        document.getElementById('stok').value = stokVal;
        document.getElementById('status_produk').value = status;

        toggleStok(); // Biar langsung ngefek

        // Scroll otomatis ke atas (ke arah form) dengan smooth
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        
        // Highlight form sebentar untuk indikasi
        let formContainer = document.querySelector('form');
        formContainer.classList.add('ring-4', 'ring-brand/20', 'rounded-xl');
        setTimeout(() => {
            formContainer.classList.remove('ring-4', 'ring-brand/20', 'rounded-xl');
        }, 1500);
    }

    function resetForm(){
        document.getElementById('id_produk').value = "";
        setTimeout(toggleStok, 50); // Reset stok visual setelah form ter-reset
    }
    
    // Inisialisasi awal
    toggleStok();
    </script>

</body>
</html>