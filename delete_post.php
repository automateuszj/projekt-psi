<?php
if (isset($_POST['delete_post_id']))
{

    $stmt = $conn->prepare("
    UPDATE posts
    SET hidden = 1
    WHERE id = ?
    ");
    $stmt->bind_param('i', $_POST['delete_post_id']);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header('Location: ?post_deleted=1');
    exit;
}
?>