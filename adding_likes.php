<?php
header('Content-Type: application/json');

include 'session.php';

$userId = $_SESSION['user_id'];
$post_id = $_GET['post_id'] ?? null;

if (!$post_id) {
    echo json_encode([
        "status" => "error",
        "message" => "Brak ID posta"
    ]);
    exit;
}

$stmt = $conn->prepare("
    DELETE FROM likes 
    WHERE user_id = ? AND post_id = ?
");

$stmt->bind_param('ii', $userId, $post_id);
$stmt->execute();

//dodanie like, jezeli post byl polikowany to affected rows bedzie 1 a jazeli nie byl to bedzie 0
if ($stmt->affected_rows === 0) {
    $insert = $conn->prepare("
        INSERT INTO likes (user_id, post_id)
        VALUES (?, ?)
    ");
    $insert->bind_param('ii', $userId, $post_id);
    $insert->execute();
    $insert->close();
    //przygotowanie odpowiedzi, ze like zostal dodany
    $response = [
    $action = "liked"
    ];
}
//usuniecie like
else
{
    //przygotowanie odpowiedzi ze like zostal usuniety
    $response = [
    $action = "unliked"
    ];
}

$sql = "
SELECT 
    COUNT(like_id) AS likes
FROM likes 
WHERE post_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$response = [
"status" => "success",
"action" => $action,
"post_id" => $post_id,
"likes_number" => $row['likes']
];

echo json_encode($response);
$stmt->close();
?>