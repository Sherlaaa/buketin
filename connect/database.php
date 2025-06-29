<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "buketin";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>
