<?php


// Query for total employees
$query_employees = "SELECT COUNT(*) AS total_employees FROM employees";
$result_employees = mysqli_query($conn, $query_employees);
$total_employees = mysqli_fetch_assoc($result_employees)['total_employees'];

// Query for total customers
$query_customers = "SELECT COUNT(*) AS total_customers FROM customers";
$result_customers = mysqli_query($conn, $query_customers);
$total_customers = mysqli_fetch_assoc($result_customers)['total_customers'];

// Query for total bookings
$query_bookings = "SELECT COUNT(*) AS total_bookings FROM booking_request"; 
$result_bookings = mysqli_query($conn, $query_bookings);
$total_bookings = mysqli_fetch_assoc($result_bookings)['total_bookings'];

// Query for total schedules
$query_schedules = "SELECT COUNT(*) AS total_schedules FROM schedule"; 
$result_schedules = mysqli_query($conn, $query_schedules);
$total_schedules = mysqli_fetch_assoc($result_schedules)['total_schedules'];

// Get current month and year
$current_month = date('m');
$current_year = date('Y');

// Query for total deposit amount for paid transactions in the current month
$query_total_deposit = "SELECT SUM(deposit_amount) AS total_deposit 
                        FROM transactions 
                        WHERE transaction_status = 'paid' 
                        AND MONTH(created_at) = $current_month 
                        AND YEAR(created_at) = $current_year"; // Adjust based on your transaction date column name
$result_total_deposit = mysqli_query($conn, $query_total_deposit);
$total_deposit = mysqli_fetch_assoc($result_total_deposit)['total_deposit'] ?? 0; 

// Query to get the top 4 most requested packages for the current month
$total_completed_requests_query = "SELECT COUNT(*) AS total 
                                    FROM booking_request 
                                    WHERE status = 'completed' 
                                    AND MONTH(booking_date) = $current_month 
                                    AND YEAR(booking_date) = $current_year"; // Adjust based on your booking date column name
$result = $conn->query($total_completed_requests_query);
$total_requests = $result->fetch_assoc()['total'];

$top_packages_query = "
    SELECT b.package_id, p.package_name, COUNT(*) AS request_count
    FROM booking_request b
    JOIN packages p ON b.package_id = p.package_id
    WHERE b.status = 'completed'
    AND MONTH(b.booking_date) = $current_month 
    AND YEAR(b.booking_date) = $current_year
    GROUP BY b.package_id, p.package_name
    ORDER BY request_count DESC
    LIMIT 4
";
$top_packages_result = $conn->query($top_packages_query);

$top_packages = [];
while ($row = $top_packages_result->fetch_assoc()) {
    $percentage = ($row['request_count'] / $total_requests) * 100;
    $top_packages[] = [
        'name' => htmlspecialchars($row['package_name']), 
        'count' => $row['request_count'],
        'percentage' => number_format($percentage, 2) 
    ];
}

// Get current month and year
$current_month = date('m');
$current_year = date('Y');

// Query to find all employees based on completed bookings
$top_employee_query = "
    SELECT 
        CONCAT(e.first_name, ' ', e.last_name) AS full_name, 
        e.profile, 
        COUNT(s.booking_id) AS completed_bookings
    FROM employees e
    LEFT JOIN schedule s ON e.employee_id = s.employee_id
    LEFT JOIN booking_request b ON s.booking_id = b.request_id AND b.status = 'completed'
    WHERE MONTH(b.booking_date) = $current_month 
    AND YEAR(b.booking_date) = $current_year
    GROUP BY e.employee_id
    ORDER BY completed_bookings DESC
";


// Execute the query
$result_top_employee = mysqli_query($conn, $top_employee_query);

// Check for query errors
if (!$result_top_employee) {
    die("Query failed: " . mysqli_error($conn));
}

// Prepare an array to hold all employees
$employees = [];
while ($row = mysqli_fetch_assoc($result_top_employee)) {
    $employees[] = $row;
}


// Query to get customers with completed booking requests for the current month
$customer_query = "
    SELECT 
        c.customer_id,
        CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
        c.profile,  
        COUNT(br.request_id) AS completed_requests
    FROM 
        customers c
    JOIN 
        booking_request br ON c.customer_id = br.customer_id 
    WHERE 
        br.status = 'completed' 
        AND MONTH(br.booking_date) = $current_month 
        AND YEAR(br.booking_date) = $current_year
    GROUP BY 
        c.customer_id
    ORDER BY 
        completed_requests DESC
";

$result_customers = mysqli_query($conn, $customer_query);

// Check for query errors
if (!$result_customers) {
    die("Query failed: " . mysqli_error($conn));
}

// Prepare an array to hold customers with completed bookings
$customers = [];
while ($row = mysqli_fetch_assoc($result_customers)) {
    $customers[] = $row;
}


// Example: Set the start date (replace with your actual start date)
$startDate = new DateTime('2024-01-01'); // Start date for counting weeks
$currentDate = new DateTime(); // Current date
$interval = $startDate->diff($currentDate);

// Calculate the number of weeks
$numberOfWeeks = (int)floor($interval->days / 7);

// Initialize arrays for labels and past deposits
$labels = [];
$pastDeposits = [];

// Fill the arrays for each week
for ($i = 0; $i < $numberOfWeeks; $i++) {
    $weekStartDate = clone $startDate;
    $weekStartDate->modify('+' . ($i * 7) . ' days'); // Get the start date for the week
    $labels[] = $weekStartDate->format('M d'); // Format the date for labels

    // Example: Generate random deposit amounts (replace this with actual deposit data)
    $pastDeposits[] = rand(1000, 5000); // Placeholder for past deposit amounts
}

// Add the total deposit for the current week
$totalDeposit = 3000; // Replace with your actual total deposit
$labels[] = 'Current'; // Label for current week
$pastDeposits[] = $totalDeposit; // Add the total deposit to the data

// Query for total deposit amount for paid transactions in the current week
$query_total_deposit = "
    SELECT SUM(deposit_amount) AS total_deposit 
    FROM transactions 
    WHERE transaction_status = 'paid' 
    AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)"; // Adjust based on your transaction date column name
$result_total_deposit = mysqli_query($conn, $query_total_deposit);
$total_deposit = mysqli_fetch_assoc($result_total_deposit)['total_deposit'] ?? 0;


// Query for the current month's total bookings
$current_month_query = "
    SELECT 
        COUNT(request_id) AS total_bookings
    FROM transactions
    WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
      AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$current_month_result = mysqli_query($conn, $current_month_query);
$current_month_data = mysqli_fetch_assoc($current_month_result);
$current_month_total = $current_month_data['total_bookings'] ?? 0;

// Query for the previous month's total bookings
$previous_month_query = "
    SELECT 
        COUNT(request_id) AS total_bookings
    FROM transactions
    WHERE MONTH(created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
      AND YEAR(created_at) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)";
$previous_month_result = mysqli_query($conn, $previous_month_query);
$previous_month_data = mysqli_fetch_assoc($previous_month_result);
$previous_month_total = $previous_month_data['total_bookings'] ?? 0;

// Calculate percentage change
$percentage_change = 0;
if ($previous_month_total > 0) {
    $percentage_change = (($current_month_total - $previous_month_total) / $previous_month_total) * 100;
} elseif ($previous_month_total == 0 && $current_month_total > 0) {

    $percentage_change = 100;
}




// Query for weekly deposits
$weekly_deposits_query = "
    SELECT 
        WEEK(created_at, 1) AS week_number,
        SUM(deposit_amount) AS total_deposit
    FROM transactions
    WHERE transaction_status = 'paid'
    GROUP BY WEEK(created_at, 1)
    ORDER BY WEEK(created_at, 1)";
$result_weekly_deposits = mysqli_query($conn, $weekly_deposits_query);

$weekly_deposits = [];
while ($row = mysqli_fetch_assoc($result_weekly_deposits)) {
    $weekly_deposits[$row['week_number']] = $row['total_deposit'];
}

// Query for weekly completed bookings
$weekly_bookings_query = "
    SELECT 
        WEEK(booking_date, 1) AS week_number,
        COUNT(*) AS total_bookings
    FROM booking_request
    WHERE status = 'completed'
    GROUP BY WEEK(booking_date, 1)
    ORDER BY WEEK(booking_date, 1)";
$result_weekly_bookings = mysqli_query($conn, $weekly_bookings_query);

$weekly_bookings = [];
while ($row = mysqli_fetch_assoc($result_weekly_bookings)) {
    $weekly_bookings[$row['week_number']] = $row['total_bookings'];
}


// Query for monthly deposits
$monthly_deposits_query = "
    SELECT 
        MONTH(created_at) AS month_number,
        SUM(deposit_amount) AS total_deposit
    FROM transactions
    WHERE transaction_status = 'paid'
    GROUP BY MONTH(created_at), YEAR(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)";
$result_monthly_deposits = mysqli_query($conn, $monthly_deposits_query);

$monthly_deposits = [];
while ($row = mysqli_fetch_assoc($result_monthly_deposits)) {
    $monthly_deposits[$row['month_number']] = $row['total_deposit'];
}

$monthly_bookings_query = "
    SELECT 
        MONTH(booking_date) AS month_number,
        COUNT(*) AS total_bookings
    FROM booking_request
    GROUP BY MONTH(booking_date), YEAR(booking_date)
    ORDER BY YEAR(booking_date), MONTH(booking_date)";

$result_monthly_bookings = mysqli_query($conn, $monthly_bookings_query);

// Query error check
if (!$result_monthly_bookings) {
    die("Query failed: " . mysqli_error($conn));
}

$monthly_bookings = [];

// Array mapping month numbers to names
$month_names = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
];

while ($row = mysqli_fetch_assoc($result_monthly_bookings)) {
    $monthly_bookings[$row['month_number']] = $row['total_bookings'];
}

// Prepare data for the current year
$labels = [];
$pastDeposits = [];
$pastBookings = [];

for ($i = 1; $i <= 12; $i++) {
    $labels[] = date('F', mktime(0, 0, 0, $i, 1)); // Month name
    $pastDeposits[] = $monthly_deposits[$i] ?? 0; // Total deposit for the month
    $pastBookings[] = $monthly_bookings[$i] ?? 0; // Total bookings for the month
}

// Pass data to JavaScript
$pastDeposits_json = json_encode($pastDeposits);
$pastBookings_json = json_encode($pastBookings);
$labels_json = json_encode($labels);



// Fetch deposit amounts for the current and previous month
$query = "
    SELECT 
        MONTH(created_at) AS month,
        SUM(deposit_amount) AS total_deposit
    FROM 
        transactions
    WHERE 
        created_at >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH)
    AND 
        MONTH(created_at) IN (MONTH(CURDATE()), MONTH(CURDATE() - INTERVAL 1 MONTH))
    GROUP BY 
        YEAR(created_at), MONTH(created_at)
    ORDER BY 
        YEAR(created_at), MONTH(created_at);
";

$result = $conn->query($query);

$deposits = [];
$months = [];
$current_month_total = 0;
$previous_month_total = 0;

while ($row = $result->fetch_assoc()) {
    $month_num = $row['month'];
    $total = $row['total_deposit'];

    // Check if the month is the current month
    if (date('n') == $month_num) {
        $current_month_total = $total;
        $months[] = date('F'); // Current month name
    } elseif (date('n') - 1 == $month_num || (date('n') == 1 && $month_num == 12)) { // Check for the previous month
        $previous_month_total = $total;
        $months[] = date('F', strtotime("last month")); // Previous month name
    }

    // Store deposits for use in the chart
    $deposits[] = $total;
}

// Close the connection
$conn->close();

// Prepare the JSON-encoded variables for JavaScript
$previous_month_name = date('F', strtotime("last month"));
$current_month_name = date('F');

$pastDeposits_json = json_encode($deposits);
$labels_json = json_encode($months);

?>