<?php
if (!isset($_SERVER['HTTP_ORIGIN'])) {
    header('HTTP/1.1 403 Forbidden');
    echo ('Metodo di accesso alle API non autorizzato');
    die();
}
$http_origin = $_SERVER['HTTP_ORIGIN'];

switch ($http_origin) {
    case 'http://localhost':
        header("Access-Control-Allow-Origin: $http_origin");
        break;
    default:
        log_message("$http_origin (Origine non riconosciuta) ha eseguito una richiesta al server", "DANGER");
}