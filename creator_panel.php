<?php
    session_start();
    require 'connection.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT id FROM content_creators WHERE user_id = ? AND active = 1 LIMIT 1");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        header('Location: welcome.php');
        exit;
    }

    $row = $res->fetch_assoc();
    $creatorId = $row['id'];
    $stmt->close();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['delete_post_id'])){
            $stmt = $conn->prepare("
            UPDATE posts
            SET hidden = 1
            WHERE id = ?
            ");
            $stmt->bind_param('i', $_POST['delete_post_id']);
            $stmt->execute();

            $stmt->close();
            $conn->close();

            header('Location: creator_panel.php?post_deleted=1');
            exit;
        }

        $content = trim($_POST['content'] ?? '');

        if ($content === '') {
            die('Tresc posta nie moze byc pusta');
        }
            $stmt = $conn->prepare("
            INSERT INTO posts (content_creator_id, content)
            VALUES (?, ?)
            ");
            $stmt->bind_param('is', $creatorId, $content);
            $stmt->execute();

            $stmt->close();
            $conn->close();

            header('Location: creator_panel.php?post_added=1');
            exit;
    }

    $stmt = $conn->prepare("
    SELECT id, content, created_at
    FROM posts
    WHERE content_creator_id = ? AND hidden = 0
    ORDER BY created_at DESC
    ");
    $stmt->bind_param('i', $creatorId);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Twórcy</title>
    <link rel="stylesheet" href="welcome_style.css"> 
</head>
<body>

    <a href="welcome.php" class="back-link">powrót na stronę główną</a>

    <div class="container">
        
        <div class="add-post-container">
            <h2>Dodaj nowy wpis</h2>
            <form method="post">
                <textarea name="content" placeholder="O czym myślisz?" required></textarea>
                <button type="submit" class="btn-add">Dodaj post</button>
            </form>
        </div>

        <h2>Twoja twórczość</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <small><?= $row['created_at'] ?></small>
                    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                    
                    <div class="post-footer">
                        <form method="post" onsubmit="return confirm('Na pewno chcesz usunąć?');">
                            <input type="hidden" name="delete_post_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn-delete">Usuń</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: white; opacity: 0.8;">Brak wpisów do wyświetlenia.</p>
        <?php endif; ?>

    </div> </body>
</html>