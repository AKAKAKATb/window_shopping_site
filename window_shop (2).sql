-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 31 2025 г., 13:26
-- Версия сервера: 8.0.40
-- Версия PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `window_shop`
--
CREATE DATABASE IF NOT EXISTS `window_shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `window_shop`;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id_order` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_tc` int NOT NULL,
  `prods_name` text NOT NULL,
  `prods_weight` int NOT NULL,
  `price` int NOT NULL,
  `order_time` datetime NOT NULL,
  PRIMARY KEY (`id_order`),
  KEY `fk_id_user_idx` (`id_user`),
  KEY `id_tc_idx` (`id_tc`)
) ENGINE=InnoDB AUTO_INCREMENT=1000016 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `id_tc`, `prods_name`, `prods_weight`, `price`, `order_time`) VALUES
(1000006, 1, 3, 'Blitz, Constanta, Delight, Intelio', 711, 114810, '2025-02-24 10:41:19'),
(1000007, 1, 1, 'Blitz, Constanta, Delight, Grazio, Intelio', 29000, 4481000, '2025-02-24 11:41:40'),
(1000008, 1, 4, 'Blitz, Constanta, Delight, Grazio, Intelio', 29000, 4481000, '2025-02-24 11:56:38'),
(1000009, 199, 1, 'Blitz, Constanta, Delight', 530, 80460, '2025-02-24 17:32:09'),
(1000010, 199, 4, 'Constanta, Delight, Grazio', 661, 97740, '2025-02-24 17:35:20'),
(1000011, 1, 1, 'Blitz, Constanta', 313, 47000, '2025-03-01 14:58:32'),
(1000012, 1, 3, 'Blitz, Constanta, Delight, Grazio', 871, 133430, '2025-03-19 17:18:37'),
(1000013, 200, 3, 'Constanta, Delight', 116, 17330, '2025-03-19 17:25:31'),
(1000014, 1, 1, 'Blitz', 48, 7500, '2025-05-13 17:46:42'),
(1000015, 1, 1, 'Blitz', 48, 7500, '2025-08-23 11:25:27');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id_order` int NOT NULL,
  `id_product` int NOT NULL,
  `amount` int NOT NULL,
  PRIMARY KEY (`id_order`,`id_product`),
  KEY `fk_id_product_idx` (`id_product`),
  KEY `fk_id_order_idx` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id_order`, `id_product`, `amount`) VALUES
(1000006, 1, 4),
(1000006, 2, 1),
(1000006, 3, 2),
(1000006, 5, 5),
(1000007, 1, 100),
(1000007, 2, 100),
(1000007, 3, 100),
(1000007, 4, 100),
(1000007, 5, 100),
(1000008, 1, 100),
(1000008, 2, 100),
(1000008, 3, 100),
(1000008, 4, 100),
(1000008, 5, 100),
(1000009, 1, 4),
(1000009, 2, 4),
(1000009, 3, 2),
(1000010, 2, 8),
(1000010, 3, 1),
(1000010, 4, 3),
(1000011, 1, 1),
(1000011, 2, 5),
(1000012, 1, 11),
(1000012, 2, 3),
(1000012, 3, 2),
(1000012, 4, 1),
(1000013, 2, 1),
(1000013, 3, 1),
(1000014, 1, 1),
(1000015, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id_product` int NOT NULL AUTO_INCREMENT,
  `prod_name` varchar(45) NOT NULL,
  `prod_weight` int NOT NULL,
  PRIMARY KEY (`id_product`),
  UNIQUE KEY `id_product_UNIQUE` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id_product`, `prod_name`, `prod_weight`) VALUES
(1, 'Blitz', 48),
(2, 'Constanta', 53),
(3, 'Delight', 63),
(4, 'Grazio', 58),
(5, 'Intelio', 68);

-- --------------------------------------------------------

--
-- Структура таблицы `shipment_report`
--

DROP TABLE IF EXISTS `shipment_report`;
CREATE TABLE IF NOT EXISTS `shipment_report` (
  `id_image` int NOT NULL,
  `image` mediumblob NOT NULL,
  PRIMARY KEY (`id_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tr_companies`
--

DROP TABLE IF EXISTS `tr_companies`;
CREATE TABLE IF NOT EXISTS `tr_companies` (
  `id_tc` int NOT NULL AUTO_INCREMENT,
  `tc_name` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tc`,`tc_name`),
  UNIQUE KEY `id_tc_UNIQUE` (`id_tc`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tr_companies`
--

INSERT INTO `tr_companies` (`id_tc`, `tc_name`) VALUES
(1, 'DPD'),
(2, 'CDEK'),
(3, 'ПЭК'),
(4, 'Деловые Линии');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `rh_factor` tinyint NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_UNIQUE` (`id_user`),
  UNIQUE KEY `login_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `full_name`, `rh_factor`) VALUES
(1, 'admin', '$2y$10$pzQiDyHcT7mCLoQb619yy.1m1vxGy9Ie7ZX0TdcqtwQNuqppuian6', 'admin', 1),
(199, 'login', '$2y$10$F1S/.dZbDIMQyaZ4LyFvfeeVE1iCnwAF5nzPWZjtyqCp3Sm2J4WUq', 'В В В', 1),
(200, 'sdfgsd', '$2y$10$qcGwa4//u3X6c1OsLkMK7.3LS7OX7psMfLhAobbpVDwDo/JZV6ErC', 'Игорб Игорь Игорьвыыыыыыыыыыыыывываы', 0),
(201, 'FGHSFG', '$2y$10$pACfl1dk3ihdsZCdE0IUV.TeEnqhp.WS9yUsQhTXURKoKwNHVt7Ai', 'Ва Ва Ва', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
