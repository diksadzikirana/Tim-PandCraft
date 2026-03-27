function loginValidate() {
    var nama = document.getElementById("nama").value;
    var password = document.getElementById("password").value;


    var userBenar = "Vera";
    var passBenar = "Vera123";


    if (nama === userBenar && password === passBenar) {
        alert("Login berhasil!");
        window.location.href = "dashboardpemilik.html";
        return false;
    } else {
        alert("Nama atau password salah!");
        return false;
    }
}


