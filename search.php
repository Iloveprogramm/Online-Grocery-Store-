<?php
include 'Assignment1DBConnection.php';
?>

<?php

$style = "
.disabled-btn {
    background-color: #cccccc;
    cursor: not-allowed;
    opacity: 0.5;
}
";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 0;
$keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';

$sql = "SELECT product_id, product_name, unit_price, unit_quantity, in_stock FROM products WHERE product_name LIKE ?";

if ($min_price > 0) { //Prevent sql injection attack
    $sql .= " AND unit_price >= " . $min_price;
}

if ($max_price > 0) {
    $sql .= " AND unit_price <= " . $max_price;
}

if ($keywords > 0) {
    $sql .= " AND (";
    $keywords_array = explode(' ', $keywords);
    for ($key = 0; $key < count($keywords_array); $key++) {
        if ($key > 0) {
            $sql .= " OR ";
        }
        $sql .= " product_name LIKE '%" . $keywords_array[$key] . "%'";
    }
    $sql .= ")";
}

$info = $conn->prepare($sql);
$search_param = '%' . $search . '%';
// Connect SQL query placeholders to search parameters.
$info->bind_param("s", $search_param);
$info->execute();
$result = $info->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card' data-card-id='" . $row["product_id"] . "' onclick='showCardBack(this)'>";
        echo '<img src="./image/' . $row["product_id"] . '.png" alt="' . $row["product_name"] . '">';
        echo "<div class='card-container'>";
        echo "<h4><b>Prodcut Id:" . $row["product_id"] . "</b></h4>";
        echo "<h4><b>Product Name:" . $row["product_name"] . "</b></h4>";
        echo "<h4><b>Unit Prices：" . $row["unit_price"] . "$</b></h4>";
        echo "<h4><b>Unit Quantity：" . $row["unit_quantity"] . "</b></h4>";
        echo "<h3><b>In Stock：" . $row["in_stock"] . "</b></h3>";
        $status = $row["in_stock"] > 0 ? "In stock" : "Out of stock";
        echo "<h3><b>Status：".$status."</b></h3>";
        echo '<h1><a href="product-details.php?product_id=' . $row["product_id"] . '">See More Details</a></h1>';
        $disabled = $row["in_stock"] > 0 ? "" : "disabled";
        $disabledClass = $row["in_stock"] > 0 ? "" : "disabled-btn";
        echo "<button class=\"button-css $disabledClass\" $disabled onclick=\"addToCart({ id: '" . $row["product_id"] . "', name: '" . $row["product_name"] . "', price: '" . $row["unit_price"] . "', image: './image/" . $row["product_id"] . ".png' })\">Add</button>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<div class='no-results'><h3>The database did not contain the product you were looking for.</h3></div>";
}
$conn->close();
?>
