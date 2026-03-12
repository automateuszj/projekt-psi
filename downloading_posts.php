<?php
if (isset($filterUserId)) {
    $sql = "
    SELECT 
        p.id,
        p.content,
        p.created_at,
        u.username,
        p.content_creator_id,
        pi.path,
        COUNT(l.like_id) AS likes
    FROM posts p
    JOIN content_creators cc ON p.content_creator_id = cc.id
    JOIN users u ON cc.user_id = u.user_id
    LEFT JOIN post_images pi ON pi.post_id = p.id
    LEFT JOIN likes l ON p.id = l.post_id
    WHERE p.hidden = 0 AND cc.id = ?
    GROUP BY p.id, p.content, p.created_at, u.username
    ORDER BY p.created_at DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $filterUserId);
}
else {
    $sql = "
    SELECT 
        p.id,
        p.content,
        p.created_at,
        u.username,
        p.content_creator_id,
        pi.path,
        COUNT(l.like_id) AS likes
    FROM posts p
    JOIN content_creators cc ON p.content_creator_id = cc.id
    JOIN users u ON cc.user_id = u.user_id
    LEFT JOIN post_images pi ON pi.post_id = p.id
    LEFT JOIN likes l ON p.id = l.post_id
    WHERE p.hidden = 0
    GROUP BY p.id, p.content, p.created_at, u.username
    ORDER BY p.created_at DESC
    ";

    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>