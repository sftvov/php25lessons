-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 30 2019 г., 15:35
-- Версия сервера: 10.4.6-MariaDB
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `photogallery`
--
CREATE DATABASE IF NOT EXISTS `photogallery` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `photogallery`;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `slug` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Растения', 'plants'),
(2, 'Архитектура', 'architecture'),
(3, 'Пейзаж', 'landscape'),
(4, 'Скульптура', 'sculpture');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `contents` text NOT NULL,
  `picture` int(10) UNSIGNED NOT NULL,
  `uploaded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `user`, `contents`, `picture`, `uploaded`) VALUES
(1, 1, 'Забавные зверушки', 3, '2019-09-06 10:18:39'),
(2, 3, 'Какое пустынное место...', 7, '2019-09-06 10:20:02'),
(3, 2, 'Весьма аппетитно выглядит эта скульптура', 2, '2019-09-06 10:21:38'),
(4, 3, 'Какая красивая!', 8, '2019-09-27 09:04:00'),
(5, 3, 'Так бы и съел. ;)', 2, '2019-09-30 08:07:27');

-- --------------------------------------------------------

--
-- Структура таблицы `pictures`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE `pictures` (
  `id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(24) NOT NULL,
  `title` tinytext NOT NULL,
  `description` text NOT NULL,
  `category` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `uploaded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pictures`
--

INSERT INTO `pictures` (`id`, `filename`, `title`, `description`, `category`, `user`, `uploaded`) VALUES
(1, '200804282020.jpg', 'Цветы кактуса', 'Снято в Волжском гуманитарном институте', 1, 3, '2019-09-06 09:38:41'),
(2, '201802131844.jpg', 'Блинная скульптура', 'Снято в кафе \"Закусочная \"Ахтуба\"\"', 4, 1, '2019-09-06 09:41:19'),
(3, '201506152037.jpg', 'Памятник сусликам', '', 4, 3, '2019-09-06 09:43:51'),
(4, '200901092053.jpg', 'Зимний закат', '', 3, 2, '2019-09-06 09:50:01'),
(5, '201709252026.jpg', 'Кот ученый', 'Поставлен по инициативе Волжского гуманитарного института', 4, 3, '2019-09-06 09:51:37'),
(6, '201710242002.jpg', 'Памятник собаке-поводырю', 'Стоит на автобусной остановке', 4, 1, '2019-09-06 09:55:46'),
(7, '200807192032.jpg', 'Пустынная аллея', 'В запущенном парке на окраине', 3, 2, '2019-09-06 09:58:40'),
(8, '201410131614.jpg', 'Роза', '', 1, 3, '2019-09-06 10:00:01'),
(9, '201709180821.jpg', 'Бегемотики', '', 4, 3, '2019-09-06 10:01:14');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'basil'),
(3, 'jocker');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded` (`uploaded`),
  ADD KEY `user` (`user`),
  ADD KEY `picture` (`picture`);

--
-- Индексы таблицы `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded` (`uploaded`),
  ADD KEY `category` (`category`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`picture`) REFERENCES `pictures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `pictures_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
