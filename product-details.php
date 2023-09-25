<?php
    include 'Assignment1DBConnection.php';
?>

<html lang="en">
<head>
    <title>Product Details Page</title>
    <link rel="stylesheet" href="ProductDetails-styles.css">
    <link rel="stylesheet" href="HeaderAndFooter.css">
    <script type="text/javascript" src="Home-scripts.js"></script>
    <script>
        //Add product to shopping cart in product detail page
        function addToCart(product) 
        {
            //if the cart is locked(checkout button is pressed), then stop add product into the cart
            if (localStorage.getItem("cartLocked") === "true") {
                alert("Shopping cart is locked and items cannot be added until order is complete.");
                return;
            }
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            const num = cart.findIndex((item) => item.id === product.id);
            if (num >= 0) 
            {
                cart[num].quantity++;
            } 
            else if (num === -1)
            {
                product.quantity = 1;
                cart.push(product);
            }
            localStorage.setItem("cart", JSON.stringify(cart));
            alert("The product has been added to the shopping cart.");
            window.location.href = "Home.php";
        }
    </script>
</head>
<body>
    <div class="header">
        <a href="#home">
            <img src="./image/logo.png" alt="Online Grocery shopping" />
            <h1>Online Grocery Store</h1>
        </a>
    </div>
    <a class="ProductDetailBtn" href="Home.php">Back to Home page</a>

    <?php
        if (isset($_GET['product_id'])) 
        {
            $product_id = $_GET['product_id'];
            $sql = "SELECT product_id, product_name, unit_price, unit_quantity, in_stock FROM products WHERE product_id = ?";
            $info = $conn->prepare($sql);
            $info->bind_param('i', $product_id);
            $info->execute();
            $result = $info->get_result();

            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();
                echo "<div class='product-details'>";
                echo "<div><img src='./image/" . $row["product_id"] . ".png' alt='" . $row["product_name"] . "'></div>";
                echo "<div class='product-info'>";
                echo "<h2>" . $row["product_name"] . "</h2>";
                echo "<p>Product ID: " . $row["product_id"] . "</p>";
                echo "<p>Unit Price: " . $row["unit_price"] . "$</p>";
                echo "<p>Unit Quantity: " . $row["unit_quantity"] . "</p>";
                echo "<p>In Stock：" . $row["in_stock"] . "</p>";
                $status = $row["in_stock"] > 0 ? "In stock" : "Out of stock";
                echo "<p>Status：".$status."</p>";
                $disabled = $row["in_stock"] > 0 ? "" : "disabled";
                $disabledClass = $row["in_stock"] > 0 ? "" : "disabled-btn";
                echo "<button class=\"ProductDetailBtn $disabledClass\" $disabled onclick=\"addToCart({ id: '" . $row["product_id"] . "', name: '" . $row["product_name"] . "', price: '" . $row["unit_price"] . "', image: './image/" . $row["product_id"] . ".png' })\">Add</button>";
                echo "</div>";
                echo "</div>";

                echo "<div class='Product-Description'>";
                echo "<h3>Return</h3>";
                echo "<p>If there is a problem, our company will provide you a complete refund.</p>";
                echo "<h3>Expiry date</h3>";
                echo "<p>Please be aware that each product has a different expiration date, which is printed on the back of the products.</p>";
                echo "<h3>Storing food</h3>";
                echo "<p>To keep your food's flavour, stay away from situations that are too hot, muggy, or chilly.</p>";
                echo "<h3>Product Description</h3>";
                echo "<p>The product is made of high-quality materials and designed for frequent use. It's a valuable addition to your shopping list and a requirement for your home.</p>";
                echo "<h3>Shipping & Returns</h3>";
                echo "<p>Shipping is free on orders of $50 or more.</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
        } else {
            echo "<p>Product not found.</p>";
        }
        $conn->close();
    } else {
        echo "<p>Invalid product ID.</p>";
    }
    ?>
    <footer>
    <p>&copy; 2023 UTS Online Grocery Shopping. All Rights Reserved. Created by Chenjun Zheng  Student Number: 14208603</p>
    </footer>
</body>
</html>