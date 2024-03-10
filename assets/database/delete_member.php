<?php
function delete_member()
{
    include(__DIR__ . "/conn.php");
    $member_id = $_GET["member_id"];
    $sql = "DELETE FROM members WHERE member_id = '{$member_id}'";

    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

function delete_related_payments()
{
    include(__DIR__ . "/conn.php");
    $member_id = $_GET["member_id"];
    $sql = "DELETE FROM payments WHERE member_id = '{$member_id}'";

    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

delete_member();
delete_related_payments();
header("Location: ../pages/management.php?page=dashboard");
exit();
