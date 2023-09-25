<html lang="en">
<head>
    <title>Order Confirmation Page</title>
    <link rel="stylesheet" href="orderconfirmation.css">
    <link rel="stylesheet" href="HeaderAndFooter.css" />
</head>
<body>
    <div class="header">
        <a href="#home">
            <img src="./image/logo.png" alt="Online Grocery shopping">
            <h1>Online Grocery Store</h1>
        </a>
    </div>
    <div class="container">
        <h1>Order Confirmation</h1>
        <strong><span id="greeting" class="CustomerName"></span></strong>
        <strong><p>A Confirmation Email is Send to Your Email</p></strong>
        <p>We appreciate you buying from us! The submission of your order was successful. Please check the email we just gave you with the order details. </p>
        <div class="order-summary">
    <h2>Order Summary</h2>
    <table>
        <tr>
            <td><strong>Order Number：</strong></td>
            <td id="OrderNumber"></td>
        </tr>
        <tr>
            <td><strong>Date of purchase：</strong></td>
            <td id="DateOfPurchase"></td>
        </tr>
        <tr>
            <td><strong>Total Cost：</strong></td>
            <td id="ProductTotalPrice"></td>
        </tr>
        <tr>
            <td><strong>Payment method：</strong></td>
            <td>Credit Cards</td>
        </tr>
    </table>

    <table id="ProductSingleCostTable">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Single Item Cost</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
        <button class="continue-btn" id="BackToHomePage">Continue shopping</button>
    </div>


<script>
  //Continnue Shopping scripts
  document.getElementById("BackToHomePage").addEventListener("click", function () 
  {
  localStorage.removeItem("confirmed-total-price");
  localStorage.removeItem("cartLocked");
  window.location.href = "Home.php";
});

  //Generate Order Number scripts
  function GenerateRandomNumber() 
  {
      let orderNumber = "";
      for (let j = 0; j < 6; j++) 
      {
          orderNumber += Math.floor(Math.random()* 6);
      }
    return orderNumber;
  }
    document.getElementById("OrderNumber").innerText = GenerateRandomNumber();

  //Get the Date of Purchase
  function GenearatePurchaseDate() 
  {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }
    document.getElementById("DateOfPurchase").innerText = GenearatePurchaseDate();
    document.getElementById("ProductTotalPrice").innerText = `$${(parseFloat(localStorage.getItem("confirmed-total-price")) || 0).toFixed(2)}`;
  
  //Display the single cost
  function GenearateProductSingleCosts() 
  {
  const cart = JSON.parse(localStorage.getItem("confirmedCart")) || [];
  const itemCostsTableBody = document.getElementById("ProductSingleCostTable").getElementsByTagName("tbody")[0];
  itemCostsTableBody.innerHTML = "";
  cart.forEach((item) =>
  {
    const row = itemCostsTableBody.insertRow();
    row.innerHTML = `
    <td><strong>${item.productName || item.name}</strong></td>
    <td>$${parseFloat(item.price)}</td>
    `;
  });
}
GenearateProductSingleCosts();

// Display the customer's name in the greeting
function displayCustomerName() {
  const firstName = localStorage.getItem("customerFirstName");
  const greetingElement = document.getElementById("greeting");
  if (firstName) {
    greetingElement.innerHTML = `Dear ${firstName}<br>` + greetingElement.innerHTML;
  }
}
displayCustomerName();
</script>

<footer>
<p>&copy; 2023 UTS Online Grocery Shopping. All Rights Reserved. Created by Chenjun Zheng  Student Number: 14208603</p>
</footer>
</body>
</html>