<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "
INSERT INTO content_creators (user_id, username)
SELECT user_id, username
FROM users
WHERE user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);

try {
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    // duplikat = user już jest twórcą
    if ($e->getCode() === 1062) {
        header('Location: welcome.php?already_creator=1');
        exit;
    }
    throw $e;
}

$stmt->close();
$conn->close();

header('Location: welcome.php?creator_registered=1');
exit;