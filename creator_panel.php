<?php

    session_start();
    require 'connection.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    // sprawdzanie czy uzytkownik jest AKTYWNYM creatorem

    $userId = $_SESSION['user_id'];

    //przygotowuje id z tabeli content_creators czyli w tabeli posts content_creator_id
    $stmt = $conn->prepare("SELECT id FROM content_creators WHERE user_id = ? AND active = 1 LIMIT 1");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        header('Location: welcome.php');
        exit;
    }

    //pobieram wartosc id z tabeli content_creators
    $row = $res->fetch_assoc();
    $creatorId = $row['id'];
    $stmt->close();

    // pobieranie warosci z formsa i insert do bazy
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $content = trim($_POST['content'] ?? '');

        if ($content === '') {
            die('Tresc posta nie moze byc pusta');
        }

         $sql = "
            INSERT INTO posts (content_creator_id, content)
            VALUES (?, ?)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('is', $creatorId, $content);
            $stmt->execute();

            $stmt->close();
            $conn->close();

            header('Location: creator_panel.php?post_added=1');
            exit;
    }

    //wyswietlanie postow
    $stmt = $conn->prepare("
    SELECT id, content, created_at
    FROM posts
    WHERE content_creator_id = ?
    ORDER BY created_at DESC
    ");
    $stmt->bind_param('i', $creatorId);
    $stmt->execute();
    $result = $stmt->get_result();


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

    <a href="welcome.php">powrót na strone główną</a>

    <h1>DODAJ POST:</h1>

    <form method="post">
        <textarea name="content" required></textarea>
        <button type="submit">Dodaj</button>
    </form>

    <!-- to samo co w welcome.php tylko tu nie ma username bo to sa posty tylko jednego uzytkownika -->

    <h1>TWOJE POSTY:</h1>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post">
                <strong><?= htmlspecialchars($row['username']) ?></strong>
                <small><?= $row['created_at'] ?></small>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Brak postów.</p>
    <?php endif; ?>

</body>
</html>