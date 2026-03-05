<?php

include 'session.php';

$filterUserId = $_GET['content_creator_id'] ?? 0;
include 'downloading_posts.php';

$stmt2 = $conn->prepare("SELECT u.username FROM users u JOIN content_creators cc ON cc.user_id = u.user_id WHERE cc.id = ?");
$stmt2->bind_param('i', $filterUserId);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona Twórcy</title>
    <link rel="icon" type="image/x-icon" href="logo.ico">
    <link rel="stylesheet" href="welcome_style.css"> </head>
</head>
<body>

    <a href="welcome.php" class="back-link">powrót na stronę główną</a>

    <div class="container">
        <h2>Wpisy twórcy <?= htmlspecialchars($row2['username'] ?? 'nieznany') ?></h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
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