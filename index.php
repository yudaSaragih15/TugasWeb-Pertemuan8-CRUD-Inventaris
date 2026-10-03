<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/Database.php';
require_once 'flash.php';

$db = Database::getInstance()->getConnection();

$search = $_GET['search'] ?? '';

$query = "SELECT p.*, k.nama_kategori, s.nama_supplier 
          FROM produk p 
          LEFT JOIN kategori k ON p.id_kategori = k.id 
          LEFT JOIN supplier s ON p.id_supplier = s.id";

if ($search) {
    $query .= " WHERE p.nama_produk LIKE :search";
}

$query .= " ORDER BY p.id DESC";

$stmt = $db->prepare($query);

if ($search) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$produk = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<h1>Daftar Produk Inventaris</h1>
<a href="create.php" class="btn">+ Tambah Produk</a>

<form method="GET" action="" class="search-form">
    <input type="text" name="search" placeholder="Cari nama produk..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit">Cari</button>
</form>

<?php tampilkanFlash(); ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($produk) > 0): ?>
            <?php foreach ($produk as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['id']) ?></td>
                <td><?= htmlspecialchars($p['nama_produk']) ?></td>
                <td><?= htmlspecialchars($p['nama_kategori'] ?? '-') ?></td>
                <td><?= htmlspecialchars($p['nama_supplier'] ?? '-') ?></td>
                <td><?= htmlspecialchars($p['stok']) ?></td>
                <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                <td>
                    <a href="edit.php?id=<?= $p['id'] ?>">Edit</a> | 
                    <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align: center;">Belum ada data produk.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once 'includes/footer.php'; ?>