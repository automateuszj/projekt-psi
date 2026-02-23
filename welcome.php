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

$sql = "
SELECT 
    p.id,
    p.content,
    p.created_at,
    u.username,
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

$stmt->close();

//dodawanie like, to jakies glupie
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $stmt = $conn->prepare("
        DELETE FROM likes 
        WHERE user_id = ? AND post_id = ?
    ");

    $stmt->bind_param('ii', $userId, $_POST['post_id']);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        $insert = $conn->prepare("
            INSERT INTO likes (user_id, post_id)
            VALUES (?, ?)
        ");
        $insert->bind_param('ii', $userId, $_POST['post_id']);
        $insert->execute();
        $insert->close();
    }
    header('Location: welcome.php');

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona Główna</title>
    <link rel="stylesheet" href="welcome_style.css"> </head>

<body>
    <nav class="navbar">
        <div class="user-info">
            Witaj, <span><?= htmlspecialchars($_SESSION['username']) ?></span>
        </div>
        
        <div class="nav-links">
            <?php if (!$isCreator): ?>
                <a href="creator_register.php" class="btn-creator">Zostań twórcą</a>
            <?php else: ?>
                <a href="creator_panel.php" style="color: #38bdf8; font-weight: bold;">Twoja twórczość</a>
                <a href="creator_unregister.php">Zrezygnuj</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-logout">Wyloguj się</a>
        </div>
    </nav>

    <div class="container">
        <h2>Najnowsze wpisy</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <strong><?= htmlspecialchars($row['username']) ?></strong>
                    <small><?= $row['created_at'] ?></small>
                    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                    <form method="post">
                    <label><?= htmlspecialchars($row['likes']) ?></label>
                    <input type="hidden" name="post_id" value="<?= $row['id'] ?>">
                    <button type="submit"><3</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="post" style="text-align: center;">
                <p>Cisza tutaj... Brak postów.</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>