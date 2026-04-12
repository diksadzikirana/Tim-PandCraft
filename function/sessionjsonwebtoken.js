function base64UrlEncode(str) {
    return btoa(JSON.stringify(str))
        .replace(/=/g, "")
        .replace(/\+/g, "-")
        .replace(/\//g, "_");
}

function createSession(data) {
    const header = {
        alg: "HS256",
        typ: "JWT"
    };

    const payload = {
        data: data,
        exp: Math.floor(Date.now() / 1800) + 1800 // 30 menit
    };

    const secret = "secret123"; // simulasi secret

    const encodedHeader = base64UrlEncode(header);
    const encodedPayload = base64UrlEncode(payload);

    // signature sederhana (simulasi)
    const signature = btoa(encodedHeader + "." + encodedPayload + secret);

    const token = `${encodedHeader}.${encodedPayload}.${signature}`;

    localStorage.setItem("token", token);
}