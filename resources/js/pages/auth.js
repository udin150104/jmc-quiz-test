export function init() {

  const togglePassword = document.querySelector("#togglePassword");
  const passwordField = document.querySelector("#password");

  if (togglePassword) {
    togglePassword.addEventListener("click", function () {
      const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
      passwordField.setAttribute("type", type);
      this.classList.toggle("bi-eye");
      this.classList.toggle("bi-eye-slash");
    });
  }
}