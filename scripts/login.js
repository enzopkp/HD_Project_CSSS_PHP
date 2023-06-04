document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const errorDiv = document.getElementById("errorDiv");
    errorDiv.hidden=true;

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        const email = emailInput.value;
        const password = passwordInput.value;

        // Reset previous errors
        errorDiv.innerHTML = "";

        // Email Validation
        const emailRegex = /^\S+@\S+\.\S+$/;
        if (!email || !email.match(emailRegex)) {
            showError("Invalid email format");
            return;
        }

        // Password Validation
        if (!password || password.length < 8 || password.length > 40) {
            showError("Password must be between 8 and 40 characters");
            return;
        }

        // Form is valid, submit it
        form.submit();
    });

    function showError(message) {
        errorDiv.hidden=false;
        const errorParagraph = document.createElement("p");
        errorParagraph.textContent = message;
        errorDiv.appendChild(errorParagraph);
    }
    // Populate email field if it was previously entered
    const storedEmail = sessionStorage.getItem("email");
    if (storedEmail) {
        emailInput.value = storedEmail;
    }

    // Store entered email in session storage
    emailInput.addEventListener("input", function() {
        sessionStorage.setItem("email", emailInput.value);
    });
});