<?php
ob_start();
session_start();
if (isset($_SESSION["email"])) {
    // Redirect to login page
    header("Location: /uap_management/assets/pages/management.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulacan Chapter</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <!-- <header>
        <h2 class="logo">Defamino</h2>
        <nav class="navigation">
            <form action="#" method="post">
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Services</a>
                <a href="#">Contact</a>
            </form>
        </nav>
    </header> -->

    <div class="wrapper">
        <!-- <span class="icon-close">
            <ion-icon name="close"></ion-icon>
        </span> -->
        <div class="form-box login">
            <h2>Login</h2>
            <form action="./index.php" method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="text" name="email" autocomplete="off" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" autocomplete="off" id="password" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" id="checkbox">Show Password</label>
                    <a href="#">Forgot Password?</a>
                </div>
                <input type="hidden" name="action" value="login">
                <button type="submit" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account?<a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registration</h2>
            <form action="./index.php" method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="name" autocomplete="off" required>
                    <label>Name</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="text" name="email" autocomplete="off" required>
                    <label>Email</label>
                </div>

                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" autocomplete="off" required>
                    <label>Password</label>
                </div>
                <!-- <div class="remember-forgot">
                    <label><input type="checkbox">I agree to the terms & conditions</label>
                </div> -->
                <input type="hidden" name="action" value="register">
                <button type="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account?<a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>
    <script>
        let password = document.getElementById("password");
        let checkbox = document.getElementById("checkbox");

        checkbox.onclick = function() {
            if (checkbox.checked) {
                password.type = 'text';
            } else {
                password.type = 'password';
            }
        }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="./assets/js/login-register.js"></script>
</body>

</html>

<?php

function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'login') {
        include(__DIR__ . "/assets/database/authenticate.php");
        if (authenticate($email, $password)) {
            include(__DIR__ . "/assets/database/fetch.php");
            if (validate_user_type($email)) {
                $_SESSION["account_type"] = "admin";
            } else {
                $_SESSION["account_type"] = "member";
            }

            $_SESSION["email"] = $email;
            header("Location: /uap_management/assets/pages/management.php?page=dashboard");
            exit();
        } else {
            header("Location: /uap_management/index.php?wrong_email_or_password");
            exit();
        }
    } elseif ($action === 'register') {
        include(__DIR__ . "/assets/database/register.php");

        $name = sanitizeInput($_POST["name"]);

        if (register($name, $email, $hashedPassword)) {
            include(__DIR__ . "/assets/database/fetch.php");
            if (validate_user_type($email)) {
                $_SESSION["account_type"] = "admin";
            } else {
                $_SESSION["account_type"] = "member";
            }
            $_SESSION["email"] = $email;
            header("Location: /uap_management/assets/pages/management.php?page=dashboard");
            exit();
        }
    }
}


?>