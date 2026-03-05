<?php

session_start();
require 'connection.php';
$komunikat = '';

if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $login = trim($_POST['login'] ?? '');
    $haslo = trim($_POST['haslo'] ?? '');

    // to chce zmienic - dodac mozliwosc logowania bez hasla
    if ($login === '' || $haslo === '') 
        $komunikat = "Podaj nazwę użytkownika oraz hasło";
    else 
    {
        $stmt = $conn->prepare("SELECT user_id, Upassword FROM users WHERE username = ?");
        $stmt->bind_param('s', $login);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) 
        {
            if (password_verify($haslo, $row['Upassword'])) 
            {
                //Zapisujemy dane do sesji
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $login;

                header('Location: index.php');
                exit;
            } 
            else 
            {
                $komunikat = "Niepoprawne hasło!";
            }
        }
        else
        {
            $komunikat = "Nie znaleziono takiego użytkownika!";
        }
        // zakonczenie poloczenia z sesja
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo.ico">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        
        <h1>Zaloguj się</h1>

        <?php if ($komunikat): ?>
            <div class="error"><?php echo $komunikat; ?></div>
        <?php endif; ?>

        <form method="post">
            <label>Login:</label>
            <input type="text" name="login" placeholder="Wpisz login">
            
            <label>Hasło:</label>
            <input type="password" name="haslo" placeholder="Wpisz hasło">
            
            <button type="submit">Zaloguj</button>
        </form>

        <div class="register-link-container">
            <p>Nie masz konta?</p>
            <a href="create_account.php" class="register-link">Utwórz je!</a>
        </div>

    </div>
</body>
</html>