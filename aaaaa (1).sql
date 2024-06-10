-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jun 2024 pada 00.23
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
-- Database: `aaaaa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `quantity`, `total_price`) VALUES
(48, 2, 1, 2, 200000),
(49, 2, 1, 2, 200000),
(50, 1, 2, 2, 170000),
(51, 1, 1, 2, 200000),
(52, 24, 3, 12, 1200000),
(53, 1, 3, 2, 200000),
(54, 1, 1, 6, 600000),
(55, 1, 2, 13, 1105000),
(56, 24, 5, 32, 2720000),
(57, 24, 3, 3, 300000),
(58, 24, 5, 2, 170000),
(59, 25, 2, 3, 255000),
(60, 1, 2, 3, 255000),
(61, 27, 6, 3, 225000),
(62, 1, 6, 9, 675000),
(63, 1, 1, 1, 100000),
(64, 1, 6, 3, 225000),
(65, 1, 2, 10, 850000),
(66, 1, 5, 3, 255000),
(67, 1, 2, 5, 425000),
(68, 1, 8, 2, 10000),
(69, 28, 2, 4, 340000),
(70, 1, 2, 3, 255000),
(71, 28, 3, 5, 500000),
(72, 29, 2, 7, 595000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`product_id`, `name`, `image`, `price`) VALUES
(1, 'Kue nastar', 'uploads/kue nasstar.png', 100000),
(2, 'Kue palm chesee', 'uploads/kue palm chesee.png', 85000),
(3, 'Kue kastengel', 'uploads/kue kastengel.png', 100000),
(4, 'Kue putri salju', 'uploads/kue pitri salju.png', 100000),
(5, 'Kue sagu keju', 'uploads/sagu keju.png', 85000),
(6, 'Kue kembang goyang', 'uploads/kembang.png', 75000),
(7, 'Kue Peler', 'uploadskue peler.png', 2000),
(8, 'Kue Anjayyyy', 'uploadskue perut ayam.png', 5000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `level`) VALUES
(1, 'nabil putra', 'nabilputra33315@gmail.com', '2007', 'admin'),
(2, 'putra', 'putra@gmail.com', 'putra', 'user'),
(7, 'vaio', 'vaio@gmail.com', 'vaio', 'user'),
(12, 'tess', 'tes@gmail.com', '$2y$10$3lRPfZu1UBdaynI.2JTzV.kpQFO7v20y/4rSn2fkGRzwiIN690Q5W', 'user'),
(22, 'bambang', 'bambang@gmail.com', '$2y$10$znHgRjaelyjNfOTW/DVBZeF.aLOYDv8erP56NK37PG5IGlrrNPVDK', 'user'),
(24, 'rere', 'sayang@gmail.com', 'rere', 'user'),
(25, 'anamm', 'anam@gmail.com', '$2y$10$rQxGfjpffFOm8cYAlG9E..ceNN6021QNo6ZTuCqXHfM8lC9M4yTRm', 'user'),
(27, 'namm', 'nam@gmail.com', '$2y$10$hdl9iqN/1/nro9o8ZU.m5O2RcHlFuGIm0ZneqcKAq1D1c4CMGbQOi', 'user'),
(28, 'ppp', 'ppp@gmail.com', 'ppp', 'user'),
(29, 'bbb', 'bb@g.c', 'bbb', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `id_user_order` (`user_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `id_user_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
