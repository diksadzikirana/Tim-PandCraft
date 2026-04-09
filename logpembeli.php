<?php
include "session.php";
include "koneksi.php";

$rememberedUser = $_COOKIE['remember_user'] ?? "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    //  divalidasi berdasarkan database di tb_user
    $query = "SELECT * FROM tb_user 
              WHERE nama='$nama' 
              AND password='$password' 
              AND role='pembeli'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        createSession([
            "user" => $nama,
            "role" => "pembeli"
        ]);

        echo "<script>alert('Login Pembeli berhasil!'); window.location='katalog.php';</script>";
    } else {
        echo "<script>alert('Login gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pembeli - PandCraft</title>
    
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
                            light: '#f0fdf4', // Light green background fallback
                            DEFAULT: '#2e7d32', // Original green
                            dark: '#1b4332', // Deep forest green
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans bg-brand-light bg-[url('ok.jpeg')] bg-cover bg-center bg-no-repeat min-h-screen flex flex-col items-center justify-center text-gray-800 p-6">

    <div class="bg-white p-10 md:p-12 w-full max-w-md rounded-3xl shadow-xl border border-green-50 relative overflow-hidden">
        
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-green-50 rounded-full blur-2xl opacity-70"></div>
        
        <div class="text-center mb-10 relative z-10">
            <div class="text-4xl font-serif font-bold text-brand-dark mb-2">
                PandCraft<span class="text-brand">.</span>
            </div>
            <h2 class="text-gray-500 font-medium">Portal Akses <span class="text-brand font-semibold">Pembeli</span></h2>
        </div>

        <form method="POST" class="relative z-10 space-y-5">
            
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Pengguna</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($rememberedUser) ?>" placeholder="Masukkan nama Anda" required
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand outline-none transition bg-gray-50 focus:bg-white text-gray-700">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand outline-none transition bg-gray-50 focus:bg-white text-gray-700">
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" <?= $rememberedUser ? 'checked' : '' ?> 
                    class="w-4 h-4 text-brand bg-gray-100 border-gray-300 rounded focus:ring-brand focus:ring-2 accent-brand cursor-pointer">
                <label for="remember" class="ml-2 text-sm font-medium text-gray-600 cursor-pointer">
                    Ingat Saya (Remember Me)
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 mt-4 bg-brand text-white font-medium rounded-xl hover:bg-brand-dark transition shadow-lg shadow-green-200">
                Masuk
            </button>

        </form>

        <div class="mt-8 text-center relative z-10 flex flex-col gap-3">
            <a href="beranda.php" class="text-sm font-medium text-gray-500 hover:text-brand transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda

    </div>

</body>
</html>