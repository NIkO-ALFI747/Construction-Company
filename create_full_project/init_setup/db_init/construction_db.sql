-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 17 2022 г., 10:56
-- Версия сервера: 10.4.22-MariaDB
-- Версия PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `construction_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brigades`
--

CREATE TABLE `brigades` (
  `ID_brigade` int(3) UNSIGNED NOT NULL,
  `ID_worker` int(3) UNSIGNED NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `brigades`
--

INSERT INTO `brigades` (`ID_brigade`, `ID_worker`, `Name`) VALUES
(1, 6, 'Бригада сварщиков'),
(2, 4, 'Бригада строительных реставраторов'),
(3, 15, 'Бригада столяров'),
(4, 11, 'Бригада каменщиков'),
(5, 16, 'Бригада плотников'),
(6, 10, 'Бригада отделочников'),
(7, 1, 'Бригада облицовщиков'),
(8, 2, 'Бригада архитекторов'),
(9, 5, 'Бригада маляров-штукатуров'),
(10, 12, 'Бригада садовников');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `ID_material` int(5) UNSIGNED NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Units` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`ID_material`, `Name`, `Units`) VALUES
(1, 'Сваи железобетонные', 'м^3'),
(2, 'Детали ростверков железобетонные', 'м^3'),
(3, 'Колонны железобетонные', 'м^3'),
(4, 'Балки подкрановые железобетонные', 'м^3'),
(5, 'Трубы железобетонные', 'м^3'),
(6, 'Опоры ЛЭП, связи и элементы контактной сети электрифицированных дорог и осветительной сети', 'м^3'),
(7, 'Шпалы и брусья железобетонные', 'шт'),
(8, 'Плиты из цемента, бетона или искусственного камня', 'м^2'),
(9, 'Кирпич строительный (включая камни) из цемента, бетона или искусственного камня', 'м^3'),
(10, 'Бетон, готовый для заливки (товарный бетон)', 'м^3'),
(11, 'Профили листовые из нелегированной стали', 'т'),
(12, 'Сталь арматурная горячекатаная для железобетонных конструкций', 'т'),
(13, 'Лесоматериалы хвойных пород необработанные, окрашенные, протравленные, обработанные креозотом или другими консервантами', 'м^3'),
(14, 'Окна и их коробки деревянные', 'м^2'),
(15, 'Двери, их коробки и пороги деревянные', 'м^2'),
(16, 'Стекло листовое литое, прокатное, тянутое или выдувное, но не обработанное другим способом', 'м^2'),
(17, 'Известь негашеная', 'т'),
(18, 'Гипс строительный', 'т'),
(19, 'Мастики кровельные и гидроизоляционные', 'т'),
(20, 'Трубы стальные водогазопроводные', 'т'),
(21, 'Кабели и арматура кабельная', 'км'),
(22, 'Светильники и осветительные устройства', 'шт'),
(23, 'Бензин автомобильный', 'т'),
(24, 'Электроэнергия', 'МВт.ч');

-- --------------------------------------------------------

--
-- Структура таблицы `objects`
--

CREATE TABLE `objects` (
  `ID_object` int(5) UNSIGNED NOT NULL,
  `ID_type` int(3) UNSIGNED NOT NULL,
  `Name` varchar(80) NOT NULL,
  `City` varchar(30) NOT NULL,
  `Street` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `objects`
--

INSERT INTO `objects` (`ID_object`, `ID_type`, `Name`, `City`, `Street`) VALUES
(1, 10, 'Акведук', 'Чэнду', 'Jinli Street'),
(2, 11, 'Рейн', 'Лондон', 'Flask Walk'),
(3, 8, 'Р-120 - Орел - граница с Республикой Белоруссия', 'Орел', 'Невский проспект'),
(4, 2, 'Боровицкая башня', 'Москва', 'Ломбард-стрит'),
(5, 13, 'Ангар Avenue из металлоконструкций', 'Нью-Йорк', 'Convent Avenue'),
(6, 3, 'Вышка сотовой связи \"Сколково\"', 'Киото', 'The Philosopher\'s Walk'),
(7, 4, 'Испарительная градирня \"Юг\"', 'Эдинбург', 'Cockburn Street'),
(8, 9, 'Октябрьское РЖД', 'Хабаровск', 'Томский проспект'),
(9, 1, 'Жилой дом № 6', 'Претория', 'Herbert Baker Street'),
(10, 6, 'Телефонная связь \"M line\"', 'Мельбурн', 'Hosier Lane'),
(11, 1, 'Дом №80', 'Краснодар', 'Центральная');

-- --------------------------------------------------------

--
-- Структура таблицы `phones`
--

CREATE TABLE `phones` (
  `ID_phone` int(5) UNSIGNED NOT NULL,
  `ID_worker` int(3) UNSIGNED NOT NULL,
  `Phone` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `phones`
--

INSERT INTO `phones` (`ID_phone`, `ID_worker`, `Phone`) VALUES
(1, 1, '275(556)780-91-25'),
(2, 8, '54(580)437-28-06'),
(3, 2, '333(88)255-35-66'),
(4, 13, '0(56)364-89-21'),
(5, 3, '276(096)831-38-58'),
(6, 4, '19(342)886-68-87'),
(7, 5, '053(5344)765-62-31'),
(8, 6, '36(7886)425-20-23'),
(9, 7, '61(05)123-68-50'),
(10, 8, '9(661)572-90-82'),
(11, 9, '1(687)825-05-87'),
(12, 10, '47(311)275-00-50'),
(13, 11, '800(781)640-70-94'),
(14, 12, '31(7317)836-88-67'),
(15, 13, '781(620)710-71-42'),
(16, 14, '62(03)622-20-18'),
(17, 14, '856(0321)927-73-29'),
(18, 15, '920(5057)884-67-22'),
(19, 16, '22(4434)110-41-93'),
(20, 14, '02(0874)683-41-58');

-- --------------------------------------------------------

--
-- Структура таблицы `professions`
--

CREATE TABLE `professions` (
  `ID_speciality` int(3) UNSIGNED NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `professions`
--

INSERT INTO `professions` (`ID_speciality`, `Name`) VALUES
(1, 'Инженер-строитель'),
(2, 'Архитектор'),
(3, 'Строительный реставратор'),
(4, 'Маляр-штукатур'),
(5, 'Техник в области строительства и эксплуатации зданий'),
(6, 'Специалист в области садово-паркового и ландшафтного строительства'),
(7, 'Отделочник'),
(8, 'Бетонщик'),
(9, 'Каменщик'),
(10, 'Садовник, рабочий зеленого хозяйства'),
(11, 'Геодезист (землемер)'),
(12, 'Крановщик'),
(13, 'Столяр'),
(14, 'Плотник'),
(15, 'Монтажник'),
(16, 'Кровельщик'),
(17, 'Электрик'),
(18, 'Сварщик'),
(19, 'Облицовщик');

-- --------------------------------------------------------

--
-- Структура таблицы `professions_workers`
--

CREATE TABLE `professions_workers` (
  `ID_professions_workers` int(5) UNSIGNED NOT NULL,
  `ID_worker` int(3) UNSIGNED NOT NULL,
  `ID_speciality` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `professions_workers`
--

INSERT INTO `professions_workers` (`ID_professions_workers`, `ID_worker`, `ID_speciality`) VALUES
(1, 1, 19),
(2, 2, 2),
(3, 3, 1),
(4, 4, 3),
(5, 5, 4),
(6, 6, 18),
(7, 7, 5),
(8, 8, 6),
(9, 9, 7),
(10, 10, 8),
(11, 11, 9),
(12, 12, 10),
(13, 13, 11),
(14, 14, 12),
(15, 15, 13),
(16, 16, 14),
(17, 7, 15),
(18, 11, 16),
(19, 12, 17),
(20, 14, 18),
(21, 9, 3),
(22, 13, 3),
(23, 11, 18),
(24, 14, 18),
(25, 1, 13),
(26, 2, 13),
(27, 3, 9),
(29, 15, 7),
(30, 7, 14);

-- --------------------------------------------------------

--
-- Структура таблицы `types_of_objects`
--

CREATE TABLE `types_of_objects` (
  `ID_type` int(3) UNSIGNED NOT NULL,
  `Name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `types_of_objects`
--

INSERT INTO `types_of_objects` (`ID_type`, `Name`) VALUES
(1, 'Здания'),
(2, 'Башни'),
(3, 'Вышки'),
(4, 'Градирни'),
(5, 'Линии электропередачи'),
(6, 'Линии связи'),
(7, 'Трубопроводы'),
(8, 'Автомобильные дороги'),
(9, 'Железнодорожные пути'),
(10, 'Мосты'),
(11, 'Аэродромы'),
(12, 'Тоннели'),
(13, 'Временные сооружения'),
(15, 'Веранда'),
(16, 'Террасса');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nick` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `nick`, `email`, `password`) VALUES
(1, 'Hinahal', 'yurogratreitei-9927@yopmail.co', '111'),
(2, 'Tian', 'joutraudetrippu-8614@yopmail.c', '222'),
(5, 'Walto', 'quaufrujedduffoi-8609@yopmail.', '333'),
(6, 'Quinty', 'cisexinnoitte-8328@yopmail.com', '444');

-- --------------------------------------------------------

--
-- Структура таблицы `uses_materials`
--

CREATE TABLE `uses_materials` (
  `Serial_number` int(5) UNSIGNED NOT NULL,
  `ID_brigade` int(3) UNSIGNED NOT NULL,
  `ID_object` int(5) UNSIGNED NOT NULL,
  `ID_material` int(5) UNSIGNED NOT NULL,
  `Amount` double DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Cost` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uses_materials`
--

INSERT INTO `uses_materials` (`Serial_number`, `ID_brigade`, `ID_object`, `ID_material`, `Amount`, `Date`, `Cost`) VALUES
(1, 9, 3, 17, 2, '2022-03-04', 7500),
(2, 5, 3, 10, 200, '2022-03-05', 15000),
(3, 1, 1, 2, 3, '2022-03-02', 1000),
(4, 8, 9, 24, 0.5, '2022-03-11', 400),
(5, 9, 9, 18, 0.06, '2022-03-11', 600),
(6, 4, 9, 9, 200, '2022-03-11', 19000),
(7, 2, 7, 16, 15, '2022-03-14', 2000),
(8, 5, 4, 13, 20, '2022-03-19', 820),
(9, 6, 9, 15, 40, '2022-03-11', 12000),
(10, 7, 5, 14, 60, '2022-03-06', 8760),
(11, 1, 5, 1, 30, '2022-03-06', 9080),
(12, 1, 10, 24, 2, '2022-03-29', 500);

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `ID_worker` int(3) UNSIGNED NOT NULL,
  `Surname` varchar(30) DEFAULT NULL,
  `Name` varchar(30) NOT NULL,
  `Patronymic` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`ID_worker`, `Surname`, `Name`, `Patronymic`) VALUES
(1, 'Иванов', 'Александр', 'Владимирович'),
(2, 'Кузнецов', 'Сергей', 'Александрович'),
(3, 'Попов', 'Владимир', 'Николаевич'),
(4, 'Смирнов', 'Андрей', 'Викторович'),
(5, 'Васильев', 'Алексей', 'Сергеевич'),
(6, 'Петров', 'Дмитрий', 'Иванович'),
(7, 'Иванова', 'Елена', 'Александровна'),
(8, 'Кузнецова', 'Татьяна', 'Владимировна'),
(9, 'Волков', 'Евгений', 'Юрьевич'),
(10, 'Соколов', 'Николай', 'Анатольевич'),
(11, 'Смирнова', 'Наталья', 'Викторовна'),
(12, 'Попова', 'Ольга', 'Николаевна'),
(13, 'Николаев', 'Юрий', 'Михайлович'),
(14, 'Захаров', 'Игорь', 'Валерьевич'),
(15, 'Лебедев', 'Павел', 'Евгеньевич'),
(16, 'Петрова', 'Марина', 'Михайловна'),
(36, 'Петров', 'Петр', 'Павлович');

-- --------------------------------------------------------

--
-- Структура таблицы `work_schedules`
--

CREATE TABLE `work_schedules` (
  `Serial_number` int(5) UNSIGNED NOT NULL,
  `ID_brigade` int(3) UNSIGNED NOT NULL,
  `ID_object` int(5) UNSIGNED NOT NULL,
  `Description_of_works` varchar(100) NOT NULL,
  `From1` date NOT NULL,
  `To1` date NOT NULL,
  `Cost` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `work_schedules`
--

INSERT INTO `work_schedules` (`Serial_number`, `ID_brigade`, `ID_object`, `Description_of_works`, `From1`, `To1`, `Cost`) VALUES
(1, 9, 3, 'Покраска линий дороги', '2022-03-04', '2022-03-09', 1600),
(2, 9, 9, 'Штукатурка стен с внутренней стороны', '2022-03-11', '2022-03-24', 3500),
(3, 5, 3, 'Заливка, выравнивание бетона', '2022-03-05', '2022-03-16', 4200),
(4, 5, 4, 'Возведение стен, потолка, крыши, креплений из досок.', '2022-03-19', '2022-04-08', 6700),
(5, 1, 1, 'Сварка узлов железобетонного каркаса моста', '2022-03-02', '2022-03-05', 6320),
(6, 1, 5, 'Сварка железобетонных свай для опоры ангара', '2022-03-06', '2022-03-19', 8600),
(7, 1, 10, 'Сварка оборудования в телефонных будках', '2022-03-29', '2022-04-06', 4160),
(8, 8, 9, 'Создание и проектирование модели жилого дома.', '2022-03-11', '2022-03-24', 5100),
(9, 8, 5, 'Создание архитектуры для каркаса ангара', '2022-03-11', '2022-03-14', 5000),
(13, 1, 1, 'Сварка металлических труб', '2022-06-01', '2022-06-04', 2300),
(14, 6, 1, 'Отделка стен', '2022-06-02', '2022-06-08', 4700);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brigades`
--
ALTER TABLE `brigades`
  ADD PRIMARY KEY (`ID_brigade`),
  ADD KEY `ID_worker` (`ID_worker`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`ID_material`);

--
-- Индексы таблицы `objects`
--
ALTER TABLE `objects`
  ADD PRIMARY KEY (`ID_object`),
  ADD KEY `ID_type` (`ID_type`);

--
-- Индексы таблицы `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`ID_phone`),
  ADD UNIQUE KEY `Phone` (`Phone`),
  ADD KEY `ID_worker` (`ID_worker`);

--
-- Индексы таблицы `professions`
--
ALTER TABLE `professions`
  ADD PRIMARY KEY (`ID_speciality`);

--
-- Индексы таблицы `professions_workers`
--
ALTER TABLE `professions_workers`
  ADD PRIMARY KEY (`ID_professions_workers`),
  ADD KEY `ID_worker` (`ID_worker`),
  ADD KEY `ID_speciality` (`ID_speciality`);

--
-- Индексы таблицы `types_of_objects`
--
ALTER TABLE `types_of_objects`
  ADD PRIMARY KEY (`ID_type`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Индексы таблицы `uses_materials`
--
ALTER TABLE `uses_materials`
  ADD PRIMARY KEY (`Serial_number`),
  ADD KEY `ID_brigade` (`ID_brigade`),
  ADD KEY `ID_object` (`ID_object`),
  ADD KEY `ID_material` (`ID_material`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`ID_worker`);

--
-- Индексы таблицы `work_schedules`
--
ALTER TABLE `work_schedules`
  ADD PRIMARY KEY (`Serial_number`),
  ADD KEY `ID_brigade` (`ID_brigade`),
  ADD KEY `ID_object` (`ID_object`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brigades`
--
ALTER TABLE `brigades`
  MODIFY `ID_brigade` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `ID_material` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `objects`
--
ALTER TABLE `objects`
  MODIFY `ID_object` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `phones`
--
ALTER TABLE `phones`
  MODIFY `ID_phone` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `professions`
--
ALTER TABLE `professions`
  MODIFY `ID_speciality` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `professions_workers`
--
ALTER TABLE `professions_workers`
  MODIFY `ID_professions_workers` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `types_of_objects`
--
ALTER TABLE `types_of_objects`
  MODIFY `ID_type` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `uses_materials`
--
ALTER TABLE `uses_materials`
  MODIFY `Serial_number` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `ID_worker` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `work_schedules`
--
ALTER TABLE `work_schedules`
  MODIFY `Serial_number` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `brigades`
--
ALTER TABLE `brigades`
  ADD CONSTRAINT `brigades_ibfk_1` FOREIGN KEY (`ID_worker`) REFERENCES `workers` (`ID_worker`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `objects`
--
ALTER TABLE `objects`
  ADD CONSTRAINT `objects_ibfk_1` FOREIGN KEY (`ID_type`) REFERENCES `types_of_objects` (`ID_type`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`ID_worker`) REFERENCES `workers` (`ID_worker`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `professions_workers`
--
ALTER TABLE `professions_workers`
  ADD CONSTRAINT `professions_workers_ibfk_1` FOREIGN KEY (`ID_worker`) REFERENCES `workers` (`ID_worker`) ON DELETE CASCADE,
  ADD CONSTRAINT `professions_workers_ibfk_2` FOREIGN KEY (`ID_speciality`) REFERENCES `professions` (`ID_speciality`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `uses_materials`
--
ALTER TABLE `uses_materials`
  ADD CONSTRAINT `uses_materials_ibfk_1` FOREIGN KEY (`ID_brigade`) REFERENCES `brigades` (`ID_brigade`) ON DELETE CASCADE,
  ADD CONSTRAINT `uses_materials_ibfk_2` FOREIGN KEY (`ID_object`) REFERENCES `objects` (`ID_object`) ON DELETE CASCADE,
  ADD CONSTRAINT `uses_materials_ibfk_3` FOREIGN KEY (`ID_material`) REFERENCES `materials` (`ID_material`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `work_schedules`
--
ALTER TABLE `work_schedules`
  ADD CONSTRAINT `work_schedules_ibfk_1` FOREIGN KEY (`ID_brigade`) REFERENCES `brigades` (`ID_brigade`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_schedules_ibfk_2` FOREIGN KEY (`ID_object`) REFERENCES `objects` (`ID_object`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
