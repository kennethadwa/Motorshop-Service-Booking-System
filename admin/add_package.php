<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php'); 

$package_added = false; // Variable to check if the package was added

// Fetch products for the selection
$product_query = "SELECT product_id, product_name FROM products";
$product_result = $conn->query($product_query);

$products = [];
if ($product_result && $product_result->num_rows > 0) {
    while ($row = $product_result->fetch_assoc()) {
        $products[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $duration_unit = $_POST['duration_unit']; // New input for unit
    $status = $_POST['status'];
    $needed_items = $_POST['needed_items']; // Get selected product IDs

    // Convert duration to hours if unit is in days
    if ($duration_unit === 'days') {
        $duration *= 24; // Convert days to hours
    }

    // Prepare and bind for packages
    $stmt = $conn->prepare("INSERT INTO packages (package_name, description, price, duration, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $package_name, $description, $price, $duration, $status);

    // Execute the statement for packages
    if ($stmt->execute()) {
        $package_id = $stmt->insert_id; // Get the last inserted package ID
        
        // Now insert the selected products into the package_products table
        if (!empty($needed_items)) {
            foreach ($needed_items as $product_id) {
                $stmt2 = $conn->prepare("INSERT INTO package_products (package_id, product_id) VALUES (?, ?)");
                $stmt2->bind_param("ii", $package_id, $product_id);
                $stmt2->execute();
                $stmt2->close();
            }
        }

        $package_added = true; // Set to true if package is added successfully
    } else {
        echo "Error: " . $stmt->error; // Display the error if there's an issue
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Package</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="css/style.css" rel="stylesheet">
    <style>
    body {
        background-color: #17153B;
        height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
    }
    #main-wrapper {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .content-body {
        flex-grow: 1;
        display: flex;
    }
    .container-fluid {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        height: 100%;
    }
    .card {
        width: 100%;
        max-width: 100%;
        height: 100%;
        box-shadow: none;
        background: transparent;
    }
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px;
        height: 100%;
    }
    form {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .add-btn {
        margin-top: 20px;
    }
    @media (max-width: 576px) {
        .card {
            margin: 0 10px;
        }
    }
</style>

</head>
<body>

<!-- Main wrapper Start -->
<div id="main-wrapper">
    <!-- Nav Header Start -->
    <?php include('nav-header.php'); ?>
    <!-- Nav Header End -->

    <!-- Header Start -->
    <?php include('header.php'); ?>
    <!-- Header End -->

    <!-- Sidebar Start -->
    <?php include('sidebar.php'); ?>
    <!-- Sidebar End -->

    <!-- Content Body Start -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row invoice-card-row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Add Package Form -->
                            <form method="POST" action="" enctype="multipart/form-data">
                             <div class="row">

                             <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="package_name">Package Name:</label>
                                    <input type="text" name="package_name" style="background: transparent; color: white;" id="package_name" class="form-control" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="description">Description:</label>
                                    <textarea name="description" style="background: transparent; color: white;" id="description" class="form-control" rows="4" required></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="price">Price:</label>
                                    <input type="number" step="0.01" style="background: transparent; color: white;" name="price" id="price" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="duration">Duration:</label>
                                    <input type="number" name="duration" style="background: transparent; color: white;" id="duration" class="form-control" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="duration_unit">Duration Unit:</label>
                                    <select name="duration_unit" style="background: transparent; color: white;" id="duration_unit" class="form-control" required>
                                        <option value="hours">Hours</option>
                                        <option value="days">Days</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="status">Status:</label>
                                    <select name="status" style="background: transparent; color: white;" id="status" class="form-control" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label>Needed Items:</label><br>
                                    <?php foreach ($products as $product): ?>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="needed_items[]" value="<?php echo $product['product_id']; ?>" id="product_<?php echo $product['product_id']; ?>">
                                            <label class="form-check-label" for="product_<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                                </div>
                                <div class="add-btn" style="display: flex; justify-content:center">
                                    <button type="submit" class="btn btn-primary mt-3" style="background: blue; color: white; border: none; box-shadow: 1px 1px 10px black; border-radius: 10px;">Add Package</button>
                                </div>
                            </form>

                            <?php if ($package_added): ?>
                            <script>
                                alert("Package added successfully!");
                                window.location.href = "view_packages";
                            </script>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Body End -->

</div>
<!-- Main wrapper end -->

<!-- Scripts -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>
<script src="js/dashboard/dashboard-1.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>

</body>
</html>
