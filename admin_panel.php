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

$stmt = $conn->prepare("SELECT user_id FROM admin_users WHERE user_id = ? LIMIT 1");
$stmt->bind_param('i', $userId);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    header('Location: welcome.php');
    exit;
}

$sql = "
SELECT 
    p.id,
    p.content,
    p.created_at,
    u.username,
    p.content_creator_id,
    COUNT(l.like_id) AS likes
FROM posts p
JOIN content_creators cc ON p.content_creator_id = cc.id
JOIN users u ON cc.user_id = u.user_id
LEFT JOIN likes l ON p.id = l.post_id
WHERE p.hidden = 0
GROUP BY p.id, p.content, p.created_at, u.username
ORDER BY p.created_at DESC
";

$result = $conn->query($sql);


//pobieranie postow

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //usuniecie posta
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

        header('Location: admin_panel.php?post_deleted=1');
        exit;
    }

    //edycja posta
    if (isset($_POST['edit_post_id']))
    {
        $content = trim($_POST['edited_content'] ?? '');

        if ($content === '') 
            die('Tresc posta nie moze byc pusta');

        $stmt = $conn->prepare("
        UPDATE posts
        SET content = ?
        WHERE id = ?
        ");
        $stmt->bind_param('si', $content, $_POST['edit_post_id']);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        header('Location: admin_panel.php?post_updated=1');
        exit;
    }

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
        
        <!-- <div class="nav-links">
            <?php if (!$isCreator): ?>
                <a href="creator_register.php" class="btn-creator">Zostań twórcą</a>
            <?php else: ?>
                <a href="creator_panel.php" style="color: #38bdf8; font-weight: bold;">Twoja twórczość</a>
                <a href="creator_unregister.php">Zrezygnuj</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-logout">Wyloguj się</a>
            <a href="terms_of_usage.html">warunki użytkowania</a>
        </div> -->
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