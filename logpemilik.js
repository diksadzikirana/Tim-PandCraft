// function loginValidate() {
//     var nama = document.getElementById("nama").value;
//     var password = document.getElementById("password").value;


//     var userBenar = "Vera";
//     var passBenar = "Vera123";

    
    


//     if (nama === userBenar && password === passBenar) {
//         alert("Login berhasil!");
//         createSession({user: userBenar, password : passBenar})

//         window.location.href = "dashboardpemilik.html";
//         return false;
//     } else {
//         alert("Nama atau password salah!");
//         return false;
//     }
// }

function loginValidate() {
    var nama = document.getElementById("nama").value;
    var password = document.getElementById("password").value;

    var userBenar = "Vera";
    var passBenar = "Vera123";

    if (nama === userBenar && password === passBenar) {
        alert("Login berhasil!");

        createSession({ user: nama });

        window.location.href = "dashboardpemilik.html";
        return false;
    } else {
        alert("Nama atau password salah!");
        return false;
    }
}


// function loginValidate() {
//     var nama = document.getElementById("nama").value;
//     var password = document.getElementById("password").value;

//     var userBenar = "Vera";
//     var passBenar = "Vera123";

//     if (nama === userBenar && password === passBenar) {
//         alert("Login berhasil!");

//         // simpan ke localStorage
//         localStorage.setItem("user", nama);

//         window.location.href = "dashboardpemilik.html";
//         return false;
//     } else {
//         alert("Nama atau password salah!");
//         return false;
//     }
// }