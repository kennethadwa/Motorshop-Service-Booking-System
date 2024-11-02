<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

include('../connection.php');

// Fetch products from the database, joining with categories for the category name
$query = "SELECT product_id, products.product_name, products.image, products.description, 
                 products.price, products.quantity, categories.category_name 
          FROM products 
          LEFT JOIN categories ON products.category_id = categories.category_id";
$result = mysqli_query($conn, $query);
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
    <link href="css/style.css" rel="stylesheet">
    <style>
    body {
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
      flex-wrap: wrap;
      justify-content: space-evenly;
    }

    .search-container {
      margin-bottom: 20px;
    }

    .search-container input {
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 100%;
      max-width: 400px;
    }

    .category-navbar {
    display: flex;
    flex-wrap: wrap; 
    justify-content: center; 
    margin-top: 20px;
}

.category-navbar a {
    margin: 5px; 
    padding: 10px 15px;
    text-decoration: none;
    color: white;
    background-color: #27005D;
    border-radius: 5px;
    transition: background-color 0.3s ease; 
}

.category-navbar a:hover {
    background-color: #7C00FE;
}


@media (max-width: 768px) {
    .category-navbar {
        flex-direction: column;
        align-items: center;
    }

    .category-navbar a {
        width: 100%;
        text-align: center;
    }
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
                        <div class="search-container d-flex justify-content-center">
                            <input type="text" id="search-input" placeholder="Search products..." onkeyup="filterPackages()">
                        </div>

                        <div class="category-navbar">
                            <a href="#" data-category="" onclick="filterByCategory(event)">All</a>
                            <a href="#" data-category="Motorcycle Parts" onclick="filterByCategory(event)">Motorcycle Parts</a>
                            <a href="#" data-category="Accessories" onclick="filterByCategory(event)">Accessories</a>
                            <a href="#" data-category="Tires & Wheels" onclick="filterByCategory(event)">Tires & Wheels</a>
                            <a href="#" data-category="Oils & Lubricants" onclick="filterByCategory(event)">Oils & Lubricants</a>
                            <a href="#" data-category="Battery" onclick="filterByCategory(event)">Battery</a>
                            <a href="#" data-category="Electrical Components" onclick="filterByCategory(event)">Electrical Components</a>
                            <a href="#" data-category="Suspension & Brakes" onclick="filterByCategory(event)">Suspension & Brakes</a>
                            <a href="#" data-category="Maintenance Services" onclick="filterByCategory(event)">Maintenance Services</a>
                            <a href="#" data-category="Performance Upgrades" onclick="filterByCategory(event)">Performance Upgrades</a>
                            <a href="#" data-category="Custom Builds & Modifications" onclick="filterByCategory(event)">Custom Builds &   Modifications</a>
                        </div>

                        <!-- Products Table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="background: transparent; color: white; text-align: center;">Image</th>
                                    <th style="background: transparent; color: white; text-align: center;">Product</th>
                                    <th style="background: transparent; color: white; text-align: center;">Description</th>
                                    <th style="background: transparent; color: white; text-align: center;">Category</th>
                                    <th style="background: transparent; color: white; text-align: center;">Price</th>
                                    <th style="background: transparent; color: white; text-align: center;">Quantity</th>
                                    <th style="background: transparent; color: white; text-align: center;">View Details</th>
                                </tr>
                            </thead>
                            <tbody id="package-list" style="background: transparent;">
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr class="pcard" data-category="<?php echo $row['category_name']; ?>">
                                        <td style="background: transparent;">
                                          <div class="d-flex justify-content-center" style="width: 100%; height: 100%;">
                                          <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>" width="50">
                                        </div>
                                        </td>
                                        <td class="title" style="background: transparent; color: white; text-align: center;"><?php echo $row['product_name']; ?></td>
                                        <td style="background: transparent; color: white; text-align: center;"><?php echo $row['description']; ?></td>
                                        <td style="background: transparent; color: white; text-align: center;"><?php echo $row['category_name']; ?></td>
                                        <td style="background: transparent; color: white; text-align: center;"><?php echo $row['price']; ?></td>
                                        <td style="background: transparent; color: white; text-align: center;"><?php echo $row['quantity']; ?></td>
                                        <td style="background: transparent; color: white; text-align: center;">
                                          <a href="edit_product.php?product_id=<?php echo $row['product_id']; ?>" style="padding: 10px 20px; background: green; color: white; border-radius: 10px;">Edit</a>
                                          &nbsp;
                                          &nbsp;
                                          <a href="delete_product.php?product_id=<?php echo $row['product_id']; ?>" style="padding: 10px; background: red; color: white; border-radius: 10px;" onclick="return confirmDelete()">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        function filterByCategory(event) {
  const category = event.target.getAttribute('data-category');
  const packageList = document.getElementById('package-list');
  const cards = packageList.getElementsByClassName('pcard');

  // Show all cards if the "All" category is selected
  for (let i = 0; i < cards.length; i++) {
    if (category === "" || cards[i].getAttribute('data-category') === category) {
      cards[i].style.display = '';
    } else {
      cards[i].style.display = 'none';
    }
  }
}
    </script>

    <script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this package?");
}
</script>
</body>

</html>
