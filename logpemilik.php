<?php
// Pastikan session sudah berjalan di file session.php atau jalankan session_start() di sini
include "session.php";
include "koneksi.php";

// ==========================================
// 1. CEK AUTO-LOGIN DARI COOKIE (TOKEN VALIDASI)
// ==========================================
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    
    // Cari token di database
    $stmt_token = $conn->prepare("SELECT nama, role FROM tb_user WHERE remember_token = ? AND role = 'pemilik'");
    $stmt_token->bind_param("s", $token);
    $stmt_token->execute();
    $result_token = $stmt_token->get_result();

    if ($row = $result_token->fetch_assoc()) {
        // Token valid! Auto-login dengan membuat session
        createSession([
            "user" => $row['nama'],
            "role" => "pemilik"
        ]);
        
        // Langsung arahkan ke dashboard tanpa perlu isi form lagi
        header("Location: dashboardpemilik.php");
        exit();
    }
}

// Untuk fitur pre-fill username (jika tidak auto-login)
$rememberedUser = $_COOKIE['remember_user'] ?? "";

// ==========================================
// 2. PROSES LOGIN MANUAL (POST DARI FORM)
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    // KEAMANAN: Gunakan Prepared Statement untuk mencegah SQL Injection!
    $stmt = $conn->prepare("SELECT nama FROM tb_user WHERE nama = ? AND password = ? AND role = 'pemilik'");
    $stmt->bind_param("ss", $nama, $password); // 'ss' berarti string, string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        // 3. LOGIKA "REMEMBER ME" SAAT LOGIN BERHASIL
        if (isset($_POST['remember'])) {
            // Buat token acak yang aman sepanjang 64 karakter
            $token = bin2hex(random_bytes(32));
            
            // Simpan token tersebut ke database pengguna ini
            $update_token = $conn->prepare("UPDATE tb_user SET remember_token = ? WHERE nama = ?");
            $update_token->bind_param("ss", $token, $nama);
            $update_token->execute();

            // Simpan token dan nama di Cookie browser selama 30 hari
            setcookie("remember_token", $token, time() + (86400 * 30), "/");
            setcookie("remember_user", $nama, time() + (86400 * 30), "/");
        } else {
            // Jika tidak dicentang, hapus token di DB dan hapus cookie di browser
            $hapus_token = $conn->prepare("UPDATE tb_user SET remember_token = NULL WHERE nama = ?");
            $hapus_token->bind_param("s", $nama);
            $hapus_token->execute();

            setcookie("remember_token", "", time() - 3600, "/");
            setcookie("remember_user", "", time() - 3600, "/");
        }

        // Buat Session standar
        createSession([
            "user" => $nama,
            "role" => "pemilik"
        ]);

        echo "<script>alert('Login Pemilik berhasil!'); window.location='dashboardpemilik.php';</script>";
    } else {
        echo "<script>alert('Login gagal! Nama atau Kata Sandi salah.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pemilik - PandCraft</title>
    
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
</head>

<body class="font-sans bg-brand-light bg-[url('ok.jpeg')] bg-cover bg-center bg-no-repeat min-h-screen flex flex-col items-center justify-center text-gray-800 p-6">

    <div class="bg-white p-10 md:p-12 w-full max-w-md rounded-3xl shadow-xl border border-green-50 relative overflow-hidden">
        
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-green-50 rounded-full blur-2xl opacity-70"></div>
        
        <div class="text-center mb-10 relative z-10">
            <div class="text-4xl font-serif font-bold text-brand-dark mb-2">
                PandCraft<span class="text-brand">.</span>
            </div>
            <h2 class="text-gray-500 font-medium">Portal Akses <span class="text-brand font-semibold">Pemilik</span></h2>
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
                Masuk ke Dashboard
            </button>

        </form>

        <div class="mt-8 text-center relative z-10">
            <a href="beranda.php" class="text-sm font-medium text-gray-500 hover:text-brand transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

    </div>

</body>
</html>