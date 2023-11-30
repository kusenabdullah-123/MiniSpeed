<?php

use MiniSpeed\Database\Manager;

$config = [
    'host' => 'mariadb.database',
    'database' => 'mini',
    'username' => 'root',
    'password' => 'root',
];
Manager::add($config,'main');