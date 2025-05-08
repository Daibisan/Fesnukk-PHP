<?php
    session_start();

    // Set timeout dalam detik (misal 10 menit = 600 detik)
    $timeout_duration = 300;

    // Login Check
    if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true) {
        header("Location: ./signIn_page.php");
        exit;
    }

    // Timeout Logic
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: ./signIn_page.php?timeout=true");
        exit;
    }

    // Logout Logic
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"]) && $_POST["logout"] === "log out") {
        session_unset();
        session_destroy();
        header("Location: ./signIn_page.php");
        exit;
    }
?>


















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <link rel="stylesheet" href="../style/reset.css">
    <link rel="stylesheet" href="../style/home_page.css">
</head>
<body>
    <main>
        <p>Hello <span class="user_name"><?= $_SESSION["username"] ?></span> 👋</p>
        <p>Welcome To Homepage!</p>

        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <input type="submit" name="logout" value="log out">
        </form>
    </main>
</body>
</html>