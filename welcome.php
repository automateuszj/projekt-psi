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
    <!-- tekst witajacy -->
    <h1>Witaj <?= htmlspecialchars($_SESSION['username']) ?></h1>

    <!-- wylogowywaniw sie -->
    <a href="logout.php">Wyloguj się</a>

    <!-- rejestracja --- sie jako content creator, chce zrobić by po klikneciu otwierala sie nowa strona na ktorej muszisz podac jakies pierdoly typu numer telefonu itd. zeby odwzorowac jakas weryfikacje -->
    <?php if (!$isCreator): ?>
        <a href="creator_register.php">Zarejestruj się jako twórca</a>
    <?php else: ?>
        <a href="creator_unregister.php">Przestań być twórcą</a>
    <?php endif; ?>

    <!-- dodawanie postu --- to wyswietli sie tylko jak jestes content_crator, przekieruje cie na inna strone do dodawnia postu -->
    <?php if ($isCreator): ?>
        <a href="add_post.php">Dodaj post</a>
    <?php endif; ?>

</body>

</html>