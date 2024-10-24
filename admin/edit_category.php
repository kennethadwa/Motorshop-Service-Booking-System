<?php

session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
  header("Location: ../login-register.php");
  exit();
}
include('../connection.php');

// Check if category ID is provided
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Fetch the category details based on the ID
    $stmt = $conn->prepare("SELECT category_name FROM categories WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $stmt->bind_result($category_name);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "No category ID provided.";
    exit();
}

if (isset($_POST['update'])) {
    $new_category_name = $_POST['category_name'];


    $stmt = $conn->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
    $stmt->bind_param("si", $new_category_name, $category_id);

    if ($stmt->execute()) {
        echo "<script>alert('Category updated successfully!'); window.location.href = 'view_category.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

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
                           <h2 style="color: white;">Edit Category</h2>
                           <br>
                          <form action="" method="POST">
                              <label for="category_name" style="color: white;">Category Name:</label>
                              <input type="text" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category_name); ?>" style="padding: 10px; border-radius:10px; font-size: 1rem;" required>
                              <br><br>
                              <button type="submit" name="update" style="padding: 10px; background: green; color: white; border-radius: 10px; box-shadow: none; border: none;">Update</button>
                          </form>
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
