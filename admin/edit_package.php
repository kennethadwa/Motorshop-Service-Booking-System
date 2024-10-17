<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

include('../connection.php');

// Check if package_id is provided
if (isset($_GET['package_id'])) {
    $package_id = $_GET['package_id'];

    // Fetch package details
    $query = "SELECT * FROM packages WHERE package_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $package = $result->fetch_assoc();
    } else {
        echo "Package not found!";
        exit();
    }

    // Handle form submission for updating the package
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $status = $_POST['status'];

        // Update package details in the database
        $update_query = "UPDATE packages SET package_name = ?, price = ?, description = ?, duration = ?, status = ? WHERE package_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("sdsssi", $name, $price, $description, $duration, $status, $package_id);

        if ($update_stmt->execute()) {
            echo "<script>alert('Package updated successfully!'); window.location.href = 'view_packages.php';</script>";
        } else {
            echo "Error updating package!";
        }
    }
} else {
    echo "No package selected!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Packages</title>
	<link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
	<!-- Style CSS -->
    <link href="css/style.css" rel="stylesheet">
    <style>
         body{
	  background-color: #17153B;
	  }

			::-webkit-scrollbar {
         width: 18px; 
      }

      ::-webkit-scrollbar-track {
          background: #17153B;
      }
      
      ::-webkit-scrollbar-thumb {
          background-color: #DA0C81; 
          border-radius: 10px; 
          border: 2px solid #DA0C81; 
      }

      ::-webkit-scrollbar-thumb:hover {
          background-color: #555;
      }

      .card-body {
       display: flex;
       flex-wrap: wrap; /* Allow cards to wrap to the next line if needed */
       justify-content: space-evenly; /* Evenly space the cards */
      }

      .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container input, .form-container select, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #590696;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #7509b5;
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
                <div class="card mb-4" style="box-shadow: none; background: transparent;">
                    <div class="card-body">                      
                        <div class="form-container" style="box-shadow: 2px 2px 5px black; background-image: linear-gradient(to bottom, #030637, #3C0753);">
                          <form method="POST">
                              <label for="name">Package Name</label>
                              <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($package['package_name']); ?>" required>
                      
                              <label for="price">Price</label>
                              <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($package['price']); ?>" required>
                      
                              <label for="description">Description</label>
                              <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($package['description']); ?></textarea>
                      
                              <label for="duration">Duration (hours)</label>
                              <input type="number" id="duration" name="duration" value="<?php echo htmlspecialchars($package['duration']); ?>" required>
                      
                              <label for="status">Status</label>
                              <select id="status" name="status">
                                  <option value="active" <?php echo $package['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                  <option value="inactive" <?php echo $package['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                              </select>
                              <div style="width: 100%; display: flex; justify-content: center; margin-top: 10px;">
                                 <a href="view_packages" style="box-shadow: none; border: none; background: orange; padding: 10px 18px; border-radius: 5px;"><i class="fas fa-arrow-left"></i></a>
                                 &nbsp;
                                 &nbsp;
                                 <button type="submit" style="box-shadow: none; border: none; background: green;"><i    class="fa-solid fa-pen-nib" style="color: #ffffff;"></i></button>
                              </div>
                              
                          </form>
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
<!-- Required vendors -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>

<!-- Apex Chart -->
<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>

<!-- Dashboard 1 -->
<script src="js/dashboard/dashboard-1.js"></script>

<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>

</body>
</html>
