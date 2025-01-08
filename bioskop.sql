-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jan 2025 pada 04.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bioskop`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `administrator`
--

CREATE TABLE `administrator` (
  `id` int(3) NOT NULL,
  `username_admin` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `administrator`
--

INSERT INTO `administrator` (`id`, `username_admin`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `carousel_image`
--

CREATE TABLE `carousel_image` (
  `id` int(255) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `carousel_image`
--

INSERT INTO `carousel_image` (`id`, `image_name`) VALUES
(14, '67736ec4623fa.jpg'),
(17, '67736ee563c6d.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `coming_soon`
--

CREATE TABLE `coming_soon` (
  `id` int(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `trailer` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `coming_soon`
--

INSERT INTO `coming_soon` (`id`, `judul`, `genre`, `trailer`, `poster`) VALUES
(1010, 'Cars 2', 'Animation', 'https://youtube.com/embed/zonotSm4Mdc?si', '991c3e2ec879942f59eada4e4d8b232a_cbcd0b60-037c-4eb8-b800-218c93afc543_480x.progressive.png'),
(1011, 'The Incredible Hulk', 'Action', 'https://youtube.com/embed/xbqNb2PFKKA?si', 'incredible_hulk_480x.progressive (1).png'),
(1020, 'The Marvels', 'Animation | Adventure', 'https://youtube.com/embed/wS_qbDztgVY?si', 'the-marvels_pnk1tryd_480x.progressive.png'),
(9597, 'Jurassic World: Dominion', 'Action', 'https://youtube.com/embed/fb5ELWi-ekk?si', 'jurassic-world-dominion_oewuv4pl_480x.progressive.png'),
(9709, 'Spiderman-2', 'Action | Superhero', 'https://youtube.com/embed/3jBFwltrxJw?si', 'spiderman2.MPW-141407.24x36_480x.progressive.png'),
(92753, 'Black Panther', 'Action | Superhero', 'https://youtube.com/embed/RlOB3UALvrQ?si', '08dbbb8ce1abd9ecf6ba84673fbddb15_7199c853-a5f2-4b75-a629-cc7477efe67c_480x.progressive.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `film`
--

CREATE TABLE `film` (
  `id` int(50) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `jadwal` varchar(50) NOT NULL,
  `waktu_tayang` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `theater` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `trailer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `film`
--

INSERT INTO `film` (`id`, `judul`, `genre`, `jadwal`, `waktu_tayang`, `harga`, `theater`, `poster`, `trailer`) VALUES
(1001, 'Venom 2', 'Action', '2025-02-02', '15:30', '45000', '1', 'venom-the-last-dance_90m5c26k_480x.progressive.png', 'https://youtube.com/embed/rrwBnlYOp4g?si'),
(1002, 'Toy Story', 'Animation', '2025-12-12', '15:15', '35000', '2', 'ToyStory.mpw.102287_480x.progressive (1).png', 'https://youtube.com/embed/CxwTLktovTU?si'),
(1003, 'Deadpool & Wolverine', 'Action', '2025-12-12', '12:12', '35000', '1', 'deadpool-wolverine_866a70e7-fb48-4f35-a44b-41594691ac76_480x.progressive.png', 'https://youtube.com/embed/73_1biulkYk?si'),
(1005, 'Moana 2', 'Animation', '2025-12-12', '16:16', '35000', '3', 'moana-2_h5f8f8rg_480x.progressive.png', 'https://youtube.com/embed/hDZ7y8RP5HE?si'),
(1006, 'Bad Boys', 'Action', '2025-12-12', '14:14', '35000', '1', 'badboys.mpw.122590_480x.progressive.png', 'https://youtube.com/embed/Xm12NSa8jsM?si');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan_kursi`
--

CREATE TABLE `pemesanan_kursi` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `kursi` varchar(5) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan_kursi`
--

INSERT INTO `pemesanan_kursi` (`id`, `booking_id`, `kursi`, `harga`, `status`) VALUES
(261, 'TCS20250106090058210', 'D7', 45000, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `username` varchar(50) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `film_id` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `theater` varchar(50) NOT NULL,
  `total_seats` varchar(50) NOT NULL,
  `total_price` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`username`, `booking_id`, `film_id`, `judul`, `tanggal`, `waktu`, `theater`, `total_seats`, `total_price`, `created_at`) VALUES
('masadita', 'TCS20241227123949793', '1003', 'Deadpool & Wolverine', '2025-12-12', '12:12', '1', '1', '35000', '2024-12-27 05:39:49'),
('masadita', 'TCS20241227134707518', '1004', 'Inside Out 2', '2025-12-12', '15:15', '2', '1', '35000', '2024-12-27 06:47:07'),
('masadita', 'TCS20241227135714936', '1001', 'Venom 2', '2025-12-12', '12:21', '2', '3', '105000', '2024-12-27 06:57:14'),
('masadita', 'TCS20241227150500326', '1003', 'Deadpool & Wolverine', '2025-12-12', '12:12', '1', '1', '35000', '2024-12-27 08:05:00'),
('masadita1', 'TCS20241227151147405', '1001', 'Venom 2', '2025-12-12', '12:21', '2', '2', '70000', '2024-12-27 08:11:47'),
('masadita1', 'TCS20241227160356194', '1001', 'Venom 2', '2025-12-12', '12:21', '2', '1', '35000', '2024-12-27 09:03:56'),
('masadita', 'TCS20241229061714662', '1004', 'Inside Out 2', '2025-12-12', '15:15', '1', '1', '35000', '2024-12-28 23:17:14'),
('masadita', 'TCS20241229080357178', '1003', 'Deadpool & Wolverine', '2025-12-12', '12:12', '1', '1', '35000', '2024-12-29 01:03:57'),
('masadita', 'TCS20241229082010768', '1004', 'Inside Out 2', '2025-12-12', '15:15', '1', '1', '35000', '2024-12-29 01:20:10'),
('masadita', 'TCS20241229092127674', '1003', 'Deadpool & Wolverine', '2025-12-12', '12:12', '1', '1', '35000', '2024-12-29 02:21:27'),
('masadita', 'TCS20241229095701652', '1004', 'Inside Out 2', '2025-12-12', '15:15', '1', '1', '35000', '2024-12-29 02:57:01'),
('masadita', 'TCS20241229113339500', '1003', 'Deadpool & Wolverine', '2025-12-12', '12:12', '1', '1', '35000', '2024-12-29 04:33:39'),
('masadita', 'TCS20241229115250425', '1003', 'Deadpool & Wolverine', '2025-12-12', '12:12', '1', '1', '35000', '2024-12-29 04:52:50'),
('masadita', 'TCS20241229115306458', '1002', 'Toy Story', '2025-12-12', '15:15', '4', '1', '35', '2024-12-29 04:53:06'),
('masadita', 'TCS20241231112156180', '1001', 'Venom 2', '2025-12-12', '12:21', '1', '2', '70000', '2024-12-31 04:21:56'),
('masadita', 'TCS20241231125710232', '1001', 'Venom 2', '2025-12-12', '12:21', '1', '2', '70000', '2024-12-31 05:57:10'),
('masadita', 'TCS20250104105510978', '1005', 'Moana 2', '2025-12-12', '16:16', '3', '1', '35000', '2025-01-04 03:55:10'),
('masadita', 'TCS20250104105944977', '1002', 'Toy Story', '2025-12-12', '15:15', '2', '1', '35000', '2025-01-04 03:59:44'),
('masadita', 'TCS20250106071916677', '1005', 'Moana 2', '2025-12-12', '16:16', '3', '1', '35000', '2025-01-06 00:19:16'),
('masadita', 'TCS20250106071954235', '1005', 'Moana 2', '2025-12-12', '16:16', '3', '1', '35000', '2025-01-06 00:19:54'),
('masadita', 'TCS20250106072357926', '1002', 'Toy Story', '2025-12-12', '15:15', '2', '1', '35000', '2025-01-06 00:23:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_hp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `nama_lengkap`, `no_hp`) VALUES
(7, 'masadita20@gmail.com', 'masadita', '$2y$10$ZNwDWhRSCdyYCgt6PRcuc.Xh/.c22mu0surv6rZrscltEbibBV2Gq', 'Zidan Masadita', '08124124124');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `carousel_image`
--
ALTER TABLE `carousel_image`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `coming_soon`
--
ALTER TABLE `coming_soon`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemesanan_kursi`
--
ALTER TABLE `pemesanan_kursi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `carousel_image`
--
ALTER TABLE `carousel_image`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `coming_soon`
--
ALTER TABLE `coming_soon`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6432315;

--
-- AUTO_INCREMENT untuk tabel `film`
--
ALTER TABLE `film`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1361437;

--
-- AUTO_INCREMENT untuk tabel `pemesanan_kursi`
--
ALTER TABLE `pemesanan_kursi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
