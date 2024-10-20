<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

include('../connection.php'); 

$product_added = false; 

// Fetch categories from the database
$categories = [];
$sql = "SELECT category_id, category_name FROM categories";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['category']; // Get selected category
    $image = $_FILES['image']; 

    $target_dir = "../uploads/product_images"; 
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($image["tmp_name"]);
    if($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($image["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO products (product_name, description, price, quantity, category_id, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiiis", $product_name, $description, $price, $quantity, $category_id, $target_file);

            if ($stmt->execute()) {
                $product_added = true;
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
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
    <title>Add Product</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #17153B;
        }
        .container-fluid {
            display: flex;
            justify-content: center;
            height: 100vh;
        }
        .card {
            max-width: 100%;
            width: 100%; 
            height: auto;
            box-shadow: none; 
            background: transparent;
        }
        @media (min-width: 768px) {
            .card {
                width: 600px;
            }
        }
        @media (max-width: 576px) {
            .card {
                width: 100%; 
                margin: 0 10px; 
            }
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
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="row">

                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="product_name">Product Name:</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="description">Description:</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                                </div>

                                <!-- Category Dropdown -->
                                <div class="form-group mt-3">
                                    <label for="category">Category:</label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">Select a Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['category_id']; ?>">
                                                <?php echo $category['category_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="price">Price:</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="image">Upload Image:</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                                </div>
                                </div>
                               </div>
                                <div class="add-btn" style="display: flex; justify-content:center">
                                    <button type="submit" class="btn mt-5" style="background-color: blue; color: white; box-shadow: none;">Add Product</button>
                                </div>
                            </form>

                            <?php if ($product_added): ?>
                            <script>
                                alert("Product added successfully!");
                                window.location.href = "view_products";
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
