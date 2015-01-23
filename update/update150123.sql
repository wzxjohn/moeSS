SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `admin_login` (
  `id` int(32) NOT NULL,
  `admin_name` varchar(128) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `ua` varchar(128) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mail_log` (
  `id` int(32) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `email` varchar(32) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `ua` varchar(128) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `options` VALUES(25, 'need_activate', 'false', '账户需要激活');

CREATE TABLE IF NOT EXISTS `user_login` (
  `id` int(32) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `ua` varchar(128) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mail_log`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `admin_login`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mail_log`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_login`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;