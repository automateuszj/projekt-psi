<?php

include 'session.php';

//sprawdzanie czy jest admin
$stmt = $conn->prepare("SELECT user_id FROM admin_users WHERE user_id = ? LIMIT 1");
$stmt->bind_param('i', $userId);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    header('Location: welcome.php');
    exit;
}

//pobieranie postow
include 'downloading_posts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //usuniecie posta
    include 'delete_post.php';

    //edycja posta
    include 'edit_post.php';

}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona Główna</title>
    <link rel="icon" type="image/x-icon" href="logo.ico">
    <link rel="stylesheet" href="welcome_style.css"> </head>

<body>

    <a href="welcome.php" class="back-link">powrót na stronę główną</a>

    <nav class="navbar">
        <div class="user-info">
            Witaj, <span><?= htmlspecialchars($_SESSION['username']) ?></span> Admin
        </div>
    </nav>

    <div class="container">
        <h2>Najnowsze wpisy</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">

                    <strong><?= htmlspecialchars($row['username']) ?> ID:<?= ($row['content_creator_id'])?></strong>
                    <small><?= $row['created_at'] ?></small>
                    <p class="post-content"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                    <label class="likesNumber" data-id="<?= $row['id'] ?>"><?= htmlspecialchars($row['likes']) ?></label>
                    <button type="submit" data-id="<?= $row['id'] ?>" class="likeBtn">❤️</button>
                    
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
            <div class="post" style="text-align: center;">
                <p>Cisza tutaj... Brak postów.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- javascript -->
    <script src="script.js"></script>
</body>

</html>