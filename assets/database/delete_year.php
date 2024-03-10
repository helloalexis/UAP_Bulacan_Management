<?php

function delete_year()
{
    include(__DIR__ . "/conn.php");
    $year_id = $_GET["year_id"];
    $sql = "DELETE FROM years WHERE year_id = '{$year_id}'";

    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

function delete_related_payments()
{
    include(__DIR__ . "/conn.php");
    $year_id = $_GET["year_id"];
    $sql = "DELETE FROM payments WHERE year_id = '{$year_id}'";

    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

delete_year();
delete_related_payments();
header("Location: ../pages/management.php?page=admin_settings");
exit();
