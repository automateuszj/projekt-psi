<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>dupa</p>
</body>

<?php
$conn = new mysqli("localhost", "root", "", "daza_banych");
if ($conn->connect_errno) {
    die("Błąd połączenia: " . $conn->connect_error);
}

$sql = "SELECT nazwa FROM tworcy";

$result = $conn->query($sql);

if (!$result) {
    die("Błąd zapytania: " . $conn->error);
    }

$fields = $result->fetch_fields();

while ($row = $result->fetch_assoc()) {
    echo "<p>" . $row['nazwa'] . "</p>";
}

$conn->close();

?>
</html>