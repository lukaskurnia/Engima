-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2019 at 08:36 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enigma`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `movie_name` varchar(255) NOT NULL,
  `genres` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `released_date` date NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'in minutes',
  `movie_pictures` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `movie_name`, `genres`, `price`, `released_date`, `description`, `duration`, `movie_pictures`) VALUES
(1, 'IT Chapter Two', 'Thriller/Mystery', 40000, '2019-09-04', 'Defeated by members of the Losers\' Club, the evil clown Pennywise returns 27 years later to terrorize the town of Derry, Maine, once again. Now adults, the childhood friends have long since gone their separate ways. But when people start disappearing, Mike Hanlon calls the others home for one final stand. Damaged by scars from the past, the united Losers must conquer their deepest fears to destroy the shape-shifting Pennywise -- now more powerful than ever.', 230, '../pictures/movies/it2.jpg'),
(2, 'Gundala', 'Drama/Action', 30000, '2019-08-29', '\"Gundala\" is a 2019 Indonesian superhero film based on the comics character Gundala created by Harya Hasmi Suraminata in 1969, co-produced by Screenplay Films and BumiLangit Studios, and distributed by Legacy Pictures. It is the first installment in the BumiLangit Cinematic Universe.', 123, '../pictures/movies/gundala.jpg'),
(3, 'John Wick: Chapter 3 - Parabellum', 'Thriller/Mystery', 40000, '2019-05-22', 'After gunning down a member of the High Table -- the shadowy international assassin\'s guild -- legendary hit man John Wick finds himself stripped of the organization\'s protective services. Now stuck with a $14 million bounty on his head, Wick must fight his way through the streets of New York as he becomes the target of the world\'s most ruthless killers.', 130, '../pictures/movies/johnwick3.jpg'),
(4, 'Ant-Man and the Wasp', 'Fantasy/Sci-fi', 30000, '2018-07-04', 'Scott Lang is grappling with the consequences of his choices as both a superhero and a father. Approached by Hope van Dyne and Dr. Hank Pym, Lang must once again don the Ant-Man suit and fight alongside the Wasp. The urgent mission soon leads to secret revelations from the past as the dynamic duo finds itself in an epic battle against a powerful new enemy.', 125, '../pictures/movies/antman2.jpg'),
(5, 'Avengers: Endgame', 'Fantasy/Sci-fi', 50000, '2019-04-24', 'Adrift in space with no food or water, Tony Stark sends a message to Pepper Potts as his oxygen supply starts to dwindle. Meanwhile, the remaining Avengers -- Thor, Black Widow, Captain America and Bruce Banner -- must figure out a way to bring back their vanquished allies for an epic showdown with Thanos -- the evil demigod who decimated the planet and the universe.', 182, '../pictures/movies/av-endgame.jpg'),
(6, 'film 6', 'Genre', 1000, '2019-11-17', 'Description', 100, 'x.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `seat_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `schedule_id`, `seat_number`, `user_id`) VALUES
(9, 2, 28, 1),
(14, 5, 19, 1),
(68, 8, 25, 2),
(69, 8, 15, 2),
(70, 8, 17, 2),
(72, 8, 5, 2),
(77, 8, 13, 2),
(78, 8, 16, 2),
(79, 8, 9, 2),
(81, 11, 16, 2),
(82, 11, 15, 2),
(83, 10, 16, 1),
(84, 10, 28, 1),
(85, 10, 27, 1),
(86, 10, 5, 1),
(88, 10, 26, 1),
(99, 1, 3, 2),
(695, 22, 19, 10),
(696, 22, 26, 10),
(697, 23, 15, 10),
(698, 22, 14, 2),
(699, 22, 18, 10),
(700, 24, 30, 10);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `orders_id`, `rating`, `review`) VALUES
(21, 14, 10, 'bagus bgt'),
(28, 698, 10, 'Nice'),
(29, 699, 2, 'Check review'),
(30, 695, 10, 'Test Review'),
(31, 696, 7, 'Lalala');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `movie_id`, `datetime`) VALUES
(1, 1, '2019-11-18 13:00:00'),
(2, 1, '2019-09-20 12:00:00'),
(3, 2, '2019-09-18 19:00:00'),
(4, 2, '2019-09-21 14:00:00'),
(5, 3, '2019-09-23 17:00:00'),
(6, 3, '2019-09-24 11:00:00'),
(7, 5, '2019-09-24 23:00:00'),
(8, 5, '2019-09-28 15:00:00'),
(9, 2, '2019-09-28 23:00:00'),
(10, 1, '2019-09-29 18:00:00'),
(11, 4, '2019-09-30 00:00:00'),
(12, 2, '2019-09-30 07:00:00'),
(13, 5, '2019-10-10 08:00:00'),
(14, 4, '2019-09-30 11:00:00'),
(15, 3, '2019-09-30 09:00:00'),
(16, 2, '2019-09-29 12:00:00'),
(17, 5, '2019-09-29 16:00:00'),
(18, 4, '2019-09-29 18:00:00'),
(19, 3, '2019-09-29 15:00:00'),
(21, 5, '2019-11-20 22:31:36'),
(22, 330457, '2019-11-21 01:05:12'),
(23, 630900, '2019-11-21 01:11:19'),
(24, 638506, '2019-11-21 22:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `server_session`
--

CREATE TABLE `server_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `access_token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_session`
--

INSERT INTO `server_session` (`id`, `user_id`, `access_token`) VALUES
(5, 2, '3KyRxWMOBuLpn_W4rWCqiBm_TDb9156gUuhixmQ_o90'),
(7, 2, '6HDPiRpZd35Z6W0wDuaT0EONBOk6HeQG7QkppkjP3vc'),
(13, 10, '2_kTshjcXQMN7KqG6BmxDTCcc4LQn6PxONXbXvnoUMU'),
(17, 10, '1-PRuP30Efo64obZXVqAUby0ArUn3ZNV2lOMOgPiX3Q'),
(27, 10, '6Lh7Ypy9q5ge3iF0ltFSjCh62O3nX7XGS2gNhYTItuw'),
(48, 10, '8RiK8cHV43f1TsBYu3xeYUi95JxLFEWUr9jafauSpRM'),
(51, 10, '9S48O-Cps8iKCwK6xBNFhew0O1RTA0BRTKeEsWeyDKo'),
(53, 10, '06ICNSmG1sZ7Y4HyRH5ss4soq42FTfjF0rZO4rI9SQE'),
(66, 10, '9OmKQmA5Bg2UD9waua6QFuQIOHJrKdbPb9tukJVYSvY'),
(81, 10, 'UhyF2KxrdlGagh5TF3qO-Pmpnd5iCphpsR8sATPdHQ0'),
(82, 10, 'bYWt00ymJjvNNaLd5j2T0BhUJiM_rZZENaiYDu4c9dE'),
(83, 10, 'xlwHO4RsEu_i4oalieycPz20vuiirEeAHsCGwAG5as8'),
(84, 10, 's0K0iZEgF1vcpyn7qXz4iCPmeWO8y1YZb6cdBgfBI0c'),
(85, 10, 'Wn_ylQWjIbYnyGdbfD9W9rz_FSgHeWWl8s0sd_jNb30');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `username`, `email`, `phone_number`, `password`, `profile_picture`) VALUES
(1, 'John.Space', 'john@gmail.com', '+628135467892', 'johnjohnjohn', '../pictures/profiles/john.jpg'),
(2, 'Andy.Burow', 'andy@gmail.com', '+628954617764', 'andyandyandy', '../pictures/profiles/andy.jpg'),
(9, 'lukas', 'lukas@g.com', '00000000000', '123', '../pictures/profiles/lukas.png'),
(10, 'lukas_kurnia', 'lukas@gmail.com', '08123456789', '12345', '../pictures/profiles/lukas_kurnia.png'),
(11, 'user', 'user@gmail.com', '0123456789', 'user', '../pictures/profiles/user.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_id` (`orders_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`) USING BTREE;

--
-- Indexes for table `server_session`
--
ALTER TABLE `server_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=701;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `server_session`
--
ALTER TABLE `server_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_profile` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `server_session`
--
ALTER TABLE `server_session`
  ADD CONSTRAINT `server_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_profile` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
