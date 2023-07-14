<?php
/**
 * Restituisce l'output delle Eccezioni non gestite
 * @param Throwable $e Eccezione richiamata
 */
function log_exception(Throwable $e)
{
    $message = 'Type: ' . get_class($e) . "; Message: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()};";

    log_message($message, 'ERROR');

    header('HTTP/1.1 500 Internal Server Error');
    echo $message;

    exit();
}

/**
 * Trasforma un errore in una eccezione da passare alla funzione di logging
 * @param  $num gravità dell'errore
 * @param  $str messaggio d'errore
 * @param  $file File di origine dell'errore
 * @param  $line Linea d'errore
 */
function log_error($num, $str, $file, $line)
{
    log_exception(new ErrorException($str, 0, $num, $file, $line));
}

/**
 * Trasforma un errore FATALE in una eccezione da passare alla funzione di logging
 */
function check_for_fatal()
{

    $error = error_get_last();
    if ($error != null)
        if ($error['type'] == E_ERROR)
            log_exception(new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']));
}

//Imposto le mie funzioni per mostrare gli errori
set_exception_handler('log_exception');
set_error_handler('log_error');
register_shutdown_function('check_for_fatal');

ini_set('display_errors', 'off');
error_reporting(E_ALL);