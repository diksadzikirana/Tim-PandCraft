<?php
include "koneksi.php";

$data = mysqli_query($conn, "
SELECT
p.id_pesanan,
p.total_harga,
p.status_pesanan,
pb.nama_pembeli,
pr.nama_produk,
pay.status_pembayaran
FROM tb_pesanan p
JOIN tb_pembeli pb ON p.id_pembeli = pb.id_pembeli
JOIN tb_detail_pesanan d ON p.id_pesanan = d.id_pesanan
JOIN tb_produk pr ON d.id_produk = pr.id_produk
LEFT JOIN tb_pembayaran pay ON p.id_pesanan = pay.id_pesanan
ORDER BY p.id_pesanan DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan Admin - PandCraft</title>
    
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
        /* Custom Select Styles to remove default arrow and add a nicer one */
        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
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
                <span class="text-sm font-medium text-gray-500 tracking-wide uppercase">Admin Panel</span>
            </div>
            
            <a href="logoutadmin.php" class="flex items-center gap-2 text-sm font-medium text-red-500 hover:text-white border border-red-200 hover:bg-red-500 hover:border-red-500 px-5 py-2.5 rounded-xl transition duration-300 shadow-sm">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
            </a>
        </div>
    </nav>

    <main class="flex-grow p-6">
        <div class="max-w-7xl mx-auto mt-6">
            
            <div class="flex items-center mb-8">
                <div class="bg-brand text-white p-3 rounded-xl shadow-md shadow-green-200 mr-4">
                    <i class="fa-solid fa-box-open text-xl"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-serif font-bold text-brand-dark mb-1">Kelola Pesanan</h2>
                    <p class="text-sm text-gray-500">Pantau dan perbarui status pesanan pelanggan Anda di sini.</p>
                </div>
            </div>

            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-xl border border-green-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-green-50/80 text-brand-dark font-medium border-b border-green-100">
                                <th class="px-6 py-5 text-center w-16">No</th>
                                <th class="px-6 py-5">Produk</th>
                                <th class="px-6 py-5">Pembeli</th>
                                <th class="px-6 py-5">Total</th>
                                <th class="px-6 py-5 text-center">Status Pesanan</th>
                                <th class="px-6 py-5 text-center">Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            
                            <?php $no=1; while($row = mysqli_fetch_array($data)){ ?>
                            <tr class="hover:bg-green-50/40 transition duration-200">
                                <td class="px-6 py-4 text-center text-gray-500"><?php echo $no++; ?></td>
                                
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-800"><?php echo $row['nama_produk']; ?></span>
                                </td>
                                
                                <td class="px-6 py-4 text-gray-600">
                                    <?php echo $row['nama_pembeli']; ?>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <span class="text-brand font-bold">
                                        Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?>
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <form action="update_status.php" method="POST" class="inline-block relative w-full max-w-[160px]">
                                        <input type="hidden" name="id" value="<?php echo $row['id_pesanan']; ?>">
                                        <select name="status" onchange="this.form.submit()"
                                            class="custom-select w-full cursor-pointer outline-none border-2 font-medium text-sm px-4 py-2.5 rounded-full shadow-sm transition-all duration-200 focus:ring-4 focus:ring-opacity-50
                                            <?php
                                            if($row['status_pesanan']=="Menunggu") 
                                                echo 'bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100 focus:ring-amber-200 focus:border-amber-400';
                                            elseif($row['status_pesanan']=="Dikirim") 
                                                echo 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100 focus:ring-blue-200 focus:border-blue-400';
                                            else 
                                                echo 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100 focus:ring-green-200 focus:border-green-400';
                                            ?>">
                                            
                                            <option value="Menunggu" class="text-amber-700 bg-white" <?php if($row['status_pesanan']=="Menunggu") echo "selected"; ?>>Menunggu</option>
                                            <option value="Dikirim" class="text-blue-700 bg-white" <?php if($row['status_pesanan']=="Dikirim") echo "selected"; ?>>Dikirim</option>
                                            <option value="Selesai" class="text-green-700 bg-white" <?php if($row['status_pesanan']=="Selesai") echo "selected"; ?>>Selesai</option>
                                        </select>
                                    </form>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <form action="update_pembayaran.php" method="POST" class="inline-block relative w-full max-w-[200px]">
                                        <input type="hidden" name="id" value="<?php echo $row['id_pesanan']; ?>">
                                        <select name="status_pembayaran" onchange="this.form.submit()"
                                            class="custom-select w-full cursor-pointer outline-none border-2 font-medium text-sm px-4 py-2.5 rounded-full shadow-sm transition-all duration-200 focus:ring-4 focus:ring-opacity-50
                                            <?php
                                            if($row['status_pembayaran']=="Pembayaran Berhasil") 
                                                echo 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100 focus:ring-green-200 focus:border-green-400';
                                            else 
                                                echo 'bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100 focus:ring-amber-200 focus:border-amber-400';
                                            ?>">
                                            
                                            <option value="Menunggu Pembayaran" class="text-amber-700 bg-white" <?php if($row['status_pembayaran']=="Menunggu Pembayaran") echo "selected"; ?>>Menunggu Pembayaran</option>
                                            <option value="Pembayaran Berhasil" class="text-green-700 bg-white" <?php if($row['status_pembayaran']=="Pembayaran Berhasil") echo "selected"; ?>>Pembayaran Berhasil</option>
                                        </select>
                                    </form>
                                </td>

                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
                
                <?php if(mysqli_num_rows($data) == 0): ?>
                <div class="text-center py-16">
                    <div class="text-gray-200 mb-4">
                        <i class="fa-solid fa-box-open text-6xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium text-lg">Belum ada pesanan yang masuk.</p>
                    <p class="text-gray-400 text-sm mt-1">Pesanan baru akan muncul di sini.</p>
                </div>
                <?php endif; ?>

            </div>
            
            <div class="mt-8 text-center text-sm text-gray-500 pb-6">
                &copy; <?= date("Y") ?> PandCraft. Hak Cipta Dilindungi.
            </div>

        </div>
    </main>

</body>
</html>