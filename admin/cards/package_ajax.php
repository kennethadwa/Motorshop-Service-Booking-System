<style>
	.pcard {
    margin-left: -1rem;
    margin-right: -1rem;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    margin-bottom: 2rem;
    width: 320px;
    display: flex;
    flex-direction: column;
    border-radius: 0.5rem;
    background-color: rgba(17, 24, 39, 1);
    padding: 1.5rem;
}

.pcard .headers {
    display: flex;
    flex-direction: column;
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

.lists {
    margin-bottom: 1.5rem;
    flex: 1 1 0%;
    color: rgba(156, 163, 175, 1);
}

.lists .list {
    margin-bottom: 0.5rem;
    display: flex;
    margin-left: 0.5rem;
}

.lists .list svg {
    height: 1.5rem;
    width: 1.5rem;
    flex-shrink: 0;
    margin-right: 0.5rem;
    color: rgba(167, 139, 250, 1);
}

.action {
    border: none;
    outline: none;
    display: inline-block;
    border-radius: 0.25rem;
    background-color: rgba(167, 139, 250, 1);
    padding-left: 1.25rem;
    padding-right: 1.25rem;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    text-align: center;
    font-weight: 600;
    letter-spacing: 0.05em;
    color: rgba(17, 24, 39, 1);
}

</style>

<?php
include('../connection.php');

// Fetch packages data from the database
$query = "SELECT package_name, price, description FROM packages"; 
$result = $conn->query($query);

$packages = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages[] = [
            'name' => $row['package_name'],
            'price' => '$' . number_format($row['price'], 2),
            'description' => $row['description']
        ];
    }
}

// Loop through each package to create individual cards
foreach ($packages as $package) {
    ?>
    <div class="pcard">
        <div class="headers">
            <span class="title"><?php echo htmlspecialchars($package['name']); ?></span>
            <span class="price" style="color: yellow; margin-top: 10px;"><?php echo htmlspecialchars($package['price']); ?></span>
        </div>
        <p class="desc"><?php echo htmlspecialchars($package['description']); ?></p>
        <ul class="lists">
            <li class="list">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span><?php echo htmlspecialchars($package['name']); ?></span>
            </li>
        </ul>
        <a href="" class="btn" style="background: orange; color: white;">Edit</a>
    </div>
    <?php
}
?>
