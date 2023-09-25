const cartTable = document.getElementById("cart-table").getElementsByTagName("tbody")[0];
const totalPriceElement = document.getElementById("total-price");

//Display the shopping cart
function displayCart() 
{
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  cartTable.innerHTML = "";
  let totalPrice = 0;
  cart.forEach((item) => 
  {
    const row = cartTable.insertRow();
    row.innerHTML = `
      <td><img src="${item.image}" width="50" height="50" /></td>
      <td>${item.name}</td>
      <td>${item.price}</td>
      <td>
        <button class="quantity-btn" data-product-id="${item.id}" data-action="decrement">-</button>
        <input class="quantity" type="number" min="1" max="20" value="${item.quantity}" data-product-id="${item.id}" pattern="\\d+">
        <button class="quantity-btn" data-product-id="${item.id}" data-action="increment">+</button>
        <span class="max-quantity">Max: 20</span>
      </td>
      <td>${(item.price * item.quantity).toFixed(2)}</td>
      <td><button class="delete-item" data-product-id="${item.id}">Delete</button></td>`;
    totalPrice += item.price * item.quantity;
  });
  totalPriceElement.innerText = totalPrice.toFixed(2);

  //if the cart is empty, disable the checkoutbutton
  const checkoutButton = document.getElementById("checkout-button");
  checkoutButton.disabled = cart.length === 0;

  //Delete item
  const deleteButtons = document.querySelectorAll(".delete-item");
  deleteButtons.forEach((button) =>
    button.addEventListener("click", function () 
    {
      const productId = button.getAttribute("data-product-id");
      removeProduct(productId);
    })
  );

  //quantity button
  const quantityButtons = document.querySelectorAll(".quantity-btn");
  quantityButtons.forEach((button) =>
    button.addEventListener("click", function () 
    {
      const productId = button.getAttribute("data-product-id");
      const action = button.getAttribute("data-action");
      updateQuantity(productId, action);
    })
  );

  //quantity input box
  const quantityInputs = document.querySelectorAll(".quantity");
  quantityInputs.forEach((input) =>input.addEventListener("change", function () 
    {
      const productId = input.getAttribute("data-product-id");
      const value = parseInt(input.value);
      if (value > 20) 
      {
        input.value = 20;
        alert("You cannot add more than 20 items of this product.");
      } 
      else if (value < 1) 
      {
        input.value = 1;
      }
      updateQuantity(productId, "manual", input.value);
    })
  );
}

//Function of Remove product
function removeProduct(productId) 
{
  const cartLocked = localStorage.getItem("cartLocked");
  if (cartLocked === "true") 
  {
    alert( "You cannot modify the cart after clicking the checkout button. Please complete your order first.");
    return;
  }
  else
  {
    let cart = JSON.parse(localStorage.getItem("cart"));
    const index = cart.findIndex((item) => item.id === productId);
    //product find to delete
    if (index >= 0) 
    {
      cart.splice(index, 1);
      localStorage.setItem("cart", JSON.stringify(cart));
      displayCart();
    }
  }
}

//function to update the number of products
function updateQuantity(productId, action, manualValue) 
{
  const cartLocked = localStorage.getItem("cartLocked");
  if (cartLocked === "true") 
  {
    alert("You cannot modify the cart after clicking the checkout button. Please complete your order first.");
    return;
  }
  let cart = JSON.parse(localStorage.getItem("cart"));
  const index = cart.findIndex((item) => item.id === productId);
  //Find matching items
  if (index >= 0) 
  {
    //Number up
    if (action === "increment") 
    {
      if (cart[index].quantity < 20) 
      {
        cart[index].quantity++;
      } 
      else 
      {
        alert("You cannot add more than 20 items of this product.");
      }
    }
    //Decline in numbers
    else if (action === "decrement") 
    {
      if (cart[index].quantity > 1) 
      {
        cart[index].quantity--;
      }
    } 
    //Manual input
    else if (action === "manual") 
    {
      cart[index].quantity = manualValue;
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
  }
}
displayCart();

//Clear Cart Button
document.getElementById("clear-cart-button").addEventListener("click", function () 
{
    const cartLocked = localStorage.getItem("cartLocked");
    if (cartLocked === "true")
    {
      alert("You cannot modify the cart after clicking the checkout button. Please complete your order first.");
      return;
    }
    //Remove everything from the shopping cart
    localStorage.removeItem("cart");
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    displayCart();
  });

//Check quantity and input value of Quantity
const quantityInputs = document.querySelectorAll(".quantity");
quantityInputs.forEach((input) =>input.addEventListener("change", function () 
  {
    const productId = input.getAttribute("data-product-id");
    const newQuantity = parseInt(input.value, 10);
    if (newQuantity >= 1 && newQuantity <= 20) 
    {
      updateQuantity(productId, "set", newQuantity);
    } 
    else 
    {
      alert("Please enter a valid quantity (between 1 and 20).");
      displayCart();
    }
  })
);

//Disable shopping cart as checkout
const checkoutButton = document.querySelector("#checkout-button");
checkoutButton.addEventListener("click", function () 
{
  const quantityInputs = document.querySelectorAll(".quantity");
  quantityInputs.forEach(function (input) 
  {
    input.disabled = true;
  });
  //Cart Locked Unable to modify content
  localStorage.setItem("cartLocked", "true"); 
  localStorage.setItem("confirmedCart", localStorage.getItem("cart"));
});

//Disable the input quantity box
document.addEventListener("DOMContentLoaded", function () 
{
  // The button has been pressed
  if (localStorage.getItem("CheckoutbuttonPressed") === "true") 
  {
    // Define a quantityinputs to accept all quantity boxes
    const quantityInputs = document.querySelectorAll(".quantity");
    quantityInputs.forEach(function (input) 
    {
      input.disabled = true; // Make the quantity box unavailable for entry
    });
    // Finally remove the checkoutbuttonpressed to ensure that the quantity box is available the next time it is not clicked
    localStorage.removeItem("CheckoutbuttonPressed");
  }
});
