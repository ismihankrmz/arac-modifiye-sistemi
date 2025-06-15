<?php
// Veritabanı bağlantısı
$host = "localhost";
$username = "root";
$password = "";
$database = "arac_modifiye";

// mysqli bağlantısı
$conn = new mysqli($host, $username, $password, $database);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}
?>