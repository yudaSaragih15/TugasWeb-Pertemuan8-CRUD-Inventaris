<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function setFlash($tipe, $pesan) {
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function tampilkanFlash() {
    if (isset($_SESSION['flash'])) {
        $tipe = $_SESSION['flash']['tipe'];
        $pesan = $_SESSION['flash']['pesan'];
        echo "<div class='alert alert-$tipe'>" . htmlspecialchars($pesan) . "</div>";
        unset($_SESSION['flash']);
    }
}
?>