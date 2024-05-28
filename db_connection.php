<?php 

$db_servername = 'localhost';
$db_username = 'root';
$db_password = '';
$db_database_name = 'db_pemweb';

$conn = new mysqli($db_servername, $db_username, $db_password, $db_database_name);

if(!$conn) {
    die('Konensi ke Database Gagal: ' . mysqli_connect_error());
}
 ?>
