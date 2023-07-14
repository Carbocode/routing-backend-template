<?php
// Credenziali del database
define('DB_HOST', 'localhost');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASSWORD', '');

// Parametri per il Token
define('TOKEN', 'your_secret_key');
define('HASH_ALG', 'sha256');

// Percorso di log
define('BASE_PATH', dirname(__DIR__));
define('LOG_FILE', BASE_PATH . '/logs/app.log');

// Costanti per la configurazione dell'applicazione
define('APP_NAME', 'AppName');
define('APP_VERSION', '0.0.0');