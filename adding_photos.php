<?php
if (!empty($_FILES['files']['tmp_name'][0])) {

    $stmt = $conn->prepare("
    INSERT INTO  post_images (post_id, path)
    VALUES(?, ?)
    ");

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {

        $name = "img_" . $creatorId . "_" . $postId . "_" . $key . ".jpg";
        move_uploaded_file($tmp_name, "uploads/" . $name);

        $stmt->bind_param('is', $postId, $name);
        $stmt->execute();
    }
}

?>