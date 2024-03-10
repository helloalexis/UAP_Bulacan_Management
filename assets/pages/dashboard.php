<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if ($_SESSION["account_type"] == "admin") {
        echo <<<HTML
                             <div class="wrap">
                                <div class="search">
                                    <input type="text" class="searchTerm" placeholder="Search name..." id="search-input">
                                    <button type="submit" class="searchButton" id="search-btn">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            
                        HTML;
    }
    ?>

    <div style="overflow-x:auto;">
        <table class="members" id="table">

            <tr>
                <th>Name</th>
                <?php
                if ($_SESSION["account_type"] == "admin") {
                    echo "<th>Action</th>";
                }

                if ($_SESSION["account_type"] == "admin") {
                    echo fetch_year();
                } else {
                    echo fetch_custom_year($_SESSION["email"]);
                }

                ?>
            </tr>
            <tbody id="memberDataContainer">
                <?php
                if ($_SESSION["account_type"] == "admin") {
                    echo fetch_members();
                } else {
                    echo fetch_member($_SESSION["email"]);
                }
                ?>
            </tbody>

        </table>
    </div>
    <button onclick="exportToExcel()" class="export-to-excel-btn">Export to Excel</button>
    <?php
    if ($_SESSION["account_type"] != "admin") {
        $total = compute_member_balance($_SESSION['email']);
        echo <<<HTML
                        <div class='payment-details-container'>
                            <div class='payment-details-flex-container'>
                                <h1>Your Total Balance: $total PHP</h1>
                                <div id='paypal-button-container'></div>
                            </div>
                        </div>
                    HTML;
    }

    ?>

</body>

</html>