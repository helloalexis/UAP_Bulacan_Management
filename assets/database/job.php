<?php



function fetch_members()
{
    include(__DIR__ . "/conn.php");

    $sql = "SELECT * FROM members";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            fetch_member_data($row['name']);
        }
    }

    mysqli_close($conn);
}

function fetch_member_data($member_name)
{

    include(__DIR__ . "/conn.php");


    $sql = "SELECT DISTINCT *, members.name, years.year_value, payments.status 
    FROM members 
    LEFT JOIN payments ON members.member_id = payments.member_id
    LEFT JOIN years ON payments.year_id = years.year_id 
    WHERE members.name = '{$member_name}'
    ORDER BY years.year_value";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            if ($row["status"] == "") {
                echo $row["name"] . " has missing payment for year " . $row["year_value"] . "<br>";
                notify_member();
            }
        }
    }


    mysqli_close($conn);
}

function notify_member()
{
}

function add_year()
{
    include(__DIR__ . "/conn.php");

    $year_value = 2024;

    $sql = "INSERT INTO years(year_value) VALUES ('{$year_value}')";

    mysqli_query($conn, $sql);

    mysqli_close($conn);
}

add_year();
