<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/Database.php';
require_once 'flash.php';
$db = Database::getInstance()->getConnection();

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

$stmt = $db->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) {
    setFlash('gagal', 'Produk tidak ditemukan!');
    header("Location: index.php");
    exit;
}

$kategori = $db->query("SELECT * FROM kategori")->fetchAll();
$supplier = $db->query("SELECT * FROM supplier")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_produk'];
    $id_kat = $_POST['id_kategori'];
    $id_sup = $_POST['id_supplier'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $update = $db->prepare("UPDATE produk SET nama_produk=?, id_kategori=?, id_supplier=?, stok=?, harga=? WHERE id=?");
    try {
        $update->execute([$nama, $id_kat, $id_sup, $stok, $harga, $id]);
        setFlash('sukses', 'Produk berhasil diupdate!');
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        setFlash('gagal', 'Gagal update: ' . $e->getMessage());
        header("Location: edit.php?id=" . $id);
        exit;
    }
}

require_once 'includes/header.php';
?>

<h1>Edit Produk</h1>
<a href="index.php" style="display:inline-block; margin-bottom:15px; text-decoration:none; color:#007bff;">&larr; Kembali ke Daftar</a>

<?php tampilkanFlash(); ?>

<form method="POST">
    <label>Nama Produk:</label>
    <input type="text" name="nama_produk" value="<?= htmlspecialchars($p['nama_produk']) ?>" required>

    <label>Kategori:</label>
    <select name="id_kategori" required>
        <?php foreach($kategori as $k): ?>
            <option value="<?= $k['id'] ?>" <?= $k['id'] == $p['id_kategori'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($k['nama_kategori']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Supplier:</label>
    <select name="id_supplier" required>
        <?php foreach($supplier as $s): ?>
            <option value="<?= $s['id'] ?>" <?= $s['id'] == $p['id_supplier'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['nama_supplier']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Stok:</label>
    <input type="number" name="stok" value="<?= htmlspecialchars($p['stok']) ?>" required min="1">

    <label>Harga (Rp):</label>
    <input type="number" name="harga" value="<?= htmlspecialchars($p['harga']) ?>" required min="0" step="0.01">

    <button type="submit">Update Produk</button>
</form>

<?php require_once 'includes/footer.php'; ?>