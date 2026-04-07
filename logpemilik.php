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
              AND role='pemilik'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        createSession([
            "user" => $nama,
            "role" => "pemilik"
        ]);

        echo "<script>alert('Login Pemilik berhasil!'); window.location='dashboardpemilik.php';</script>";
    } else {
        echo "<script>alert('Login gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Pemilik</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col items-center gap-6 bg-cover bg-center"
style="background-image: linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),url('anyam.png');">

<header class="w-full bg-[#1e1e1e] px-6 py-4 text-[#2e7d32] font-bold">
Website PandCraft
</header>

<h2 class="text-white text-2xl">Masukkan Nama dan Password</h2>

<div class="bg-white p-6 w-80 rounded-xl shadow-lg">

<form method="POST">

<input type="text" name="nama"
value="<?= htmlspecialchars($rememberedUser) ?>"
placeholder="Nama"
class="w-full mb-3 p-2 border rounded">

<input type="password" name="password"
placeholder="Password"
class="w-full mb-3 p-2 border rounded">

<label>
<input type="checkbox" name="remember"
<?= $rememberedUser ? 'checked' : '' ?>>
Remember Me
</label>

<button class="w-full mt-3 bg-green-600 text-white p-2 rounded">
Login
</button>

</form>

<a href="beranda.php" class="block mt-3 text-center text-green-600">
← Kembali
</a>

</div>

</body>
</html>