class Product {
  constructor(productElement, manager) {
    this.cod = productElement.dataset.product;
    this.name = productElement.dataset.name;
    this.price = productElement.dataset.price;
    this.category = productElement.dataset.category;

    this.addToCartButton = productElement.querySelector(".add-to-cart");
    this.removeFromCartButton =
      productElement.querySelector(".remove-from-cart");
    // this.addToWishlistButton = null;

    this.manager = manager;

    this.initEventHandlers();
  }

  handleAddToCart() {
    this.manager.clearErrors();

    fetch("/hw1/api/addToCart-api.php", {
      method: "POST",
      body: JSON.stringify({ cod: this.cod }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.success) {
          const updateMiniCartEvent = new CustomEvent("cart:updateMiniCart", {
            detail: {
              quantity: response.totalQuantity,
            },
          });

          window.dispatchEvent(updateMiniCartEvent);
        } else {
          this.manager.displayError("Ops, qualcosa è andato storto.");
        }
      })
      .catch(() => {
        this.manager.displayError("Ops, qualcosa è andato storto.");
      });
  }

  handleRemoveFromCart() {
    this.manager.clearErrors();

    fetch("/hw1/api/removeFromCart-api.php", {
      method: "POST",
      body: JSON.stringify({ cod: this.cod }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.success) {
          const updateMiniCartEvent = new CustomEvent("cart:updateCart", {
            detail: {
              totalQuantity: response.totalQuantity,
              totalPrice: response.totalPrice,
              items: response.items,
            },
          });

          window.dispatchEvent(updateMiniCartEvent);
        } else {
          this.manager.displayError("Ops, qualcosa è andato storto.");
        }
      })
      .catch(() => {
        this.manager.displayError("Ops, qualcosa è andato storto.");
      });
  }

  /* handleAddToWishlist() {
    fetch("/api/addToWishlist-api.php", {
      method: "POST",
      body: JSON.stringify({ url: this.url }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (response.ok) {
          console.log(
            "Prodotto aggiunto alla lista dei desideri con successo."
          );
        } else {
          console.error(
            "Errore durante l'aggiunta del prodotto alla lista dei desideri."
          );
        }
      })
      .catch((error) => {
        console.error(
          "Si è verificato un errore durante la chiamata Fetch:",
          error
        );
      }); 
  }*/

  initEventHandlers() {
    if (this.addToCartButton) {
      this.addToCartButton.addEventListener("click", () =>
        this.handleAddToCart()
      );
    }
    if (this.removeFromCartButton) {
      this.removeFromCartButton.addEventListener("click", () =>
        this.handleRemoveFromCart()
      );
    }

    /* if (this.addToWishlistButton) {
      this.addToWishlistButton.addEventListener(
        "click",
        this.handleAddToWishlist.bind(this)
      );
    } */
  }
}

class ProductPageManager {
  constructor() {
    this.products = [];

    this.errorContainer = document.getElementById("server-error");

    this.buildProduct();

    this.initEventHandlers();
  }

  initEventHandlers() {
    window.addEventListener(
      "product:buildProduct",
      this.buildProduct.bind(this)
    );
  }

  buildProduct() {
    this.products = [];
    const productElements = document.querySelectorAll("[data-product]");
    for (let i = 0; i < productElements.length; i++) {
      const product = new Product(productElements[i], this);
      this.products.push(product);
    }
  }

  displayError(message, element = this.errorContainer) {
    element.textContent = message;
  }

  clearErrors(element = this.errorContainer) {
    element.textContent = "";
  }
}

const productPageManager = new ProductPageManager();
