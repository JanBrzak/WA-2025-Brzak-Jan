-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 15. čen 2025, 20:49
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `blog_nightrides`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `socpost_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `socpost_id`, `text`, `created_at`) VALUES
(1, 2, 21, 'skibidi sigma', '2025-06-15 10:54:29'),
(2, 2, 21, 'dobrej kaťák', '2025-06-15 10:55:52'),
(3, 2, 21, 'za kolik?\r\n', '2025-06-15 11:02:42'),
(4, 2, 21, 'fdffsdfsdf', '2025-06-15 11:14:25'),
(5, 2, 22, 'nice car', '2025-06-15 11:17:23'),
(6, 2, 22, 'banger', '2025-06-15 11:17:29');

-- --------------------------------------------------------

--
-- Struktura tabulky `socposts`
--

CREATE TABLE `socposts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `socposts`
--

INSERT INTO `socposts` (`id`, `title`, `author`, `text`, `images`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Liberec, Gamma green alpina', 'Anonymous777', 'This car was spotted on Monday 7.6. beautiful green metalic alpina with  3.5L V8 engine according to website pushing around 560 horsepower .', '[]', 2, '2025-06-14 21:26:20', '2025-06-14 21:26:20'),
(2, 'sdfads', 'sadasd', 'adfasfafvasdxcasdas', '[]', 2, '2025-06-14 21:27:10', '2025-06-14 21:27:10'),
(3, 'Liberec, Gamma green alpina', 'Anonymous777', 'asdasgewfasfshndfgsdffgasdfsegsdfgadsfsedghdrgbsdfgx', '[]', 2, '2025-06-14 21:30:25', '2025-06-14 21:30:25'),
(4, 'dasfagfadfa', 'sdgdasgsdagadg', 'sadasfaghesadgasga', '[]', 2, '2025-06-14 21:38:00', '2025-06-14 21:38:00'),
(5, 'dfasfsaf', 'fasfasfasf', 'fasfasfasf', '[]', 2, '2025-06-14 21:38:49', '2025-06-14 21:38:49'),
(6, 'wdfasdfsad', 'asdasdasd', 'dasdasdasdsadas', '[]', 2, '2025-06-14 21:56:30', '2025-06-14 21:56:30'),
(7, 'dawsdawsfdas', 'asdasdasdas', 'dasdasdas', '[]', 2, '2025-06-14 22:01:29', '2025-06-14 22:01:29'),
(9, 'fafasfasfas', 'asdfasfasasf', 'fsafasfasfasfsafsafas', '[\"\\/WA-2025-Brzak-Jan\\/nightrides-php\\/public\\/img\\/BMW_Alpina_B7_Java_Green_2016_sada_07_800_600.jpg\"]', 2, '2025-06-14 22:11:43', '2025-06-14 22:11:43'),
(10, 'rfawetfgse', 'fgsdgsgsrgh', 'sdgsgsdgssgd', '[]', 2, '2025-06-14 22:16:46', '2025-06-14 22:16:46'),
(12, 'Liberec, Gamma green alpina', 'Anonymous777', 'fsdfgsdfgds', '[]', 2, '2025-06-15 08:25:55', '2025-06-15 08:25:55'),
(14, 'fasfdsa', 'asdfasfdas', 'dasdasdsad', '[]', 2, '2025-06-15 08:33:54', '2025-06-15 08:33:54'),
(16, 'fsdayfasf', 'safasfasf', 'fasfsafsa', '[]', 2, '2025-06-15 08:41:16', '2025-06-15 08:41:16'),
(18, 'fdfsdafsd', 'dsfsdfsdfsd', 'dasfafasfasfas', '[]', 2, '2025-06-15 09:07:30', '2025-06-15 09:07:30'),
(19, 'dsafasff', 'fasfsafa', 'fsafasfasf', '[]', 2, '2025-06-15 09:09:51', '2025-06-15 09:09:51'),
(21, 'dasdasdsa', 'dsdasdasd', 'dsadasdas', '[\"public\\/img\\/sleh.jpg\"]', 2, '2025-06-15 10:34:12', '2025-06-15 10:34:12'),
(22, 'hyperbola', 'dsdsds', 'dasdasdasd', '[\"public\\/img\\/BMW_Alpina_B7_Java_Green_2016_sada_07_800_600.jpg\"]', 2, '2025-06-15 11:17:14', '2025-06-15 11:17:14'),
(23, 'bakl', 'Torso', 'bozo', '[\"public\\/img\\/PP.jpg\"]', 2, '2025-06-15 11:51:38', '2025-06-15 12:03:37'),
(24, 'ddsds', 'dsadas', 'dsadasd', '[\"public\\/img\\/BMW_Alpina_B7_Java_Green_2016_sada_07_800_600.jpg\"]', 3, '2025-06-15 12:21:05', '2025-06-15 12:21:05'),
(25, 'brabus', 'Koloděj777', 'Krásný Brabus z mercedesu GLA. můžeme si povšimnout krásných křivek a úžasných barev.', '[\"public\\/img\\/dgvdxsgbdsxfhbd.png\"]', 2, '2025-06-15 13:00:39', '2025-06-15 13:00:39'),
(26, 'gt86', 'Brandys', 'Kolokolomlýnský', '[\"public\\/img\\/egfsgsgsgsedcsgsd.png\"]', 2, '2025-06-15 13:07:33', '2025-06-15 13:07:33'),
(27, 'Golum', 'Bazar006', 'Sigma Sigma', '[\"public\\/img\\/pngwing.com7.png\"]', 5, '2025-06-15 17:37:47', '2025-06-15 17:37:47'),
(28, 'dfds', 'sdfsd', 'sdfsd', '[\"public\\/img\\/pngimg.com-disabled_PNG126.png\"]', 5, '2025-06-15 17:38:23', '2025-06-15 17:38:23'),
(29, 'fgdfgfd', 'dfggfgdf', 'gdfgdfg', '[\"public\\/img\\/Default_standing_30_year_oldeuropean_man_dirty_adidas_tracksui_1.jpg\"]', 5, '2025-06-15 17:39:05', '2025-06-15 17:39:05'),
(30, 'fdgdgfd', 'dfgdfg', 'dfgdfgdf', '[\"public\\/img\\/ewgtrdyhddf.png\"]', 5, '2025-06-15 17:39:33', '2025-06-15 17:39:33'),
(31, 'fgfdg', 'dfgdfg', 'dfgdfg', '[\"public\\/img\\/FFASFASF.png\"]', 5, '2025-06-15 17:39:50', '2025-06-15 17:39:50'),
(32, 'asddasd', 'dasdas', 'asdsadas', '[\"public\\/img\\/BMW_Alpina_B7_Java_Green_2016_sada_07_800_600.jpg\"]', 5, '2025-06-15 17:40:17', '2025-06-15 17:40:17'),
(33, 'rgfts', 'fdsfsdf', 'fsdfsd', '[\"public\\/img\\/BMW_Alpina_B7_Java_Green_2016_sada_07_800_600.jpg\"]', 5, '2025-06-15 17:49:19', '2025-06-15 17:49:19'),
(34, 'fsfd', 'dfsdfs', 'dsffsd', '[\"public\\/img\\/BMW_Alpina_B7_Java_Green_2016_sada_07_800_600.jpg\"]', 2, '2025-06-15 18:16:12', '2025-06-15 18:16:12');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `name`, `surname`, `role`, `created_at`) VALUES
(1, 'Spravce', 'honzabrzak@gmail.com', '$2y$10$zCz6O.FFmh1IXUAv4a0sOe2XkTrKw9W4aOGaKCFzIQY1M9phvnhQS', 'Admin', 'Velkovezir', 'user', '2025-03-01 09:00:00'),
(2, 'jjj', 'jjj@jjj.cz', '$2y$10$PBkikccsTRJXf4xzkOHDI.1OsqRlKqMKKL.HTGftfE8zqbeqYDm76', 'jjj', 'jjj', 'admin', '2025-06-14 19:24:17'),
(3, 'Bozo', 'bozo@gmail.eu', '$2y$10$ohRdU/z3iCLSaCbotStksO3/LO9GybWtfvJ00SqTItCn/waXIZ5g6', 'Bozo', 'Bozor', 'user', '2025-06-15 12:20:39'),
(4, 'admin', 'admin@example.com', '$2y$10$1QK68GgUcc3l3.YhtkHybOaXKmDR8yNurOfUH3e8ei/rgu2g.tyq6', 'admin', 'admin', 'admin', '2025-06-15 12:24:38'),
(5, 'Bazar006', 'japan@jdm.cz', '$2y$10$QB5Z5rGqhfh.7hYxqdlh0.gk/Uj9hxEOwV4mSJ05Jx6I8S4dfaCIK', 'Augustus', 'Bonzajus', 'user', '2025-06-15 17:37:01');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `socpost_id` (`socpost_id`);

--
-- Indexy pro tabulku `socposts`
--
ALTER TABLE `socposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pro tabulku `socposts`
--
ALTER TABLE `socposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`socpost_id`) REFERENCES `socposts` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `socposts`
--
ALTER TABLE `socposts`
  ADD CONSTRAINT `socposts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
