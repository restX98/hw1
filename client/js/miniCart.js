class MiniCart {
  constructor() {
    this.miniCart = document.querySelector("header .cart");

    this.initEventHandlers();
  }

  updateMiniCart(e) {
    const { quantity } = e.detail;
    this.miniCart.dataset.quantity = quantity;
  }

  initEventHandlers() {
    window.addEventListener("cart:updateMiniCart", (e) =>
      this.updateMiniCart(e)
    );
  }
}

const miniCart = new MiniCart();
