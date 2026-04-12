<?php
session_start();
include "koneksi.php"; // Panggil koneksi untuk mengubah data di database

// 1. (Opsional tapi penting untuk keamanan) Hapus token dari database
if (isset($_COOKIE['remember_user'])) {
    $nama = $_COOKIE['remember_user'];
    $hapus_token = $conn->prepare("UPDATE tb_user SET remember_token = NULL WHERE nama = ?");
    $hapus_token->bind_param("s", $nama);
    $hapus_token->execute();
}

// 2. Hancurkan Session
session_unset();
session_destroy();

// 3. Hapus Cookie di browser (dengan mengatur waktunya ke masa lalu)
setcookie("remember_token", "", time() - 3600, "/");

// Catatan: Jika ingin nama pengguna tetap ada di form login saat kembali, 
// biarkan baris di bawah ini. Jika ingin namanya ikut hilang, hapus tanda // nya.
// setcookie("remember_user", "", time() - 3600, "/");

// 4. Arahkan ke halaman login
header("Location: logpemilik.php");
exit();
?>