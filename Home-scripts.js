//Hide all sub-menus and show all product cards.
const homeButton = document.getElementsByClassName("home-btn")[0];
homeButton.addEventListener("click", () => 
{
  const submenus = document.querySelectorAll(".sub-menu");
  for (let j = 0; j < submenus.length; j++) 
  {
    submenus[j].style.display = "none";
  }

  const productCards = document.querySelectorAll(".card");
  for (let j = 0; j < productCards.length; j++) 
  {
    productCards[j].style.display = "block";
  }
});

//Hover Cart Icon
  var openCart = document.querySelector("div.open-cart");
  openCart.onclick = function() {
  var shoppingCart = document.querySelector(".shopping-cart");
  if (shoppingCart.style.display == "") 
  {
    shoppingCart.style.display = "block";
  } 
  else if 
  (shoppingCart.style.display == "none")
  {
    shoppingCart.style.display = "block";
  } 
  else 
  {
    shoppingCart.style.display = "none";
  }
};

//Moveable shopping cart page
const shoppingCart = document.querySelector(".shopping-cart");
shoppingCart.addEventListener("mousedown", (event) => 
{
  event.preventDefault();
  const MouseX = event.clientX - shoppingCart.getBoundingClientRect().left;
  const MouseY = event.clientY - shoppingCart.getBoundingClientRect().top;
  const moveAt = (pageX, pageY) => 
  {
    shoppingCart.style.left = pageX - MouseX + "px";
    shoppingCart.style.top = pageY - MouseY  + "px";
  };
  const onMouseMove = (event) => 
  {
    moveAt(event.pageX, event.pageY);
  };
  document.addEventListener("mousemove", onMouseMove);
  shoppingCart.addEventListener("mouseup", () => 
  {
  document.removeEventListener("mousemove", onMouseMove);
  });
});

function handleSubmenuClick(selector) 
{
  const menuItems = document.querySelectorAll(selector);
  for (let i = 0; i < menuItems.length; i++) 
  {
    const item = menuItems[i];
    item.addEventListener("click", (event) => 
    {
      if (event.target.classList.contains("disableNoInventory")) 
      {
        event.preventDefault();
        return;
      }

      event.preventDefault();
      const submenu = event.target.nextElementSibling;
      if (submenu.style.display === "block") 
      {
        submenu.style.display = "none";
      } 
      else
      {
        submenu.style.display = "block";
      }
      event.target.classList.toggle("expanded");
      for (let j = 0; j < menuItems.length; j++) 
      {
        const otherItem = menuItems[j];
        if (otherItem !== item) 
        {
          otherItem.nextElementSibling.style.display = "none";
          otherItem.classList.remove("expanded");
        }
      }
    });
  }
}

function DisableNoStock() 
{
  const getStock = document.querySelectorAll("a[data-stock]");

  for (let i = 0; i < getStock.length; i++) 
  {
    const link = getStock[i];
    const stock = parseInt(link.getAttribute("data-stock"));
    if (stock === 0) 
    {
      link.classList.add("disableNoInventory");
    } 
    else if (stock != 0)
    {
      link.classList.remove("disableNoInventory");
    }
  }
}


DisableNoStock();


// Call the function for each submenu level
handleSubmenuClick(".has-submenu > a");
handleSubmenuClick(".has-submenu-level2 > a");

const submenuItems = document.querySelectorAll(".sub-menu li a");
submenuItems.forEach((item) => 
{
  item.addEventListener("click", (event) => 
  {
    event.preventDefault();
    const searchResults = document.querySelector("#search-results");
    if (searchResults) 
    {
      searchResults.innerHTML = "";
    }

    let cardIds = [];
    if (item.hasAttribute("data-id")) 
    {
      cardIds.push(item.getAttribute("data-id"));
    } 
    else if (item.hasAttribute("data-ids")) 
    {
      cardIds = item.getAttribute("data-ids").split(",");
    }

    const productCards = document.querySelectorAll(".card");
    productCards.forEach((card) => 
    {
      card.style.display = "none";
    });

    cardIds.forEach((id) => 
    {
      const relatedCards = document.querySelectorAll( `.card[data-card-id='${id}']`);
      relatedCards.forEach((card) => 
      {
        card.style.display = "block";
      });
    });
  });
});

const cartCounter = document.createElement("span");
cartCounter.classList.add("cart-counter");
openCart.appendChild(cartCounter);

function updateCartCounter() 
{
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  let totalCount = 0;
  for (let i = 0; i < cart.length; i++) 
  {
    totalCount += cart[i].quantity;
  }
  cartCounter.textContent = totalCount;
}
updateCartCounter();

//The Shopping Cart Conents
function showCartContent() 
{
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  let cartContent = "";
  let totalPrice = 0;
  if (cart.length === 0) 
  {
    cartContent ='<div class="empty-cart">The Shopping Cart Is Currently Empty</div>';
  } 
  else 
  {
    cart.forEach((item) => 
    {
      cartContent += `<div class="product">${item.name} - Quantity: ${item.quantity} <button class="add-quantity" data-id="${item.id}">+</button><button class="subtract-quantity" data-id="${item.id}">-</button><div class="remove-item-container"><button class="remove-item" data-id="${item.id}">Remove</button></div></div>`;
      totalPrice += item.quantity * parseFloat(item.price);
    });
    cartContent += `<div class="total-price">Total Price: $${totalPrice.toFixed(2)}</div><h4>Maximum 20 items per product</h4>`;
  }

  const cartItems = document.querySelector(".shopping-cart .items");
  cartItems.innerHTML = cartContent;
  const viewCartContainer = document.querySelector(".shopping-cart .view-cart-container");
  if (cart.length === 0) 
  {
    viewCartContainer.innerHTML = "";
  } 
  else 
  {
    viewCartContainer.innerHTML =
    '<button class="button-css proceedtoshoppingcart btn-spacing">View Full Cart</button>';
  }

  const clearCartContainer = document.querySelector(".shopping-cart .clear-cart-container");
  if (cart.length === 0) 
  {
    clearCartContainer.innerHTML = "";
  } 
  else 
  {
    clearCartContainer.innerHTML ='<button class="button-css CleanAllProducts">Clear Shopping Cart</button>';
  }

  const checkoutContainer = document.querySelector(".shopping-cart .checkout-container");
  if (cart.length === 0) 
  {
    checkoutContainer.innerHTML = "";
  } 
  else 
  {
    checkoutContainer.innerHTML ='<button class="button-css checkout-button">Checkout</button>';
  }

  attachClearCartButtonEvent();
  SetUpCheckoutButton(totalPrice);

  // Attach event listeners to the remove-item buttons
  const removeItemButtons = document.querySelectorAll(".remove-item");
  removeItemButtons.forEach((button) => 
  {
    button.addEventListener("click", function (event) 
    {
      const cartLocked = localStorage.getItem("cartLocked");
      if (cartLocked === "true") 
      {
        alert("You cannot modify the cart after clicking the checkout button. Please complete your order first.");
        return;
      }
      const itemId = event.target.dataset.id;
      const updatedCart = cart.filter((item) => item.id !== itemId);
      localStorage.setItem("cart", JSON.stringify(updatedCart));
      showCartContent();
    });
  });
}

function SetUpCheckoutButton(totalPrice) 
{
  const checkoutButton = document.querySelector(".shopping-cart .checkout-container .checkout-button");
  checkoutButton.onclick = function() 
  {
    if (totalPrice === 0) 
    {
      alert("Your cart is empty. Please add items to your cart before checking out.");
      return;
    }
    localStorage.setItem("CheckoutbuttonPressed", "true");
    localStorage.setItem("confirmedCart", localStorage.getItem("cart"));
    localStorage.setItem("cartLocked", "true");
    localStorage.setItem("total-price", totalPrice);
    window.location.href = "checkout.html";
  };
}

//Proceed to Shopping Cart
document.addEventListener("click", (event) => 
{
  if (event.target.classList.contains("proceedtoshoppingcart")) 
  {
    window.location.href = "./cart.html";
  }
});

//Clean All the products in the shopping cart
function attachClearCartButtonEvent() 
{
  const clearCartButton = document.querySelector(".CleanAllProducts");
  if (clearCartButton) 
  {
    clearCartButton.addEventListener("click", () => {
      if (localStorage.getItem("cartLocked") === "true") 
      {
        alert("Shopping cart is locked and items cannot be added until order is complete.");
        return;
      }
      localStorage.removeItem("cart");
      updateCartCounter();
      showCartContent();
    });
  }
}

document.addEventListener("click", function(event) 
{
  if (event.target.classList.contains("add-quantity")) 
  {
    const id = event.target.getAttribute("data-id");
    ModifyQuantity(id, 1);
  } 
  else if (event.target.classList.contains("subtract-quantity")) 
  {
    const id = event.target.getAttribute("data-id");
    ModifyQuantity(id, -1);
  }
});

function ModifyQuantity(id, change) 
{
  if (localStorage.getItem("cartLocked") === "true") 
  {
    alert("Shopping cart is locked and items cannot be added until order is complete.");
    return;
  }
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  let ProductUpdated = false;
  for (let i = 0; i < cart.length; i++) 
  {
    if (cart[i].id === id) 
    {
      cart[i].quantity += change;
      if (cart[i].quantity > 20) 
      {
        alert("You cannot add more than 20 items of this product.");
        cart[i].quantity = 20;
      }
      if (cart[i].quantity <= 0) 
      {
        cart.splice(i, 1);
      }
      ProductUpdated = true;
      break;
    }
  }
  if (ProductUpdated === true) 
  {
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCounter();
    showCartContent();
  }
}

showCartContent();

//Add product into shopping cart
function addToCart(product) 
{
  if (localStorage.getItem("cartLocked") === "true") 
  {
    alert("Shopping cart is locked and items cannot be added until order is complete.");
    return;
  }
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  let itemFound = false;
  for (let i = 0; i < cart.length; i++) 
  {
    if (cart[i].id === product.id) 
    {
      cart[i].quantity++;
      itemFound = true;
      break;
    }
  }

  if (!itemFound) {
  product.quantity = 1;
  cart.push(product);
}

  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCounter();
  showCartContent();
  alert("Product has been added to the cart");
}


