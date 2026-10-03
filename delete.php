<?php
require_once 'config/Database.php';
require_once 'flash.php';
$db = Database::getInstance()->getConnection();

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        // BONUS: Menggunakan Transaction pada delete
        $db->beginTransaction();
        
        $stmt = $db->prepare("DELETE FROM produk WHERE id = ?");
        $stmt->execute([$id]);

        $db->commit();
        setFlash('sukses', 'Produk berhasil dihapus!');
        
    } catch (PDOException $e) {
        $db->rollBack();
        setFlash('gagal', 'Gagal menghapus produk: ' . $e->getMessage());
    }
} else {
    setFlash('gagal', 'ID Produk tidak valid!');
}

header("Location: index.php");
exit;
?>