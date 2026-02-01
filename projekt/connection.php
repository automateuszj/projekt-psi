<?php
$conn = new mysqli("localhost", "root", "", "siteDB");
if ($conn->connect_errno) {
    die("Błąd połączenia: " . $conn->connect_error);
}
echo "Połączenie działa!"; // test
?>