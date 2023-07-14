<?php
require_once './config/constants.php';
require_once './config/errors.php';
require_once './config/access.php';
require_once './config/functions.php';
require_once './config/logging.php';
require_once './config/database.php';
require_once './config/auth.php';

/**
 * Tutti i percorsi da noi accettati
 */
$routes = [
    '/' => '',
    'ent1' => [
        'create' => '/ent1/create.php',
        'read' => '/ent1/read.php',
        'update' => '/ent1/update.php',
        'delete' => '/ent1/delete.php'
    ],
    'users' => [
        'login' => '/users/login.php',
        'register' => '/users/register.php'
    ],
    'imgs' => [
        'type1' => 'img',
        'type2' => 'img'
    ],
    'files' => [
        'referti' => 'file'
    ],
    'documentation' => [
        'read' => '/documentation/documentation.html',
        'style.css' => '/documentation/style.css',
        'script.js' => '/documentation/script.js',
        'update' => '/documentation/update.php',
    ]
];

$request = strtok($_SERVER['REQUEST_URI'], '?') ?? '/'; // Ottieni il percorso richiesto

/*
 * N.B.:   
 * Anche se la query string viene rimossa dall'URI e non gestita in alcun modo, 
 * PHP in automatico inserisce le variabili all'interno di $_GET.
 * quindi non ci serve gestirle!
 */

$path = explode('/', trim($request, '/')); // Divido il percorso

$file = __DIR__ . '/api'; // Percorso dal quale prendere le api

// Cicla tra le sezioni della richiesta
foreach ($path as $segment) {

    if (isset($routes[$segment])) { //Verifica che esista la sezione
        $route = $routes[$segment];

        if (is_array($route)) { // se la sezione ha un array associato

            $routes = $route; // il prossimo segmento viene cercato al suo interno
            continue;
        } else if ($route == 'img') {

            header('Content-Type: ' . 'image/jpg');
            readfile($request); // invia l'immagine
            exit();
        } else if ($route == 'file') {

            header('Content-Type: ' . 'application/pdf');
            readfile($request); // invia il file
            exit();
        } else {

            $file .= $route; // se esiste la sezione e non è un array crea il percorso al file
            require $file;
            exit();
        }
    } else {
        break;
    }
}

http_response_code(404); // se non esiste dà errore
echo 'Risorsa non esistente';