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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #FFFFFF;
        }
        .container {
            margin-top: 50px;
            max-width: 800px;
            background-color: #FFFFFF;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .form-control {
            background-color: #EDE8DC;
            border: none;
            color: black;
        }
        .form-control:hover{
            background-color: #EDE8DC;
            color: black;
        }
        .form-control:focus {
            background-color: #EDE8DC;
            color: black;
            border-color: black;
            box-shadow: none;
        }
        label {
            font-weight: bold;
            color: black;
        }
        .btn-custom {
            background-color: #180161;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        .file-upload {
            background-color: #EDE8DC;
            padding: 10px;
            border-radius: 5px;
        }
        textarea {
            resize: none;
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
                    <div class="card mb-4" style="background: transparent; box-shadow: none;">
                        <div class="card-body">

                            <!-- Add Package Form -->
                        <div class="container">                         
                            <form method="POST" action="" enctype="multipart/form-data">

                            <div class="mb-3">
                                    <label for="package_name">Package Name:</label>
                                    <input type="text" name="package_name" style="background: #EDE8DC; color: black;" id="package_name" class="form-control" required>
                            </div>


                            <div class="mb-3">
                                    <label for="description">Description:</label>
                                    <textarea name="description" style="background: #EDE8DC; color: black;" id="description" class="form-control" rows="4" required></textarea>
                            </div>


                            <div class="mb-3">
                                    <label for="price">Price:</label>
                                    <input type="number" step="0.01" style="background: #EDE8DC; color: black;" name="price" id="price" class="form-control" required>
                            </div>

                            <div class="row mb- 3">
                                <div class="col-md-6">
                                    <label for="duration">Duration:</label>
                                    <input type="number" name="duration" style="background: #EDE8DC; color: black;" id="duration" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="duration_unit">Duration Unit:</label>
                                    <select name="duration_unit" style="background: #EDE8DC; color: black;" id="duration_unit" class="form-control" required>
                                        <option value="hours">Hours</option>
                                        <option value="days">Days</option>
                                    </select>
                                </div>
                            </div>


                                <div class="mb-5">
                                    <label for="status">Status:</label>
                                    <select name="status" style="background: #EDE8DC; color: black;" id="status" class="form-control" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            
                            <div class="mb-3">
                                <label>Needed Items:</label>
                                <div class="form-group" style="background:#1E201E; border-radius: 10px; padding: 15px 0 10px 0; display: flex; justify-content: space-evenly;">
                                    <?php foreach ($products as $product): ?>
                                        <div class="form-check">
                                            <input type="checkbox" style="border: 1px solid black;" class="form-check-input" name="needed_items[]" value="<?php echo $product['product_id']; ?>" id="product_<?php echo $product['product_id']; ?>">
                                            <label class="form-check-label" style="color: white;" for="product_<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></label>
                                        </div>
                                    <?php endforeach; ?>
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
