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
    header('Location: creator_register.php?error=1'); 
    exit;
}
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zostań Twórcą</title>
    <link rel="stylesheet" href="welcome_style.css">
</head>
<body>

    <a href="welcome.php" class="back-link">powrót na stronę główną</a>

    <div class="container">
        <div class="add-post-container">
            <h2>Zostań Twórcą</h2>
            
            <form method="post" class="creator-form">
                <div class="input-group">
                    <label for="phone">Telefon:</label>
                    <input type="number" id="phone" name="phone" required>
                </div>

                <div class="input-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <button type="submit" class="btn-add">Dodaj</button>
            </form>
        </div>
    </div>
    <?php if (isset($_GET['error'])): ?>
        <script>
            alert('Wystąpił błąd podczas rejestracji. Spróbuj ponownie.');
            window.history.replaceState({}, document.title, window.location.pathname);
        </script>
    <?php endif; ?>
</body>
</body>
</html>