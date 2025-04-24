-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 24 2025 г., 15:51
-- Версия сервера: 10.11.11-MariaDB-0ubuntu0.24.04.2
-- Версия PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `zoopoli1_zoopolis`
--

-- --------------------------------------------------------

--
-- Структура таблицы `acquiring`
--

CREATE TABLE `acquiring` (
  `id` int(11) NOT NULL COMMENT 'Порядковый',
  `user` int(11) DEFAULT NULL,
  `payid` varchar(16) DEFAULT NULL,
  `type` smallint(6) NOT NULL COMMENT '1 - zooid, 2 - concierge',
  `zooid_user` int(11) DEFAULT NULL,
  `concierge_user` int(11) DEFAULT NULL,
  `currency` varchar(5) NOT NULL DEFAULT 'byn',
  `sum` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `acquiring`
--

INSERT INTO `acquiring` (`id`, `user`, `payid`, `type`, `zooid_user`, `concierge_user`, `currency`, `sum`, `date`) VALUES
(1, 1, '3171820d5875468b', 1, 1, NULL, 'byn', 100, '2023-04-02 21:45:14'),
(2, 3, '77f2583c247035f8', 1, 12, NULL, 'byn', 250, '2023-04-02 19:11:36'),
(3, 3, '19838bbd9a6380a1', 1, 13, NULL, 'byn', 250, '2023-04-02 19:25:26'),
(4, 3, 'a5853533f83d2fb2', 1, 14, NULL, 'byn', 250, '2023-04-02 19:26:25'),
(5, 3, 'a73e741cae6d36b0', 1, 15, NULL, 'byn', 25000, '2023-04-02 19:28:18'),
(6, 3, 'a93fad26321eb94c', 1, 16, NULL, 'BYN', 25000, '2023-04-02 19:35:20'),
(7, 3, '5547a6b639335c94', 1, 17, NULL, 'BYN', 25000, '2023-04-02 19:38:41'),
(8, 3, '00ca298a35a26e32', 1, 18, NULL, 'BYN', 25000, '2023-04-02 20:10:50'),
(9, 3, '4c9970929f09cf90', 1, 19, NULL, 'BYN', 25000, '2023-04-02 20:13:07'),
(10, 3, 'c3365f84d1530e8f', 1, 20, NULL, 'BYN', 25000, '2023-04-02 20:13:37'),
(11, 3, '1ab9626cfbce56a7', 1, 21, NULL, 'BYN', 25000, '2023-04-02 20:21:24'),
(12, 3, 'd7da9e4a0eba6a45', 1, 22, NULL, 'BYN', 25000, '2023-04-02 20:51:30'),
(13, 3, 'b483314b7ad69be2', 1, 23, NULL, 'BYN', 25000, '2023-04-02 20:59:28'),
(14, 3, '78fac638b2046b12', 2, NULL, 6, 'BYN', 40000, '2023-04-02 21:04:47'),
(15, 4, '4260e18a49fb6198', 1, 24, NULL, 'BYN', 25000, '2023-04-10 17:09:08'),
(16, 4, '6739e8ff2a8b250a', 1, 25, NULL, 'BYN', 25000, '2023-04-10 17:14:12'),
(17, 4, '886bbe3782c4733b', 1, 26, NULL, 'BYN', 25000, '2023-04-10 17:14:23'),
(18, 4, '198e4817eeead670', 1, 27, NULL, 'BYN', 25000, '2023-04-10 17:22:04'),
(19, 3, 'e3c30cabc8fb50e5', 1, 28, NULL, 'BYN', 25000, '2023-05-14 12:13:56'),
(20, 3, 'f4bedd63fd42643a', 1, 29, NULL, 'BYN', 100000, '2023-05-23 04:39:46'),
(21, 3, '61fd5390f391af03', 1, 30, NULL, 'BYN', 100000, '2023-05-23 04:41:17'),
(22, 3, 'f8b481dcfd50e6f4', 1, 31, NULL, 'BYN', 100000, '2023-05-23 04:59:11'),
(23, 3, '446a5b75f9e5fe53', 1, 32, NULL, 'BYN', 100000, '2023-05-23 05:05:22'),
(24, 3, '843f85da71502b61', 1, 33, NULL, 'BYN', 100000, '2023-05-23 05:05:48'),
(25, 3, 'ed1b2b9704eb3508', 1, 34, NULL, 'BYN', 300, '2023-05-23 05:16:24'),
(26, 3, '6f20828f8b2567b4', 1, 35, NULL, 'BYN', 300, '2023-05-23 05:18:10'),
(27, 3, 'faa8b46ef1502c1e', 1, 36, NULL, 'BYN', 1800, '2023-05-23 05:19:08'),
(28, 3, '11198734ddde2523', 1, 37, NULL, 'BYN', 180000, '2023-05-23 05:20:00'),
(29, 3, '893ae50c56fad0e7', 1, 38, NULL, 'BYN', 180000, '2023-05-23 05:40:05'),
(30, 3, '7a2cd0ca88fb3e8e', 1, 39, NULL, 'BYN', 120000, '2023-05-23 07:48:40'),
(31, 3, '69c2b46afe0e4b5b', 1, 40, NULL, 'BYN', 120000, '2023-05-23 07:56:41'),
(32, 3, 'd44abd17f57dce37', 1, 41, NULL, 'BYN', 120000, '2023-05-23 07:57:29'),
(33, 3, '0cfd9eb96ebfd0fb', 1, 42, NULL, 'BYN', 120000, '2023-05-23 07:57:35'),
(34, 3, 'ad3a9e91141929cb', 2, NULL, 7, 'BYN', 360000, '2023-05-23 08:26:57'),
(35, 9, '6553175da489429d', 1, 43, NULL, 'BYN', 180000, '2023-08-29 08:37:13'),
(36, 9, '1e63b5d6e28acab0', 2, NULL, 8, 'BYN', 300000, '2023-08-29 08:39:11'),
(37, 3, '7a91ce03792add43', 1, 44, NULL, 'BYN', 180000, '2024-04-11 15:38:21'),
(38, 11, 'b14cd5d17807fb88', 1, 45, NULL, 'BYN', 180000, '2024-08-19 12:09:50'),
(39, 11, '25819824b40a214d', 1, 46, NULL, 'BYN', 180000, '2024-08-19 12:18:20'),
(40, 11, '2a11986b93d561b4', 1, 47, NULL, 'BYN', 180000, '2024-08-19 12:19:10'),
(41, 11, 'd5c084b13886b52c', 1, 48, NULL, 'BYN', 180000, '2024-08-19 13:32:06'),
(42, 11, '15ccccc839c5b8bc', 1, 49, NULL, 'BYN', 180000, '2024-08-20 12:28:31'),
(43, 19, '942d69470a9ff52f', 1, 50, NULL, 'BYN', 180000, '2024-11-27 13:20:31'),
(44, 11, '7031d56040daf33b', 1, 51, NULL, 'BYN', 180000, '2024-12-18 11:41:16'),
(45, 21, '2379b1b4a25b8662', 1, 52, NULL, 'BYN', 180000, '2024-12-19 12:06:50'),
(46, 9, '79fbcb10bd73092d', 1, 53, NULL, 'BYN', 180000, '2024-12-23 14:46:05'),
(47, 9, 'fc7f2e0b4f506d78', 2, NULL, 9, 'BYN', 360000, '2024-12-23 15:48:51'),
(48, 22, 'b2ae2df5c5d2ce1b', 1, 54, NULL, 'BYN', 10000, '2024-12-24 14:58:21'),
(49, 22, '7681d83f945cda18', 1, 55, NULL, 'BYN', 10000, '2024-12-24 14:58:32'),
(50, 22, '412d0ca07081c309', 1, 56, NULL, 'BYN', 240000, '2024-12-24 15:00:56'),
(51, 21, 'cf34ba416f9bee1b', 2, NULL, 10, 'BYN', 60000, '2025-01-09 10:51:33'),
(52, 21, '6a04d03323730ea1', 2, NULL, 11, 'BYN', 60000, '2025-01-09 10:53:45'),
(53, 24, '0013ee632cb5bca7', 1, 57, NULL, 'BYN', 4200, '2025-01-15 16:23:40'),
(54, 26, '51bafb05f3688f15', 1, 58, NULL, 'BYN', 700, '2025-02-05 09:35:32'),
(55, 26, '09eb0532543ca277', 1, 59, NULL, 'BYN', 700, '2025-02-05 09:38:50'),
(56, 26, '0130d7916492137f', 1, 60, NULL, 'BYN', 8400, '2025-02-05 09:39:11'),
(57, 26, '6e1da18e1b1b64f8', 1, 61, NULL, 'BYN', 8400, '2025-02-05 09:39:47'),
(58, 26, 'df95c2ed44bb9644', 1, 62, NULL, 'BYN', 700, '2025-02-05 09:39:57'),
(59, 26, '4ecc86d1dd1b6f58', 1, 63, NULL, 'BYN', 700, '2025-02-05 09:40:22'),
(60, 30, '2cc577490cf2725c', 1, 64, NULL, 'BYN', 4200, '2025-02-08 11:19:46'),
(61, 30, '4497338ea9d1d331', 1, 65, NULL, 'BYN', 4200, '2025-02-08 11:19:50'),
(62, 30, 'f1aaff91ec32d8fd', 1, 66, NULL, 'BYN', 4200, '2025-02-08 11:20:00'),
(63, 30, '1bf97b7a7e87e5c5', 1, 67, NULL, 'BYN', 4200, '2025-02-08 11:20:13'),
(64, 30, '8323a74f667737f9', 1, 68, NULL, 'BYN', 500, '2025-02-08 11:20:27'),
(65, 30, '9c45e467776b7a48', 1, 69, NULL, 'BYN', 500, '2025-02-08 11:20:31'),
(66, 30, '8e1da876d6740811', 1, 70, NULL, 'BYN', 500, '2025-02-08 11:20:32'),
(67, 30, '9b5b0eb06c74f088', 1, 71, NULL, 'BYN', 500, '2025-02-08 11:20:32'),
(68, 30, '6369e96d9267f257', 1, 72, NULL, 'BYN', 500, '2025-02-08 11:20:33'),
(69, 30, '090838360c535af2', 1, 73, NULL, 'BYN', 500, '2025-02-08 11:20:34'),
(70, 30, '0153d237de135dc5', 1, 74, NULL, 'BYN', 500, '2025-02-08 11:20:35'),
(71, 30, 'd9f2f5ee69bac683', 1, 75, NULL, 'BYN', 500, '2025-02-08 11:20:36'),
(72, 30, 'c283a8cac1611f4d', 1, 76, NULL, 'BYN', 500, '2025-02-08 11:20:41'),
(73, 30, 'b205259d8b5bb4cd', 1, 77, NULL, 'BYN', 500, '2025-02-08 11:20:42'),
(74, 30, '8f56bff98bcfc472', 1, 78, NULL, 'BYN', 500, '2025-02-08 11:20:42'),
(75, 30, '8235fc90030a11cf', 1, 79, NULL, 'BYN', 500, '2025-02-08 11:20:42'),
(76, 30, '23d764368e2cbef3', 1, 80, NULL, 'BYN', 500, '2025-02-08 11:20:42'),
(77, 30, '8db262df55fea8ff', 1, 81, NULL, 'BYN', 500, '2025-02-08 11:20:42'),
(78, 30, '596830eab7206f1e', 1, 82, NULL, 'BYN', 500, '2025-02-08 11:20:43'),
(79, 30, 'b32db78a422fcd94', 1, 83, NULL, 'BYN', 500, '2025-02-08 11:20:43'),
(80, 30, 'f7b89f4bf2c1e9e0', 1, 84, NULL, 'BYN', 500, '2025-02-08 11:20:43'),
(81, 30, 'a1c4aba2bbbbb9e4', 1, 85, NULL, 'BYN', 500, '2025-02-08 11:20:43'),
(82, 30, '63c4abb5107291fb', 1, 86, NULL, 'BYN', 500, '2025-02-08 11:20:43'),
(83, 30, 'f593d40ce9ea9245', 1, 87, NULL, 'BYN', 500, '2025-02-08 11:20:43'),
(84, 30, '6557ec8afc2fec1e', 1, 88, NULL, 'BYN', 500, '2025-02-08 11:20:44'),
(85, 30, '0eeff9d633ca2e57', 1, 89, NULL, 'BYN', 500, '2025-02-08 11:20:44'),
(86, 30, '4304d7ad59745128', 1, 90, NULL, 'BYN', 500, '2025-02-08 11:20:44'),
(87, 30, '6bdea5509926c8f3', 1, 91, NULL, 'BYN', 500, '2025-02-08 11:20:44'),
(88, 30, '42c99f47c5c1e572', 1, 92, NULL, 'BYN', 500, '2025-02-08 11:20:44'),
(89, 30, '5b121a1f770cccab', 1, 93, NULL, 'BYN', 500, '2025-02-08 11:20:45'),
(90, 30, '7d9c231306c7418c', 1, 94, NULL, 'BYN', 500, '2025-02-08 11:20:45'),
(91, 30, '2629b6cab92779a4', 1, 95, NULL, 'BYN', 500, '2025-02-08 11:20:45'),
(92, 30, '7b3da21cfd5e01d1', 1, 96, NULL, 'BYN', 500, '2025-02-08 11:20:46'),
(93, 30, 'e97167680c1b7317', 1, 97, NULL, 'BYN', 500, '2025-02-08 11:20:51'),
(94, 30, 'c3397d8a85674eb3', 1, 98, NULL, 'BYN', 500, '2025-02-08 11:20:52'),
(95, 30, '32d6163cff277e30', 1, 99, NULL, 'BYN', 700, '2025-02-08 11:20:56'),
(96, 30, '85c6f28d18ab50ab', 1, 100, NULL, 'BYN', 500, '2025-02-08 11:21:06'),
(97, 30, '85fc95958220e190', 1, 101, NULL, 'BYN', 500, '2025-02-08 11:21:07'),
(98, 30, 'cd903ce304280779', 1, 102, NULL, 'BYN', 500, '2025-02-08 11:21:07'),
(99, 30, '510b02f4d73a86d6', 1, 103, NULL, 'BYN', 500, '2025-02-08 11:21:07'),
(100, 30, 'f6710367081b39ae', 1, 104, NULL, 'BYN', 500, '2025-02-08 11:21:07'),
(101, 30, '1eafc6eb34d12644', 1, 105, NULL, 'BYN', 500, '2025-02-08 11:21:07'),
(102, 30, 'dcb63b90ce0a7241', 1, 106, NULL, 'BYN', 500, '2025-02-08 11:21:08'),
(103, 30, 'e0dd1ef8190cc8db', 1, 107, NULL, 'BYN', 500, '2025-02-08 11:21:08'),
(104, 30, '0c9cf534c95ef445', 1, 108, NULL, 'BYN', 700, '2025-02-08 11:21:18'),
(105, 30, '2bf96f5373152416', 1, 109, NULL, 'BYN', 700, '2025-02-08 11:21:20'),
(106, 30, '20e29f1756ae8c7f', 1, 110, NULL, 'BYN', 700, '2025-02-08 11:21:26'),
(107, 30, '8dae0256a9f9f9cd', 1, 111, NULL, 'BYN', 500, '2025-02-08 11:21:47'),
(108, 29, '98d0e4329ddf3ac7', 1, 112, NULL, 'BYN', 4200, '2025-02-09 07:15:06'),
(109, 29, '3cd0e444c8ac235d', 1, 113, NULL, 'BYN', 500, '2025-02-09 07:15:19'),
(110, 29, 'c566e726debd3b42', 1, 114, NULL, 'BYN', 700, '2025-02-09 07:17:11'),
(111, 29, 'ce9dab49b23c6707', 1, 115, NULL, 'BYN', 700, '2025-02-09 07:17:12'),
(112, 30, '9c38ec874f195b40', 1, 116, NULL, 'BYN', 700, '2025-02-17 12:30:04'),
(113, 30, '756ef6d4b45f206b', 1, 117, NULL, 'BYN', 0, '2025-02-17 12:42:03'),
(114, 30, '988f8b349a1cc295', 1, 118, NULL, 'BYN', 0, '2025-02-17 12:42:04'),
(115, 32, '6c718653b73a1ca1', 1, 119, NULL, 'BYN', 500, '2025-02-19 21:06:44'),
(116, 32, 'a8f8ef97d2b534ca', 1, 120, NULL, 'BYN', 500, '2025-02-19 21:07:24'),
(117, 36, 'a737d01764b35f61', 1, 121, NULL, 'BYN', 500, '2025-02-27 15:42:19'),
(118, 36, 'daadec040d742cae', 1, 122, NULL, 'BYN', 500, '2025-02-27 16:01:04'),
(119, 36, 'fe786dc96daed18c', 1, 123, NULL, 'BYN', 500, '2025-02-28 09:19:57'),
(120, 36, 'f342b0b273d89c03', 1, 124, NULL, 'BYN', 500, '2025-02-28 09:21:52'),
(121, 36, '8fd825241f57a985', 1, 125, NULL, 'BYN', 500, '2025-02-28 09:23:52'),
(122, 36, 'aeea73170d713b38', 1, 126, NULL, 'BYN', 3000, '2025-02-28 09:24:52'),
(123, 36, '1ac414cdf32cf1c2', 1, 127, NULL, 'BYN', 3000, '2025-02-28 09:28:47'),
(124, 36, '7f046b4b395cd597', 1, 128, NULL, 'BYN', 500, '2025-02-28 09:32:42'),
(125, 34, '69939f1a88c406f5', 2, NULL, 12, 'BYN', 360000, '2025-02-28 09:39:31'),
(126, 36, '5c80f8b875e02476', 1, 129, NULL, 'BYN', 0, '2025-02-28 09:41:24'),
(127, 33, 'c3aa2a10b6f1199c', 1, 130, NULL, 'BYN', 500, '2025-02-28 21:09:17'),
(128, 37, '25f7d4b4ce2c77fc', 1, 131, NULL, 'BYN', 500, '2025-02-28 21:22:28'),
(129, 39, 'dbfc04ec49714d13', 1, 132, NULL, 'BYN', 1500, '2025-03-01 11:23:40'),
(130, 39, '735f26f9c5cbebed', 1, 133, NULL, 'BYN', 1500, '2025-03-01 11:28:50'),
(131, 40, '5c0b186b7fb90e61', 1, 134, NULL, 'BYN', 1500, '2025-03-05 10:29:48'),
(132, 41, '9a556ebc89928323', 1, 135, NULL, 'BYN', 1500, '2025-03-07 05:53:05'),
(133, 43, 'a1ff71e93fad15ef', 1, 136, NULL, 'BYN', 1500, '2025-03-13 15:27:21'),
(134, 43, '77db6107bb6aabc8', 1, 137, NULL, 'BYN', 1500, '2025-03-13 15:30:48'),
(135, 43, 'c1135fd731c06d18', 1, 138, NULL, 'BYN', 1500, '2025-03-13 15:31:10'),
(136, 45, '354ee9a66a0c4bb9', 1, 139, NULL, 'BYN', 1500, '2025-03-24 17:06:26'),
(137, 47, 'b6fa85ca64070fe5', 1, 140, NULL, 'BYN', 12000, '2025-03-26 16:39:10'),
(138, 47, '84d039ed8f10ae92', 1, 141, NULL, 'BYN', 5000, '2025-03-26 16:41:31'),
(139, 22, '65f3b5814a1a6478', 1, 142, NULL, 'BYN', 3000, '2025-03-27 07:00:25'),
(140, 22, '79889bc67fcdc82d', 1, 143, NULL, 'BYN', 3000, '2025-03-27 07:13:55'),
(141, 50, '8b6d8bf757369088', 1, 144, NULL, 'BYN', 3000, '2025-03-27 08:20:05'),
(142, 40, 'c996ca211bd3ccfc', 1, 145, NULL, 'BYN', 3000, '2025-03-28 05:29:15');

-- --------------------------------------------------------

--
-- Структура таблицы `check_phone_numbers`
--

CREATE TABLE `check_phone_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(1, 'Минск'),
(2, 'Брест');

-- --------------------------------------------------------

--
-- Структура таблицы `concierge`
--

CREATE TABLE `concierge` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `descshort` text DEFAULT NULL,
  `desc` mediumtext DEFAULT NULL,
  `BYN` int(11) NOT NULL DEFAULT 0,
  `RUB` int(11) NOT NULL DEFAULT 0,
  `hide` tinyint(4) NOT NULL DEFAULT 0,
  `delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `concierge`
--

INSERT INTO `concierge` (`id`, `name`, `descshort`, `desc`, `BYN`, `RUB`, `hide`, `delete`) VALUES
(1, 'ЗооКонсьерж (Базовый тариф, обязательный)', NULL, NULL, 500, 1600, 0, 0),
(2, 'Звонки в 6 утра', NULL, NULL, 100, 200, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `concierge_userconfig`
--

CREATE TABLE `concierge_userconfig` (
  `user` bigint(20) UNSIGNED NOT NULL,
  `config` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `concierge_userconfig`
--

INSERT INTO `concierge_userconfig` (`user`, `config`) VALUES
(9, '[2]');

-- --------------------------------------------------------

--
-- Структура таблицы `form_missinganimal`
--

CREATE TABLE `form_missinganimal` (
  `id` bigint(20) NOT NULL,
  `user` bigint(20) UNSIGNED NOT NULL,
  `create` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `text` text DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `uid` char(36) DEFAULT NULL,
  `name_finder` varchar(255) DEFAULT NULL,
  `phone_finder` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `form_missinganimal`
--

INSERT INTO `form_missinganimal` (`id`, `user`, `create`, `text`, `comments`, `status`, `uid`, `name_finder`, `phone_finder`, `address`) VALUES
(1, 3, '2023-05-31 06:54:56', 'dfsa', NULL, 0, NULL, NULL, NULL, NULL),
(2, 3, '2023-08-02 13:13:00', 'Подготовили для вас статью с бесплатными курсами по Python. В некоторых курсах есть тренажеры: можно проходить теории и там же практиковаться.\r<div>\r</div><div>Покликайте на курсы, выбирайте. Важно, чтобы вам был удобен курс, понятен язык изложения, и ваш уровень знаний подходил для конкретного курса.\r</div><div>Python — это один из наиболее популярных языков программирования в мире, широко применяемый как в создании программного обеспечении, так и в Data Science B Machine Learning.\r</div><div>Тренажеры\r</div><div>Бесплатный тренажер по Python от Каталог-курсов.ру\r</div><div>Тип: тренажер состоит из блоков теории, после которых сразу идет практика с задачами внутри тренажера. Бесплатный сертификат о прохождении выдается после окончания курса.\r</div><div>Язык: русский.\r</div><div>W3schools.com\r</div><div>Тип: обучающий тренажер.\r</div><div>Язык: английский.\r</div><div>Codewars.ru\r</div><div>Тип: обучающий тренажер.\r</div><div>Язык: английский.\r</div><div>Бесплатные курсы от школ\r</div><div>\"Поколение Python: курс для начинающих\" от Stepik\r</div><div>Курс на платформе Stepik от онлайн-школы BEEGEEK для начинающих и учащихся образовательных учреждений. Программа предлагает изучить основы владения Python, а по окончании участников ждет электронный сертификат.\r</div><div>\"Программирование для всех (начало работы с Python)\" от Coursera\r</div><div>Бесплатный курс от Мичиганского университета на платформе Coursera предлагает участником набор онлайн-лекций по базовым навыкам владения языком Python. Каждый поток длится 7 недель, в рамках которых профессор Чарльз Северанс преподносит знания из своей книги \"Python for Everybody\".\r</div><div>\"Ключевые аспекты разработки на Python\" от Hexlet\r</div><div>Бесплатный курс по Python от Хекслет для начинающих программистов. Материалы, среди которых — 7 уроков в формате текста или видео и тесты, раскрывают основы написания кодов на языке, а также описывают ключевые аспекты работы в его экосистеме.\r</div><div>\"Программирование на Python\" от Stepik\r</div><div>В рамках этих курсов по Python от Skillbox автор Артем Манченков расскажет обо всем, что пригодится начинающему программисту, используя реальные примеры. Вместе участники пройдут путь от написания интерфейса мессенджера до создания голосового помощника — и все это в формате видео.\r</div><div>\"Инди-курс программирования на Python\" от Stepik\r</div><div>Как заявляет автор курса, его программа рассчитана для программистов Python с любым уровнем знаний. По мере прохождения участников ждут 90 видеоуроков и практических заданий. По окончании курса платформа Stepik выдает электронный сертификат.\r</div><div>\"Python для начинающих\" от Академии IT\r</div><div>Бесплатный курс от Академии IT с рейтингом 4,75. Обучение состоит из прохождения 42 уроков, во время которых автор Михаил Тарасов расскажет все об основах программирования на Python, а также поделится ценной информацией о будущей карьере программиста.\r</div><div>\"Основы языка Python\" от Hexlet\r</div><div>\"Добрый, добрый Python\" от Сергея Балакирева\r</div><div>\"Уроки Python\" от itProger\r</div><div>\"Python\" от Skillbox\r</div><div>\"Основы программирования на языке Python в примерах и задачах\" от Stepik\r</div><div>\"Python-разработка для начинающих\" от Нетологии\r</div><div>Топ-25 бесплатных курсов обучения Python 2023 года Python, IT, Программирование, Программист, Курсы программирования, Разработка, Длиннопост\r</div><div>Курсы с Youtube\r</div><div>Этический взлом на Python\r</div><div>Курс YouTube-лекций по программированию на Python. Вся программа состоит из 123 видео длительность от 5 до 12 минут. При желании можно найти те же видео на языке оригинала.\r</div><div>Язык программирования PYTHON для начинающих\r</div><div>Интернет-магазин Django 3.0\r</div><div>Python для начинающих от Code Basics\r</div><div>Python для начинающих от ItProger\r</div><div>Python для новичка\r</div><div>Программирование на Python (2021)\r</div><div>Django для python (уроки)\r</div><div>2020 Практика программирования на Python, лекция №1\r</div><div>Уроки изучения Django / Создание сайта на Джанго\r</div><div>Топ-25 бесплатных курсов обучения Python 2023 года Python, IT, Программирование, Программист, Курсы программирования, Разработка, Длиннопост\r</div><div>Что можно писать на Python\r</div><div>Практически как Java, Python находит применение во многих областях программирования. Так, например, язык применяют в:\r</div><div>Создании систем автоматизации;\r</div><div>Веб-разработке;\r</div><div>Создании приложений;\r</div><div>Математических расчетах и других продуктах.\r</div><div>Сколько приносит знание Python в 2023 году?\r</div><div>Средняя заработная плата Python-программистов, согласно данным портала ГородРабот.ру, составляет 131 478 рублей — лучший показатель на рынке труда. А вот новички, основываясь на информации HH.ru, могут получать оплату от 70 000 рублей.\r</div><div>Ключевой недостаток владения Python — это необходимость конкурировать с другими кандидатами за место в штате. По подсчетам того же ГородРабот.ру, количество вакансий на позицию Python-разработчика достигает до 203 мест ежемесячно, однако и предложение труда уверенно растет: так, команда Skillbox посчитала, что на одно место программиста Python в 2023 году приходятся сразу 20 кандидатов.\r</div><div>Почему Python?\r</div><div>Python — идеальное решение для каждого и предлагает:\r</div><div>Доступность — из-за простого синтаксиса язык понятен даже новичкам;\r</div><div>Кроссплатформенность — интерпретаторы Python поддерживаются большинством операционных систем;\r</div><div>Разнообразие применения — язык нужен везде: от веб-разработки до геймдева;\r</div><div>Интегративность — Python можно применять в сочетании с другими системами и встраивать его коды как компоненты.</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div>', 'еуые', 1, NULL, NULL, NULL, NULL),
(3, 3, '2024-12-03 20:09:04', 'Подготовили для вас статью с бесплатными курсами по Python. В некоторых курсах есть тренажеры: можно проходить теории и там же практиковаться.\r<div>\r</div><div>Покликайте на курсы, выбирайте. Важно, чтобы вам был удобен курс, понятен язык изложения, и ваш уровень знаний подходил для конкретного курса.\r</div><div>Python — это один из наиболее популярных языков программирования в мире, широко применяемый как в создании программного обеспечении, так и в Data Science B Machine Learning.\r</div><div>Тренажеры\r</div><div>Бесплатный тренажер по Python от Каталог-курсов.ру\r</div><div>Тип: тренажер состоит из блоков теории, после которых сразу идет практика с задачами внутри тренажера. Бесплатный сертификат о прохождении выдается после окончания курса.\r</div><div>Язык: русский.\r</div><div>W3schools.com\r</div><div>Тип: обучающий тренажер.\r</div><div>Язык: английский.\r</div><div>Codewars.ru\r</div><div>Тип: обучающий тренажер.\r</div><div>Язык: английский.\r</div><div>Бесплатные курсы от школ\r</div><div>\"Поколение Python: курс для начинающих\" от Stepik\r</div><div>Курс на платформе Stepik от онлайн-школы BEEGEEK для начинающих и учащихся образовательных учреждений. Программа предлагает изучить основы владения Python, а по окончании участников ждет электронный сертификат.\r</div><div>\"Программирование для всех (начало работы с Python)\" от Coursera\r</div><div>Бесплатный курс от Мичиганского университета на платформе Coursera предлагает участником набор онлайн-лекций по базовым навыкам владения языком Python. Каждый поток длится 7 недель, в рамках которых профессор Чарльз Северанс преподносит знания из своей книги \"Python for Everybody\".\r</div><div>\"Ключевые аспекты разработки на Python\" от Hexlet\r</div><div>Бесплатный курс по Python от Хекслет для начинающих программистов. Материалы, среди которых — 7 уроков в формате текста или видео и тесты, раскрывают основы написания кодов на языке, а также описывают ключевые аспекты работы в его экосистеме.\r</div><div>\"Программирование на Python\" от Stepik\r</div><div>В рамках этих курсов по Python от Skillbox автор Артем Манченков расскажет обо всем, что пригодится начинающему программисту, используя реальные примеры. Вместе участники пройдут путь от написания интерфейса мессенджера до создания голосового помощника — и все это в формате видео.\r</div><div>\"Инди-курс программирования на Python\" от Stepik\r</div><div>Как заявляет автор курса, его программа рассчитана для программистов Python с любым уровнем знаний. По мере прохождения участников ждут 90 видеоуроков и практических заданий. По окончании курса платформа Stepik выдает электронный сертификат.\r</div><div>\"Python для начинающих\" от Академии IT\r</div><div>Бесплатный курс от Академии IT с рейтингом 4,75. Обучение состоит из прохождения 42 уроков, во время которых автор Михаил Тарасов расскажет все об основах программирования на Python, а также поделится ценной информацией о будущей карьере программиста.\r</div><div>\"Основы языка Python\" от Hexlet\r</div><div>\"Добрый, добрый Python\" от Сергея Балакирева\r</div><div>\"Уроки Python\" от itProger\r</div><div>\"Python\" от Skillbox\r</div><div>\"Основы программирования на языке Python в примерах и задачах\" от Stepik\r</div><div>\"Python-разработка для начинающих\" от Нетологии\r</div><div>Топ-25 бесплатных курсов обучения Python 2023 года Python, IT, Программирование, Программист, Курсы программирования, Разработка, Длиннопост\r</div><div>Курсы с Youtube\r</div><div>Этический взлом на Python\r</div><div>Курс YouTube-лекций по программированию на Python. Вся программа состоит из 123 видео длительность от 5 до 12 минут. При желании можно найти те же видео на языке оригинала.\r</div><div>Язык программирования PYTHON для начинающих\r</div><div>Интернет-магазин Django 3.0\r</div><div>Python для начинающих от Code Basics\r</div><div>Python для начинающих от ItProger\r</div><div>Python для новичка\r</div><div>Программирование на Python (2021)\r</div><div>Django для python (уроки)\r</div><div>2020 Практика программирования на Python, лекция №1\r</div><div>Уроки изучения Django / Создание сайта на Джанго\r</div><div>Топ-25 бесплатных курсов обучения Python 2023 года Python, IT, Программирование, Программист, Курсы программирования, Разработка, Длиннопост\r</div><div>Что можно писать на Python\r</div><div>Практически как Java, Python находит применение во многих областях программирования. Так, например, язык применяют в:\r</div><div>Создании систем автоматизации;\r</div><div>Веб-разработке;\r</div><div>Создании приложений;\r</div><div>Математических расчетах и других продуктах.\r</div><div>Сколько приносит знание Python в 2023 году?\r</div><div>Средняя заработная плата Python-программистов, согласно данным портала ГородРабот.ру, составляет 131 478 рублей — лучший показатель на рынке труда. А вот новички, основываясь на информации HH.ru, могут получать оплату от 70 000 рублей.\r</div><div>Ключевой недостаток владения Python — это необходимость конкурировать с другими кандидатами за место в штате. По подсчетам того же ГородРабот.ру, количество вакансий на позицию Python-разработчика достигает до 203 мест ежемесячно, однако и предложение труда уверенно растет: так, команда Skillbox посчитала, что на одно место программиста Python в 2023 году приходятся сразу 20 кандидатов.\r</div><div>Почему Python?\r</div><div>Python — идеальное решение для каждого и предлагает:\r</div><div>Доступность — из-за простого синтаксиса язык понятен даже новичкам;\r</div><div>Кроссплатформенность — интерпретаторы Python поддерживаются большинством операционных систем;\r</div><div>Разнообразие применения — язык нужен везде: от веб-разработки до геймдева;\r</div><div>Интегративность — Python можно применять в сочетании с другими системами и встраивать его коды как компоненты.</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div><div>\r</div>', 'awd', 0, NULL, NULL, NULL, NULL),
(4, 9, '2024-12-03 20:08:27', 'Добрый день, во время прогулки моя собака', NULL, 2, NULL, NULL, NULL, NULL),
(5, 22, '2024-12-24 15:02:26', 'Потеряла питомца!&nbsp;<br>что делать?&nbsp;<br>хотела бы воспользоваться Вашим сервисом!&nbsp;<br>Помогите!', NULL, 0, NULL, NULL, NULL, NULL),
(6, 21, '2025-01-07 18:54:45', 'ываошышаоыоащыоащ тест 0701', NULL, 0, NULL, NULL, NULL, NULL),
(7, 24, '2025-01-20 14:24:06', 'wwwwwwww', NULL, 0, NULL, NULL, NULL, NULL),
(8, 26, '2025-02-05 09:41:58', '', NULL, 0, NULL, NULL, NULL, NULL),
(9, 34, '2025-02-22 15:08:25', 'Тетст Срочной!', NULL, 0, NULL, NULL, NULL, NULL),
(10, 31, '2025-02-15 11:18:52', '1111 тест', NULL, 0, NULL, NULL, NULL, NULL),
(11, 30, '2025-02-15 12:20:51', '375 (99) 999-11-13', NULL, 1, NULL, NULL, NULL, NULL),
(12, 0, '2025-02-18 17:48:00', NULL, '1', 0, 'e0414d20-f8b2-493b-b81c-63a4a8f08f9a', '1', '+375 1', 'Центральное РУВД г.Минска, 58 к1, Орловская улица, Центральный район, Минск, 220053, Беларусь'),
(13, 36, '2025-02-27 15:47:01', 'питомец Теди потерялся в центре Минска..&nbsp;<br>тест 27.02', NULL, 0, NULL, NULL, NULL, NULL),
(14, 34, '2025-02-27 17:26:35', 'произошел<div>ужасный&nbsp;</div><div>конфуз</div>', NULL, 0, NULL, NULL, NULL, NULL),
(15, 33, '2025-02-28 21:16:30', 'Пропал мой Банни 01.03<div><br></div><div>Очень переживаем&nbsp;</div>', NULL, 0, NULL, NULL, NULL, NULL),
(16, 0, '2025-03-05 08:24:00', NULL, '', 0, 'e0414d20-f8b2-493b-b81c-63a4a8f08f9a', '1', '+375 1', ''),
(17, 34, '2025-03-05 09:28:58', 'Пропала собака по кличке Дружок', NULL, 0, NULL, NULL, NULL, '39, улица Максима Богдановича, Сторожовка, Центральный район, Минск, 220002, Беларусь'),
(18, 41, '2025-03-07 05:56:15', 'Пропал малыш ((', NULL, 0, NULL, NULL, NULL, 'Стадион Динамо, 8 к6, улица Кирова, Ляховская Слобода, Ленинский район, Минск, 220030, Беларусь'),
(19, 36, '2025-03-07 12:39:10', 'Пропал мой пушистый - зовут Педдиииииииииииииииииии, что делать? подскажите 07.03.25', NULL, 0, NULL, NULL, NULL, 'ТЦ Galleria Minsk, 9, проспект Победителей, Замчище, Центральный район, Минск, 220004, Беларусь'),
(20, 36, '2025-03-07 12:40:09', '', NULL, 0, NULL, NULL, NULL, '13, 7-й Орловский переулок, Центральный район, Минск, 220068, Беларусь'),
(21, 22, '2025-03-12 11:20:08', 'мой пушистый пропал 11.03.25', NULL, 0, NULL, NULL, NULL, ''),
(22, 22, '2025-03-27 07:02:10', 'потерялся питомец! мой тедди кудато делся в парке... ', NULL, 0, NULL, NULL, NULL, 'Коммунистическая улица, Старостинская Слобода, Центральный район, Минск, 722197, Беларусь');

-- --------------------------------------------------------

--
-- Структура таблицы `media`
--

CREATE TABLE `media` (
  `id` bigint(20) NOT NULL,
  `a` tinyint(3) UNSIGNED ZEROFILL DEFAULT NULL,
  `b` tinyint(3) UNSIGNED ZEROFILL DEFAULT NULL,
  `name` text DEFAULT NULL,
  `type` tinyint(1) UNSIGNED ZEROFILL DEFAULT 0,
  `create` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `media`
--

INSERT INTO `media` (`id`, `a`, `b`, `name`, `type`, `create`, `status`) VALUES
(27, 221, 254, '435b5c23.jpg', 1, '2025-02-24 15:28:46', 1),
(28, 177, 089, 'd16c60e2.png', 2, '2025-02-24 15:31:10', 1),
(29, 190, 090, 'd2433116.jpg', 1, '2025-02-24 15:36:47', 1),
(30, 008, 130, '41a737e5.png', 2, '2025-03-26 15:25:39', 1),
(31, 028, 237, '2706f019.jpg', 1, '2025-03-26 15:31:04', 1),
(32, 069, 239, 'be0a9aae.jpg', 1, '2025-03-26 15:32:13', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2024_08_21_124611_create_user_request_cities', 1),
(5, '2024_12_07_025442_add_column_is_active_in_users', 1),
(7, '2024_12_23_154444_create_concierge_userconfig_table', 2),
(8, '2025_02_13_141647_create_pet_qr_codes_table', 3),
(9, '2025_02_14_184040_add_column_in_form_missinganimal', 4),
(12, '2025_03_09_152151_create_pet_shops_table', 5),
(13, '2025_03_18_083745_add_column_code_verification_in_users', 6),
(18, '2025_03_28_135058_create_temp_registers_table', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `pet_qr_codes`
--

CREATE TABLE `pet_qr_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pet_qr_codes`
--

INSERT INTO `pet_qr_codes` (`id`, `uid`, `user_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'e0414d20-f8b2-493b-b81c-63a4a8f08f9a', 34, 1, '2025-02-13 15:24:20', '2025-02-22 14:49:13'),
(2, '67b0e7d6-534e-4478-8d84-4415e876c4c9', NULL, 0, '2025-02-13 15:25:10', '2025-02-13 15:25:10'),
(3, 'fd258569-fe66-4a7c-9d72-d4acdcb09af9', 37, 1, '2025-02-19 12:47:59', '2025-02-28 21:21:38');

-- --------------------------------------------------------

--
-- Структура таблицы `pet_shops`
--

CREATE TABLE `pet_shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `time_work` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pet_shops`
--

INSERT INTO `pet_shops` (`id`, `name`, `address`, `desc`, `link`, `phone`, `time_work`, `lat`, `lng`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ЗооЗавр', 'Гостиный двор, площадь Свободы, Верхний город, Центральный район, Минск, 220030, Беларусь', 'text<div>text</div>', 'https://ya.ru/', '+7 952 952 95 52', '123 3123', '53.904171', '27.555684', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `promo`
--

CREATE TABLE `promo` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT 1,
  `media` text DEFAULT NULL,
  `shortdesc` varchar(1000) DEFAULT NULL,
  `percent` int(11) DEFAULT NULL,
  `summ` int(11) DEFAULT NULL,
  `promocode` varchar(100) DEFAULT NULL,
  `promolink` varchar(1000) DEFAULT NULL,
  `сonditions` text DEFAULT NULL,
  `minprice` int(11) DEFAULT NULL,
  `currency` text DEFAULT 'byn' COMMENT 'byn/rub',
  `start` datetime DEFAULT NULL,
  `stop` datetime DEFAULT NULL,
  `aboutpartner` text DEFAULT NULL,
  `size` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `promo`
--

INSERT INTO `promo` (`id`, `title`, `type`, `media`, `shortdesc`, `percent`, `summ`, `promocode`, `promolink`, `сonditions`, `minprice`, `currency`, `start`, `stop`, `aboutpartner`, `size`) VALUES
(1, 'Royal Canin', 2, '08/82/41a737e5.png', 'скидка на корма для собак высокого качества', 5, 0, 'Кораблик', 'https://vk.com', '<p><br></p>\n', 0, 'BYN', '2023-03-01 00:00:00', '2023-03-30 00:00:00', '<p><br></p>', 1),
(12, 'AJO', 2, '1c/ed/2706f019.jpg', 'скидка на сухие корма AJO', 5, 0, NULL, NULL, NULL, 0, 'RUB', NULL, NULL, NULL, 1),
(13, 'Grand Prix', 2, '45/ef/be0a9aae.jpg', 'скидка на корма', 10, 0, NULL, NULL, NULL, 0, 'RUB', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `promo_city`
--

CREATE TABLE `promo_city` (
  `id` int(11) NOT NULL,
  `promo` int(11) NOT NULL,
  `city` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `promo_city`
--

INSERT INTO `promo_city` (`id`, `promo`, `city`) VALUES
(22, 3, 2),
(21, 3, 1),
(28, 1, 1),
(11, 14, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `promo_tags`
--

CREATE TABLE `promo_tags` (
  `id` bigint(20) NOT NULL,
  `promo` int(11) NOT NULL,
  `tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `promo_tags`
--

INSERT INTO `promo_tags` (`id`, `promo`, `tag`) VALUES
(57, 1, 1),
(58, 1, 2),
(59, 1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `sub_concierge`
--

CREATE TABLE `sub_concierge` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `currency` varchar(5) NOT NULL DEFAULT 'rub',
  `days` int(11) NOT NULL DEFAULT 30,
  `month` int(11) NOT NULL DEFAULT 1,
  `pricebase` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sub_concierge`
--

INSERT INTO `sub_concierge` (`id`, `status`, `name`, `currency`, `days`, `month`, `pricebase`) VALUES
(1, 1, '1 месяц', 'BYN', 30, 1, 40000),
(2, 1, '6 месяцев', 'BYN', 182, 6, 300000),
(3, 1, '12 месяцев', 'BYN', 365, 12, 500000);

-- --------------------------------------------------------

--
-- Структура таблицы `sub_concierge_user`
--

CREATE TABLE `sub_concierge_user` (
  `id` bigint(20) NOT NULL,
  `user` bigint(20) UNSIGNED NOT NULL,
  `sub_concierge` int(11) NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`config`)),
  `BYN` int(11) DEFAULT 0,
  `RUB` int(11) DEFAULT 0,
  `period` smallint(6) DEFAULT 0,
  `status` smallint(6) DEFAULT 1,
  `auto` tinyint(4) DEFAULT 1,
  `create` datetime NOT NULL DEFAULT current_timestamp(),
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sub_concierge_user`
--

INSERT INTO `sub_concierge_user` (`id`, `user`, `sub_concierge`, `config`, `BYN`, `RUB`, `period`, `status`, `auto`, `create`, `start`, `end`) VALUES
(7, 3, 1, '[1, 2]', 360000, 1080000, 6, 1, 1, '2023-05-23 08:26:57', '2023-05-23 08:26:57', '2023-11-23 08:26:57'),
(8, 9, 1, '[1]', 300000, 960000, 6, 3, 1, '2023-08-29 08:39:11', '2023-08-29 08:39:11', '2024-02-29 08:39:11'),
(9, 9, 1, '[1,2]', 360000, 1080000, 6, 1, 1, '2024-12-23 15:48:51', '2024-12-23 15:48:51', '2025-06-23 15:48:51'),
(10, 21, 1, '[1,2]', 60000, 180000, 1, 1, 1, '2025-01-09 10:51:33', '2025-01-09 10:51:33', '2025-02-09 10:51:33'),
(11, 21, 1, '[1,2]', 60000, 180000, 1, 1, 1, '2025-01-09 10:53:45', '2025-01-09 10:53:45', '2025-02-09 10:53:45'),
(12, 34, 1, '[1,2]', 360000, 1080000, 6, 1, 1, '2025-02-28 09:39:31', '2025-02-28 09:39:31', '2025-08-28 09:39:31');

-- --------------------------------------------------------

--
-- Структура таблицы `sub_zooid`
--

CREATE TABLE `sub_zooid` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `currency` varchar(5) NOT NULL DEFAULT 'rub',
  `days` int(11) NOT NULL DEFAULT 30,
  `month` int(11) NOT NULL DEFAULT 1,
  `pricebase` int(11) NOT NULL DEFAULT 0,
  `pendant` int(11) NOT NULL DEFAULT 0 COMMENT 'Кулон с уникальным ID',
  `manager` int(11) NOT NULL DEFAULT 0 COMMENT 'Менеджер с круглосуточной линией',
  `remuneration` int(11) NOT NULL DEFAULT 0 COMMENT 'Выплата вознаграждения нашедшему',
  `delivery` int(11) NOT NULL DEFAULT 0 COMMENT 'Доставка питомца'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sub_zooid`
--

INSERT INTO `sub_zooid` (`id`, `status`, `name`, `currency`, `days`, `month`, `pricebase`, `pendant`, `manager`, `remuneration`, `delivery`) VALUES
(1, 1, '1 месяц', 'BYN', 30, 1, 25000, 2000, 3000, 4000, 5000),
(2, 1, '6 месяцев', 'BYN', 182, 6, 100000, 2000, 3000, 4000, 5000),
(3, 1, '12 месяцев', 'BYN', 365, 12, 300000, 2000, 3000, 4000, 5000);

-- --------------------------------------------------------

--
-- Структура таблицы `sub_zooid_user`
--

CREATE TABLE `sub_zooid_user` (
  `id` bigint(20) NOT NULL,
  `user` bigint(20) UNSIGNED NOT NULL,
  `sub_zooid` int(11) NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `BYN` int(11) DEFAULT 0,
  `RUB` int(11) DEFAULT 0,
  `period` smallint(6) DEFAULT 0,
  `pendant` tinyint(4) DEFAULT 1,
  `manager` tinyint(4) DEFAULT 1,
  `remuneration` tinyint(4) DEFAULT 1,
  `delivery` tinyint(4) DEFAULT 1,
  `status` smallint(6) NOT NULL DEFAULT 1 COMMENT '1 - Заявка сформированна. 2 - Ожидание оплаты. 3 - Оплачено',
  `auto` smallint(6) DEFAULT 1,
  `create` datetime NOT NULL DEFAULT current_timestamp(),
  `start` datetime DEFAULT NULL COMMENT 'Начало действия абонемента',
  `end` datetime DEFAULT NULL COMMENT 'Завершене действия абонемента'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sub_zooid_user`
--

INSERT INTO `sub_zooid_user` (`id`, `user`, `sub_zooid`, `config`, `BYN`, `RUB`, `period`, `pendant`, `manager`, `remuneration`, `delivery`, `status`, `auto`, `create`, `start`, `end`) VALUES
(39, 3, 1, '[1, 3]', 120000, 540000, 6, 1, 1, 1, 1, 1, 1, '2023-05-23 07:48:40', '2023-05-23 07:48:40', '2023-11-23 07:48:40'),
(40, 3, 1, '[1, 3]', 120000, 540000, 6, 1, 1, 1, 1, 1, 1, '2023-05-23 07:56:41', '2023-05-23 07:56:41', '2023-11-23 07:56:41'),
(41, 3, 1, '[1, 3]', 120000, 540000, 6, 1, 1, 1, 1, 1, 1, '2023-05-23 07:57:29', '2023-05-23 07:57:29', '2023-11-23 07:57:29'),
(42, 3, 1, '[1, 3]', 120000, 540000, 6, 1, 1, 1, 1, 3, 1, '2023-05-23 07:57:35', '2023-05-23 07:57:35', '2023-05-30 07:57:35'),
(43, 9, 1, '[1, 3, 4]', 180000, 780000, 6, 1, 1, 1, 1, 3, 1, '2023-08-29 08:37:13', '2023-08-29 08:37:13', '2024-02-29 08:37:13'),
(44, 3, 1, '[1, 3, 4]', 180000, 780000, 6, 1, 1, 1, 1, 1, 1, '2024-04-11 15:38:21', '2024-04-11 15:38:21', '2024-10-11 15:38:21'),
(50, 19, 1, '[1,3,4]', 180000, 780000, 6, 1, 1, 1, 1, 1, 1, '2024-11-27 13:20:31', '2024-11-27 13:20:31', '2025-05-27 13:20:31'),
(51, 11, 1, '[1,3,4]', 180000, 780000, 6, 1, 1, 1, 1, 3, 1, '2024-12-18 11:41:16', '2024-12-18 11:41:16', '2025-06-18 11:41:16'),
(52, 21, 1, '[1,3,4]', 180000, 780000, 6, 1, 1, 1, 1, 3, 1, '2024-12-19 12:06:50', '2024-12-19 12:06:50', '2025-06-19 12:06:50'),
(53, 9, 1, '[1,3,4]', 180000, 780000, 6, 1, 1, 1, 1, 3, 1, '2024-12-23 14:46:05', '2024-12-23 14:46:05', '2025-06-23 14:46:05'),
(57, 24, 1, '[1,4,7]', 4200, 330000, 6, 1, 1, 1, 1, 1, 1, '2025-01-15 16:23:40', '2025-01-15 16:23:40', '2025-07-15 16:23:40'),
(58, 26, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-05 09:35:32', '2025-02-05 09:35:32', '2025-03-05 09:35:32'),
(59, 26, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-05 09:38:50', '2025-02-05 09:38:50', '2025-03-05 09:38:50'),
(60, 26, 1, '[1,4,7]', 8400, 660000, 12, 1, 1, 1, 1, 1, 1, '2025-02-05 09:39:11', '2025-02-05 09:39:11', '2026-02-05 09:39:11'),
(61, 26, 1, '[1,4,7]', 8400, 660000, 12, 1, 1, 1, 1, 1, 1, '2025-02-05 09:39:47', '2025-02-05 09:39:47', '2026-02-05 09:39:47'),
(62, 26, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-05 09:39:57', '2025-02-05 09:39:57', '2025-03-05 09:39:57'),
(63, 26, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-05 09:40:22', '2025-02-05 09:40:22', '2025-03-05 09:40:22'),
(64, 30, 1, '[1,4,7]', 4200, 330000, 6, 1, 1, 1, 1, 1, 1, '2025-02-08 11:19:46', '2025-02-08 11:19:46', '2025-08-08 11:19:46'),
(65, 30, 1, '[1,4,7]', 4200, 330000, 6, 1, 1, 1, 1, 1, 1, '2025-02-08 11:19:50', '2025-02-08 11:19:50', '2025-08-08 11:19:50'),
(66, 30, 1, '[1,4,7]', 4200, 330000, 6, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:00', '2025-02-08 11:20:00', '2025-08-08 11:20:00'),
(67, 30, 1, '[1,4,7]', 4200, 330000, 6, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:13', '2025-02-08 11:20:13', '2025-08-08 11:20:13'),
(68, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:27', '2025-02-08 11:20:27', '2025-03-08 11:20:27'),
(69, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:31', '2025-02-08 11:20:31', '2025-03-08 11:20:31'),
(70, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:32', '2025-02-08 11:20:32', '2025-03-08 11:20:32'),
(71, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:32', '2025-02-08 11:20:32', '2025-03-08 11:20:32'),
(72, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:33', '2025-02-08 11:20:33', '2025-03-08 11:20:33'),
(73, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:34', '2025-02-08 11:20:34', '2025-03-08 11:20:34'),
(74, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:35', '2025-02-08 11:20:35', '2025-03-08 11:20:35'),
(75, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:36', '2025-02-08 11:20:36', '2025-03-08 11:20:36'),
(76, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:41', '2025-02-08 11:20:41', '2025-03-08 11:20:41'),
(77, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:42', '2025-02-08 11:20:42', '2025-03-08 11:20:42'),
(78, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:42', '2025-02-08 11:20:42', '2025-03-08 11:20:42'),
(79, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:42', '2025-02-08 11:20:42', '2025-03-08 11:20:42'),
(80, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:42', '2025-02-08 11:20:42', '2025-03-08 11:20:42'),
(81, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:42', '2025-02-08 11:20:42', '2025-03-08 11:20:42'),
(82, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:43', '2025-02-08 11:20:43', '2025-03-08 11:20:43'),
(83, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:43', '2025-02-08 11:20:43', '2025-03-08 11:20:43'),
(84, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:43', '2025-02-08 11:20:43', '2025-03-08 11:20:43'),
(85, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:43', '2025-02-08 11:20:43', '2025-03-08 11:20:43'),
(86, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:43', '2025-02-08 11:20:43', '2025-03-08 11:20:43'),
(87, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:43', '2025-02-08 11:20:43', '2025-03-08 11:20:43'),
(88, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:44', '2025-02-08 11:20:44', '2025-03-08 11:20:44'),
(89, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:44', '2025-02-08 11:20:44', '2025-03-08 11:20:44'),
(90, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:44', '2025-02-08 11:20:44', '2025-03-08 11:20:44'),
(91, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:44', '2025-02-08 11:20:44', '2025-03-08 11:20:44'),
(92, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:44', '2025-02-08 11:20:44', '2025-03-08 11:20:44'),
(93, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:45', '2025-02-08 11:20:45', '2025-03-08 11:20:45'),
(94, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:45', '2025-02-08 11:20:45', '2025-03-08 11:20:45'),
(95, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:45', '2025-02-08 11:20:45', '2025-03-08 11:20:45'),
(96, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:46', '2025-02-08 11:20:46', '2025-03-08 11:20:46'),
(97, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:51', '2025-02-08 11:20:51', '2025-03-08 11:20:51'),
(98, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:52', '2025-02-08 11:20:52', '2025-03-08 11:20:52'),
(99, 30, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:20:56', '2025-02-08 11:20:56', '2025-03-08 11:20:56'),
(100, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:06', '2025-02-08 11:21:06', '2025-03-08 11:21:06'),
(101, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:07', '2025-02-08 11:21:07', '2025-03-08 11:21:07'),
(102, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:07', '2025-02-08 11:21:07', '2025-03-08 11:21:07'),
(103, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:07', '2025-02-08 11:21:07', '2025-03-08 11:21:07'),
(104, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:07', '2025-02-08 11:21:07', '2025-03-08 11:21:07'),
(105, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:07', '2025-02-08 11:21:07', '2025-03-08 11:21:07'),
(106, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:08', '2025-02-08 11:21:08', '2025-03-08 11:21:08'),
(107, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:08', '2025-02-08 11:21:08', '2025-03-08 11:21:08'),
(108, 30, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:18', '2025-02-08 11:21:18', '2025-03-08 11:21:18'),
(109, 30, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:20', '2025-02-08 11:21:20', '2025-03-08 11:21:20'),
(110, 30, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:26', '2025-02-08 11:21:26', '2025-03-08 11:21:26'),
(111, 30, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-08 11:21:47', '2025-02-08 11:21:47', '2025-03-08 11:21:47'),
(112, 29, 1, '[1,4,7]', 4200, 330000, 6, 1, 1, 1, 1, 1, 1, '2025-02-09 07:15:06', '2025-02-09 07:15:06', '2025-08-09 07:15:06'),
(113, 29, 1, '[1]', 500, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-09 07:15:19', '2025-02-09 07:15:19', '2025-03-09 07:15:19'),
(114, 29, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-09 07:17:11', '2025-02-09 07:17:11', '2025-03-09 07:17:11'),
(115, 29, 1, '[1,4,7]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-09 07:17:12', '2025-02-09 07:17:12', '2025-03-09 07:17:12'),
(116, 30, 1, '[1,4,7,9]', 700, 55000, 1, 1, 1, 1, 1, 1, 1, '2025-02-17 12:30:04', '2025-02-17 12:30:04', '2025-03-17 12:30:04'),
(117, 30, 1, '[1]', 0, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-17 12:42:03', '2025-02-17 12:42:03', '2025-03-17 12:42:03'),
(118, 30, 1, '[1]', 0, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-17 12:42:04', '2025-02-17 12:42:04', '2025-03-17 12:42:04'),
(119, 32, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 1, 1, '2025-02-19 21:06:44', '2025-02-19 21:06:44', '2025-03-19 21:06:44'),
(120, 32, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 1, 1, '2025-02-19 21:07:24', '2025-02-19 21:07:24', '2025-03-19 21:07:24'),
(121, 36, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 1, 1, '2025-02-27 15:42:19', '2025-02-27 15:42:19', '2025-03-27 15:42:19'),
(122, 36, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 1, 1, '2025-02-27 16:01:04', '2025-02-27 16:01:04', '2025-03-27 16:01:04'),
(123, 36, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 1, 1, '2025-02-28 09:19:57', '2025-02-28 09:19:57', '2025-03-28 09:19:57'),
(124, 36, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 1, 1, '2025-02-28 09:21:52', '2025-02-28 09:21:52', '2025-03-28 09:21:52'),
(125, 36, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 1, 1, '2025-02-28 09:23:52', '2025-02-28 09:23:52', '2025-03-28 09:23:52'),
(126, 36, 1, '[1,2]', 3000, 270000, 6, 1, 1, 1, 1, 1, 1, '2025-02-28 09:24:52', '2025-02-28 09:24:52', '2025-08-28 09:24:52'),
(127, 36, 1, '[1,2]', 3000, 270000, 6, 1, 1, 1, 1, 1, 1, '2025-02-28 09:28:47', '2025-02-28 09:28:47', '2025-08-28 09:28:47'),
(128, 36, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 1, 1, '2025-02-28 09:32:42', '2025-02-28 09:32:42', '2025-03-28 09:32:42'),
(129, 36, 1, '[1]', 0, 5000, 1, 1, 1, 1, 1, 1, 1, '2025-02-28 09:41:24', '2025-02-28 09:41:24', '2025-03-28 09:41:24'),
(130, 33, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 3, 1, '2025-02-28 21:09:17', '2025-02-28 21:09:17', '2025-03-28 21:09:17'),
(131, 37, 1, '[1,2]', 500, 45000, 1, 1, 1, 1, 1, 3, 1, '2025-02-28 21:22:28', '2025-02-28 21:22:28', '2025-03-28 21:22:28'),
(132, 39, 1, '[1,2]', 1500, 135000, 3, 1, 1, 1, 1, 3, 1, '2025-03-01 11:23:40', '2025-03-01 11:23:40', '2025-06-01 11:23:40'),
(133, 39, 1, '[1,2]', 1500, 135000, 3, 1, 1, 1, 1, 3, 1, '2025-03-01 11:28:50', '2025-03-01 11:28:50', '2025-06-01 11:28:50'),
(134, 40, 1, '[]', 1500, 120000, 3, 1, 1, 1, 1, 1, 1, '2025-03-05 10:29:48', '2025-03-05 10:29:48', '2025-06-05 10:29:48'),
(135, 41, 1, '[]', 1500, 120000, 3, 1, 1, 1, 1, 1, 1, '2025-03-07 05:53:05', '2025-03-07 05:53:05', '2025-06-07 05:53:05'),
(136, 43, 1, '[]', 1500, 120000, 3, 1, 1, 1, 1, 1, 1, '2025-03-13 15:27:21', '2025-03-13 15:27:21', '2025-06-13 15:27:21'),
(137, 43, 1, '[]', 1500, 120000, 3, 1, 1, 1, 1, 1, 1, '2025-03-13 15:30:48', '2025-03-13 15:30:48', '2025-06-13 15:30:48'),
(138, 43, 1, '[]', 1500, 120000, 3, 1, 1, 1, 1, 1, 1, '2025-03-13 15:31:10', '2025-03-13 15:31:10', '2025-06-13 15:31:10'),
(139, 45, 1, '[]', 1500, 120000, 3, 1, 1, 1, 1, 1, 1, '2025-03-24 17:06:26', '2025-03-24 17:06:26', '2025-06-24 17:06:26'),
(140, 47, 1, '[]', 12000, 0, 12, 1, 1, 1, 1, 1, 1, '2025-03-26 16:39:10', '2025-03-26 16:39:10', '2026-03-26 16:39:10'),
(141, 47, 1, '[]', 5000, 0, 12, 1, 1, 1, 1, 3, 1, '2025-03-26 16:41:31', '2025-03-26 16:41:31', '2026-03-26 16:41:31'),
(144, 50, 1, '[]', 3000, 0, 3, 1, 1, 1, 1, 3, 1, '2025-03-27 08:20:05', '2025-03-27 08:20:05', '2025-06-27 08:20:05'),
(145, 40, 1, '[]', 3000, 0, 3, 1, 1, 1, 1, 3, 1, '2025-03-28 05:29:15', '2025-03-28 05:29:15', '2025-06-28 05:29:15');

-- --------------------------------------------------------

--
-- Структура таблицы `sub_zoopolis`
--

CREATE TABLE `sub_zoopolis` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `currency` varchar(32) DEFAULT 'rub',
  `days` int(11) DEFAULT 0,
  `month` int(11) DEFAULT 0,
  `pricebase` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sub_zoopolis`
--

INSERT INTO `sub_zoopolis` (`id`, `status`, `name`, `currency`, `days`, `month`, `pricebase`) VALUES
(1, 1, '1 месяц', 'rub', 30, 1, 0),
(2, 1, '6 месяцев', 'rub', 182, 6, 0),
(3, 1, '12 месяцев', 'rub', 365, 12, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `sub_zoopolis_user`
--

CREATE TABLE `sub_zoopolis_user` (
  `id` int(11) NOT NULL,
  `user` bigint(20) UNSIGNED NOT NULL,
  `sub_zoopolis` int(10) UNSIGNED NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `BYN` int(10) UNSIGNED DEFAULT 0,
  `RUB` int(10) UNSIGNED DEFAULT 0,
  `period` smallint(5) UNSIGNED DEFAULT 0,
  `status` smallint(5) UNSIGNED DEFAULT 0,
  `auto` smallint(5) UNSIGNED DEFAULT 0,
  `create` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sub_zoopolis_user`
--

INSERT INTO `sub_zoopolis_user` (`id`, `user`, `sub_zoopolis`, `config`, `BYN`, `RUB`, `period`, `status`, `auto`, `create`, `start`, `end`) VALUES
(1, 3, 1, '[1,2]', 100000, 700000, 1, 0, 0, '2024-12-23 18:58:56', '2023-05-29 12:58:33', '2023-06-29 12:58:33'),
(2, 9, 1, '[1,2]', 600000, 4200000, 6, 0, 0, '2024-12-23 18:58:56', '2024-06-19 11:39:38', '2024-12-19 11:39:38'),
(5, 9, 1, '[1,2]', 600000, 4200000, 6, 0, 0, '2024-12-23 18:58:56', '2024-12-23 15:54:11', '2025-06-23 15:54:11'),
(6, 25, 1, '[1]', 600000, 4200000, 6, 0, 0, '2025-01-29 04:21:41', '2025-01-29 04:21:41', '2025-07-29 04:21:41'),
(7, 34, 1, '[1]', 600000, 4200000, 6, 0, 0, '2025-02-23 08:49:13', '2025-02-23 08:49:13', '2025-08-23 08:49:13');

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'Новое'),
(2, 'Корма'),
(3, 'Зоотовары');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `phoneOther_1` bigint(20) DEFAULT NULL,
  `phoneOther_2` bigint(20) DEFAULT NULL,
  `phoneOther_3` bigint(20) DEFAULT NULL,
  `email` varchar(56) DEFAULT NULL,
  `emailCheck` int(11) NOT NULL DEFAULT 0,
  `phoneCheck` int(11) NOT NULL DEFAULT 0,
  `first` varchar(32) DEFAULT NULL,
  `last` varchar(32) DEFAULT NULL,
  `pass` text DEFAULT NULL,
  `passdate` datetime NOT NULL DEFAULT current_timestamp(),
  `level` int(11) NOT NULL DEFAULT 1 COMMENT '0 - blocked, 1 - user. 2 - manager, 9 - admin',
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `blocked_reason` text DEFAULT NULL,
  `code_verification` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `phone`, `phoneOther_1`, `phoneOther_2`, `phoneOther_3`, `email`, `emailCheck`, `phoneCheck`, `first`, `last`, `pass`, `passdate`, `level`, `created`, `is_active`, `is_blocked`, `blocked_reason`, `code_verification`) VALUES
(3, 79123555341, 79123555343, NULL, NULL, 'bugsmafia@gmail.com', 0, 0, 'Сергей', 'Осипов', '94d6c31143cb03e574c4da0fe09c902f', '2023-02-20 18:54:44', 2, '2025-01-15 16:28:07', 1, 1, 'Тест блокировки', NULL),
(4, 79002101997, 78005553535, NULL, NULL, 'alexeev.amg@gmail.com', 0, 0, 'Николай', 'Алексеев', '018075a53c9e4ea4ecc280dc221e755f', '2023-02-28 08:55:31', 9, '2023-05-16 10:58:09', 1, 0, NULL, NULL),
(5, 79950681622, NULL, NULL, NULL, 'corp@fluid.fyi', 0, 0, '', '121', '3cd9188caaa879a839e0794ee7e16c90', '2023-03-24 12:20:09', 1, '2025-02-22 12:35:15', 1, 0, NULL, NULL),
(6, 79776350908, NULL, NULL, NULL, 'yudinvladimir01@mail.ru', 0, 0, NULL, NULL, '702e00600f788949bbb3486cc14bbc97', '2023-04-10 19:19:00', 1, '2023-04-10 19:19:00', 1, 0, NULL, NULL),
(7, 7925436953, NULL, NULL, NULL, 'vyuuudin@gmail.com', 0, 0, NULL, NULL, '5294e07d125324dae4a0b2fdd4a6e94c', '2023-05-04 12:05:08', 1, '2023-05-04 12:05:08', 1, 0, NULL, NULL),
(8, 79123555342, NULL, NULL, NULL, NULL, 0, 0, 'Новый', 'Пробный', NULL, '2023-05-15 09:57:30', 1, '2023-05-15 09:57:46', 1, 0, NULL, NULL),
(9, 375298842382, NULL, NULL, NULL, 'test@gmail.com', 0, 0, NULL, NULL, '970e6240ea4ca92d44ee078f8d06becd', '2023-06-07 11:33:24', 9, '2024-12-23 14:46:05', 1, 0, NULL, NULL),
(10, 79039695300, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-08-02 12:49:13', 1, '2023-08-02 12:49:13', 1, 0, NULL, NULL),
(11, 79623261991, NULL, NULL, NULL, 'serzh.iva90@gmail.com', 0, 0, NULL, NULL, '121214b6f22a6ab94c1e2ca156702a0a', '2024-08-08 09:31:29', 9, '2024-12-19 12:06:40', 1, 0, NULL, NULL),
(14, 375122353453, NULL, NULL, NULL, 'yudin@mail.ru', 0, 0, 'Вуцпа', 'каукп', 'd634fd709635d0cd7078c940dbc89235', '2024-08-26 12:36:48', 1, '2024-08-26 12:36:49', 1, 0, NULL, NULL),
(15, 375123423432, NULL, NULL, NULL, 'test@mail.ru', 0, 0, 'Владимир', 'Юдин', 'd49fdb73e8eb4b925b9bc8bf47200f69', '2024-08-30 12:07:12', 1, '2024-08-30 12:07:13', 1, 0, NULL, NULL),
(16, 375123123123, NULL, NULL, NULL, 'test1234@gmail.com', 0, 0, 'Владимир', 'Юдин', 'b3824f90bf24256e5b6bbffac7748e5b', '2024-09-03 07:50:30', 1, '2024-09-03 07:50:30', 1, 0, NULL, NULL),
(17, 79623261992, NULL, NULL, NULL, 'hools181@yandex.ru', 0, 0, 'Сергей', 'Иванов', 'de72536ae41cfc64f97e76d55dc339b7', '2024-11-21 13:07:30', 1, '2025-01-07 13:13:47', 1, 0, NULL, NULL),
(18, 375123234234, NULL, NULL, NULL, 'vovka27102001@mail.ru', 0, 0, 'Владимир', 'Юдин', '4fea1b957c8a5b14db2cff303f487fd9', '2024-11-27 13:18:21', 1, '2024-11-27 13:18:21', 1, 0, NULL, NULL),
(19, 375198887123, NULL, NULL, NULL, 'yudinvladimir27@yandex.ru', 0, 0, 'Владимир', 'Юдин', 'e0838f8c239e3fabb668eab92cae822a', '2024-11-27 13:19:46', 1, '2024-11-27 13:19:46', 1, 0, NULL, NULL),
(20, 375298843181, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2024-12-02 12:47:51', 1, '2024-12-02 12:47:51', 1, 0, NULL, NULL),
(21, 79623261990, NULL, NULL, NULL, 'hools181@ya.ru', 0, 0, '12', '1', '$2y$10$SZZziqvHeTJ9nzTmkaeFDewsX270e3pP5FAyVDP9GXbc4OVodMYgm', '2024-12-19 12:06:42', 9, '2025-03-09 15:04:50', 1, 0, NULL, NULL),
(23, 37544444444, NULL, NULL, NULL, NULL, 0, 0, '', '', NULL, '2024-12-25 14:22:23', 9, '2024-12-25 14:22:33', 1, 0, NULL, NULL),
(24, 79623261999, NULL, NULL, NULL, 'hools181@ya.ru', 0, 0, NULL, NULL, '$2y$10$DO16yfuUE6efdEin8HdTXuuBKrw0742kkNHJnz5yIzEq0Wpfk83vG', '2025-01-15 14:21:55', 1, '2025-01-15 16:23:40', 1, 0, NULL, NULL),
(25, 375999999999, 375, NULL, NULL, 'test@test.ru', 0, 0, 'Тест2н', 'Тестн', '$2y$10$CVISCIfo..j9atRNCe6/QuT7x.LiAGFjua/ljG8njlkJbnnAT6nw6', '2025-01-29 04:21:19', 9, '2025-03-28 14:07:13', 1, 0, NULL, NULL),
(26, 3759999911111111111, 375, NULL, NULL, 'test@test.test', 0, 0, '', '', '$2y$10$BEHby9v.ooi1kWWJIXGeGuTzCYJVHsPnET5imHbYf2GORP1QOLVoC', '2025-02-05 09:32:40', 1, '2025-02-05 09:44:00', 1, 0, NULL, NULL),
(27, 123123, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-02-05 09:46:56', 1, '2025-02-05 09:47:13', 1, 1, 'тест', NULL),
(28, 375999991111, NULL, NULL, NULL, '', 0, 0, '', '', '0f312a063b074ed592ad0cdeb59c0461', '2025-02-08 10:02:24', 1, '2025-02-08 11:44:22', 1, 1, 'тест', NULL),
(29, 375999991112, NULL, NULL, NULL, '', 0, 0, 'выв', 'авыа', '$2y$10$GdckNIyylXzZhAZ/JNopmO1FBiUOHxoiEDHWHWrGpDVc9iK4Wa1a2', '2025-02-08 10:19:13', 1, '2025-02-15 11:01:37', 1, 1, 'т', NULL),
(30, 375999991116, NULL, NULL, NULL, 'test@test.test', 0, 0, NULL, NULL, '$2y$10$U1gj1Vquy15zGnVj6HrNcerAHb51R4rXcFXaE7oFx2wk1J7CjQLjm', '2025-02-08 10:28:04', 1, '2025-02-17 12:30:04', 1, 0, NULL, NULL),
(31, 375999991114, NULL, NULL, NULL, 'test@test.test', 0, 0, 'выв', 'авыа', '$2y$10$LmJa9yuTaV2Cel2.DpsB/e./NHIlMAXyft4huhsFDhVuE.0Q4CpEK', '2025-02-15 11:02:54', 1, '2025-02-15 12:13:25', 1, 0, NULL, NULL),
(32, 375447490964, NULL, NULL, NULL, 'starolatko@gmail.com', 0, 0, NULL, NULL, '$2y$10$Te9FmjwWQDHoQbKQcFE3huobAZqVTF2L5gDj9v0xL8ZUDAzmZ19qO', '2025-02-19 21:01:21', 1, '2025-02-19 21:06:44', 1, 0, NULL, NULL),
(33, 375447490963, NULL, NULL, NULL, 'starolatko@gmail.com', 0, 0, NULL, NULL, '$2y$10$VWdOy2F9k3bZtxrcjmS2LOKLquXy1qWKPL5yE53/mALbZ28wJGseC', '2025-02-19 21:42:38', 1, '2025-02-28 21:09:17', 1, 0, NULL, NULL),
(34, 77777777777, NULL, NULL, NULL, '', 0, 0, '1', '2', '$2y$10$Wv9gFwM7bqhOmxKYT8zWYubW4YiJczHjGo1Mdn.vOcUd5z8E.xlr6', '2025-02-22 13:41:37', 1, '2025-03-01 09:58:54', 1, 0, NULL, NULL),
(35, 77777777771, NULL, NULL, NULL, '', 0, 0, 'Ivan', 'Ivanov', '$2y$10$zLTs7bYj8b2DCwX7xQb1TuzkM5OO10bhq06j8LznM2pOibuZFIaim', '2025-02-22 13:58:31', 1, '2025-02-22 13:58:31', 1, 0, NULL, NULL),
(36, 375447490962, 375445564333, NULL, NULL, 'starolatko@gmail.com', 0, 0, 'дмитрий444вввоо', 'Старолатко2см', '$2y$10$XJlWgi6D3Jbb3vYDVubQcuotIxg.NhFyrlg.XZIkxYf9NSd0JY9H2', '2025-02-27 15:36:55', 1, '2025-03-26 15:34:23', 1, 0, NULL, '1234'),
(37, 375447490961, NULL, NULL, NULL, 'starolatko@gmail.com', 0, 0, NULL, NULL, '$2y$10$qDMwDuahi/7TVLjxb10nY.ySSLw3av883sVda6v8VeLdI.v/SCfYW', '2025-02-28 21:21:38', 1, '2025-02-28 21:22:28', 1, 0, NULL, NULL),
(38, 79999999999, NULL, NULL, NULL, 'test@test.ru', 0, 0, NULL, NULL, '$2y$10$Cm6xmeTOPmJmgM5QbxAEeO.4t9uANFaBFZ49h5M.R3iz4MT0vGyWC', '2025-03-01 10:01:16', 1, '2025-03-01 10:01:16', 1, 0, NULL, NULL),
(39, 375777777777, NULL, NULL, NULL, 'test@test.ru', 0, 0, '122', '2', '$2y$10$5wNPpoUYII0ueA4lLUWr/eqsRDtd1BKvreO0sPJg7u9hdIpntmAiu', '2025-03-01 10:04:15', 9, '2025-03-29 10:05:21', 1, 0, NULL, NULL),
(40, 375447490960, NULL, NULL, NULL, 'infoivanov@gmail.com', 0, 0, 'Татьяна', 'Старолатко ', '$2y$10$Y6AaZ2bumAmFgzDpbXuA/uqmozKEgzchN.CNoooWDKKCW2DmCXCV2', '2025-03-05 10:27:03', 1, '2025-03-28 05:29:15', 1, 0, NULL, NULL),
(41, 375447490959, NULL, NULL, NULL, '', 0, 0, NULL, NULL, '$2y$10$qelIBcjpGwiSUf2.yjkTh.1azGr94byXK8ilp3hXUwAtkCz2vADbW', '2025-03-07 05:45:40', 1, '2025-03-07 05:53:05', 1, 0, NULL, NULL),
(42, 375447490958, NULL, NULL, NULL, 'starolatko@gmail.com', 0, 0, 'Татьяна', 'Старолатко 0703', '$2y$10$TOacyGq2yyOt1cDcqQRmTOCFKDJZwa.0U9h5UFcDPDTiJZy0hXCwy', '2025-03-07 09:39:22', 1, '2025-03-07 09:39:23', 1, 0, NULL, NULL),
(43, 375111111111, NULL, NULL, NULL, '', 0, 0, '11', '22', '$2y$10$3PfD/D2hluWmvRkiwiim/.CjlDEPDvxQ4sOgY4l0fCRS6klXT9HPC', '2025-03-13 14:48:18', 1, '2025-03-25 13:14:23', 1, 0, NULL, '1234'),
(44, 375123123908, NULL, NULL, NULL, 'yudinvladimir01@gmail.com', 0, 0, NULL, NULL, '$2y$10$bT8aniFa9hDsTTRtbWcT3e9hLaMEOQxhm89cR9/hHIjGABeDp.6y.', '2025-03-17 14:11:41', 1, '2025-03-18 10:36:19', 1, 0, NULL, '2241'),
(45, 375847238947, NULL, NULL, NULL, 'dhfsdjfh@gmail.com', 0, 0, 'фыв', 'фывфывф', '$2y$10$tV59LMo9xO5/aYHGm7dCXeTVVr8iye/qmDEOdraxPhKRPdHmqZBry', '2025-03-18 10:36:58', 1, '2025-03-24 17:06:26', 1, 0, NULL, NULL),
(46, 375228397492, NULL, NULL, NULL, 'odf@gmail.com', 0, 0, NULL, NULL, '$2y$10$D2JqbYI.QoHrXSU.Iy.Ui.Ieacer3xanxjs3jta7yvyKqjrQCmQMy', '2025-03-26 10:03:13', 1, '2025-03-26 10:03:13', 1, 0, NULL, NULL),
(47, 375888888888, NULL, NULL, NULL, 'test@test.ru', 0, 0, '', '', '$2y$10$J8m8z2k3ftnt.4sO3gNvf.gfivEPxtrCTzJY0ld2WXI5zIxYZqbje', '2025-03-26 16:38:50', 1, '2025-03-26 16:57:22', 1, 0, NULL, NULL),
(48, 375283478923, NULL, NULL, NULL, 'ывоыпр@gmail.com', 0, 0, NULL, NULL, '$2y$10$fxHr7ulDLhvztmT2STP4uOdX6L937wi78K8G2HtmyF2qfDT2POyYy', '2025-03-26 16:49:44', 1, '2025-03-26 16:49:44', 1, 0, NULL, NULL),
(49, 375447490957, NULL, NULL, NULL, '', 0, 0, NULL, NULL, '$2y$10$AjRHHIonSeyKO3X.QZMLu.ZYM5bw4MY8bgJNzTZFueCHrwJUsFu/W', '2025-03-27 07:22:47', 1, '2025-03-27 07:22:47', 1, 0, NULL, NULL),
(50, 375447490956, 375445564333, NULL, NULL, 'starolatko@gmail.com', 0, 0, 'Татьянаоо', 'Старолатко 2703л', '$2y$10$9su/px0wUG1D90c0JW7Ke.g7C2zdgKQBXZFURuAm0kQdNhL9qyagu', '2025-03-27 08:19:27', 1, '2025-03-27 08:26:54', 1, 0, NULL, NULL),
(51, 375120371892, NULL, NULL, NULL, 'testtest123123123@gmail.com', 0, 0, NULL, NULL, '$2y$10$CHy3TvP8xSveiEj6cFG/Wu5aYjq9erBWXuHCpagbZ7NNhCFeMPt1u', '2025-03-27 08:19:49', 1, '2025-03-27 08:19:49', 1, 0, NULL, NULL),
(52, 375444444444, NULL, NULL, NULL, '', 0, 0, NULL, NULL, '$2y$10$Fdo03OCXV6hBwkFPzoBPNOHrEdmEM1yVqiF/qnh8JRe7onCeJ8IPy', '2025-03-27 11:58:32', 1, '2025-03-27 11:58:32', 1, 0, NULL, '6734'),
(53, 375000000000, NULL, NULL, NULL, '', 0, 0, NULL, NULL, '$2y$10$n9LlHLuup0geleKQNxvjJucc5nAvudUMLD7mpysRw0ouWu.Tj6Cze', '2025-03-27 11:59:05', 1, '2025-03-27 11:59:23', 1, 0, NULL, NULL),
(54, 375447490953, NULL, NULL, NULL, 'starolatko@gmail.com', 0, 0, NULL, NULL, '$2y$10$xsi7BAOA.8Xo6hsKtg7O3.edbWWkciR5.0WZYb2VXkCWhw/GCfGje', '2025-03-27 15:24:56', 1, '2025-03-27 15:24:56', 1, 0, NULL, '3897'),
(55, 375447978183, NULL, NULL, NULL, 'starolatko@gmail.com', 0, 0, NULL, NULL, '$2y$10$w6JcnBxROtGPRCJ85QBC1.KYZm1eskEfQz/69NtUjfOYGKZqUMbae', '2025-03-28 06:02:49', 1, '2025-03-28 06:02:49', 1, 0, NULL, '8344'),
(56, 375999999911, NULL, NULL, NULL, '', 0, 0, NULL, NULL, '$2y$10$f9g8Ib/hFjB26QJat6lh1evI1xyoOOWqi/wHjpIDvvyuViPX9awPe', '2025-03-28 15:25:51', 1, '2025-03-28 15:25:51', 1, 0, NULL, NULL),
(57, 375111111123, NULL, NULL, NULL, '11111111', 0, 0, NULL, NULL, '$2y$10$rHJ.XIRUHmZUhp3LtMYtbuhg3dHpWZJmbSSLjKpJKM2KF4D1yIsCi', '2025-03-28 15:26:13', 1, '2025-03-28 15:26:13', 1, 0, NULL, NULL),
(58, 375111111110, NULL, NULL, NULL, '', 0, 0, NULL, NULL, '$2y$10$ZJP2LZpbGqiDwYDckuICw.fObLx49kx5UsQBehV04Ehxn0L1hEYpS', '2025-03-28 15:27:45', 1, '2025-03-28 15:27:45', 1, 0, NULL, NULL),
(59, 375447490965, NULL, NULL, NULL, 'starolatko@gmail.com', 0, 0, NULL, NULL, '$2y$10$xLklCWfqBxKxOA0UTj0UbOgipL49pQt1jWVUlIaOS3B7D/Do4WP2S', '2025-03-29 06:08:20', 1, '2025-03-29 06:08:20', 1, 0, NULL, NULL),
(60, 375888899999, NULL, NULL, NULL, '', 0, 0, NULL, NULL, '$2y$10$vMkeARwJA.5k9kekB8Fhn.TAGWQC3ojxyVKU8WVKHV15YeCsf7/Em', '2025-03-29 10:05:58', 1, '2025-03-29 10:05:58', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `userstoken`
--

CREATE TABLE `userstoken` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` bigint(20) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `userstoken`
--

INSERT INTO `userstoken` (`id`, `user`, `token`, `created`, `created_at`, `updated_at`) VALUES
(11, 3, '74fa84b2868f920699950bcf65ad745d', '2023-03-10 09:34:09', NULL, NULL),
(12, 3, '1939d15f8f5e7c5b2878857445a75460', '2023-03-10 09:36:58', NULL, NULL),
(13, 3, '3dc6006effea893886790527d618daeb', '2023-03-16 08:21:12', NULL, NULL),
(14, 3, '9167f8cbf97f281acf999286dce4036a', '2023-03-16 22:34:59', NULL, NULL),
(15, 3, '9f6b2a682f1f71abd9ecb622bd06f000', '2023-03-18 14:09:28', NULL, NULL),
(26, 3, '48e697c563f408ea4a9b650680ccb6cc', '2023-05-11 18:53:48', NULL, NULL),
(27, 4, '4df1a9c14c4b40b71cff7d47ae8b5909', '2023-05-16 11:37:55', NULL, NULL),
(28, 4, 'f48b86489e21df411c02bfc1eea9bba4', '2023-05-16 11:41:44', NULL, NULL),
(29, 4, '488b2f163dfa44bf1ac897f24969500e', '2023-05-16 11:42:26', NULL, NULL),
(35, 3, 'a20c8599303c4771f3aee0dfbaab2b7b', '2023-06-07 13:01:26', NULL, NULL),
(36, 9, '19d89a9268c049094e8a4545257c6eca', '2023-07-03 11:10:14', NULL, NULL),
(40, 4, '5c25c337601bd7d11b48e5d21c276da9', '2023-07-04 14:51:02', NULL, NULL),
(41, 9, '8f568816503a515f0a26204f79aac849', '2023-08-02 12:42:23', NULL, NULL),
(42, 9, 'f2e37246dab7bc32b1bd53a02897adfb', '2023-08-02 13:03:18', NULL, NULL),
(43, 9, '9145097e4db7f044d166354c63625b88', '2024-06-19 11:36:56', NULL, NULL),
(46, 9, 'f5dfc12ba5d00aab4ca7a5c16a1b39a6', '2024-07-08 09:00:43', NULL, NULL),
(47, 11, '002f05630e0533af2e02668f468c3665', '2024-08-08 09:31:29', NULL, NULL),
(56, 11, '175122c49b35f6dc511441e2171330e7', '2024-08-20 12:57:51', NULL, NULL),
(63, 11, '6fa9fa97b8cbaef52e7f8e5dbc8c93ca', '2024-08-26 13:44:24', NULL, NULL),
(64, 9, '473a614e32bd12af88e291431ae4ca65', '2024-08-30 06:55:28', NULL, NULL),
(69, 11, '299c0d61480cb60badfe20ad653d2731', '2024-09-01 11:48:39', NULL, NULL),
(72, 11, 'c659adc06ebeb75eba38dee9ad7cbbbf', '2024-11-09 14:58:20', NULL, NULL),
(75, 9, '20c86ae8b098d34e8bf45c68fbfb9821', '2024-11-19 08:12:49', NULL, NULL),
(80, 9, '419834d4371445caacba9954e855c371', '2024-11-21 11:05:16', NULL, NULL),
(83, 18, '29c5d3ca1a01d3b33807299268d28e3c', '2024-11-27 13:18:21', NULL, NULL),
(85, 9, '2d60bcdec01fb2e66f0aba3dffda8669', '2024-11-27 13:23:51', NULL, NULL),
(87, 9, '0c113f0c2f5c941641b839a6a0781988', '2024-12-02 12:07:22', NULL, NULL),
(93, 21, '466e04cb6461cce26492b74b3b973e40', '2024-12-20 08:10:02', NULL, NULL),
(94, 21, 'fbf97294a2ac2cd4a4fe7f3d0f0c6d2f', '2024-12-20 08:11:16', NULL, NULL),
(95, 21, 'b54ee87427c933e7449e77d4044a9941', '2024-12-20 18:01:08', NULL, NULL),
(97, 21, 'a79fcbcbce39d5cf971add5c16fe005f', '2024-12-21 14:20:56', NULL, NULL),
(100, 9, '7cde5d8154fa17a57ff9452b7504d5ad', '2024-12-23 14:48:10', NULL, NULL),
(103, 22, 'b1bf9cb69e4d0dce7604a7c2230cce3c', '2024-12-24 14:54:32', NULL, NULL),
(104, 9, '28af9b12f39673d473fb3e6f95cf1dfa', '2024-12-25 12:57:14', NULL, NULL),
(106, 9, '1dfad6f8947efbea8652efc1f49520d0', '2024-12-25 14:20:51', NULL, NULL),
(108, 21, '859bbc3d93b8f78e1f389c107971c298', '2024-12-26 15:38:04', NULL, NULL),
(122, 21, '0ac8f98140551daee60214763c30e094', '2025-01-22 13:51:14', NULL, NULL),
(125, 25, 'f4ebd6ac65bc1051db644f4bed769cea', '2025-02-05 09:30:30', NULL, NULL),
(127, 28, 'fefb9b344a119db4deb18ba4904baef3', '2025-02-08 10:02:24', NULL, NULL),
(128, 29, '23d09e623385fac566f23c5d73f8a68d', '2025-02-08 10:19:13', NULL, NULL),
(130, 29, '7175edb9120b29062de24f6d6d0c8043', '2025-02-08 11:40:07', NULL, NULL),
(135, 21, '8e005f20f840fca0c546e25cdb41aa6c', '2025-02-13 14:25:41', NULL, NULL),
(139, 30, '3c33aeb4b355b12860218729c13b041a', '2025-02-15 12:18:53', NULL, NULL),
(156, 38, 'c182bd50fdae1b9945bcf1a1d431d2de', '2025-03-01 10:01:16', NULL, NULL),
(169, 41, 'b75d4e7155c994211672ac5a47a9acda', '2025-03-07 05:45:40', NULL, NULL),
(170, 36, '9d25c7f21762fbbe36aa11f14176794a', '2025-03-07 09:30:39', NULL, NULL),
(171, 42, 'ab140359547680ff073b41665d8811f0', '2025-03-07 09:39:22', NULL, NULL),
(192, 25, '402839e77b01ca492a6bd546f7311230', '2025-03-25 13:21:24', NULL, NULL),
(206, 51, 'e76fecff440c2ed3efbe81074b5fe286', '2025-03-27 08:19:49', NULL, NULL),
(210, 22, '16ec669b591f1d537bec26017ebb8476', '2025-03-28 06:46:25', NULL, NULL),
(212, 25, 'a46555b0bdf54d862447ab0959a74e84', '2025-03-28 12:57:27', NULL, NULL),
(213, 25, '8cda03e7245e03e3560459c796742a4c', '2025-03-28 13:42:41', NULL, NULL),
(219, 59, '1a160c246c20e826af662341e9fe8665', '2025-03-29 06:08:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users_address`
--

CREATE TABLE `users_address` (
  `id` bigint(20) NOT NULL,
  `user` bigint(20) UNSIGNED NOT NULL COMMENT 'Ид пользователя',
  `city` varchar(32) DEFAULT NULL COMMENT 'Город',
  `street` varchar(96) DEFAULT NULL COMMENT 'Улица и дом',
  `entrance` smallint(6) DEFAULT NULL COMMENT 'Подъезд',
  `apartment` bigint(20) DEFAULT NULL COMMENT 'Номер квартиры',
  `floor` smallint(6) DEFAULT NULL COMMENT 'Номер этажа',
  `comm` text DEFAULT NULL COMMENT 'Доп комментарий'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users_address`
--

INSERT INTO `users_address` (`id`, `user`, `city`, `street`, `entrance`, `apartment`, `floor`, `comm`) VALUES
(2, 3, 'Оренбург', 'ул. Волгоградская 32/1', 5, 57, 4, 'Типа какой-то комментарий'),
(3, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 11, 'чы', NULL, NULL, NULL, NULL, NULL),
(14, 14, 'укпаук', 'укпук', 1, 2, 2, 'ацва'),
(15, 15, 'Минск', '12312', 1231, 1231, 123, 'вцува'),
(16, 16, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 16, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 17, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 18, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 19, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 20, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 21, '1', '22', 2, 2, 2, '2'),
(24, 23, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 24, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 25, '1', '2', 3, 4, 5, '6'),
(27, 26, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 27, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 28, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 29, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 30, '11', ' ', NULL, 0, -2, NULL),
(32, 31, 'минск', ' ', 0, 0, -1, 'ыфв22'),
(33, 32, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 33, 'Минск', NULL, 333, 33, 4, NULL),
(35, 34, '1', NULL, NULL, NULL, NULL, NULL),
(36, 35, 'Moscow', 'Lenina 1', 1, 1, 1, NULL),
(37, 36, 'Минск111р', 'Камайскйаавв', 23221, 222, 4, 'ааааатест'),
(38, 37, 'Минск', 'Тимирязева ', 1, 65, 2, NULL),
(39, 39, 'Minsk', 'Lenina 22', 1, 1, 1, NULL),
(40, 40, 'Минск', 'Тимирязева ', 3, 288, 8, NULL),
(41, 41, 'Минск', 'Тимирязева ', 6, 45, 7, NULL),
(42, 42, 'Минск', 'Камайская ', 12, 34, 6, NULL),
(43, 43, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 44, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 45, NULL, NULL, NULL, 1, NULL, NULL),
(46, 46, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 47, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 48, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 49, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 50, 'Минск', '56', 4, NULL, NULL, NULL),
(51, 51, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 53, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 56, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 57, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 57, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 58, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 59, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 60, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 60, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users_pets`
--

CREATE TABLE `users_pets` (
  `id` bigint(20) NOT NULL,
  `user` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) DEFAULT NULL COMMENT 'Имя питомца',
  `age` int(11) DEFAULT NULL COMMENT 'Возраст',
  `gender` int(11) DEFAULT NULL COMMENT 'Пол',
  `breed` varchar(64) DEFAULT NULL COMMENT 'Порода животного',
  `comm` text DEFAULT NULL COMMENT 'Комментарий',
  `commmore` text DEFAULT NULL COMMENT 'Дополнительный комментарий'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users_pets`
--

INSERT INTO `users_pets` (`id`, `user`, `name`, `age`, `gender`, `breed`, `comm`, `commmore`) VALUES
(2, 3, 'кличка rew f', 5, 1, 'Не знаю f', 'комм f', 'Введите информацию... fds'),
(3, 4, 'Арчибальд', 1, 1, 'Немецкий шпиц', NULL, NULL),
(4, 5, 'Арчибальд', 20, 1, NULL, NULL, NULL),
(5, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 9, NULL, 20, 1, NULL, NULL, NULL),
(9, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 11, '22', 5, 1, NULL, NULL, NULL),
(13, 14, 'выава', 4, 1, 'Шпиц', NULL, NULL),
(14, 15, 'ыва', 3, 1, 'Питбуль', 'цуава', NULL),
(15, 16, 'Бароша', 7, 1, 'Питбуль', NULL, NULL),
(16, 16, 'Бароша', 7, 1, 'Питбуль', NULL, NULL),
(17, 17, 'Басик', 3, 1, 'Котяра', NULL, NULL),
(18, 18, 'Баро', 8, 1, 'Питбуль', 'Аллергия на курицу', NULL),
(19, 19, 'Бароша', 8, 1, 'Питбуль', 'Есть аллергия на курицу', NULL),
(20, 20, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 21, '22', 20, 1, NULL, '2', NULL),
(23, 23, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 24, NULL, 20, 1, NULL, NULL, NULL),
(25, 25, '123', 20, 1, NULL, NULL, NULL),
(26, 26, 'тестик', 0, 1, 'тест', 'тесттесттест', NULL),
(27, 27, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 28, NULL, 20, 1, NULL, NULL, NULL),
(29, 28, NULL, 20, 1, NULL, NULL, NULL),
(30, 29, NULL, 20, 1, NULL, NULL, NULL),
(31, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 31, NULL, 20, 1, NULL, NULL, NULL),
(33, 32, 'Teddy', 4, 1, NULL, 'test comm', 'Введите информацию...'),
(34, 33, 'Testy', 12, 2, 'Dog', NULL, NULL),
(35, 34, '22', 20, 2, NULL, NULL, NULL),
(36, 35, NULL, 20, 1, NULL, NULL, NULL),
(37, 36, 'уууууував', 5, 2, 'бульдог', 'Самый милый песик)', 'Введите информацию...уцуцуцуц'),
(38, 37, 'Теддд', 7, 2, 'Бигль', 'Мой милый пес ', NULL),
(39, 39, '1', 20, 2, '1', '1', NULL),
(40, 40, 'Тедди', 10, 2, 'Чау-чау', 'Протим', 'Введите информацию...'),
(41, 41, 'Пряник', 10, 2, 'Гончая', NULL, NULL),
(42, 42, 'Томас', 9, 1, 'Самоед', 'Белый пушистый', NULL),
(43, 43, NULL, 20, 1, NULL, NULL, NULL),
(44, 44, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 45, 'фыв', 9, 1, 'фывп', 'ваыва', NULL),
(46, 46, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 47, NULL, 20, 1, NULL, NULL, NULL),
(48, 48, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 49, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 50, NULL, 20, 1, NULL, NULL, NULL),
(51, 51, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 53, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 56, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 57, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 58, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 59, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 60, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 60, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_one_timetoken`
--

CREATE TABLE `user_one_timetoken` (
  `id` bigint(20) NOT NULL,
  `user` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `check` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_request_cities`
--

CREATE TABLE `user_request_cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_request_cities`
--

INSERT INTO `user_request_cities` (`id`, `user_id`, `email`, `city_name`, `created_at`, `updated_at`) VALUES
(1, 26, 'test@test.test', '11111', '2025-02-05 09:33:06', '2025-02-05 09:33:06'),
(2, 30, 'test@test.test', '1223', '2025-02-08 11:16:36', '2025-02-08 11:16:36'),
(3, 34, '', '1111111111', '2025-02-22 14:49:38', '2025-02-22 14:49:38'),
(4, 43, '', 'Воронеж', '2025-03-13 14:48:33', '2025-03-13 14:48:33'),
(5, 44, 'yudinvladimir01@gmail.com', 'Москва', '2025-03-17 14:11:58', '2025-03-17 14:11:58');

-- --------------------------------------------------------

--
-- Структура таблицы `veterinaryclinics`
--

CREATE TABLE `veterinaryclinics` (
  `id` int(11) NOT NULL,
  `coordinates` point DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `addr` varchar(256) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `link` varchar(512) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `phone2` bigint(20) DEFAULT NULL,
  `timework` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `veterinaryclinics`
--

INSERT INTO `veterinaryclinics` (`id`, `coordinates`, `name`, `addr`, `desc`, `link`, `phone`, `phone2`, `timework`, `status`) VALUES
(3, 0x00000000010100000009c3802557f94a4094a46b26dfb03b40, 'Альфа-Вет ', '9, Острошицкая улица, Уручье-4, Уручье, Первомайский район, Минск, 220125, Беларусь', 'Врачи ветеринарной клиники «Альфа-Вет» всегда готовы помочь вашему домашнему любимцу справиться с недугом, а также проконсультировать вас по всем волнующим вопросам.', 'https://alfavet.by/  ', NULL, NULL, 'Режим работы: круглосуточно\r<div>Среда: перерыв с 11:00 до 14:00</div>', 1),
(8, NULL, 'Удобно и быстро', 'г Минск, ул Тимирязева, д 65А', 'Быстро и качественно', NULL, 375447490965, NULL, '09-21', 1),
(9, NULL, 'New Test', NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `zooid`
--

CREATE TABLE `zooid` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `descshort` text DEFAULT NULL,
  `desc` mediumtext DEFAULT NULL,
  `BYN` int(11) NOT NULL DEFAULT 0,
  `RUB` int(11) NOT NULL DEFAULT 0,
  `hide` tinyint(4) NOT NULL DEFAULT 0,
  `delete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `zooid`
--

INSERT INTO `zooid` (`id`, `name`, `descshort`, `desc`, `BYN`, `RUB`, `hide`, `delete`) VALUES
(1, 'Зоо ID (Базовый тариф, обязательный)', '', '', 5, 0, 1, 0),
(2, 'Выдадим кулон с уникальным ID', NULL, NULL, 10, 0, 0, 0),
(3, 'Добавление новой', NULL, NULL, 1, 400, 0, 1),
(4, 'Test 1 0', NULL, NULL, 1, 400, 0, 1),
(5, 'Test 2', NULL, NULL, 0, 0, 0, 1),
(6, 'Созданная и удалена', NULL, NULL, 0, 0, 0, 1),
(7, 'тест татьяной 27.12', NULL, NULL, 1, 100, 0, 1),
(8, 'Тест 1111 yesy', NULL, NULL, 0, 0, 0, 1),
(9, 'Еуые', NULL, NULL, -5, -100, 1, 1),
(10, 'Выделим менеджера с круглосуточной линией связи', NULL, NULL, 0, 0, 0, 0),
(11, 'Выплатим вознаграждение нашедшему', NULL, NULL, 0, 0, 0, 0),
(12, 'Доставим питомца вам в пределах Минска и области', NULL, NULL, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `zooid_userconfig`
--

CREATE TABLE `zooid_userconfig` (
  `user` bigint(20) UNSIGNED NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`config`))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `zooid_userconfig`
--

INSERT INTO `zooid_userconfig` (`user`, `config`) VALUES
(3, '[\"1\", \"3\", \"4\"]'),
(9, '[3,4]'),
(11, '[]'),
(21, '[1,4,7]');

-- --------------------------------------------------------

--
-- Структура таблицы `zoopolis`
--

CREATE TABLE `zoopolis` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `descshort` text DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `BYN` int(11) DEFAULT 0,
  `RUB` int(11) DEFAULT 0,
  `hide` tinyint(4) DEFAULT 0,
  `delete` tinyint(4) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `zoopolis`
--

INSERT INTO `zoopolis` (`id`, `name`, `descshort`, `desc`, `BYN`, `RUB`, `hide`, `delete`) VALUES
(1, 'Зоополис (Базовая, обязательная)', NULL, NULL, 1000, 7000, 1, 0),
(2, 'Тест настройки зооПолис', NULL, NULL, 100, 700, 0, 0),
(3, 'Еще одна услуга на миллион', NULL, NULL, 100000, 700000, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `zoopolis_userconfig`
--

CREATE TABLE `zoopolis_userconfig` (
  `user` bigint(20) UNSIGNED NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `zoopolis_userconfig`
--

INSERT INTO `zoopolis_userconfig` (`user`, `config`) VALUES
(9, '[0]');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `acquiring`
--
ALTER TABLE `acquiring`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `check_phone_numbers`
--
ALTER TABLE `check_phone_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `concierge`
--
ALTER TABLE `concierge`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `form_missinganimal`
--
ALTER TABLE `form_missinganimal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pet_qr_codes`
--
ALTER TABLE `pet_qr_codes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pet_shops`
--
ALTER TABLE `pet_shops`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media` (`media`(768));

--
-- Индексы таблицы `promo_city`
--
ALTER TABLE `promo_city`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `promo_tags`
--
ALTER TABLE `promo_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promo` (`promo`),
  ADD KEY `tag` (`tag`);

--
-- Индексы таблицы `sub_concierge`
--
ALTER TABLE `sub_concierge`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sub_concierge_user`
--
ALTER TABLE `sub_concierge_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `sub_concierge` (`sub_concierge`);

--
-- Индексы таблицы `sub_zooid`
--
ALTER TABLE `sub_zooid`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sub_zooid_user`
--
ALTER TABLE `sub_zooid_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `sub_zooid` (`sub_zooid`);

--
-- Индексы таблицы `sub_zoopolis`
--
ALTER TABLE `sub_zoopolis`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sub_zoopolis_user`
--
ALTER TABLE `sub_zoopolis_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_pk` (`phone`);

--
-- Индексы таблицы `userstoken`
--
ALTER TABLE `userstoken`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_address`
--
ALTER TABLE `users_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `users_pets`
--
ALTER TABLE `users_pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `user_one_timetoken`
--
ALTER TABLE `user_one_timetoken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `user_request_cities`
--
ALTER TABLE `user_request_cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `veterinaryclinics`
--
ALTER TABLE `veterinaryclinics`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `zooid`
--
ALTER TABLE `zooid`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `zooid_userconfig`
--
ALTER TABLE `zooid_userconfig`
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `zoopolis`
--
ALTER TABLE `zoopolis`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `zoopolis_userconfig`
--
ALTER TABLE `zoopolis_userconfig`
  ADD KEY `user` (`user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `acquiring`
--
ALTER TABLE `acquiring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Порядковый', AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT для таблицы `check_phone_numbers`
--
ALTER TABLE `check_phone_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `concierge`
--
ALTER TABLE `concierge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `form_missinganimal`
--
ALTER TABLE `form_missinganimal`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `pet_qr_codes`
--
ALTER TABLE `pet_qr_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `pet_shops`
--
ALTER TABLE `pet_shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `promo_city`
--
ALTER TABLE `promo_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `promo_tags`
--
ALTER TABLE `promo_tags`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT для таблицы `sub_concierge`
--
ALTER TABLE `sub_concierge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sub_concierge_user`
--
ALTER TABLE `sub_concierge_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `sub_zooid`
--
ALTER TABLE `sub_zooid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sub_zooid_user`
--
ALTER TABLE `sub_zooid_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT для таблицы `sub_zoopolis`
--
ALTER TABLE `sub_zoopolis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sub_zoopolis_user`
--
ALTER TABLE `sub_zoopolis_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT для таблицы `userstoken`
--
ALTER TABLE `userstoken`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT для таблицы `users_address`
--
ALTER TABLE `users_address`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT для таблицы `users_pets`
--
ALTER TABLE `users_pets`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `user_one_timetoken`
--
ALTER TABLE `user_one_timetoken`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_request_cities`
--
ALTER TABLE `user_request_cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `veterinaryclinics`
--
ALTER TABLE `veterinaryclinics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `zooid`
--
ALTER TABLE `zooid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `zoopolis`
--
ALTER TABLE `zoopolis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `promo_tags`
--
ALTER TABLE `promo_tags`
  ADD CONSTRAINT `promo_tags_ibfk_1` FOREIGN KEY (`promo`) REFERENCES `promo` (`id`),
  ADD CONSTRAINT `promo_tags_ibfk_2` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`);

--
-- Ограничения внешнего ключа таблицы `sub_concierge_user`
--
ALTER TABLE `sub_concierge_user`
  ADD CONSTRAINT `sub_concierge_user_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sub_concierge_user_ibfk_2` FOREIGN KEY (`sub_concierge`) REFERENCES `sub_concierge` (`id`);

--
-- Ограничения внешнего ключа таблицы `sub_zooid_user`
--
ALTER TABLE `sub_zooid_user`
  ADD CONSTRAINT `sub_zooid_user_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sub_zooid_user_ibfk_2` FOREIGN KEY (`sub_zooid`) REFERENCES `sub_zooid` (`id`);

--
-- Ограничения внешнего ключа таблицы `users_address`
--
ALTER TABLE `users_address`
  ADD CONSTRAINT `users_address_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `users_pets`
--
ALTER TABLE `users_pets`
  ADD CONSTRAINT `users_pets_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_one_timetoken`
--
ALTER TABLE `user_one_timetoken`
  ADD CONSTRAINT `user_one_timetoken_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
