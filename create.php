<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/Database.php';
require_once 'flash.php';
$db = Database::getInstance()->getConnection();

$kategori = $db->query("SELECT * FROM kategori")->fetchAll();
$supplier = $db->query("SELECT * FROM supplier")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_produk'];
    $id_kat = $_POST['id_kategori'];
    $id_sup = $_POST['id_supplier'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $stmt = $db->prepare("INSERT INTO produk (nama_produk, id_kategori, id_supplier, stok, harga) VALUES (?, ?, ?, ?, ?)");
    
    try {
        $stmt->execute([$nama, $id_kat, $id_sup, $stok, $harga]);
        setFlash('sukses', 'Produk berhasil ditambahkan!');
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        setFlash('gagal', 'Gagal menambahkan produk: ' . $e->getMessage());
        header("Location: create.php");
        exit;
    }
}

require_once 'includes/header.php';
?>

<h1>Tambah Produk Baru</h1>
<a href="index.php" style="display:inline-block; margin-bottom:15px; text-decoration:none; color:#007bff;">&larr; Kembali ke Daftar</a>

<?php tampilkanFlash(); ?>

<form method="POST">
    <label>Nama Produk:</label>
    <input type="text" name="nama_produk" required placeholder="Contoh: Laptop Asus">

    <label>Kategori:</label>
    <select name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach($kategori as $k): ?>
            <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Supplier:</label>
    <select name="id_supplier" required>
        <option value="">-- Pilih Supplier --</option>
        <?php foreach($supplier as $s): ?>
            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama_supplier']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Stok:</label>
    <input type="number" name="stok" required min="1" placeholder="Contoh: 10">

    <label>Harga (Rp):</label>
    <input type="number" name="harga" required min="0" step="0.01" placeholder="Contoh: 7500000">

    <button type="submit">Simpan Produk</button>
</form>

<?php require_once 'includes/footer.php'; ?>