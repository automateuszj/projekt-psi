<?php
if (isset($_POST['edit_post_id']))
{

    $postId = $_POST['edit_post_id'];

    $conn->begin_transaction();
    try{

        $content = trim($_POST['edited_content'] ?? '');

        if ($content === '') 
            die('Tresc posta nie moze byc pusta');

        $stmt = $conn->prepare("
        UPDATE posts
        SET content = ?
        WHERE id = ?
        ");
        $stmt->bind_param('si', $content, $postId);
        $stmt->execute();

        if (isset($_POST['delete_photo_path'])) {
            foreach ($_POST['delete_photo_path'] as $path) {

                $stmt = $conn->prepare("
                    DELETE FROM post_images 
                    WHERE path = ? AND post_id = ?
                ");
                $stmt->bind_param("si", $path, $postId);
                $stmt->execute();

                unlink("uploads/" . $path);
            }
        }


        include 'adding_photos.php';
        $conn->commit();
    }

    catch (Exception $e) {
        $conn->rollback();
        $errorMsg = $e->getMessage();
        // $recovered_content = $content;
    }

    $stmt->close();
    $conn->close();

    header('Location: ?post_updated=1');
    exit;
}
?>