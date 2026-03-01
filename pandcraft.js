document.getElementById("formProduk").addEventListener("submit", function (event) {
    const kategori = document.getElementById("kategori").value;
    const statusProduk = document.getElementById("status_produk").value.trim();


    // Regex: hanya huruf dan spasi
    const hurufSaja = /^[A-Za-z\s]+$/;


    // Validasi kategori (JS, bukan browser)
    if (kategori === "") {
        alert("Kategori produk wajib dipilih!");
        event.preventDefault();
        return;
    }


    // Validasi status produk
    if (!hurufSaja.test(statusProduk)) {
        alert("Status produk hanya boleh berisi huruf, tidak boleh simbol/angka!");
        event.preventDefault();
        return;
    }


   
});
