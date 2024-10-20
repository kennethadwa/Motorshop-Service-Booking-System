<style>
.container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem; /* Gap between cards */
    justify-content: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 2rem; /* Add padding around the container */
}

.pcard {
    flex: 1 1 300px; /* Allow cards to grow and shrink, with a minimum width of 300px */
    max-width: 600px; /* Adjust width for landscape */
    display: flex;
    border-radius: 0.75rem;
    background-color: #ffffff; /* Changed to a light background */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Softer shadow for a more elegant look */
    padding: 2rem; /* Increased padding for a more spacious feel */
    margin-bottom: 2rem; 
    transition: transform 0.3s; /* Add transition for hover effect */
}

.pcard:hover {
    transform: translateY(-5px); /* Slight lift on hover for interactivity */
}

.pcard .left-side {
    flex: 1; /* Takes remaining space */
    padding-right: 1.5rem; /* Space between left and right side */
}

.pcard .right-side {
    width: 200px; /* Fixed width for products */
}

.title {
    font-size: 1.75rem; /* Increased font size for better prominence */
    line-height: 2rem;
    font-weight: 700;
    color: #333; /* Darker color for better readability */
}

.price {
    font-size: 1.25rem; /* Increased font size for better visibility */
    font-weight: 700;
    color: #007BFF; /* Blue color for prices */
}

.desc {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    line-height: 1.625;
    color: #555; /* Slightly darker gray for better contrast */
}

.duration {
    margin-top: 0.5rem;
    line-height: 1.625;
    color: #007BFF; /* Blue color for duration */
}

.lists {
    margin-bottom: 1.5rem;
    color: #555; /* Use dark gray for consistency */
}

.lists .list {
    margin-bottom: 0.5rem;
    display: flex;
    margin-left: 0.5rem;
}

.bookbtn {
    color: #fff; 
    border-radius: 5px; 
    background: #007BFF; /* Blue color for button */
    padding: 12px 20px; 
    font-weight: bold; /* Bold text for emphasis */
    text-align: center; /* Center text */
    text-decoration: none; /* Remove underline */
    transition: background 0.3s ease;
}

.bookbtn:hover {
    background: #0056b3; /* Darker blue on hover */
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
        font-size: 1.5rem; /* Adjust title size for smaller screens */
    }

    .price, .desc, .duration {
        font-size: 1rem; /* Consistent font size for readability */
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
                <br><br>
                <span class="price">
                    <span style="color: #333;">Price: </span><?php echo htmlspecialchars($package['price']); ?>
                </span>
                <br><br>
                <p class="desc"><?php echo htmlspecialchars($package['description']); ?></p>
                <br><br>
                <p class="duration" style="font-weight: bold; font-size: 16px;">Duration: <?php echo htmlspecialchars($package['duration']); ?></p>
            </div>
            <div class="right-side d-flex align-items-center" style="flex-direction: column;">
                <h5 style="color: #333;">Included Products:</h5>
                <div class="prdct mt-2 mb-3">
                    <?php if (!empty($package['products'])): ?>
                    <?php foreach ($package['products'] as $product): ?>
                        <div class="list">                       
                            <span style="color: #555;">
                                <i class="fa-solid fa-square-check" style="color: #007BFF;"></i>&nbsp;
                                <?php echo htmlspecialchars($product['name']); ?> (<span style="color: #007BFF;"><?php echo htmlspecialchars($product['price']); ?></span>)
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #555;">No products included.</p>
                <?php endif; ?>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <a href="request_booking" class="bookbtn">Book Now</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
