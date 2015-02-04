SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(128) NOT NULL,
  `good_name` varchar(256) NOT NULL,
  `good_description` longtext NOT NULL,
  `good_price` decimal(12,2) NOT NULL,
  `good_traffic` bigint(20) NOT NULL,
  `good_enable` tinyint(1) NOT NULL,
  `good_order` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `goods` VALUES(1, '1G Plan', 'SS 流量 1GB', 1.00, 1073741824, 1, 0);
INSERT INTO `goods` VALUES(2, '2G Plan', 'SS 流量 2GB', 2.00, 2147483648, 1, 0);
INSERT INTO `goods` VALUES(3, '3G Plan', 'SS 流量 3GB', 3.00, 3221225472, 1, 0);
INSERT INTO `goods` VALUES(4, '4G Plan', 'SS 流量 4GB', 4.00, 4294967296, 1, 0);
INSERT INTO `goods` VALUES(5, '5G Plan', 'SS 流量 5GB', 5.00, 5368709120, 1, 0);
INSERT INTO `goods` VALUES(6, '6G Plan', 'SS 流量 6GB', 1.00, 1073741824, 0, 0);
INSERT INTO `goods` VALUES(7, '7G Plan', 'SS 流量 7GB', 1.00, 1073741824, 0, 0);
INSERT INTO `goods` VALUES(8, '8G Plan', 'SS 流量 8GB', 1.00, 1073741824, 0, 0);

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

ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `moess_sessions`
  ADD PRIMARY KEY (`id`), ADD KEY `ci_sessions_timestamp` (`timestamp`);

ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transaction_form`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `goods`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;

ALTER TABLE `transactions`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;

ALTER TABLE `transaction_form`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
