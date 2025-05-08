<!-- 
Notes :
    1. Belum pakai PDO + masih pakai mysqli
-->


<?php
    session_start();
    include("./database.php");

    //Sign Up Logic
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["sign_up"])) {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_SPECIAL_CHARS);
        $hashed_password = password_hash($password, PASSWORD_ARGON2ID);

        $reset_A_I_sql = "ALTER TABLE users AUTO_INCREMENT = 0;";
        $post_data_sql = "INSERT INTO users (user, password) VALUES ('$username', '$hashed_password')";

        try {
            $conn->query($reset_A_I_sql);
            $conn->query($post_data_sql);
            $_SESSION['message'] = "Success SignUp!";
            
        } catch (mysqli_sql_exception) {
            $_SESSION['message'] = "User is already created!";
        }

        $conn->close();
        header("Location: ./signIn_page.php");
        exit();
    }
?>













<!-- 
Link :
    http://localhost/PHP/loginForm/
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SignUp Fesnukk</title>
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
        <h1>Sign Up To Fesnukk</h1>
        <form id="signUp_form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return validateForm()">
            <ul>
                <li>
                    <label for="username_input">Username:</label>
                    <input id="username_input" type="text" name="username" maxlength="25">
                </li>
                <li>
                    <label for="pass_input">Password:</label>
                    <input id="pass_input" type="password" name="pass" maxlength="20">
                </li>

                <button type="submit" name="sign_up" value="signUp">Sign Up</button>

                <li class="switch_page_container">
                    <p>Already have an account?</p>
                    <a href="./signIn_page.php">Login with username</a>
                </li>
            </ul>
        </form>
    </main>

    <script src="../JS/script.js"></script>
</body>
</html>