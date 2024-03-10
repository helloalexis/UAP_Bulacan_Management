<?php


session_start();

if (!isset($_SESSION["email"])) {
    // Redirect to login page
    header("Location: /uap_management/index.php");

    exit();
}

?>
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin-settings.css">

    <style>
        .members {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .members td,
        .members th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .members tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .members tr:hover {
            background-color: #ddd;
        }

        .members th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;

        }

        .paid {
            background-color: #6a994e;
            color: white;
        }

        .unpaid {
            background-color: #bc4749;
            color: white;
        }

        .search {
            width: 100%;

            display: flex;
        }

        .searchTerm {
            width: 100%;
            border: 3px solid #00B4CC;
            border-right: none;
            padding: 5px;
            height: 36px;
            border-radius: 5px 0 0 5px;
            outline: none;
            color: #9DBFAF;
        }

        .searchTerm:focus {
            color: #00B4CC;
        }

        .searchButton {
            width: 40px;
            height: 36px;
            border: 1px solid #00B4CC;
            background: #00B4CC;
            text-align: center;
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            font-size: 20px;
        }

        /*Resize the wrap to see the search bar change!*/
        .wrap {
            width: 30%;
            margin-bottom: 5px;
        }


        .payment-details-container {
            width: 100%;
        }

        .payment-details-flex-container {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .export-to-excel-btn {
            background-color: #04AA6D;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- replace with your own id -->
    <script src="https://www.paypal.com/sdk/js?client-id=AdsOoKVQtVp8Z1WAaXSHG4oWGo5OuFAIQoXEbPZYaVzFtNl2HbHCsHDuI3SqaWTdlSuRIDDY8WSzO_J3&currency=PHP"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

</head>

<body>
    <div class="area">
        <?php
        include(__DIR__ . "/../database/fetch.php");
        $_SESSION["membership_fee"] = fetch_membership_fee();
        $page = $_GET["page"];

        switch ($page) {
            case "dashboard":

                require(__DIR__ . "/dashboard.php");
                break;
            case "admin_settings":

                require(__DIR__ . "/admin-settings.php");
                break;
        }
        ?>
    </div>
    <nav class="main-menu">
        <ul class="profile">
            <li>
                <a href="">
                    <i class="fa fa-user fa-4x"></i>
                    <span class="nav-text">
                        <?php
                        $_SESSION["member_name"] =  fetch_member_name($_SESSION["email"]);
                        echo $_SESSION["member_name"];
                        ?>
                    </span>
                </a>

            </li>
        </ul>

        <ul>

            <li>
                <a href="./management.php?page=dashboard">
                    <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                        Dashboard
                    </span>
                </a>

            </li>


            <?php
            if ($_SESSION["account_type"] == "admin") {
                echo <<<HTML
                      <li>
                        <a href="./management.php?page=admin_settings">
                            <i class="fa fa-cogs fa-2x"></i>
                            <span class="nav-text">
                                Tools & Resources
                            </span>
                        </a>
                    </li>
                HTML;
            }
            ?>


        </ul>

        <ul class="logout">
            <li>
                <a href="../database/logout.php">
                    <i class="fa fa-power-off fa-2x"></i>
                    <span class="nav-text">
                        Logout
                    </span>
                </a>
            </li>
        </ul>
    </nav>


    <?php
    if ($_SESSION["account_type"] == "member") {

        $total = compute_member_balance($_SESSION["email"]);
        echo <<<HTML
                 <script>
                        paypal.Buttons({
                            createOrder: function(data, actions) {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: '{$total}',
                                         
                                        }
                                    }]
                                });
                            },
                            onApprove: function(data, actions) {
                                return actions.order.capture().then(function(details) {
                                    console.log(details);
                                    alert('Transaction completed by ' + details.payer.name.given_name);

                                    $.ajax({
                                            url: 'http://localhost/uap_management/assets/database/insert.php',
                                            type: 'post',
                                            data: {
                                                "update_member_payment": "1",
                                            },
                                            success: function(response) {
                                                // Handle the response from the server
                                                $('#table').html(response);
                                              
                                            },
                                            error: function(xhr, status, error) {
                                                // Handle errors if any
                                                console.error(xhr.responseText);
                                            }
                                         });
                                    
                                });
                            }
                        }).render('#paypal-button-container');
             </script>
            HTML;
    }
    ?>


    <script>
        document.getElementById("search-btn").addEventListener("click", function(e) {
            clear_table();
            search();
        });

        function clear_table() {

            document.getElementById("memberDataContainer").innerHTML = "";

        }

        function search() {
            let search = document.getElementById("search-input").value;

            $.ajax({
                url: 'http://localhost/uap_management/assets/database/fetch.php',
                type: 'post',
                data: {
                    "callFunc1": "1",
                    "search": search,

                },
                success: function(response) {
                    // Handle the response from the server
                    // $('#table').html(response);

                    document.getElementById("memberDataContainer").innerHTML = response;
                    console.log(response)
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        function exportToExcel() {
            /* Get table element */
            var table = document.getElementById("table");

            /* Convert table to workbook */
            var workbook = XLSX.utils.table_to_book(table);

            /* Save the workbook as an Excel file */
            XLSX.writeFile(workbook, 'exported_data.xlsx');
        }
    </script>
</body>

</html>