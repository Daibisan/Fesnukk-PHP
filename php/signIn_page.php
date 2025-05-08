<!-- Validasi Input Kosong by JS -->
<?php 
    session_start();
    include("./database.php");

    //Timeout Message Logic
    if (isset($_GET['timeout']) && $_GET['timeout'] === 'true') {
        $_SESSION["message"] = "Waktu login habis!";
    }

    //Login Logic
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_SPECIAL_CHARS);

        try {
            $sql = "SELECT * FROM users WHERE user = '$username'";
            
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            // Cek keberadaan Username
            if (!empty($row)) {
                $fetched_pass = $row["password"];
    
                // Cek kesamaan Password
                if (password_verify($password, $fetched_pass)) {
                    session_regenerate_id(true); // reset session id

                    $_SESSION["username"] = $username;
                    $_SESSION["is_login"] = true;
                    $_SESSION["LAST_ACTIVITY"] = time(); // set waktu awal

                    header("Location: ./home_page.php");
                    exit();
                }
                else {
                    $_SESSION['message'] = "Username atau Password Salah!";
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }
            else {
                $_SESSION['message'] = "Username atau Password Salah!";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();            }

        }
        // Mengatasi kesalahan koneksi database
        catch (mysqli_sql_exception $e) {
            $_SESSION['message'] = "Terjadi kesalahan pada server!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        $conn->close();

    }
?>













<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fesnukk</title>
    <link rel="stylesheet" href="../style/reset.css">
    <link rel="stylesheet" href="../style/account_page.css">
</head>

<body>
    <!-- Message Pop Up -->
    <?php
        if (!empty($_SESSION['message'])) {
            echo "<script>alert('" . $_SESSION['message'] . "');</script>";
            unset($_SESSION['message']);
    }
    ?>

    <main>
        <h1>Login To Fesnukk</h1>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" onsubmit="return validateForm()">
            <ul>
                <li>
                    <label for="username_input">Username:</label>
                    <input id="username_input" type="text" name="username" maxlength="25">
                </li>
                <li>
                    <label for="pass_input">Password:</label>
                    <input id="pass_input" type="password" name="pass" maxlength="20">
                </li>

                <button type="submit" name="login" value="login">Login</button>

                <li class="switch_page_container">
                    <p>New to Fesnukk?</p>
                    <a href="./signUp_page.php">Create an account</a>
                </li>
            </ul>
        </form>
    </main>
</body>
<script src="../JS/script.js"></script>

</html>