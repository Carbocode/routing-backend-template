<?php
$data = json_decode(file_get_contents('php://input'));

$body = $data->Body;

file_put_contents("./api/documentation/documentation.html", $body);

echo (json_encode("DOM Salvato"));