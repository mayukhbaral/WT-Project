        var loginButton = document.getElementById("login-button");
        var signupButton = document.getElementById("signup-button");
        var overlay = document.getElementById("overlay");
		var loginForm = document.getElementById("login-form");
        var closeLogin = document.getElementById("close-login");
        var signupNow = document.getElementById("signup-now");
        var signupForm = document.getElementById("signup-form");
        var loginNow = document.getElementById("login-now");
        var closeSignup = document.getElementById("close-signup");
        var signup = document.getElementById("signup");


		loginButton.addEventListener("click", function() {
            loginForm.style.transform = "scale(1)";
            overlay.style.opacity = "1";
            overlay.style.pointerEvents = "auto";

		});

        signupButton.addEventListener("click", function() {
            signupForm.style.transform = "scale(1)";
            overlay.style.opacity = "1";
            overlay.style.pointerEvents = "auto";
		});

        closeLogin.addEventListener("click", function() {
            loginForm.style.transform = "scale(0)";
            overlay.style.opacity = "0";
            overlay.style.pointerEvents = "none";

		});

        signupNow.addEventListener("click", function() {
            signupForm.style.transform = "scale(1)";
            loginForm.style.transform = "scale(0)";
		});

        loginNow.addEventListener("click", function() {
			loginForm.style.transform = "scale(1)";
            signupForm.style.transform = "scale(0)";
		});

        closeSignup.addEventListener("click", function() {
            signupForm.style.transform = "scale(0)";
            overlay.style.opacity = "0";
            overlay.style.pointerEvents = "none";
		});

