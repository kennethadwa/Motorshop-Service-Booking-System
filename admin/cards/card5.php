<?php

// Database connection
include('../connection.php');

// Query to get the total deposit for this week only
$currentWeekQuery = "SELECT SUM(deposit_amount) AS total_this_week
                     FROM transactions
                     WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";

// Execute query and check for errors
$currentWeekResult = $conn->query($currentWeekQuery);
if (!$currentWeekResult) {
    die("Error in current week query: " . $conn->error);
}

$total_deposit = ($currentWeekResult->num_rows > 0) ? $currentWeekResult->fetch_assoc()['total_this_week'] : 0;

// Close the database connection if it's no longer needed
$conn->close();
?>

<div class="col-xl-12 col-xxl-12 d-flex p-0"> <!-- Add p-0 to remove padding -->
    <div class="card w-100" style="box-shadow: none;"> <!-- Add w-100 to ensure full width -->
        <div class="card-body">
            <div class="row align-items-center">
                <!-- Right Column -->
                <div class="col-md-8">
                    <div class="card-bx bg-blue">
                        <img class="pattern-img" src="images/pattern/pattern6.png" alt="">
                        <div class="card-info text-white d-flex justify-content-center align-items-center flex-column">
                            <img src="images/pattern/circle.png" class="mb-4" alt="">
                            <h2 class="text-white card-balance">₱<?php echo number_format($total_deposit, 2); ?></h2>
                            <u class="fs-16">Total Revenue</u>
                            <span style="color: lightgreen">Current Week's Total</span>
                        </div>
                    </div>
                </div>

                <!-- Left Column -->
                <div class="col-md-4 mt-3 d-flex flex-column align-items-start">
                    <h4 class="card-title">Most Requested Packages</h4>
                    <span style="color: black;">Overview of the top requested packages based on completed bookings</span>
                    <ul class="card-list mt-3">
                        <?php foreach ($top_packages as $index => $package): ?>
                            <li>
                                <span style="color: black;"><?php echo htmlspecialchars($package['name']); ?></span>
                                <span style="color: green;"><?php echo $package['count']; ?> requests (<?php echo $package['percentage']; ?>%)</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
