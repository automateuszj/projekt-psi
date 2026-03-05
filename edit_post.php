<?php
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

    header('Location: ?post_updated=1');
    exit;
}
?>