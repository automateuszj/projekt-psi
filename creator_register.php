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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //sprawdzanie czy dane sa poprawnie wpisane
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // rozpoczecie transkacji, jak cos bedzie nie tak to wszystko sie zresetuje
    $conn->begin_transaction();
    try {

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

        $stmt = $conn->prepare("SELECT id FROM content_creators WHERE user_id = ? LIMIT 1");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $creatorId = $res->fetch_assoc()['id'];
        $stmt->close();

        $sql = "
        INSERT INTO content_creator_credentials (content_creator_id, phone, email)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE 
            phone = VALUES(phone),
            email = VALUES(email)
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $creatorId, $phone, $email);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        header('Location: welcome.php?creator_registered=1');
        exit;
    }
    catch (Exception $e) {
        $conn->rollback();
        die('Błąd rejestracji');
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="post">

        <label for="phone" >Phone:</label><br>
        <input type="number" id="phone" name="phone" required><br>
        <label for="email" >email:</label><br>
        <input type="email" id="email" name="email" required>
        <button type="submit">Dodaj</button>

    </form>

</body>
</html>