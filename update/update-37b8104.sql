SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `moess_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(128) NOT NULL,
  `trade_no` varchar(128) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `amount` int(8) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `ctime` int(11) NOT NULL,
  `ftime` int(11) NOT NULL,
  `notify_id` longtext NOT NULL,
  `buyer_email` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `transaction_form` (
  `id` int(128) NOT NULL,
  `trade_no` varchar(128) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `body` longtext NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `moess_sessions`
  ADD PRIMARY KEY (`id`), ADD KEY `ci_sessions_timestamp` (`timestamp`);

ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transaction_form`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transactions`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;

ALTER TABLE `transaction_form`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
