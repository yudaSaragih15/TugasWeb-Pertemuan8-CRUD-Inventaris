CREATE DATABASE IF NOT EXISTS `inventaris_db` 
USE `inventaris_db`;

DELETE FROM `kategori`;
INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
	(1, 'Elektronik'),
	(2, 'Pakaian'),
	(3, 'Makanan'),
	(4, 'Alat Tulis'),
	(5, 'Perabotan');

DELETE FROM `produk`;
INSERT INTO `produk` (`id`, `nama_produk`, `id_kategori`, `id_supplier`, `stok`, `harga`) VALUES
	(1, 'Laptop Asus', 1, 1, 10, 7500000.00),
	(2, 'Kaos Polos', 2, 2, 50, 50000.00),
	(3, 'Biskuit Kaleng', 3, 3, 100, 25000.00),
	(4, 'Pulpen Gel', 4, 4, 200, 3000.00),
	(5, 'Meja Kayu', 5, 5, 5, 1500000.00),
	(6, 'Mouse', 1, 1, 5, 7500000.00);

DELETE FROM `supplier`;
INSERT INTO `supplier` (`id`, `nama_supplier`, `kontak`) VALUES
	(1, 'PT Maju Jaya', '08123456789'),
	(2, 'CV Sumber Rejeki', '08987654321'),
	(3, 'Toko Sejahtera', '08771234567'),
	(4, 'UD Makmur', '08559876543'),
	(5, 'PT Global Tech', '08112233445');