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

//sesja

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

//sprawdzanie czy jest creatorem

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
$conn->close();

//pobieranie postow
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
            <a href="terms_of_usage.html">warunki użytkowania</a>
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
                    <div class="likes-wrapper">
                    <button type="button" data-id="<?= $row['id'] ?>" class="likeBtn">❤️</button>
                    <span class="likesNumber" data-id="<?= $row['id'] ?>"><?= htmlspecialchars($row['likes']) ?> </span>
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