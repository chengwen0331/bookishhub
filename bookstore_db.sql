-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2023 at 04:11 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `book_id` int(5) NOT NULL,
  `book_title` varchar(200) NOT NULL,
  `book_author` varchar(200) NOT NULL,
  `book_isbn` varchar(15) NOT NULL,
  `book_price` float NOT NULL,
  `book_description` varchar(500) NOT NULL,
  `book_pub` varchar(100) NOT NULL,
  `book_lang` varchar(100) NOT NULL,
  `book_qty` int(5) NOT NULL,
  `book_date` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`book_id`, `book_title`, `book_author`, `book_isbn`, `book_price`, `book_description`, `book_pub`, `book_lang`, `book_qty`, `book_date`) VALUES
(1, 'Harry Potter and the Philosopher\'s Stone', 'J. K. Rowling', '9781408855898', 43.9, 'Harry Potter has never even heard of Hogwarts when the letters start dropping on the doormat at number four, Privet Drive. Addressed in green ink on yellowish parchment with a purple seal, they are swiftly confiscated by his grisly aunt and uncle. Then, on Harry\'s eleventh birthday, a great beetle-eyed giant of a man called Rubeus Hagrid bursts in with some astonishing news: Harry Potter is a wizard, and he has a place at Hogwarts School of Witchcraft and Wizardry. An incredible adventure is abo', 'Bloomsbury', 'English', 15, '0000-00-00 00:00:00.000000'),
(2, 'Atomic Habits', 'James Clear', '9780735211292', 54.6, 'The No1 New York Times bestseller. Over 10 million copies sold!\r\n\r\nTiny Changes, Remarkable Results\r\n\r\nNo matter your goals, Atomic Habits offers a proven framework for improving--every day. James Clear, one of the world\'s leading experts on habit formation, reveals practical strategies that will teach you exactly how to form good habits, break bad ones, and master the tiny behaviors that lead to remarkable results.\r\n\r\nIf you\'re having trouble changing your habits, the problem isn\'t you. The pro', 'Penguin Publishing Group', 'English', 20, '0000-00-00 00:00:00.000000'),
(3, 'The Little Prince', 'Antoine de Saint-Exupery', '9780547338002', 30, 'The Little Prince is a classic tale of equal appeal to children and adults. On one level it is the story of an airman\'s discovery, in the desert, of a small boy from another planet - the Little Prince of the title - and his stories of intergalactic travel, while on the other hand it is a thought-provoking allegory of the human condition.', 'Harcourt', 'English', 2, '0000-00-00 00:00:00.000000'),
(4, 'To Kill a Mockingbird', 'Harper Lee', '9780062368683', 35.9, 'A lawyer\'s advice to his children as he defends the real mockingbird of Harper Lee\'s classic novel - a black man charged with the rape of a white girl. Though the young eyes of Scout and Jem Finch, Harper Lee explores with exuberant humour the irrationality of adult attitudes to race and class in the Deep South of the 1930s. The conscience of a town steeped in prejudice, violence, and hypocrisy is pricked by the stamina of one man\'s struggle for justice. But the weight of history will only toler', 'HarperCollins', 'English', 4, '0000-00-00 00:00:00.000000'),
(5, 'The Intelligent Investor', 'Benjamin Graham', '9780061745171', 85.4, 'The greatest investment advisor of the twentieth century, Benjamin Graham taught and inspired people worldwide. Graham\'s philosophy of \"value investing\"-which shields investors from substantial error and teaches them to develop long-term strategies-has made The Intelligent Investor the stock market bible ever since its original publication in 1949.', 'HarperCollins', 'English', 3, '0000-00-00 00:00:00.000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `book_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
