-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 14 2022 г., 09:00
-- Версия сервера: 5.7.33
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bistrobank`
--

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `fio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inn` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id`, `fio`, `inn`) VALUES
(17, 'Креветков Владимир Креветкович', '123412341234');

-- --------------------------------------------------------

--
-- Структура таблицы `client_individual`
--

CREATE TABLE `client_individual` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `passport_series` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_number` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `client_law`
--

CREATE TABLE `client_law` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `client_law`
--

INSERT INTO `client_law` (`id`, `client_id`, `organization_id`) VALUES
(3, 17, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `credit`
--

CREATE TABLE `credit` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `term` int(3) NOT NULL,
  `amount` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `deposit`
--

CREATE TABLE `deposit` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `bid` decimal(10,0) NOT NULL,
  `capitalization_period` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ogrn` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inn` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kpp` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `organization`
--

INSERT INTO `organization` (`id`, `name`, `ogrn`, `inn`, `kpp`, `address`) VALUES
(6, 'ООО Креветка', '1234123412341', '4411441144', '123456789', 'Креветкинская улица 121, 3');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `client_individual`
--
ALTER TABLE `client_individual`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `client_law`
--
ALTER TABLE `client_law`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `client_individual`
--
ALTER TABLE `client_individual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `client_law`
--
ALTER TABLE `client_law`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `credit`
--
ALTER TABLE `credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
