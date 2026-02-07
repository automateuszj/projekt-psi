<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "
INSERT INTO content_creators (user_id, active)
SELECT user_id, 1
FROM users
WHERE user_id = ?
ON DUPLICATE KEY UPDATE active = 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();

$stmt->close();
$conn->close();

header('Location: welcome.php?creator_registered=1');
exit;