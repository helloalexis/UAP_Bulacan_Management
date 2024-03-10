<div style="overflow-x:auto" class="year-table-container">
    <table class="year-table">
        <th>Year value</th>
        <th>Action</th>
        <tr>
            <?php
            echo fetch_admin_settings_year();
            ?>
        </tr>
    </table>
</div>

<button id="insertYearButton" class="insert-year-btn">Add Another Year</button>

<H2>Membership Fee</H2>
<?php
$membership_fee = fetch_membership_fee();
echo <<<HTML
            <input type="text" name="membership_fee" id="membershipfeeInput" class="membership-fee-input" value = "{$membership_fee}">
        HTML;
?>

<br>
<button id="updateMembershipFeeButton" class="update-membership-fee-btn">Update Membership Fee</button>

<script>
    $(document).ready(function() {

        $("#insertYearButton").on("click", function() {
            // Make an AJAX request to your PHP script

            $.ajax({
                url: 'http://localhost/uap_management/assets/database/insert.php',
                type: 'POST',
                data: {
                    action: 'insert_year'
                }, // Additional data if needed
                success: function(response) {

                    console.log(response);
                },
                error: function(error) {
                    // Handle errors
                    console.error(error);
                }
            });
        });

        $("#updateMembershipFeeButton").on("click", function() {
            // Make an AJAX request to your PHP script
            let membershipfee = document.getElementById("membershipfeeInput").value;
            $.ajax({
                url: 'http://localhost/uap_management/assets/database/insert.php',
                type: 'POST',
                data: {
                    action: 'update_membership_fee',
                    "membership_fee": membershipfee
                }, // Additional data if needed
                success: function(response) {

                    console.log(response);
                },
                error: function(error) {
                    // Handle errors
                    console.error(error);
                }
            });
        });
    });
</script>