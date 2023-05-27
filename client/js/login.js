class Login {
  constructor() {
    this.form = document.querySelector(".login-form");
    this.emailInput = document.getElementById("email-input");
    this.passwordInput = document.getElementById("password-input");
    this.emailError = document.getElementById("email-error");
    this.passwordError = document.getElementById("password-error");
    this.serverError = document.getElementById("server-error");

    this.form.addEventListener("submit", (e) => this.handleSubmit(e));
  }

  handleSubmit(event) {
    event.preventDefault();

    if (!this.validateFields()) {
      return;
    }

    const email = this.emailInput.value.trim();
    const password = this.passwordInput.value.trim();

    fetch("/hw1/api/login-api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email, password }),
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.success) {
          window.location.href = "/hw1/profile";
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
          } else if (response.mailError) {
            this.displayError(
              this.emailError,
              "Non esiste un accound con questa mail"
            );
          } else if (response.passwordError) {
            this.displayError(this.passwordError, "Password errata");
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
    const email = this.emailInput.value.trim();
    const password = this.passwordInput.value.trim();
    let isValid = true;

    this.clearErrors();

    if (email === "") {
      this.displayError(this.emailError, "Inserisci un indirizzo email");
      isValid = false;
    } else {
      const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
      if (!emailRegex.test(email)) {
        this.displayError(
          this.emailError,
          "Inserisci un indirizzo email valido"
        );
        isValid = false;
      }
    }

    if (password === "") {
      this.displayError(this.passwordError, "Inserisci una password");
      isValid = false;
    }

    return isValid;
  }

  displayError(element, message) {
    element.textContent = message;
    element.style.display = "block";
  }

  clearErrors() {
    this.emailError.textContent = "";
    this.emailError.style.display = "none";
    this.passwordError.textContent = "";
    this.passwordError.style.display = "none";
    this.serverError.textContent = "";
  }
}

const login = new Login();
