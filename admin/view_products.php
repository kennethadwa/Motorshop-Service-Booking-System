<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
  header("Location: ../login-register.php");
  exit();
}

include('../connection.php');

// Fetch packages data with needed items from the database
$query = "SELECT p.package_id, p.package_name, p.price, pp.product_id, pr.product_name 
          FROM packages p 
          LEFT JOIN package_products pp ON p.package_id = pp.package_id 
          LEFT JOIN products pr ON pp.product_id = pr.product_id";
$result = $conn->query($query);

$packages = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $package_name = $row['package_name'];
    // Create a new package entry if it doesn't exist
    if (!isset($packages[$package_name])) {
      $packages[$package_name] = [
        'id' => $row['package_id'], // Store package ID for editing
        'price' => '₱' . number_format($row['price'], 2), // Format the price as currency
        'needed_items' => [] // Initialize needed items
      ];
    }
    // Add the product name to the needed items array
    if ($row['product_name']) {
      $packages[$package_name]['needed_items'][] = $row['product_name'];
    }
  }
} else {
  $packages = []; // No packages found
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
            <div class="search-container d-flex justify-content-center">
              <input type="text" id="search-input" placeholder="Search products..." onkeyup="filterPackages()">
            </div>

            <!-- Category Navbar -->
            <div class="category-navbar">
              <a href="#" data-category="Motorcycle Parts" onclick="filterByCategory(event)">Motorcycle Parts</a>
              <a href="#" data-category="Accessories" onclick="filterByCategory(event)">Accessories</a>
              <a href="#" data-category="Tires & Wheels" onclick="filterByCategory(event)">Tires & Wheels</a>
              <a href="#" data-category="Oils & Lubricants" onclick="filterByCategory(event)">Oils & Lubricants</a>
              <a href="#" data-category="Battery" onclick="filterByCategory(event)">Battery</a>
              <a href="#" data-category="Electrical Components" onclick="filterByCategory(event)">Electrical Components</a>
              <a href="#" data-category="Suspension & Brakes" onclick="filterByCategory(event)">Suspension & Brakes</a>
              <a href="#" data-category="Maintenance Services" onclick="filterByCategory(event)">Maintenance Services</a>
              <a href="#" data-category="Performance Upgrades" onclick="filterByCategory(event)">Performance Upgrades</a>
              <a href="#" data-category="Custom Builds & Modifications" onclick="filterByCategory(event)">Custom Builds & Modifications</a>
            </div>

            <div class="card mb-4" style="box-shadow: none; background: transparent;">
              <div class="card-body" id="package-list">
                <?php include('./cards/product_ajax.php'); ?>
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

  <script>

function filterByCategory(event) {
  const category = event.target.getAttribute('data-category');
  const packageList = document.getElementById('package-list');
  const cards = packageList.getElementsByClassName('pcard');

  // Show all cards if no category is selected
  if (category === "") {
    for (let i = 0; i < cards.length; i++) {
      cards[i].style.display = '';
    }
    return;
  }

  // Filter cards based on category
  for (let i = 0; i < cards.length; i++) {
    const packageCategory = cards[i].getAttribute('data-category'); // Assume you add a data-category attribute to your package cards
    if (packageCategory === category) {
      cards[i].style.display = '';
    } else {
      cards[i].style.display = 'none';
    }
  }
}

    function filterPackages() {
      const input = document.getElementById('search-input');
      const filter = input.value.toLowerCase();
      const packageList = document.getElementById('package-list');
      const cards = packageList.getElementsByClassName('pcard');

      for (let i = 0; i < cards.length; i++) {
        const packageName = cards[i].querySelector('.title').textContent.toLowerCase();
        if (packageName.includes(filter)) {
          cards[i].style.display = '';
        } else {
          cards[i].style.display = 'none';
        }
      }
    }
  </script>

  

</body>

</html>
