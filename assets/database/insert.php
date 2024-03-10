<?php
session_start();

function get_member_id($member_email)
{
    include(__DIR__ . "/conn.php");
    $sql = "SELECT member_id FROM members WHERE email='{$member_email}';";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["member_id"];
    } else {
        return -1;
    }
}

function get_member_membership_date($member_id)
{
    include(__DIR__ . "/conn.php");

    $sql = "SELECT membership_date FROM members WHERE member_id = '{$member_id}'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            return $row["membership_date"];
        }
    }
    mysqli_close($conn);
    return "";
}

function check_member_for_payment($member_id, $year_value)
{
    include(__DIR__ . "/conn.php");

    $sql = "SELECT * FROM years LEFT JOIN payments ON payments.year_id = years.year_id LEFT JOIN members ON payments.member_id = members.member_id  WHERE members.member_id='{$member_id}' AND year_value = '{$year_value}' ORDER BY year_value;";

    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result);
}


function update_member_payment_status($member_id)
{
    include(__DIR__ . "/conn.php");

    $sql = "SELECT * FROM years ORDER BY year_value";

    $result = mysqli_query($conn, $sql);

    $year =  date('Y', strtotime(get_member_membership_date($member_id)));

    $quantity = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["year_value"] >= $year) {
                if (check_member_for_payment($member_id, $row["year_value"]) < 1) {
                    insert_member_payment_status($member_id, $row["year_id"]);
                    $quantity++;
                }
            }
        }
    }

    mysqli_close($conn);
    ob_start();
    echo "<script>window.location.href = 'http://localhost/uap_management/assets/database/generate_receipt.php?quantity={$quantity}'</script>";
    ob_end_flush();
    exit();
}

function insert_member_payment_status($member_id, $year_id)
{
    include(__DIR__ . "/conn.php");
    $sql = "INSERT INTO payments(member_id, year_id, status) VALUES ('{$member_id}', '{$year_id}', 'PAID')";

    mysqli_query($conn, $sql);

    mysqli_close($conn);
}

if (isset($_POST["update_member_payment"])) {

    update_member_payment_status(get_member_id($_SESSION["email"]));
}


function get_last_year_value()
{
    include(__DIR__ . "/conn.php");
    $sql = "SELECT MAX(year_value) AS greatest_year_value
    FROM years";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            mysqli_close($conn);
            return $row["greatest_year_value"];
        }
    }
    mysqli_close($conn);
    return -1;
}

function insert_year()
{
    include(__DIR__ . "/conn.php");
    $last_year_value = get_last_year_value();
    $year_value = $last_year_value + 1;

    $sql = "INSERT INTO years(year_value) VALUES ('{$year_value}')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

function update_membership_fee($fee)
{
    include(__DIR__ . "/conn.php");

    $sql = "UPDATE membership SET membership_fee='{$fee}' WHERE 1";

    mysqli_query($conn, $sql);
    mysqli_close($conn);
    exit();
}


if (isset($_POST['action']) && $_POST['action'] == 'insert_year') {

    insert_year();
}

if (isset($_POST['action']) && $_POST['action'] == 'update_membership_fee') {
    $membershipfee = $_POST["membership_fee"];
    if (isset($membershipfee) && !empty($membershipfee)) {
        update_membership_fee($membershipfee);
    }
}
