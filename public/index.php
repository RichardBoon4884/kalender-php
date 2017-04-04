<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

require ROOT . 'config/database_connection.php';
require ROOT . 'core/core.php';
require ROOT . 'core/route.php';

route();