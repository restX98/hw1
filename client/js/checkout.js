class Checkout {
  constructor() {
    this.form = document.querySelector(".address-form");

    this.streetInput = document.getElementById("street-input");
    this.houseNumberInput = document.getElementById("houseNumber-input");
    this.postalCodeInput = document.getElementById("postalCode-input");
    this.cityInput = document.getElementById("city-input");
    this.provinceInput = document.getElementById("province-input");
    this.countryInput = document.getElementById("country-input");

    this.streetError = document.getElementById("street-error");
    this.houseNumberError = document.getElementById("houseNumber-error");
    this.postalCodeError = document.getElementById("postalCode-error");
    this.cityError = document.getElementById("city-error");
    this.provinceError = document.getElementById("province-error");
    this.countryError = document.getElementById("country-error");

    this.form.addEventListener("submit", (e) => this.handleSubmit(e));
  }

  handleSubmit(event) {
    event.preventDefault();

    if (!this.validateFields()) {
      return;
    }

    const street = this.streetInput.value.trim();
    const houseNumber = this.houseNumberInput.value.trim();
    const postalCode = this.postalCodeInput.value.trim();
    const city = this.cityInput.value.trim();
    const province = this.provinceInput.value.trim();
    const country = this.countryInput.value.trim();

    fetch("/hw1/api/placeOrder-api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        street,
        houseNumber,
        postalCode,
        city,
        province,
        country,
      }),
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.success) {
          window.location.href = "/hw1/home";
        } else {
          if (response.errorFields) {
            const errorFields = response.errorFields;
            for (const fieldName in errorFields) {
              const errorMessage = errorFields[fieldName];
              const input = document.querySelector(
                `input[name="${fieldName}"]`
              );
              this.displayError(input.nextElementSibling, errorMessage);
            }
          } else {
            this.displayError(
              this.serverError,
              "Ops, qualcosa è andato storto."
            );
          }
        }
      })
      .catch(() => {
        this.displayError(this.serverError, "Ops, qualcosa è andato storto.");
      });
  }

  validateFields() {
    const streetInput = this.streetInput.value.trim();
    const houseNumberInput = this.houseNumberInput.value.trim();
    const postalCodeInput = this.postalCodeInput.value.trim();
    const cityInput = this.cityInput.value.trim();
    const provinceInput = this.provinceInput.value.trim();
    const countryInput = this.countryInput.value.trim();

    let isValid = true;

    this.clearErrors();

    if (streetInput === "") {
      this.displayError(this.streetError, "Inserisci una via");
      isValid = false;
    }

    if (houseNumberInput === "") {
      this.displayError(this.houseNumberError, "Inserisci un numero civico");
      isValid = false;
    } else if (postalCodeInput.length > 10) {
      this.displayError(this.houseNumberError, "Massimo 10 caratteri");
      isValid = false;
    }

    if (postalCodeInput === "") {
      this.displayError(this.postalCodeError, "Inserisci un codice postale");
      isValid = false;
    } else if (postalCodeInput.length > 10) {
      this.displayError(this.postalCodeError, "Massimo 10 caratteri");
      isValid = false;
    }

    if (cityInput === "") {
      this.displayError(this.cityError, "Inserisci una città");
      isValid = false;
    }

    if (provinceInput === "") {
      this.displayError(this.provinceError, "Inserisci una città");
      isValid = false;
    }

    if (countryInput === "") {
      this.displayError(this.countryError, "Inserisci una città");
      isValid = false;
    }

    return isValid;
  }

  displayError(element, message) {
    element.textContent = message;
    element.style.display = "block";
  }

  clearErrors() {
    this.streetError.textContent = "";
    this.houseNumberError.textContent = "";
    this.postalCodeError.textContent = "";
    this.cityError.textContent = "";
    this.provinceError.textContent = "";
    this.countryError.textContent = "";
  }
}

const checkout = new Checkout();
