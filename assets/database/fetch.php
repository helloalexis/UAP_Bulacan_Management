<?php

function fetch_year()
{
    include(__DIR__ . "/conn.php");
    $table_row = "";

    $sql = "SELECT * FROM years ORDER BY year_value";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $year_array[] = $row['year_value'];
            $year_start = $row['year_value'];
            $year_end = $row['year_value'] + 1;
            $table_row .= <<<HTML
                    <th>$year_start-$year_end</th>
                    
            HTML;
        }
    }

    mysqli_close($conn);

    return $table_row;
}

function fetch_custom_year($email)
{
    include(__DIR__ . "/conn.php");
    $sql = "SELECT * FROM members WHERE email = '{$email}'";

    $result = mysqli_query($conn, $sql);
    $membership_year = "";
    $table_row = "";


    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $membership_year = date('Y', strtotime($row["membership_date"]));
        }
    }

    $sql = "SELECT * FROM years ORDER BY year_value";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $year_start = $row['year_value'];
            if ($year_start >= $membership_year) {
                $year_end = $row['year_value'] + 1;
                $table_row .= <<<HTML
                    <th>$year_start-$year_end</th>
                    
            HTML;
            }
        }
    }

    mysqli_close($conn);
    return $table_row;
}

function fetch_admin_settings_year()
{
    include(__DIR__ . "/conn.php");
    $table_row = "";

    $sql = "SELECT * FROM years ORDER BY year_value";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $year_id = $row["year_id"];
            $year_start = $row['year_value'];
            $year_end = $row['year_value'] + 1;
            $table_row .= <<<HTML
                    <!-- <tr><td>$year_start-$year_end</td><td><a href="../database/delete_year.php?year_id={$year_id}">Delete</a></td></tr> -->
                    <tr>
                        <td>$year_start-$year_end</td>
                        <td>
                            <a href="../database/delete_year.php?year_id={$year_id}">
                                <i  class="fa fa-trash-o fa-2x" ></i>
                               
                            </a>
                        </td>
                    </tr>
            HTML;
        }
    }

    mysqli_close($conn);

    return $table_row;
}

function get_year_array()
{
    include(__DIR__ . "/conn.php");
    $year_array = array();

    $sql = "SELECT * FROM years ORDER BY year_value";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $year_array[] = $row['year_value'];
        }
    }

    mysqli_close($conn);
    return $year_array;
}

function validate_user_type($email)
{
    include(__DIR__ . "/conn.php");

    $sql = "SELECT account_type.account_type_name, members.account_type_id FROM members LEFT JOIN account_type ON members.account_type_id = account_type.account_type_id WHERE email='{$email}'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["account_type_name"] == "admin") {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return false;
        }
    }
}

function fetch_member_name($email)
{
    include(__DIR__ . "/conn.php");
    $sql = "SELECT * FROM members WHERE email='{$email}'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            return $row["name"];
        }
    }
    mysqli_close($conn);
    return "No user found";
    exit();
}


function fetch_member($email)
{
    include(__DIR__ . "/conn.php");
    $year = date('Y', strtotime(get_member_membership_date($email)));
    $year_array = get_year_array();

    $member_related_data = "";
    $member_name = "";

    $sql = "SELECT DISTINCT *, members.name, years.year_value, payments.status 
    FROM members 
    LEFT JOIN payments ON members.member_id = payments.member_id
    LEFT JOIN years ON payments.year_id = years.year_id 
    WHERE members.email = '{$email}'
    ORDER BY years.year_value";


    $result = mysqli_query($conn, $sql);
    $index = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $member_name = $row["name"];
            foreach ($year_array as $year_value) {
                if ($year_array[$index] == $row['year_value']) {
                    $member_related_data .= "<td class='paid'>{$row['status']}</td>";
                    $index++;
                    break;
                } else {
                    if ($year_value >= $year) {
                        $member_related_data .= "<td class='unpaid'>UNPAID</td>";
                    }
                    $index++;
                }
            }
        }
    }

    for ($i = $index; $i <= count($year_array) - 1; $i++) {

        $member_related_data .= "<td class='unpaid'>MISSING</td>";
    }


    $table_row = "<tr>
                    <td>{$member_name}</td>
                ";

    $table_row .= $member_related_data . "</tr>";

    mysqli_close($conn);

    return $table_row;
}

function fetch_members()
{
    include(__DIR__ . "/conn.php");
    $member_data = "";
    $year_array = get_year_array();

    $sql = "SELECT * FROM members ORDER BY name";

    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $membership_date = date('Y', strtotime(get_member_membership_date($row["email"])));
            $member_data .= fetch_member_data($row['name'], $row["member_id"], $membership_date, $year_array);
        }
    }

    mysqli_close($conn);
    return $member_data;
}

function fetch_member_data($member_name, $member_id, $membership_date, $year_array)
{

    include(__DIR__ . "/conn.php");
    $table_row = "<tr>
                    <td>{$member_name}</td>
                    <td> 
                        <a href='../database/delete_member.php?member_id={$member_id}' style='color: #bc4749; text-decoration: none;'>
                            <i  class='fa fa-trash-o fa-2x' ></i> 
                           
                        </a>
                    </td>
                   
                ";

    $member_related_data = "";


    $sql = "SELECT DISTINCT *, members.name, years.year_value, payments.status 
    FROM members 
    LEFT JOIN payments ON members.member_id = payments.member_id
    LEFT JOIN years ON payments.year_id = years.year_id 
    WHERE members.name = '{$member_name}'
    ORDER BY years.year_value";


    $result = mysqli_query($conn, $sql);
    $index = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            foreach ($year_array as $year_value) {

                if ($year_array[$index] == $row['year_value']) {
                    $member_related_data .= "<td class='paid'>{$row['status']}</td>";
                    $index++;
                    break;
                } else {
                    if ($year_value >= $membership_date) {
                        $member_related_data .= "<td class='unpaid'>UNPAID</td>";
                    } else {
                        $member_related_data .= "<td>-</td>";
                    }

                    $index++;
                }
            }
        }
    }

    for ($i = $index; $i <= count($year_array) - 1; $i++) {
        $member_related_data .= "<td class='unpaid'>UNPAID</td>";
    }

    $table_row .= $member_related_data . "</tr>";

    mysqli_close($conn);

    return $table_row;
}


// start of AJAX calls

function search_member($search)
{
    include(__DIR__ . "/conn.php");
    $member_data = "";
    $year_array = get_year_array();

    $escapedSearch = $conn->real_escape_string($search);

    $sql = "SELECT * FROM members WHERE name LIKE '%$escapedSearch%' ORDER BY name";

    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $membership_date = date('Y', strtotime(get_member_membership_date($row["email"])));
            $member_data .= fetch_member_data($row['name'], $row["member_id"], $membership_date, $year_array);
        }
    }

    mysqli_close($conn);
    return $member_data;
}


if (isset($_POST["callFunc1"])) {
    $search = isset($_POST["search"]) ? $_POST["search"] : '';

    $member_data = search_member($search);
    $table_data = $member_data;
    echo $table_data;
}

// End of AJAX calls

function get_year_row($membership_year)
{
    include(__DIR__ . "/conn.php");

    $sql =  "SELECT * FROM years";

    $result = mysqli_query($conn, $sql);

    $year_count = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $db_year = $row["year_value"];
            if ($db_year >= $membership_year) {
                $year_count++;
            }
        }
    }
    mysqli_close($conn);
    return $year_count;
}

function get_member_membership_date($email)
{
    include(__DIR__ . "/conn.php");

    $sql = "SELECT membership_date FROM members WHERE email = '{$email}'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            return $row["membership_date"];
        }
    }
    mysqli_close($conn);
    return "";
}

function compute_member_balance($member_email)
{
    include(__DIR__ . "/conn.php");
    $membership_fee = fetch_membership_fee();


    $paid_count = 0;
    $total = 0.00;

    $sql = "SELECT * FROM years LEFT JOIN payments ON payments.year_id = years.year_id LEFT JOIN members ON payments.member_id = members.member_id ORDER BY year_value;";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["email"] == $member_email) {
                $paid_count++;
            }
        }
    }

    $year = date('Y', strtotime(get_member_membership_date($member_email)));

    $total = (get_year_row($year) - $paid_count) * $membership_fee;

    mysqli_close($conn);
    return number_format($total, 2);
}

function fetch_membership_fee()
{
    include(__DIR__ . "/conn.php");
    $sql = "SELECT membership_fee FROM membership WHERE membership_fee_id = 1";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            return $row["membership_fee"];
        }
    }
}
