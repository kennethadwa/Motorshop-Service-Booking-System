<?php
include('../connection.php');

// Fetch categories data from the database
$query = "SELECT category_id, category_name FROM categories";
$result = $conn->query($query);

$categories = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = [
            'id' => $row['category_id'],
            'name' => $row['category_name']
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
    width: 300px;
    height: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    border-radius: 0.5rem;
    background-color: rgba(17, 24, 39, 1);
    box-shadow: 2px 2px 7px black;
    margin-bottom: 1.5rem;
    text-align: center;
}

.title {
    font-size: 1.8rem;
    line-height: 1.8rem; 
    font-weight: 700;
    color: #fff;
    margin: 0; 
}

.edit-btn,
.delete-btn {
    color: white;
    border-radius: 5px;
    padding: 8px 10px;
    transition: 0.5s ease;
    font-weight: bold;
    margin-top: 10px;
    width: 100%;
}

.edit-btn {
    background: #28a745;
    width: auto;
}

.delete-btn {
    background: #dc3545; /* Red for delete button */
}

.edit-btn:hover {
    background: #218838; /* Darker green on hover */
}

.delete-btn:hover {
    background: #c82333; /* Darker red on hover */
}

@media (max-width: 768px) {
    .pcard {
        width: 100%; /* Full width on small screens */
    }

    .title {
        font-size: 1.25rem;
    }
}
</style>

<div class="container">
    <?php foreach ($categories as $category) { ?>
        <div class="pcard">
            <span class="title"><?php echo htmlspecialchars($category['name']); ?></span>
            <div style="display: flex; justify-content: center; margin-top: 10px;">
                <a href="edit_category?id=<?php echo $category['id']; ?>" class="edit-btn">Edit</a>
                <form action="delete_category.php" method="POST" style="margin-left: 10px;" onsubmit="return confirmDelete();">
                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this category?");
}
</script>
