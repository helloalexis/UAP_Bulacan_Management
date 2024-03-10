<?php

function authenticate($email, $password)
{
    include(__DIR__ . "/conn.php");

    $sql = "SELECT * FROM members WHERE email = '{$email}'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            return true;
            mysqli_close($conn);
            exit();
        } else {
            mysqli_close($conn);
            return false;
        }
    }
    mysqli_close($conn);
    return false;
}
