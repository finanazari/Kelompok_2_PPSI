-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jun 2023 pada 11.40
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(5) NOT NULL,
  `nama_barang` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`) VALUES
('BR001', 'Pakaian'),
('BR002', 'Gorden'),
('BR003', 'Selimut Kecil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_layanan`
--

CREATE TABLE `barang_layanan` (
  `id_barang_layanan` varchar(5) NOT NULL,
  `id_barang` varchar(5) NOT NULL,
  `id_layanan` varchar(5) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang_layanan`
--

INSERT INTO `barang_layanan` (`id_barang_layanan`, `id_barang`, `id_layanan`, `satuan`, `harga`) VALUES
('HG001', 'BR001', 'LY001', 'Kg', 6000),
('HG002', 'BR001', 'LY002', 'Kg', 7500),
('HG003', 'BR002', 'LY001', 'Lembar', 12000),
('HG004', 'BR002', 'LY002', 'Lembar', 15000),
('HG005', 'BR003', 'LY001', 'Lembar', 10000),
('HG006', 'BR003', 'LY002', 'Lembar', 20000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_barang_layanan` varchar(5) NOT NULL,
  `id_transaksi` varchar(5) NOT NULL,
  `ukuran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_barang_layanan`, `id_transaksi`, `ukuran`) VALUES
('HG001', 'TR002', 1),
('HG001', 'TR003', 4),
('HG001', 'TR004', 3),
('HG001', 'TR005', 3),
('HG001', 'TR007', 2),
('HG003', 'TR001', 4),
('HG003', 'TR002', 2),
('HG003', 'TR003', 1),
('HG005', 'TR004', 1),
('HG005', 'TR005', 1),
('HG005', 'TR007', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` varchar(5) NOT NULL,
  `layanan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `layanan`) VALUES
('LY001', 'Cuci Gosok'),
('LY002', 'Setrika');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(5) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `saldo` int(12) NOT NULL DEFAULT 0 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `no_hp`, `alamat`, `saldo`) VALUES
('PL001', 'Ana', '0876554433', 'Jl Irigasi', 50000),
('PL003', 'Aulia', '087655443323', 'Pasar Baru', 0),
('PL004', 'Adi', '0876554433', 'Jl Pintu Angin',100000),
('PL005', 'erwin', '08227689112', 'Limau manis', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_laundry`
--

CREATE TABLE `status_laundry` (
  `id_status_laundry` varchar(5) NOT NULL,
  `status_laundry` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status_laundry`
--

INSERT INTO `status_laundry` (`id_status_laundry`, `status_laundry`) VALUES
('SL001', 'Belum Selesai'),
('SL002', 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id_metode_pembayaran` varchar(5) NOT NULL,
  `metode_pembayaran` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status_laundry`
--

INSERT INTO `metode_pembayaran` (`id_metode_pembayaran`, `metode_pembayaran`) VALUES
('0', 'Belum'),
('MP001', 'Cash'),
('MP002', 'QRIS'),
('MP003', 'Saldo'); 

-- --------------------------------------------------------
--
-- Struktur dari tabel `status_pembayaran`
--

CREATE TABLE `status_pembayaran` (
  `id_status_pembayaran` varchar(5) NOT NULL,
  `status_pembayaran` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status_pembayaran`
--

INSERT INTO `status_pembayaran` (`id_status_pembayaran`, `status_pembayaran`) VALUES
('0', 'Proses'),
('SB001', 'Lunas'),
('SB002', 'Belum Bayar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(5) NOT NULL,
  `id_user` varchar(5) NOT NULL,
  `id_pelanggan` varchar(5) NOT NULL,
  `id_status_laundry` varchar(5) NOT NULL,
  `id_metode_pembayaran` varchar(5) NOT NULL,
  `id_status_pembayaran` varchar(5) NOT NULL,
  `total_pembayaran` int(12) NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tanggal_diantar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `id_pelanggan`, `id_status_laundry`, `id_metode_pembayaran`, `id_status_pembayaran`, `total_pembayaran`, `tanggal_selesai`, `tanggal_diantar`) VALUES
('TR001', 'US002', 'PL001', 'SL002', 'MP001', 'SB001', 10000,'2023-10-07', '2023-10-29'),
('TR002', 'US002', 'PL005', 'SL001', 'MP002', '0', 12000, '0000-00-00', '2023-09-08'),
('TR003', 'US002', 'PL005', 'SL002', 'MP002','SB001', 24000, '2023-10-07', '2023-09-29');


-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` varchar(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `NIK` varchar(25) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_user` varchar(20) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `NIK`, `nama`, `jenis_user`, `no_hp`, `alamat`, `password`, `gambar`) VALUES
('US001', 'suci', '12312345789787', 'Suci Rahmadhani', 'Admin', '082345332345', 'Pasar Baru', '25d55ad283aa400af464c76d713c07ad', 'default.png\r\n');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `barang_layanan`
--
ALTER TABLE `barang_layanan`
  ADD PRIMARY KEY (`id_barang_layanan`),
  ADD UNIQUE KEY `handle` (`id_barang`,`id_layanan`),
  ADD KEY `layanan_barang_layanan_fk` (`id_layanan`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_barang_layanan`,`id_transaksi`),
  ADD KEY `transaksi_detail_transalsi_fk` (`id_transaksi`);

--
-- Indeks untuk tabel `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `status_laundry`
--
ALTER TABLE `status_laundry`
  ADD PRIMARY KEY (`id_status_laundry`);

--
-- Indeks untuk tabel `status_laundry`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id_metode_pembayaran`);


--
-- Indeks untuk tabel `status_pembayaran`
--
ALTER TABLE `status_pembayaran`
  ADD PRIMARY KEY (`id_status_pembayaran`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `status_pembayaran_transaksi_fk` (`id_status_pembayaran`),
  ADD KEY `status_laundry_transaksi_fk` (`id_status_laundry`),
  ADD KEY `metode_pembayaran_transaksi_fk` (`id_metode_pembayaran`),
  ADD KEY `operator_transaksi_fk` (`id_user`),
  ADD KEY `pelanggan_transaksi_fk` (`id_pelanggan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_layanan`
--
ALTER TABLE `barang_layanan`
  ADD CONSTRAINT `barang_barang_layanan_fk` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `layanan_barang_layanan_fk` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `barang_layanan_detail_transalsi_fk` FOREIGN KEY (`id_barang_layanan`) REFERENCES `barang_layanan` (`id_barang_layanan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transaksi_detail_transalsi_fk` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `operator_transaksi_fk` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `pelanggan_transaksi_fk` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `status_laundry_transaksi_fk` FOREIGN KEY (`id_status_laundry`) REFERENCES `status_laundry` (`id_status_laundry`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `status_pembayaran_transaksi_fk` FOREIGN KEY (`id_status_pembayaran`) REFERENCES `status_pembayaran` (`id_status_pembayaran`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
