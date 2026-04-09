<?php
include "koneksi.php";

$pesan_masuk = mysqli_query($conn, "
SELECT p.*, pb.nama_pembeli, pr.nama_produk
FROM tb_pesanan p
JOIN tb_pembeli pb ON p.id_pembeli = pb.id_pembeli
JOIN tb_detail_pesanan d ON p.id_pesanan = d.id_pesanan
JOIN tb_produk pr ON d.id_produk = pr.id_produk
WHERE p.status_pesanan = 'Menunggu'
ORDER BY p.id_pesanan DESC
");

$semua = mysqli_query($conn, "
SELECT p.*, pb.nama_pembeli, pr.nama_produk
FROM tb_pesanan p
JOIN tb_pembeli pb ON p.id_pembeli = pb.id_pembeli
JOIN tb_detail_pesanan d ON p.id_pesanan = d.id_pesanan
JOIN tb_produk pr ON d.id_produk = pr.id_produk
ORDER BY p.id_pesanan DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kelola Pesanan - Admin Panel</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-b from-green-50 via-white to-gray-50 min-h-screen text-gray-800 font-sans antialiased">

<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 pb-6 border-b border-green-200 gap-4 sm:gap-0">
        <div>
            <h1 class="text-3xl font-extrabold text-green-700 flex items-center gap-3 tracking-tight">
                <i class="fa-solid fa-boxes-stacked text-2xl"></i> Kelola Pesanan
            </h1>
            <p class="text-sm text-gray-500 mt-2 ml-1">Pantau dan kelola semua pesanan pelanggan Anda di sini.</p>
        </div>

        <a href="dashboardpemilik.php"
        class="bg-white border border-gray-300 hover:bg-gray-50 hover:text-green-600 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all duration-200 flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="mb-14">
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-yellow-100 p-2.5 rounded-lg text-yellow-600">
                <i class="fa-solid fa-bell text-xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">
                Perlu Diproses <span class="text-sm font-medium bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full ml-2 align-middle">Menunggu</span>
            </h2>
        </div>

        <?php if(mysqli_num_rows($pesan_masuk) == 0){ ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center flex flex-col items-center justify-center">
                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486831.png" alt="Kosong" class="w-24 h-24 opacity-30 mb-4 grayscale">
                <p class="text-gray-500 font-medium text-lg">Hore! Tidak ada pesanan baru yang tertunda.</p>
            </div>
        <?php } else { ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while($row = mysqli_fetch_array($pesan_masuk)){ ?>
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-gray-100 overflow-hidden transition-all duration-300 flex flex-col h-full relative">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-yellow-400"></div>
                    
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2 pr-2">
                                <?php echo $row['nama_produk']; ?>
                            </h3>
                            <span class="bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-bold px-2.5 py-1 rounded-md whitespace-nowrap">
                                Baru
                            </span>
                        </div>
                        
                        <div class="space-y-2 mt-4 text-sm text-gray-600">
                            <p class="flex items-center gap-2">
                                <i class="fa-solid fa-user text-gray-400 w-4 text-center"></i> 
                                <span class="font-medium text-gray-700"><?php echo $row['nama_pembeli']; ?></span>
                            </p>
                            <p class="flex items-center gap-2">
                                <i class="fa-solid fa-hashtag text-gray-400 w-4 text-center"></i> 
                                Order ID: #<?php echo str_pad($row['id_pesanan'], 4, '0', STR_PAD_LEFT); ?>
                            </p>
                        </div>
                        
                        <div class="mt-5 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">Total Belanja</p>
                            <p class="text-xl font-extrabold text-green-600">
                                Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?>
                            </p>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-50 border-t border-gray-100">
                        <a href="detail_pesanan_admin.php?id=<?php echo $row['id_pesanan']; ?>"
                        class="block w-full text-center bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold transition shadow-sm hover:shadow">
                            Lihat Pesanan <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-green-100 p-2.5 rounded-lg text-green-700">
                <i class="fa-solid fa-list-check text-xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">
                Semua Riwayat Pesanan
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-green-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left whitespace-nowrap">
                    <thead class="bg-green-50 text-green-800 uppercase font-bold text-xs tracking-wider border-b border-green-100">
                        <tr>
                            <th scope="col" class="py-4 px-6 w-16 text-center">No</th>
                            <th scope="col" class="py-4 px-6">Informasi Produk</th>
                            <th scope="col" class="py-4 px-6">Nama Pembeli</th>
                            <th scope="col" class="py-4 px-6">Total Tagihan</th>
                            <th scope="col" class="py-4 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <?php $no=1; while($row = mysqli_fetch_array($semua)){ ?>
                        <tr class="hover:bg-green-50/50 transition-colors duration-200">
                            
                            <td class="py-4 px-6 text-center text-gray-500 font-medium">
                                <?php echo $no++; ?>
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-bold text-gray-900"><?php echo $row['nama_produk']; ?></div>
                                <div class="text-xs text-gray-400 mt-1">ID: #<?php echo str_pad($row['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></div>
                            </td>

                            <td class="py-4 px-6 font-medium text-gray-700">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-xs font-bold">
                                        <?php echo substr($row['nama_pembeli'], 0, 1); ?>
                                    </div>
                                    <?php echo $row['nama_pembeli']; ?>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <span class="font-bold text-green-600 text-base">
                                    Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?>
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center">
                                <?php
                                    // Menentukan warna badge berdasarkan status
                                    $bgClass = '';
                                    $textClass = '';
                                    $iconClass = '';
                                    
                                    if($row['status_pesanan'] == "Menunggu"){
                                        $bgClass = 'bg-yellow-100 border-yellow-200';
                                        $textClass = 'text-yellow-700';
                                        $iconClass = 'fa-clock';
                                    } elseif($row['status_pesanan'] == "Dikirim"){
                                        $bgClass = 'bg-blue-100 border-blue-200';
                                        $textClass = 'text-blue-700';
                                        $iconClass = 'fa-truck-fast';
                                    } else { // Selesai
                                        $bgClass = 'bg-green-100 border-green-200';
                                        $textClass = 'text-green-700';
                                        $iconClass = 'fa-circle-check';
                                    }
                                ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border <?php echo $bgClass; ?> <?php echo $textClass; ?>">
                                    <i class="fa-solid <?php echo $iconClass; ?>"></i>
                                    <?php echo $row['status_pesanan']; ?>
                                </span>
                            </td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="bg-gray-50 border-t border-gray-100 p-4 text-center sm:text-right text-sm text-gray-500">
                Menampilkan semua riwayat pesanan.
            </div>
        </div>
    </div>

</div>

</body>
</html>