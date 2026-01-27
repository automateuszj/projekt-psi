<?php

// AAAAAAAAAA
// zmien, zeby hasla byly hashowane i costam jeszcze


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// zaczecie sesji, uruchomienie pliku connection ktory laczy sie z baza, przygotowanie zmiennej na komunikaty
session_start();
require 'connection.php';
$komunikat = '';

// echo password_hash('qqq1234', PASSWORD_DEFAULT);
// echo password_hash('1qazXSW@', PASSWORD_DEFAULT);

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
                $_SESSION['user_login'] = $username;

                echo "<p>aaaaaaaaaa</p>";
                //header('Location: welcome.php');
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
// zakonczenie poloczenia z baza
$conn->close();

// $conn = new mysqli("localhost", "root", "", "daza_banych");
// if ($conn->connect_errno) {
//     die("Błąd połączenia: " . $conn->connect_error);
// }

// $sql = "SELECT nazwa FROM tworcy";

// $result = $conn->query($sql);

// if (!$result) {
//     die("Błąd zapytania: " . $conn->error);
//     }

// $fields = $result->fetch_fields();

// while ($row = $result->fetch_assoc()) {
//     echo "<p>" . $row['nazwa'] . "</p>";
// }

// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Strona Główna</h1>
    <p>zaloguj: (funkcj atymczasowo niedostępna)</p>
    <form action="POST"></form>
    <form method="post">
        <label>Login: <input type="text" name="login"></label><br>
        <label>Hasło: <input type="password" name="haslo"></label><br><br>
        <button type="submit">Zaloguj</button>
    </form>

</body>
</html>