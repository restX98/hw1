class Cart {
  constructor() {
    this.totalQuantityElement = document.querySelector(".total-quantity");
    this.totalPriceElement = document.querySelector(".total-price");
    this.totalPriceElement = document.querySelector(".continue-button");

    this.cartItemsContainer = document.querySelector(".items ul");

    this.initEventHandlers();
  }

  updateCart(e) {
    const { totalQuantity, totalPrice, items } = e.detail;

    this.updateSummary(totalQuantity, totalPrice);
    this.updateItemsList(items);
  }

  initEventHandlers() {
    window.addEventListener("cart:updateCart", (e) => this.updateCart(e));
  }

  updateSummary(totalQuantity, totalPrice) {
    this.totalQuantityElement.textContent = totalQuantity;
    this.totalPriceElement.textContent = `€ ${totalPrice}`;
    this.totalPriceElement.setAttribute("disabled", totalPrice === 0);
  }

  updateItemsList(items) {
    const itemsContainer = document.querySelector(".items ul");

    itemsContainer.innerHTML = "";

    items.forEach((item) => this.createItem(item));

    const updateMiniCartEvent = new CustomEvent("product:buildProduct");
    window.dispatchEvent(updateMiniCartEvent);
  }

  createItem(item) {
    const { cod, name, price, category, quantity } = item;

    const listItem = document.createElement("li");
    listItem.classList.add("product");
    listItem.setAttribute("data-product", cod);
    listItem.setAttribute("data-name", name);
    listItem.setAttribute("data-price", price);
    listItem.setAttribute("data-category", category);

    const productImage = document.createElement("img");
    productImage.classList.add("product-image");
    productImage.src = `https://picsum.photos/id/3/600`;
    productImage.alt = name;
    listItem.appendChild(productImage);

    const productDetails = document.createElement("div");
    productDetails.classList.add("product-details");
    listItem.appendChild(productDetails);

    const productName = document.createElement("h3");
    productName.textContent = name;
    productDetails.appendChild(productName);

    const productPrice = document.createElement("p");
    productPrice.innerHTML = `Prezzo: € <span class="price">${price}</span> x <span class="quantity">${quantity}</span>`;
    productDetails.appendChild(productPrice);

    const removeButton = document.createElement("button");
    removeButton.classList.add("remove-from-cart");
    listItem.appendChild(removeButton);

    const removeIcon = document.createElement("img");
    removeIcon.src = "/hw1/client/icons/remove.svg";
    removeIcon.alt = "Logout Icon";
    removeButton.appendChild(removeIcon);

    this.cartItemsContainer.appendChild(listItem);
  }
}

const cart = new Cart();
