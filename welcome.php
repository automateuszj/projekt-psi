<?php

include 'session.php';

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

//pobieranie postow
include 'downloading_posts.php';

$stmt->close();
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
            <?php while ($row = $result->fetch_assoc()):?>
            <?php
                if (!empty($row['images'])) {
                    $parts = explode(',', $row['images']);
                } else {
                    $parts = [];
                }
            ?>


                <div class="post">
                    <a href="account.php?content_creator_id=<?= $row['content_creator_id'] ?>" class="creatorAcc">
                        <strong><?= htmlspecialchars($row['username']) ?></strong>
                    </a>
                    <small><?= $row['created_at'] ?></small>
                    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>

                    <div>
                        <?php foreach ($parts as $image): ?>
                            <img width="300" src="<?= "uploads/" . htmlspecialchars($image) ?>" alt="zdjęcie posta">
                        <?php endforeach; ?>
                    </div>

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