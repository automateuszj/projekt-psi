<?php

session_start();
require 'connection.php';
$komunikat = '';

if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //sprawdzanie czy hasla sa jednakowe
    $password = trim($_POST['password'] ?? '');
    $password_check = trim($_POST['password_check'] ?? '');

    if ($first_name === '' || $last_name === '' || $username === '' || $password === '')
        $error = 'Wszystkie pola są wymagane';
    elseif ($password !== $password_check)
        $error = 'Hasła nie są jednakowe';

    //sprawdzanie czy reszta danych jest poprawnie wpisana
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');

    if (!isset($error)) {
        //hashowanie hasla
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // rozpoczecie transkacji, jak cos bedzie nie tak to wszystko sie zresetuje
        $conn->begin_transaction();
        try {

            $sql = "
            INSERT INTO users (first_name, last_name, username, Upassword)
            VALUES(?, ?, ?, ?)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $first_name, $last_name, $username, $hash);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            header('Location: login.php');
            exit;
        }
        catch (Exception $e) {
            $conn->rollback();
            die('Błąd przy tworzeniu użytkownika');
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Zaloguj sie</h1>
    <form method="POST">
        <label>imie</label><br>
        <input type="text"name="first_name" required><br>

        <label>nazwisko</label><br>
        <input type="text" name="last_name" required><br>

        <label>nazwa użytkownika</label><br>
        <input type="text" name="username" required><br>

        <label>hasło</label><br>
        <input type="password" name="password" required><br>

        <label>hasło</label><br>
        <input type="password" name="password_check" required><br>

        <button type="submit">Dodaj</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</body>
</html>