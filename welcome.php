<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$isCreator = false;

$sql = "
SELECT active
FROM content_creators
WHERE user_id = ?
LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $isCreator = ($row['active'] == 1);
}

$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Witaj <?= htmlspecialchars($_SESSION['username']) ?></h1>
    <form action="logout.php" method="post">
        <button type="submit">Wyloguj się</button>
    </form>

    <?php if (!$isCreator): ?>
        <form action="creator_register.php" method="post">
            <button type="submit">Zarejestruj się jako twórca</button>
        </form>
    <?php else: ?>
        <form action="creator_unregister.php" method="post">
            <button type="submit">Przestań być twórcą</button>
        </form>
    <?php endif; ?>
</body>
</html>