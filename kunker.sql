-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Des 2023 pada 18.30
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kunker`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `acc`
--

CREATE TABLE `acc` (
  `idacc` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `tanggal` date NOT NULL,
  `pangkat` varchar(27) NOT NULL,
  `idpegawai` int(11) NOT NULL,
  `idpengajuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `acc`
--

INSERT INTO `acc` (`idacc`, `waktu`, `tanggal`, `pangkat`, `idpegawai`, `idpengajuan`) VALUES
(1, '2023-12-21 07:47:48', '2023-12-21', 'Pembina Tk. I', 7, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `agenda`
--

CREATE TABLE `agenda` (
  `idagenda` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `acara` text NOT NULL,
  `idpengajuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `agenda`
--

INSERT INTO `agenda` (`idagenda`, `waktu`, `acara`, `idpengajuan`) VALUES
(1, '2023-05-25 10:00:00', 'Di DPRD Kota Cimahi tentang Kebijakan Anggaran dan Persiapan Pilkada Serentak Tahun 2024', 1),
(2, '2023-05-26 10:00:00', 'Di DPRD Kabupaten Bandung Barat tentang Pengawasan dan Pembinaan terhadap Ormas dan LSM', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayar`
--

CREATE TABLE `bayar` (
  `idbayar` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `jenis` varchar(27) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `penerima` varchar(63) NOT NULL,
  `keterangan` text NOT NULL,
  `idpengajuan` int(11) NOT NULL,
  `idpengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bayar`
--

INSERT INTO `bayar` (`idbayar`, `waktu`, `jenis`, `jumlah`, `penerima`, `keterangan`, `idpengajuan`, `idpengguna`) VALUES
(1, '2023-12-21 11:17:39', 'Akomodasi', 100000, 'Sapto Aji Pratama', 'contoh keterangan tambahan lain', 1, 3),
(3, '2023-12-21 11:21:27', 'Komunikasi', 150000, 'Sapto Aji Pratama', 'titipan', 1, 3),
(4, '2023-12-21 11:22:21', 'Lain-Lain', 150000, 'Sapto Aji Pratama', 'pelunasan', 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya`
--

CREATE TABLE `biaya` (
  `idbiaya` int(11) NOT NULL,
  `jenis` varchar(27) NOT NULL,
  `rincian` text NOT NULL,
  `jumlah` int(11) NOT NULL,
  `idpengajuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `biaya`
--

INSERT INTO `biaya` (`idbiaya`, `jenis`, `rincian`, `jumlah`, `idpengajuan`) VALUES
(1, 'Akomodasi', 'Menginap Hotel', 100000, 1),
(2, 'Transportasi', 'Tiket Kereta Api', 300000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dasar`
--

CREATE TABLE `dasar` (
  `iddasar` int(11) NOT NULL,
  `dasar` text NOT NULL,
  `idpengajuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dasar`
--

INSERT INTO `dasar` (`iddasar`, `dasar`, `idpengajuan`) VALUES
(1, 'Surat Ketua DPRD Kabupaten Batang nomor: 172/345 tanggal 15 Mei 2023 perihal Koordinasi dan Konsultasi Komisi A DPRD Kabupaten Batang;', 1),
(2, 'Surat Ketua DPRD Kabupaten Batang nomor: 172/346 tanggal 15 Mei 2023 perihal Koordinasi dan Konsultasi Komisi A DPRD Kabupaten Batang;', 1),
(3, 'Bahwa sehubungan dengan hal tersebut, guna tertib administrasi dan kelancaran pelaksanaannya perlu mengeluarkan Surat Perintah', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `indek`
--

CREATE TABLE `indek` (
  `idindek` int(11) NOT NULL,
  `indek` char(9) NOT NULL,
  `tujuan` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `indek`
--

INSERT INTO `indek` (`idindek`, `indek`, `tujuan`) VALUES
(1, '000', 'Umum'),
(2, '001', 'Lambang'),
(3, '090', 'Perjalanan Dinas'),
(4, '099', 'Perjalanan Pegawai Ke Luar Negeri');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keterangan`
--

CREATE TABLE `keterangan` (
  `idketerangan` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `idpengajuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keterangan`
--

INSERT INTO `keterangan` (`idketerangan`, `keterangan`, `idpengajuan`) VALUES
(1, 'Rombongan berangkat tanggal 24 Mei 2023, Kembali ke Batang tanggal 27 Mei 2023;', 1),
(2, 'Melaporkan Hasilnya.', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `idlaporan` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `klien` varchar(63) NOT NULL,
  `lokasi` text NOT NULL,
  `materi` text NOT NULL,
  `solusi` text NOT NULL,
  `pic` varchar(63) NOT NULL,
  `id` char(21) NOT NULL,
  `jabatan` varchar(27) NOT NULL,
  `idagenda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `idpegawai` int(11) NOT NULL,
  `nip` char(21) NOT NULL,
  `nama` varchar(63) NOT NULL,
  `jekel` enum('Pria','Wanita') NOT NULL,
  `alamat` text NOT NULL,
  `pangkat` varchar(27) NOT NULL,
  `golongan` char(9) NOT NULL,
  `jabatan` varchar(99) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`idpegawai`, `nip`, `nama`, `jekel`, `alamat`, `pangkat`, `golongan`, `jabatan`, `status`) VALUES
(1, '19720314 199903 1 008', 'Buntoro, S.Sos', 'Pria', 'Batang', 'Pembina Tk. I', 'IV/a', 'Kabag Umum dan Keuangan', '1'),
(2, '19740720 199703 1 004', 'Moch. Suharyono, S.I.P', 'Pria', 'Batang', 'Pembina Tk. I', 'II/d', 'Kasubag Tata Usaha dan Kepegawaian', '1'),
(3, '19830826 201502 2 001', 'Etik Sugiyarti, S.Pd', 'Wanita', 'Batang', 'Pembina Tk. I', 'IV/a', 'Analis Kebijakan Ahli Muda', '1'),
(4, '19821008 200801 2 006', 'Dyah Ayu Mahesti, SE', 'Wanita', 'Batang', 'Pembina Tk. I', 'II/d', 'Staf', '1'),
(6, '', 'Ganang Mahardhika, S.Kom', 'Pria', 'Batang', 'Pembina Tk. I', 'IV/a', 'Staf', '1'),
(7, '19690320 201001 1 001', 'Mukhamad Muhtadi', 'Pria', 'Batang', 'Pembina Tk. I', 'IV/a', 'Staf', '1'),
(8, '19660202 199403 1 012', 'Avis Ehar', 'Pria', 'Batang', 'Pembina Tk. I', 'II/d', 'Staf', '1'),
(9, '19880711 201101 1 007', 'Abdur Rouf, S.Kom', 'Pria', 'Batang', 'Pembina Tk. I', 'IV/a', 'Staf', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan`
--

CREATE TABLE `pengajuan` (
  `idpengajuan` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `nomor` char(18) NOT NULL,
  `tujuan` text NOT NULL,
  `tembusan` text NOT NULL,
  `angkutan` text NOT NULL,
  `anggaran` text NOT NULL,
  `keterangan` text NOT NULL,
  `catatan` text NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL,
  `idpengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengajuan`
--

INSERT INTO `pengajuan` (`idpengajuan`, `waktu`, `nomor`, `tujuan`, `tembusan`, `angkutan`, `anggaran`, `keterangan`, `catatan`, `status`, `idpengguna`) VALUES
(1, '2023-12-20 18:19:32', '090/001', 'Mendampingi dan Mengantar Komisi A DPRD Kabupaten Batang Melaksanakan Koordinasi dan Konsultasi', 'Pimpinan DPRD Kabupaten Batang\r\nKabag. Umum dan Keuangan Set. DPRD Kabupaten Batang\r\nArsip', 'Kereta Api', 'RABD', 'contoh keterangan tambahan', 'tolong sesuaikan pada bagian bagian itu', '5', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `idpengguna` int(11) NOT NULL,
  `nama` varchar(63) NOT NULL,
  `jekel` enum('Pria','Wanita') NOT NULL,
  `level` enum('p','b','o') NOT NULL,
  `username` varchar(99) NOT NULL,
  `password` char(32) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`idpengguna`, `nama`, `jekel`, `level`, `username`, `password`, `status`, `foto`) VALUES
(1, 'H. Maulana Yusup, S.IP', 'Pria', 'p', 'pimpinan', 'e10adc3949ba59abbe56e057f20f883e', '1', '20190206083535.jpg'),
(2, 'Abdi Susanto', 'Pria', 'o', 'abdi0', 'e10adc3949ba59abbe56e057f20f883e', '1', ''),
(3, 'Rania Safitri', 'Wanita', 'b', 'rania0', 'e10adc3949ba59abbe56e057f20f883e', '1', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengikut`
--

CREATE TABLE `pengikut` (
  `idpengikut` int(11) NOT NULL,
  `nama` varchar(63) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL,
  `idpengajuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengikut`
--

INSERT INTO `pengikut` (`idpengikut`, `nama`, `tanggal`, `keterangan`, `idpengajuan`) VALUES
(1, 'Abdi Susanto', '1991-12-20', 'Pengikut', 1),
(2, 'Rania Safitri', '1998-01-20', 'Anak Magang', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `utusan`
--

CREATE TABLE `utusan` (
  `idutusan` int(11) NOT NULL,
  `jabatan` varchar(99) NOT NULL,
  `keterangan` varchar(36) NOT NULL,
  `idpegawai` int(11) NOT NULL,
  `idpengajuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `utusan`
--

INSERT INTO `utusan` (`idutusan`, `jabatan`, `keterangan`, `idpegawai`, `idpengajuan`) VALUES
(1, 'Kabag Umum dan Keuangan', 'Pendamping', 1, 1),
(2, 'Kasubag Tata Usaha dan Kepegawaian', 'Pendamping', 2, 1),
(3, 'Staf', 'Pengemudi G 7010 XC', 8, 1),
(4, 'Staf', 'Pendamping', 4, 1),
(5, 'Analis Kebijakan Ahli Muda', 'Pendamping', 3, 1),
(6, 'Staf', 'Pengemudi G 9510 SC', 6, 1),
(7, 'Staf', 'Pengemudi G 9 C', 7, 1),
(9, 'Staf', 'Pengemudi G 9502 TC', 9, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `acc`
--
ALTER TABLE `acc`
  ADD PRIMARY KEY (`idacc`);

--
-- Indeks untuk tabel `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`idagenda`);

--
-- Indeks untuk tabel `bayar`
--
ALTER TABLE `bayar`
  ADD PRIMARY KEY (`idbayar`);

--
-- Indeks untuk tabel `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`idbiaya`);

--
-- Indeks untuk tabel `dasar`
--
ALTER TABLE `dasar`
  ADD PRIMARY KEY (`iddasar`);

--
-- Indeks untuk tabel `indek`
--
ALTER TABLE `indek`
  ADD PRIMARY KEY (`idindek`);

--
-- Indeks untuk tabel `keterangan`
--
ALTER TABLE `keterangan`
  ADD PRIMARY KEY (`idketerangan`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`idlaporan`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`idpegawai`);

--
-- Indeks untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`idpengajuan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`idpengguna`);

--
-- Indeks untuk tabel `pengikut`
--
ALTER TABLE `pengikut`
  ADD PRIMARY KEY (`idpengikut`);

--
-- Indeks untuk tabel `utusan`
--
ALTER TABLE `utusan`
  ADD PRIMARY KEY (`idutusan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `acc`
--
ALTER TABLE `acc`
  MODIFY `idacc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `agenda`
--
ALTER TABLE `agenda`
  MODIFY `idagenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `bayar`
--
ALTER TABLE `bayar`
  MODIFY `idbayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `biaya`
--
ALTER TABLE `biaya`
  MODIFY `idbiaya` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `dasar`
--
ALTER TABLE `dasar`
  MODIFY `iddasar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `indek`
--
ALTER TABLE `indek`
  MODIFY `idindek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `keterangan`
--
ALTER TABLE `keterangan`
  MODIFY `idketerangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `idlaporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `idpegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `idpengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `idpengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengikut`
--
ALTER TABLE `pengikut`
  MODIFY `idpengikut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `utusan`
--
ALTER TABLE `utusan`
  MODIFY `idutusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
