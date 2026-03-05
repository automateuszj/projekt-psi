<?php
    include 'session.php';

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //usuniecie posta
        include 'delete_post.php';

        //edycja posta
        include 'edit_post.php';

        //dodanie nowego posta
        $content = trim($_POST['content'] ?? '');
        if ($content === '') {
            die('Tresc posta nie moze byc pusta');
        }
        else{
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
    }

    $filterUserId = $creatorId;
    include 'downloading_posts.php';

    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo.ico">
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
                <div class="post" data-id="<?= $row['id'] ?>">
                    <small><?= $row['created_at'] ?></small>

                    <p class="post-content"><?= nl2br(htmlspecialchars($row['content'])) ?></p>

                    <form method="post" class="edit-form" style="display:none;">
                        <input type="hidden" name="edit_post_id" value="<?= $row['id'] ?>">
                        <textarea name="edited_content" required><?= htmlspecialchars($row['content']) ?></textarea>
                        <button type="submit">Zapisz</button>
                        <button type="button" class="btn-cancel">Anuluj</button>
                    </form>

                    <div class="post-footer">
                        <form method="post" onsubmit="return confirm('Na pewno chcesz usunąć?');">
                            <input type="hidden" name="delete_post_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn-delete">Usuń</button>
                        </form>
                        <button type="button" class="btn-edit">Edytuj</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: white; opacity: 0.8;">Brak wpisów do wyświetlenia.</p>
        <?php endif; ?>
    </div>

    <script src="script.js"></script>
</body>

</html>