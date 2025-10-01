<?php

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'Farmacia1';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, 3307);

if ($conn->connect_error) {
	die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}


if (!$conn->set_charset('utf8mb4')) {
	trigger_error('Não foi possível definir charset utf8mb4: ' . $conn->error, E_USER_WARNING);
}
?>

