<?php
include('../connection.php');

// Fetch products data from the database
$query = "SELECT p.product_id, p.product_name, p.description, p.price, p.quantity, p.image, c.category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.category_id";
$result = $conn->query($query);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => $row['product_id'],
            'name' => $row['product_name'],
            'price' => '₱' . number_format($row['price'], 2),
            'description' => $row['description'],
            'quantity' => $row['quantity'],
            'image' => $row['image'],
            'category' => $row['category_name'] // Fetch the category name
        ];
    }
}
?>

<style>
.container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    justify-content: center;
}

.pcard {
    width: 300px; /* Fixed width for all cards */
    height: 450px; /* Fixed height for all cards */
    display: flex;
    flex-direction: column;
    border-radius: 0.5rem;
    background-color: rgba(17, 24, 39, 1);
    box-shadow: 2px 2px 7px black;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.pcard .left-side {
    flex: 1;
}

.pcard img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.title {
    font-size: 1.5rem;
    line-height: 2rem;
    font-weight: 700;
    color: #fff;
}

.category {
    font-size: 1rem;
    line-height: 1.5rem;
    font-weight: bold;
    color: #00FF9C;
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

.quantity {
    margin-top: 0.5rem;
    color: lightseagreen;
}

.bookbtn {
    color: black;
    border-radius: 5px;
    background: rgba(167, 139, 250, 1);
    padding: 10px 15px;
    transition: 0.5s ease;
    font-weight: bold;
    align-self: center; /* Center button */
}

.bookbtn:hover {
    background: #27005D;
}

@media (max-width: 768px) {
    .pcard {
        width: 100%; /* Full width on small screens */
        height: auto; /* Dynamic height on small screens */
    }

    .title {
        font-size: 1.25rem;
    }

    .price, .desc, .quantity, .category {
        font-size: 0.9rem;
    }

    .bookbtn {
        width: 100%; /* Full width button on small screens */
    }
}
</style>

<div class="container">
    <?php foreach ($products as $product) { ?>
        <div class="pcard" data-category="<?php echo htmlspecialchars($product['category']); ?>">
            <div class="left-side">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <span class="title"><?php echo htmlspecialchars($product['name']); ?></span>
                <br>
                <span class="category">
                    <?php echo htmlspecialchars($product['category']); ?>
                </span>
                <br>
                <br>
                <span class="price" style="color: yellow;">
                    <span style="color: white;">Price: </span><?php echo htmlspecialchars($product['price']); ?>
                </span>
                <p class="desc"><?php echo htmlspecialchars($product['description']); ?></p>
                <p class="quantity">Quantity: <?php echo htmlspecialchars($product['quantity']); ?></p>
            </div>
            <a href="edit_product?product_id=<?php echo $product['id']; ?>" class="bookbtn" style="background: #7C00FE; color: white; box-shadow: 1px 1px 7px black;">Edit Product</a>
        </div>
    <?php } ?>
</div>
