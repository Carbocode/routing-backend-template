<?php
/**
 * Scrive un messaggio di log nel file di log.
 *
 * @param string $message Il messaggio da scrivere nel log.
 * @param string $level Gravità del log: 'ERROR' | 'WARNING' | 'INFO' | 'DEBUG'
 */
function log_message($message, $level = 'INFO')
{
    $timeStamp = date('Y-m-d H:i:s');
    $logEntry = "[$timeStamp]-[$level]: $message" . PHP_EOL;

    // Scrive il messaggio nel file di log
    file_put_contents(LOG_FILE, $logEntry, FILE_APPEND);
}