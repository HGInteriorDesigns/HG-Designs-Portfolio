<?php
// db_init.php
define('APPPATH', __DIR__ . '/app/');
define('WRITEPATH', __DIR__ . '/writable/');

require_once APPPATH . 'Database/DatabaseSetup.php';
\App\Database\DatabaseSetup::run();
