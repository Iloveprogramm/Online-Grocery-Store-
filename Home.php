<?php
include 'Assignment1DBConnection.php';
?>

<html>
<head>
    <title>Online Grocery shopping</title>
    <link rel="stylesheet" href="Home-styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>

<body>
<div class="header-navbar-container">

    <div class="header">
        <div class="logo">
        <a href="#home">
        <img src="./image/logo.png" alt="Online Grocery shopping">
        <h1>Online Grocery Store</h1>
        </a>
    </div>

<form action="search.php" method="GET" onsubmit="searchProducts(event)">
    <div class="search-box">
            <div class="input-group">
            <input type="text" id="search-input" placeholder="Search">
            </div>
    
            <div class="input-group">
            <input type="number" name="min_price" id="min-price" placeholder="Low Price" min="1" max="15">
            </div>

            <div class="input-group">
            <input type="number" name="max_price" id="max-price" placeholder="High Price" min="1" max="15">
            </div>

            <div class="input-group">
            <input type="text" name="keywords" id="keywords" placeholder="KeyWord">
            </div>

            <div class="input-group">
            <button type="submit" id="search-btn">Search</button>
            <button id="search-btn" onclick="clearSearch()">Clear Search</button>
            </div>
        </div>
</form>
<button class="home-btn">Home</button>
</div>


<ul class="navbar">
    <h2>Product List</h2>
        <!-- First major category: Frozen foods -->
        <li class="has-submenu">
        <a href="#products">Frozen-Food</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="1002" data-items="10">Hamburger Patties</a></li>
            <li class="has-submenu-level2">
            <a href="#" data-items="3" data-ids="1000,1001">Fish Fingers(2)</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="1000" class="submenu-level2">500 Gram</a></li>
            <li><a href="#" data-id="1001" class="submenu-level2">1000 Gram</a></li>
            </ul>
            </li>
            <li><a href="#" data-id="1003" data-items="8">Shell Prawns</a></li>
            <li class="has-submenu-level2">
            <a href="#" data-items="3" data-ids="1004,1005">Tub Ice Cream(2)</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="1004" class="submenu-level2">1 Litre</a></li>
            <li><a href="#" data-id="1005" class="submenu-level2">2 Litre</a></li>
            </ul>
            </li>
            <li><a class="unavailable-item" href="#" data-id="1006" data-items="10" data-stock="0">Pizza</a></li>
            </ul>
        </li>

        <!-- Second major category: Health -->
        <li class="has-submenu">
        <a href="#products">Home-Health</a>
            <ul class="sub-menu">
            <li class="has-submenu-level2">
            <a href="#"   data-items="3" data-ids="2000,2001">Panadol(2)</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="2000" class="submenu-level2">Pack 24</a></li>
            <li><a href="#" data-id="2001" class="submenu-level2">Bottle 50</a></li>
            </ul>
            </li>
            <li><a href="#" data-id="2002" data-items="7">Bath Soap</a></li>
            <li class="has-submenu-level2">
            <a href="#"   data-items="3" data-ids="2003,2004">Garbage Bags(2)</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="2003" class="submenu-level2">Small</a></li>
            <li><a href="#" data-id="2004" class="submenu-level2">Large</a></li>
            </ul>
            </li>
            <li><a href="#" data-id="2005" data-items="3">Washing Power</a></li>
            <li><a href="#" data-id="2006" data-items="3">Laundry Bleach</a></li>
            <li><a class="unavailable-item" href="#" data-id="2007" data-items="10" data-stock="0">Paper Towels</a></li>
            </ul> 
        </li>

        <!-- Third major category: freshing foods -->
        <li class="has-submenu">
        <a href="#products">Fresh-food</a>
            <ul class="sub-menu">
            <li class="has-submenu-level2">
            <a href="#"  data-items="3"  data-ids="3000,3001">Cheddear Cheese(2)</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="3000" class="submenu-level2">500 gram</a></li>
            <li><a href="#" data-id="3001" class="submenu-level2">1000 gram</a></li>
            </ul>
            </li>
            <li><a href="#" data-id="3002" data-items="6">TBone Steak</a></li>
            <li class="has-submenu-level2">
            <a href="#" data-items="3" data-ids="3003,3004,3005,3006,3007">Fruits(5)</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="3003" class="submenu-level2">Navel Oranges - $3.99/bag (20)</a></li>
            <li><a href="#" data-id="3004" class="submenu-level2">Bananas - $1.49/kilo</a></li>
            <li><a href="#" data-id="3005" class="submenu-level2">Peaches - $2.99/kilo</a></li>
            <li><a href="#" data-id="3006" class="submenu-level2">Grapes - $3.5/kilo</a></li>
            <li><a href="#" data-id="3007" class="submenu-level2">Apples - $1.99/kilo</a></li>
            </ul>
            <li><a class="unavailable-item" href="#" data-id="3008" data-items="10" data-stock="0">Vegetables</a></li>
            </li>
            </ul>
        </li>

        <!-- Fourth major category: beverages -->
        <li class="has-submenu">
        <a href="#products">Beverages</a>
            <ul class="sub-menu">
            <li class="has-submenu-level2">
            <a href="#" data-items="3" data-ids="4000,4001,4002">Earl Crey Tea Bags(3)</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="4000" class="submenu-level2">Pack 25</a></li>
            <li><a href="#" data-id="4001" class="submenu-level2">Pack 100</a></li>
            <li><a href="#" data-id="4002" class="submenu-level2">Pack 200</a></li>
            </ul>
            </li>
            <li class="has-submenu-level2">
            <a href="#" data-items="3"  data-ids="4003,4004">Instant Coffee(2)</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="4003" class="submenu-level2">200 gram</a></li>
            <li><a href="#" data-id="4004" class="submenu-level2">500 gram</a></li>
            </ul>
            </li>
            <li><a href="#" data-id="4005" data-items="3">Chocolate Bar</a></li>
            <li><a class="unavailable-item" href="#" data-id="4006" data-items="10" data-stock="0">Chamomile Tea Bags</a></li>
            </ul>
        </li>

        <!-- Five major category: Dog food -->
        <li class="has-submenu">
        <a href="#products">Pet-Food</a>
            <ul class="sub-menu">
            <li class="has-submenu-level2">
            <a href="#" data-items="3"  data-ids="5000,5001">Dry Dog Food(2)</a>
            <ul class="sub-menu">
            <li><a href="#" data-id="5000" class="submenu-level2">5 kg Pack</a></li>
            <li><a href="#" data-id="5001" class="submenu-level2">1 kg Pack</a></li>
            </ul>
            </li>
            <li><a href="#" data-id="5002" data-items="4">Bird Food</a></li>
            <li><a href="#" data-id="5003" data-items="2">Cat Food</a></li>
            <li><a href="#" data-id="5004" data-items="2">Fish Food</a></li>
            <li><a class="unavailable-item" href="#" data-id="5005" data-items="10" data-stock="0">Hamster food</a></li>
            </ul>
        </li>
</ul>

<div>
<div class="open-cart">
    <img src="./image/cart.png" alt="Cart" class="cart-icon">
</div>

<div class="main-content">
<div id="search-results" class="cards-container">
    </div>
    <div class="shopping-cart">
<h3>Shopping Cart</h3>
<div class="items"></div>
<div class="button-container">
    <div class="checkout-container"></div>
    <div class="clear-cart-container"></div>
    <div class="view-cart-container"></div>
</div>
</div>

<div class="cards-container" id="product-list">

<?php
    $sql = "SELECT product_id, product_name, unit_price, unit_quantity, in_stock FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='card' data-card-id='" . $row["product_id"] . "' onclick='showCardBack(this)'>";
            echo '<img src="./image/' . $row["product_id"] . '.png" alt="' . $row["product_name"] . '">';
            echo "<div class='card-container'>";
            echo "<h3><b>Prodcut Id:" .$row["product_id"] . "</b></h3>";
            echo "<h3><b>Product Name:".$row["product_name"]."</b></h3>";
            echo "<h3><b>Unit Prices：" . $row["unit_price"] . "$</b></h3>";
            echo "<h3><b>Unit Quantity：" . $row["unit_quantity"] . "</b></h3>";
            echo "<h3><b>In Stock：" . $row["in_stock"] . "</b></h3>";
            $status = $row["in_stock"] > 0 ? "In stock" : "Out of stock";
            echo "<h3><b>Status：".$status."</b></h3>";
            echo '<h3><a href="product-details.php?product_id=' . $row["product_id"] . '">See More Details</a></h3>'; 
            $disabled = $row["in_stock"] > 0 ? "" : "disabled";
            $disabledClass = $row["in_stock"] > 0 ? "" : "disabled-btn";
            echo "<button class=\"addtocart $disabledClass\" $disabled onclick=\"addToCart({ id: '" . $row["product_id"] . "', name: '" . $row["product_name"] . "', price: '" . $row["unit_price"] . "', image: './image/" . $row["product_id"] . ".png' })\">Add</button>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "0 Result";
    }
    $conn->close();
?>

</div>
    <div class="footer-message">End of Page</div>
</div>

<script type="text/javascript" src="Home-scripts.js"></script>

<script>
let originalProductList = "";

$(document).ready(function () 
{
    originalProductList = $("#product-list").html();
});


function searchProducts(event) 
{
    event.preventDefault();
    // Get search parameters from the form
    let search = $("#search-input").val();
    let min_price = $("#min-price").val();
    let max_price = $("#max-price").val();
    let keywords = $("#keywords").val();
    // Call search.php with AJAX
    $.get("search.php", 
    {
        search: search,
        min_price: min_price,
        max_price: max_price,
        keywords: keywords
    }, function (data) 
    {
        if (data.trim() !== "") 
        {
            $("#product-list").html(data);
        } 
        else 
        {
            $("#product-list").html(originalProductList);
        }
    });
}

function clearSearch() 
{
    $("#search-input").val("");
    $("#min-price").val("");
    $("#max-price").val("");
    $("#keywords").val("");
    $("#product-list").html(originalProductList);
}

</script>
</body>
</html>
