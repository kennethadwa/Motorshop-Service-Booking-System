<style>
.container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem; /* Gap between cards */
    justify-content: center;
}

.pcard {
    flex: 1 1 300px; /* Allow cards to grow and shrink, with a minimum width of 300px */
    max-width: 600px; /* Adjust width for landscape */
    display: flex;
    border-radius: 0.5rem;
    background-color: rgba(17, 24, 39, 1);
    box-shadow: 2px 2px 7px black;
    padding: 1.5rem;
    margin-bottom: 2rem; 
}

.pcard .left-side {
    flex: 1; /* Takes remaining space */
    padding-right: 1rem; /* Space between left and right side */
}

.pcard .right-side {
    width: 200px; /* Fixed width for products */
}

.title {
    font-size: 1.5rem;
    line-height: 2rem;
    font-weight: 700;
    color: #fff;
}

.price {
    font-size: 1rem;
    line-height: 1;
    font-weight: 700;
    color: #fff;
}

.desc {
    margin-top: 0.75rem;
    margin-bottom: 0.75rem;
    line-height: 1.625;
    color: rgba(156, 163, 175, 1);
}

.duration {
    margin-top: 0.5rem;
    line-height: 1.625;
    color: rgba(156, 163, 175, 1);
}

.lists {
    margin-bottom: 1.5rem;
    color: rgba(156, 163, 175, 1);
}

.lists .list {
    margin-bottom: 0.5rem;
    display: flex;
    margin-left: 0.5rem;
}

.bookbtn{
    color: black; 
    border-radius: 5px; 
    background: rgba(167, 139, 250, 1); 
    padding: 10px 15px; 
    transition: 0.5s ease;
}

.bookbtn:hover{
    background: #27005D;
}

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
    .pcard {
        flex-direction: column; /* Stack items vertically */
        align-items: center; /* Center items */
    }

    .pcard .left-side {
        padding-right: 0; /* Remove right padding on small screens */
        text-align: center; /* Center text on small screens */
    }

    .pcard .right-side {
        width: auto; /* Allow right-side width to be auto */
        margin-top: 1rem; /* Add margin above the right side */
    }

    .title {
        font-size: 1.25rem; /* Adjust title size for smaller screens */
    }

    .price, .desc, .duration {
        font-size: 0.9rem; /* Smaller font sizes for better fit */
    }

    .action {
        width: 100%; /* Full width button on small screens */
    }
}
</style>



<?php
include('../connection.php');

// Fetch packages and their associated products with prices
$query = "SELECT p.package_id, p.package_name, p.price AS package_price, p.description, p.duration, p.status, pr.product_name, pr.price AS product_price 
          FROM packages p 
          LEFT JOIN package_products pp ON p.package_id = pp.package_id 
          LEFT JOIN products pr ON pp.product_id = pr.product_id";
$result = $conn->query($query);

$packages = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $package_id = $row['package_id'];
        // Initialize package if it doesn't exist
        if (!isset($packages[$package_id])) {
            // Create a range for the duration (adding 2 hours)
            $duration = $row['duration'];
            $durationRange = $duration . ' - ' . ($duration + 2) . ' hours'; // Modify here

            $packages[$package_id] = [
                'id' => $package_id,
                'name' => $row['package_name'],
                'price' => '₱' . number_format($row['package_price'], 2),
                'description' => $row['description'],
                'duration' => $durationRange, // Use the duration range
                'status' => $row['status'],
                'products' => []
            ];
        }
        // Add product name and price to the package if it exists
        if (!empty($row['product_name'])) {
            $packages[$package_id]['products'][] = [
                'name' => $row['product_name'],
                'price' => '₱' . number_format($row['product_price'], 2)
            ];
        }
    }
}

// Reset the array for a simpler structure
$packages = array_values($packages);
?>

<div class="container">
    <?php
    foreach ($packages as $package) {
        $statusColor = '';
        switch ($package['status']) {
            case 'active':
                $statusColor = '#06D001';
                break;
            case 'inactive':
                $statusColor = 'red';
                break;
            default:
                $statusColor = 'white';
                break;
        }
        ?>
        <div class="pcard">
            <div class="left-side">
                <span class="title"><?php echo htmlspecialchars($package['name']); ?></span>
                <br>
                <span class="price" style="color: yellow;">
                    <span style="color: white;">Price: </span><?php echo htmlspecialchars($package['price']); ?>
                </span>
                <p class="desc"><?php echo htmlspecialchars($package['description']); ?></p>
                <p class="duration" style="color:lightseagreen;">Duration: <?php echo htmlspecialchars($package['duration']); ?></p>
            </div>
            <div class="right-side d-flex align-items-center" style="flex-direction: column;">
                <h5 style="color: #fff;">Included Products:</h5>
                <div class="prdct mt-2 mb-3">
                    <?php if (!empty($package['products'])): ?>
                    <?php foreach ($package['products'] as $product): ?>
                        <div class="list">                       
                            <span style="color: rgba(156, 163, 175, 1);">
                                <i class="fa-solid fa-square-check" style="color: #f9a939;"></i>&nbsp;
                                <?php echo htmlspecialchars($product['name']); ?> (<span style="color: lightseagreen;"><?php echo htmlspecialchars($product['price']); ?></span>)
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: rgba(156, 163, 175, 1);">No products included.</p>
                <?php endif; ?>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="edit_package.php?package_id=<?php echo $package['id']; ?>" class="bookbtn" style="font-weight: bold; background: green; color: white;">Edit</a>
                    &nbsp;
                    &nbsp;
                    <a href="delete_package.php?package_id=<?php echo $package['id']; ?>" class="bookbtn" style="font-weight: bold; background: red; color: white;" onclick="return confirmDelete();" >Delete</a>
                </div>
                
            </div>
        </div>
    <?php } ?>
</div>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this package?");
}
</script>

