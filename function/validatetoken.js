function parseJwt(token) {
    try {
        const base64Payload = token.split('.')[1]
            .replace(/-/g, '+')
            .replace(/_/g, '/');

        return JSON.parse(atob(base64Payload));
    } catch (e) {
        return null;
    }
}

function getValidSession() {
    const token = localStorage.getItem("token");

    if (!token) return null;

    const payload = parseJwt(token);

    if (!payload) return null;

    const now = Math.floor(Date.now() / 1800);

    // cek expired
    if (now > payload.exp) {
        localStorage.removeItem("token");
        return null;
    }

    return payload; // valid
}