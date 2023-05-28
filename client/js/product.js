class Product {
  constructor(productElement) {
    this.cod = productElement.dataset.product;
    this.name = productElement.dataset.name;
    this.price = productElement.dataset.price;
    this.category = productElement.dataset.category;

    this.addToCartButton = productElement.querySelector(".add-button");
    // this.addToWishlistButton = null;

    this.initEventHandlers();
  }

  handleAddToCart() {
    fetch("/api/addToCart-api.php", {
      method: "POST",
      body: JSON.stringify({ cod: this.cod }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (response.ok) {
          console.log("Prodotto aggiunto al carrello con successo.");
        } else {
          console.error("Errore durante l'aggiunta del prodotto al carrello.");
        }
      })
      .catch((error) => {
        console.error(
          "Si è verificato un errore durante la chiamata Fetch:",
          error
        );
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
      this.addToCartButton.addEventListener("click", this.handleAddToCart);
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
    this.productContainer = document.getElementById("search");
    this.products = [];

    const productElements =
      this.productContainer.querySelectorAll("[data-product]");
    for (let i = 0; i < productElements.length; i++) {
      const product = new Product(productElements[i]);
      this.products.push(product);
    }
  }
}

const productPageManager = new ProductPageManager();
