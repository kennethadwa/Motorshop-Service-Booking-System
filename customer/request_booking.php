<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register.php");
    exit();
}

include('../connection.php');

// Fetch packages for selection
$packages = [];
$packageSql = "SELECT package_id, package_name FROM packages WHERE status = 'active'";
$packageResult = $conn->query($packageSql);

if ($packageResult) {
    while ($row = $packageResult->fetch_assoc()) {
        $packages[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
    $_SESSION['form_submitted'] = true; // Set a flag to indicate form has been submitted

    $customer_id = $_SESSION['customer_id'];
    $model_name = $_POST['model_name'];
    $address = $_POST['address'];
    $request_date = $_POST['request_date'];
    $request_time = $_POST['request_time'];
    $description = $_POST['description'];
    $package_id = $_POST['package_id'];

    $insertSql = "INSERT INTO booking_request (customer_id, model_name, address, request_date, request_time, description, package_id)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param('isssssi', $customer_id, $model_name, $address, $request_date, $request_time, $description, $package_id);

    if ($stmt->execute()) {
        $request_id = $stmt->insert_id;

        // Handle image uploads
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $target_dir = "../uploads/booking_images/";

            foreach ($_FILES['images']['name'] as $key => $image_name) {
                $image_tmp_name = $_FILES['images']['tmp_name'][$key];

                if (!empty($image_tmp_name) && is_uploaded_file($image_tmp_name)) {
                    $image_target_path = $target_dir . basename($image_name);
                    $check = getimagesize($image_tmp_name);

                    if ($check !== false && move_uploaded_file($image_tmp_name, $image_target_path)) {
                        $imageSql = "INSERT INTO booking_images (request_id, image_path) VALUES (?, ?)";
                        $imageStmt = $conn->prepare($imageSql);
                        $imageStmt->bind_param('is', $request_id, $image_target_path);
                        $imageStmt->execute();
                    }
                }
            }
        }

        // Redirect to avoid form resubmission
        header('Location: booking_history');
        exit();
    } else {
        echo "<script>alert('Error submitting booking request: " . $stmt->error . "');</script>";
    }
}

// Remove the form submission flag after successful redirection or on next page load
unset($_SESSION['form_submitted']);
?>  


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Request</title>
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

<div id="main-wrapper">
    <?php include('nav-header.php'); ?>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>

    <div class="content-body">
        <div class="container-fluid">
            <div class="row invoice-card-row">
                <div class="col-12">
                    <div class="card mb-4" style="background: transparent; box-shadow: none;">

                       <div class="container">
                          <form method="POST" action="" enctype="multipart/form-data">


                              <div class="mb-3">
                                  <label for="model_name">Motorcycle Model:</label>
                                  <input type="text" name="model_name" id="model_name" class="form-control" required>
                              </div>


                              <div class="mb-3">
                                  <label for="address">Address:</label>
                                  <input type="text" name="address" id="address" class="form-control" required>
                              </div>


                              <div class="row mb-3">
                                  <div class="col-md-6">
                                      <label for="request_date">Booking Date:</label>
                                      <input type="date" name="request_date" id="request_date" class="form-control" required>
                                  </div>
                                  <div class="col-md-6">
                                      <label for="request_time">Booking Time:</label>
                                      <input type="time" name="request_time" id="request_time" class="form-control" required>
                                  </div>
                              </div>


                              <div class="mb-3">
                                  <label for="description">Description:</label>
                                  <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                              </div>


                              <div class="mb-3">
                                  <label for="package_id">Select Package:</label>
                                  <select name="package_id" id="package_id" class="form-control" required>
                                      <option value="">Select a package</option>
                                      <?php foreach ($packages as $package): ?>
                                          <option value="<?= $package['package_id'] ?>">
                                              <?= htmlspecialchars($package['package_name']) ?>
                                          </option>
                                      <?php endforeach; ?>
                                  </select>
                              </div>

                              
                              <div class="mb-3 file-upload">
                                  <label for="images">Upload Images:</label>
                                  <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                              </div>

                              
                              <button type="submit" class="btn btn-custom">Submit Request</button>
                                                </form>
                                           </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>

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




