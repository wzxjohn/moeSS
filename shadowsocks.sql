SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `activate` (
  `id` int(11) NOT NULL,
  `activate_code` varchar(128) NOT NULL,
  `uid` int(11) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `email` varchar(32) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `admin_login` (
  `id` int(32) NOT NULL,
  `admin_name` varchar(128) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `ua` varchar(128) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `invite_code` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `user` int(32) NOT NULL,
  `used` tinyint(1) DEFAULT '0',
  `owner` int(11) DEFAULT '1',
  `user_name` varchar(128) DEFAULT NULL
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

CREATE TABLE IF NOT EXISTS `moess_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
  `data` blob DEFAULT '' NOT NULL,
  PRIMARY KEY (id),
  KEY `ci_sessions_timestamp` (`timestamp`)
);

CREATE TABLE IF NOT EXISTS `options` (
  `option_id` int(20) unsigned NOT NULL,
  `option_name` varchar(64) NOT NULL,
  `option_value` longtext NOT NULL,
  `display_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `options` VALUES(1, 'invite_only', 'true', '邀请注册');
INSERT INTO `options` VALUES(2, 'default_transfer', '5368709120', '默认流量(Byte)');
INSERT INTO `options` VALUES(3, 'default_invite_number', '1', '默认邀请数量');
INSERT INTO `options` VALUES(4, 'check_min', '50', '签到下限(MB)');
INSERT INTO `options` VALUES(5, 'check_max', '100', '签到上限(MB)');
INSERT INTO `options` VALUES(6, 'version', '1.2', '程序版本');
INSERT INTO `options` VALUES(7, 'default_method', 'rc4-md5', '默认加密方式');
INSERT INTO `options` VALUES(8, 'mail_protocol', 'mail', '邮件引擎');
INSERT INTO `options` VALUES(9, 'mail_mailpath', '/usr/sbin/sendmail', 'Sendmail路径');
INSERT INTO `options` VALUES(10, 'mail_smtp_host', 'smtp.gmail.com', 'SMTP服务器');
INSERT INTO `options` VALUES(11, 'mail_smtp_user', 'admin@gmail.com', 'SMTP用户名');
INSERT INTO `options` VALUES(12, 'mail_smtp_pass', 'adminPassword', 'SMTP密码');
INSERT INTO `options` VALUES(13, 'mail_smtp_port', '587', 'SMTP端口');
INSERT INTO `options` VALUES(14, 'mail_smtp_crypto', 'tls', 'SMTP加密方法');
INSERT INTO `options` VALUES(15, 'mail_sender_address', 'admin@gmail.com', '发件邮箱');
INSERT INTO `options` VALUES(16, 'mail_sender_name', 'John Stephen', '发件人姓名');
INSERT INTO `options` VALUES(17, 'mail_sg_user', 'api_user', 'SendGrid API User');
INSERT INTO `options` VALUES(18, 'mail_sg_pass', 'api_key', 'SendGrid API Key');
INSERT INTO `options` VALUES(19, 'email_subject', '请激活您的账户', '邮件标题');
INSERT INTO `options` VALUES(20, 'email_body', '<html>\n<head></head>\n<body>\n<h1>感谢注册本站服务</h1><br>\n<p>请点击下方链接激活账户：<br>\n<a href="%{activate_link}%" target="_blank">激活账户</a><br>\n%{activate_link}%<br>\n</p>\n</body>\n</html>', '邮件正文(%{activate_link}%将被替换为链接)');
INSERT INTO `options` VALUES(21, 'reset_mail_subject', '请确认您的密码重置请求', '邮件标题');
INSERT INTO `options` VALUES(22, 'reset_mail_body', '<html>\n<head></head>\n<body>\n<p>请点击下方链确认重置：<br>\n<a href="%{reset_link}%" target="_blank">重置密码</a><br>\n%{reset_link}%\n</p>\n</body>\n</html>', '邮件正文(%{reset_link}%将被替换为链接)');
INSERT INTO `options` VALUES(23, 'resend_mail_subject', '您的密码已经重置', '邮件标题');
INSERT INTO `options` VALUES(24, 'resend_mail_body', '<html>\n<head></head>\n<body>\n<p>您的密码已经重置，这是您的账户信息：<br>\nUsername: %{username}%<br>\nPassword: %{password}%<br>\n</p>\n</body>\n</html>', '邮件正文(%{username}%和%{password}%将被替换为账号密码)');
INSERT INTO `options` VALUES(25, 'need_activate', 'false', '账户需要激活');

CREATE TABLE IF NOT EXISTS `reset` (
  `id` int(11) NOT NULL,
  `reset_code` varchar(128) CHARACTER SET latin1 NOT NULL,
  `uid` int(11) NOT NULL,
  `user_name` varchar(128) CHARACTER SET latin1 NOT NULL,
  `email` varchar(32) CHARACTER SET latin1 NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ss_admin` (
  `uid` int(11) NOT NULL,
  `admin_name` varchar(128) NOT NULL,
  `email` varchar(32) NOT NULL,
  `pass` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ss_admin` VALUES(1, 'admin', 'admin@gmail.com', '7488e331b8b64e5794da3fa4eb10ad5d');

CREATE TABLE IF NOT EXISTS `ss_node` (
  `id` int(11) NOT NULL,
  `node_name` varchar(128) NOT NULL,
  `node_type` int(3) NOT NULL,
  `node_server` varchar(128) NOT NULL,
  `node_info` varchar(128) NOT NULL,
  `node_status` varchar(128) NOT NULL,
  `node_order` int(3) NOT NULL,
  `node_method` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ss_node` VALUES(1, '默认节点', 0, '1.2.3.4', '默认节点', '可用', 0, 'rc4-md5');

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

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `email` varchar(32) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `plan` varchar(2) NOT NULL,
  `passwd` varchar(16) NOT NULL,
  `t` int(11) NOT NULL DEFAULT '0',
  `u` bigint(20) NOT NULL,
  `d` bigint(20) NOT NULL,
  `transfer_enable` bigint(20) NOT NULL,
  `port` int(11) NOT NULL,
  `switch` tinyint(4) NOT NULL DEFAULT '1',
  `enable` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `last_get_gift_time` int(11) NOT NULL DEFAULT '0',
  `last_check_in_time` int(11) NOT NULL DEFAULT '0',
  `last_rest_pass_time` int(11) NOT NULL DEFAULT '0',
  `reg_date` int(11) NOT NULL DEFAULT '0',
  `invite_num` int(8) NOT NULL,
  `money` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` VALUES(1, 'admin', 'admin@gmail.com', '7488e331b8b64e5794da3fa4eb10ad5d', 'A', '0000000', 0, 0, 0, 5368709120, 50000, 1, 1, 7, 0, 0, 0, '2015-01-01 00:00:00', 0, 0.00);

CREATE TABLE IF NOT EXISTS `user_login` (
  `id` int(32) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `ua` varchar(128) NOT NULL,
  `result` tinyint(1) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `activate`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `invite_code`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mail_log`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

ALTER TABLE `reset`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ss_admin`
  ADD PRIMARY KEY (`uid`);

ALTER TABLE `ss_node`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transaction_form`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `activate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `admin_login`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
ALTER TABLE `goods`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;
ALTER TABLE `invite_code`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
ALTER TABLE `mail_log`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
ALTER TABLE `options`
  MODIFY `option_id` int(20) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ss_admin`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ss_node`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `transactions`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;
ALTER TABLE `transaction_form`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user_login`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
