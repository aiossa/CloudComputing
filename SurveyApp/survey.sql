-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 14 2016 г., 20:06
-- Версия сервера: 5.7.11
-- Версия PHP: 5.6.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `survey`
--

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`data`) VALUES
('{\r\n	"sex": {\r\n		"type": "radio",\r\n		"question": {\r\n			"ru": "Укажите Ваш пол",\r\n			"en": "Choose your sex"\r\n		},\r\n		"variants": {\r\n			"m": {\r\n				"ru": "Мужчина",\r\n				"en": "Male"\r\n			},\r\n			"f": {\r\n				"ru": "Женщина",\r\n				"en": "Female"\r\n			}\r\n		}\r\n	},\r\n	"age": {\r\n		"type": "dropdown",\r\n		"question": {\r\n			"ru": "Укажите Ваш возраст",\r\n			"en": "Choose your age"\r\n		},\r\n		"variants": [\r\n			"<18", "18-25", "25-35", ">35"\r\n		]\r\n	},\r\n	"design": {\r\n		"type": "rating",\r\n		"question": {\r\n			"ru": "Сколько котиков(выбери звездочки!)",\r\n			"en": "What is the right number of cats (choose stars)?"\r\n		},\r\n		"variants": 10\r\n	},\r\n	"logo": {\r\n		"type": "radio",\r\n		"question": {\r\n			"ru": "Какой логотип Вам больше нравится",\r\n			"en": "Which logo do you prefer"\r\n		},\r\n		"variants": {\r\n			"1": {\r\n				"ru": "СКБ Контур",\r\n				"en": "SKB Kontur"\r\n			},\r\n			"2": {\r\n				"ru": "Иннополис1111",\r\n				"en": "Innopolis"\r\n			},\r\n			"3": {\r\n				"ru": "Оба",\r\n				"en": "Like both of them"\r\n			},\r\n			"4": {\r\n				"ru": "Ни один",\r\n				"en": "None of them"\r\n			}\r\n		}\r\n	},\r\n	"comment": {\r\n		"type": "text",\r\n		"question": {\r\n			"ru": "Как зовут котика?",\r\n			"en": "What is the name for the cat?"\r\n		}\r\n	}\r\n}');

-- --------------------------------------------------------

--
-- Структура таблицы `results`
--

CREATE TABLE `results` (
  `id` int(10) UNSIGNED NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL,
  `data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `results`
--

INSERT INTO `results` (`id`, `timestamp`, `data`) VALUES
(2, 1465922516, '{"sex":"m","age":"0","design":"3","logo":"1","comment":"123","ok":"OK"}'),
(3, 1465922577, '{"sex":"m","age":"0","design":"3","logo":"1","comment":"123","ok":"OK"}'),
(4, 1465922578, '{"sex":"m","age":"0","design":"3","logo":"1","comment":"123","ok":"OK"}'),
(5, 1465922587, '{"sex":"f","age":"2","design":"5","logo":"2","comment":"3444","ok":"OK"}');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `results`
--
ALTER TABLE `results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
