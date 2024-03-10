<?php
function register($name, $email, $password)
{

    include(__DIR__ . "/conn.php");

    $sql = "INSERT INTO members( name, email, password) VALUES ('{$name}', '{$email}', '{$password}')";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        return true;
    }
    mysqli_close($conn);
    return false;
    ob_end_flush();
}
