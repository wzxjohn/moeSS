因为本 Commit 更新了 CI 框架到官方最新的 RC 版，所以配置文件有一些改动，主要差别如下：

config.php

旧配置文件：

    $config['sess_driver']          = 'cookie';
    $config['sess_valid_drivers']   = array();
    $config['sess_cookie_name']     = 'asiass_session';
    $config['sess_expiration']      = 7200;
    $config['sess_expire_on_close'] = FALSE;
    $config['sess_encrypt_cookie']  = TRUE;
    $config['sess_use_database']    = FALSE;
    $config['sess_table_name']      = 'ci_sessions';
    $config['sess_match_ip']        = FALSE;
    $config['sess_match_useragent'] = TRUE;
    $config['sess_time_to_update']  = 300;


新配置文件：

    $config['sess_driver']          = 'database';
    $config['sess_cookie_name']     = 'asiass_session';
    $config['sess_expiration']      = 7200;
    $config['sess_save_path']       = 'moess_session';
    $config['sess_encrypt_cookie']  = TRUE;
    $config['sess_match_ip']        = FALSE;
    $config['sess_time_to_update']  = 300;

并且需要执行下面的语句初始化 session 数据库：

    CREATE TABLE IF NOT EXISTS `moess_sessions` (
            `id` varchar(40) NOT NULL,
            `ip_address` varchar(45) NOT NULL,
            `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
            `data` blob DEFAULT '' NOT NULL,
            PRIMARY KEY (id),
            KEY `ci_sessions_timestamp` (`timestamp`)
    );

database.php

旧配置文件：

    'pconnect' => TRUE,

新配置文件：

    'pconnect' => FALSE,

请在更新源代码之后修改 `application/config/config.php` 和 `application/config/database.php` ，删除旧配置，添加新配置。
