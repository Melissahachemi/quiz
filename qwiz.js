document.addEventListener("DOMContentLoaded", function () {
    // Gestion de l'affichage/masquage du mot de passe pour la page de connexion (index.php)
    const togglePasswordLogin = document.querySelector("#togglePassword-login");
    const passwordInputLogin = document.querySelector("#password");

    if (togglePasswordLogin && passwordInputLogin) {
        togglePasswordLogin.addEventListener("click", function () {
            const type = passwordInputLogin.getAttribute("type") === "password" ? "text" : "password";
            passwordInputLogin.setAttribute("type", type);
            this.textContent = type === "password" ? "Afficher" : "Masquer";
        });
    }

    // Gestion de l'affichage/masquage du mot de passe pour la page d'inscription (signup.php)
    const togglePasswordSignup = document.querySelector("#togglePassword-signup");
    const passwordInputSignup = document.querySelector("#password"); // Notez que l'ID est le même sur les deux pages

    if (togglePasswordSignup && passwordInputSignup) {
        togglePasswordSignup.addEventListener("click", function () {
            const type = passwordInputSignup.getAttribute("type") === "password" ? "text" : "password";
            passwordInputSignup.setAttribute("type", type);
            this.textContent = type === "password" ? "Afficher" : "Masquer";
        });
    }
});