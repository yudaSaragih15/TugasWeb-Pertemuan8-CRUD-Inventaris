<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <nav>
            <a href="index.php">Home</a> | 
            <a href="create.php">Tambah Produk</a>
        </nav>
        <hr>