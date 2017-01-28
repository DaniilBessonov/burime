-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 28 2017 г., 13:28
-- Версия сервера: 5.6.16
-- Версия PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `burime`
--

-- --------------------------------------------------------

--
-- Структура таблицы `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` varchar(40) DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `players_count` int(11) NOT NULL DEFAULT '2',
  `turns_count` int(11) NOT NULL DEFAULT '2',
  `finished` int(11) NOT NULL DEFAULT '0',
  `players_ready` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Дамп данных таблицы `games`
--

INSERT INTO `games` (`id`, `topic`, `admin_id`, `players_count`, `turns_count`, `finished`, `players_ready`) VALUES
(1, 'Game0', 1, 5, 5, 0, 0),
(2, 'Game #2', 1, 4, 5, 0, 1),
(20, 'Game1', 8, 5, 5, 0, 1),
(21, 'Game1', 8, 5, 5, 0, 1),
(22, 'Game1', 8, 5, 5, 0, 1),
(23, 'Game1', 8, 5, 5, 0, 1),
(24, 'Game1', 8, 5, 5, 0, 1),
(25, 'Game1', 8, 5, 5, 0, 1),
(26, 'Game1', 8, 5, 5, 0, 1),
(27, 'Game1', 8, 5, 5, 0, 1),
(28, 'Game1', 8, 5, 5, 0, 1),
(29, 'Game1', 8, 5, 5, 0, 1),
(30, 'Game1', 8, 5, 5, 0, 1),
(31, 'Game1', 8, 5, 5, 0, 1),
(32, 'Game3', 1, 2, 2, 0, 1),
(33, 'Game3', 1, 2, 2, 0, 1),
(34, 'Game4', 1, 2, 2, 0, 0),
(35, 'Game5', 1, 2, 2, 0, 0),
(36, 'Ð ÑƒÑÑÐºÐ°Ñ', 16, 2, 2, 0, 0),
(37, 'drtedrtd', 16, 2, 2, 0, 0),
(38, 'Ð¸Ð¾Ð»Ñ‚Ð¾Ð»', 16, 2, 2, 0, 0),
(39, 'Test', 1, 2, 2, 0, 1),
(40, 'Test2', 1, 2, 2, 0, 1),
(41, 'Test3', 1, 2, 2, 0, 1),
(42, 'Test4', 1, 2, 2, 0, 1),
(43, 'Test5', 1, 1, 1, 0, 0),
(44, 'Test6', 1, 2, 1, 1, 1),
(45, 'Tester', 1, 2, 1, 1, 1),
(46, 'Ð°Ð»ÑÐ»Ñ', 1, 2, 1, 1, 1),
(47, '123', 1, 122, 12, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `made_turns` int(11) NOT NULL DEFAULT '0',
  `turn_now` int(11) NOT NULL DEFAULT '0',
  `order_number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `game_id` (`game_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `game_id`, `user_id`, `made_turns`, `turn_now`, `order_number`) VALUES
(1, 2, 1, 3, 0, 1),
(5, 2, 8, 3, 0, 2),
(6, 2, 9, 3, 0, 3),
(7, 34, 1, 0, 1, 1),
(8, 35, 1, 0, 1, 1),
(9, 36, 16, 0, 1, 1),
(10, 37, 16, 0, 1, 1),
(11, 38, 16, 0, 1, 1),
(12, 2, 15, 2, 1, 4),
(13, 39, 1, 0, 1, 1),
(14, 39, 14, 0, 0, 2),
(15, 40, 1, 1, 1, 1),
(16, 40, 14, 1, 0, 2),
(17, 41, 1, 1, 0, 1),
(18, 41, 14, 0, 1, 2),
(19, 42, 1, 3, 1, 1),
(20, 42, 14, 3, 0, 2),
(21, 43, 1, 0, 1, 1),
(22, 44, 1, 1, 1, 1),
(23, 44, 14, 1, 0, 2),
(24, 45, 1, 1, 1, 1),
(25, 45, 14, 1, 0, 2),
(26, 46, 1, 1, 1, 1),
(27, 46, 14, 1, 0, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `stories`
--

CREATE TABLE IF NOT EXISTS `stories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` mediumtext NOT NULL,
  `order_number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `game_id` (`game_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Дамп данных таблицы `stories`
--

INSERT INTO `stories` (`id`, `game_id`, `user_id`, `text`, `order_number`) VALUES
(15, 2, 8, 'Text1', 1),
(17, 2, 8, 'Text2', 2),
(18, 2, 8, 'Text3', 3),
(19, 2, 8, 'Text5', 5),
(20, 2, 8, 'Text4', 4),
(21, 1, 8, 'Text1', 1),
(23, 1, 8, 'Text2', 2),
(24, 1, 8, 'Text3', 3),
(25, 2, 8, 'Text', 6),
(26, 2, 8, 'uuuuuuuuuuuu', 7),
(27, 2, 8, 'gggggg', 8),
(28, 2, 9, 'mytext', 9),
(29, 2, 15, 'mytext2', 10),
(30, 2, 15, 'mytext2', 11),
(31, 2, 1, 'text', 12),
(32, 2, 8, 'uiji', 13),
(33, 2, 9, ' n jjnnj', 14),
(34, 40, 1, 'Ð»Ð¾Ñ€Ñ€Ñ€Ð¾', 1),
(35, 40, 14, 'jjjjjj', 2),
(36, 41, 1, '111', 1),
(37, 42, 1, '1111', 1),
(38, 42, 14, '2222', 2),
(39, 42, 1, '3333', 3),
(40, 42, 14, '4444', 4),
(41, 42, 1, '5555', 5),
(42, 42, 14, '6666', 6),
(43, 44, 1, '11111', 1),
(44, 44, 14, '22222', 2),
(45, 45, 1, 'Ñ€Ð°Ð· Ð´Ð²Ð°', 1),
(46, 45, 14, 'Ð¢Ñ€Ð¸ Ñ‡ÐµÑ‚Ñ‹Ñ€Ð¸', 2),
(47, 46, 1, 'Ð—Ð´Ñ€Ð°Ð²ÑÑ‚Ð²ÑƒÐ¹Ñ‚Ðµ', 1),
(48, 46, 14, 'Ð§Ñ‚Ð¾ Ð¿Ñ€Ð¾Ð¸ÑÑ…Ð¾Ð´Ð¸Ñ‚?', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'Petiy', '123'),
(8, 'Petiy1', '123'),
(9, 'Mryia', '12345'),
(14, 'Dabe', '1'),
(15, 'Mike', '123'),
(16, 'Ð’Ð°ÑÑ', '123');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `stories`
--
ALTER TABLE `stories`
  ADD CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `stories_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
