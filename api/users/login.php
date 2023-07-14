<?php
//! Deprecato

$db = new DatabaseService();

$idAccount = '';

$email = $_GET['Email'];
$password = $_GET['Password'];

$query = "SELECT IDAccount FROM Account WHERE Email = '$email' AND Password = '$password' LIMIT 1";

$result = $db->exQuery($query);

if ($result->num_rows > 0) {
  // output data of each row
  while ($row = $result->fetch_assoc()) {
    $idAccount = $row['IDAccount'];
  }
}

header('HTTP/1.1 200 OK');
echo json_encode(
  array(
    'idAccount' => $idAccount
  )
);