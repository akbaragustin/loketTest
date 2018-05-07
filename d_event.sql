-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 07 Bulan Mei 2018 pada 20.49
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `d_event`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_event`
--

CREATE TABLE `t_event` (
  `id_event` int(11) NOT NULL,
  `id_location` int(11) DEFAULT NULL,
  `name_event` varchar(20) DEFAULT NULL,
  `description_event` text,
  `date_start_event` datetime NOT NULL,
  `date_end_event` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_event`
--

INSERT INTO `t_event` (`id_event`, `id_location`, `name_event`, `description_event`, `date_start_event`, `date_end_event`, `created_at`, `updated_at`) VALUES
(4, 7, 'Big Data', 'Data Sains', '2018-05-07 03:08:43', '2018-05-08 03:08:46', '2018-05-06 20:08:48', '2018-05-06 20:08:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_location`
--

CREATE TABLE `t_location` (
  `id_location` int(11) NOT NULL,
  `name_location` varchar(20) NOT NULL,
  `address_location` varchar(20) DEFAULT NULL,
  `city_location` varchar(20) DEFAULT NULL,
  `state_location` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_location`
--

INSERT INTO `t_location` (`id_location`, `name_location`, `address_location`, `city_location`, `state_location`, `created_at`, `updated_at`) VALUES
(7, 'Ev Hive City', 'Plaza Kuningan', 'Jakarta', 'Indonesia', '2018-05-06 20:07:57', '2018-05-06 20:07:57'),
(8, 'Ev Hive Maja', 'Kyai Maja', 'Bandung', 'Indonesia', '2018-05-06 20:08:23', '2018-05-06 20:08:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_ticket`
--

CREATE TABLE `t_ticket` (
  `id_ticket` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `capacity_ticket` int(11) NOT NULL,
  `name_ticket` varchar(20) NOT NULL,
  `date_start_ticket` datetime NOT NULL,
  `date_end_ticket` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_ticket`
--

INSERT INTO `t_ticket` (`id_ticket`, `id_event`, `capacity_ticket`, `name_ticket`, `date_start_ticket`, `date_end_ticket`, `created_at`, `updated_at`) VALUES
(4, 4, 8, 'Event', '2018-05-07 07:12:29', '2018-05-09 07:12:33', '2018-05-07 00:12:36', '2018-05-07 17:43:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_transaction_event`
--

CREATE TABLE `t_transaction_event` (
  `id_transaction` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_transaction_event`
--

INSERT INTO `t_transaction_event` (`id_transaction`, `id_user`, `id_ticket`, `created_at`, `updated_at`) VALUES
(16, 1, 4, '2018-05-07 03:05:45', '2018-05-07 03:05:45'),
(17, 1, 4, '2018-05-07 05:02:49', '2018-05-07 05:02:49'),
(18, 1, 4, '2018-05-07 17:42:08', '2018-05-07 17:42:08'),
(19, 3, 4, '2018-05-07 17:43:56', '2018-05-07 17:43:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `created_at`, `updated_at`) VALUES
(1, 'akbar', '2018-05-06 20:03:39', '2018-05-06 20:03:41'),
(3, 'akbar_agustin1', '2018-05-07 09:45:25', '2018-05-07 09:45:25');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_event`
--
ALTER TABLE `t_event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_location` (`id_location`);

--
-- Indeks untuk tabel `t_location`
--
ALTER TABLE `t_location`
  ADD PRIMARY KEY (`id_location`);

--
-- Indeks untuk tabel `t_ticket`
--
ALTER TABLE `t_ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_event` (`id_event`);

--
-- Indeks untuk tabel `t_transaction_event`
--
ALTER TABLE `t_transaction_event`
  ADD PRIMARY KEY (`id_transaction`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_event`
--
ALTER TABLE `t_event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `t_location`
--
ALTER TABLE `t_location`
  MODIFY `id_location` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `t_ticket`
--
ALTER TABLE `t_ticket`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `t_transaction_event`
--
ALTER TABLE `t_transaction_event`
  MODIFY `id_transaction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_event`
--
ALTER TABLE `t_event`
  ADD CONSTRAINT `id_location` FOREIGN KEY (`id_location`) REFERENCES `t_location` (`id_location`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_ticket`
--
ALTER TABLE `t_ticket`
  ADD CONSTRAINT `id_event` FOREIGN KEY (`id_event`) REFERENCES `t_event` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_transaction_event`
--
ALTER TABLE `t_transaction_event`
  ADD CONSTRAINT `id_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `t_ticket` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
