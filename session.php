<?php
session_start();

function createSession($data) {
    $_SESSION['user'] = $data['user'];
    $_SESSION['exp'] = time() + (60 * 30); // waktunya 30 menit 
}

function getValidSession() {
    if (!isset($_SESSION['user']) || !isset($_SESSION['exp'])) {
        return false;
    }

    if (time() > $_SESSION['exp']) {
        session_unset();
        session_destroy();
        return false;
    }

    // refresh session tiap aktivitas
    $_SESSION['exp'] = time() + 1800;

    return ["user" => $_SESSION['user']];
}
?>