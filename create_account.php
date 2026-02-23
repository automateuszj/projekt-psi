<?php
session_start();
require 'connection.php';
$error = ''; 

if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_check = trim($_POST['password_check'] ?? '');

    if ($first_name === '' || $last_name === '' || $username === '' || $password === '') {
        $error = 'Wszystkie pola są wymagane';
    } elseif ($password !== $password_check) {
        $error = 'Hasła nie są jednakowe';
    }

    if ($error === '') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn->begin_transaction();
        try {
            $sql = "INSERT INTO users (first_name, last_name, username, Upassword) VALUES(?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $first_name, $last_name, $username, $hash);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            header('Location: login.php?registered=1'); 
            exit;
        }
        catch (Exception $e) {
            $conn->rollback();
            $error = 'Błąd przy tworzeniu użytkownika';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utwórz konto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h1>Załóż konto</h1>

        <?php if ($error !== ''): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Imię</label>
            <input type="text" name="first_name" placeholder="np. Jan" required>

            <label>Nazwisko</label>
            <input type="text" name="last_name" placeholder="np. Kowalski" required>

            <label>Nazwa użytkownika</label>
            <input type="text" name="username" placeholder="Twój unikalny login" required>

            <label>Hasło</label>
            <input type="password" name="password" placeholder="Minimum 6 znaków" required>

            <label>Powtórz hasło</label>
            <input type="password" name="password_check" placeholder="Wpisz hasło ponownie" required>

            <button type="submit">Zarejestruj się</button>
        </form>

        <div class="register-link-container">
            <p>Masz już konto?</p>
            <a href="login.php" class="register-link">Zaloguj się tutaj</a>
        </div>
    </div>
</body>
</html>