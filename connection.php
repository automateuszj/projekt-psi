<?php
$conn = new mysqli("20.215.232.132", "devuser", "Qwerty!23456", "siteDB");
if ($conn->connect_errno) {
    die("Błąd połączenia: " . $conn->connect_error);
}
?>