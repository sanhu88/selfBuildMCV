<?php

// 数据库配置
$config['db']['host'] = 'localhost';
$config['db']['username'] = 'root';
$config['db']['password'] = '123456';
$config['db']['dbname'] = 'project';


// 默认控制器和操作名
$config['defaultController'] ='Item';
$config['defaultAction'] = 'index';


return $config;

//入口中的$config变量接收到配置参数后，再传给框架的核心类，也就是Fastphp类