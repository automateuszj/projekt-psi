<?php
include 'session.php';

$sql = "
UPDATE content_creators
SET active = 0
WHERE user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();  

$stmt->close();
$conn->close();

header('Location: welcome.php');
exit;