<?php
//! Deprecato

$db = new DatabaseService();

$email = $_GET['Email'];
$password = $_GET['Password'];
$nome = $_GET['Nome'];
$cognome = $_GET['Cognome'];

$query = "INSERT INTO Account (IDAccount, Email, Password, Nome, Cognome) 
        VALUES ('', '$email', '$password', '$nome', '$cognome')";

$result = $db->exQuery($query);

header('HTTP/1.1 200 OK');
echo json_encode(
        array(
                'idAccount' => $db->getLastID()
        )
);