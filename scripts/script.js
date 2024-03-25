$(document).ready(function () {
    // Login
    $("#input-email").blur(function () {
        if (!$(this).val()) {
            $("#emailAlertLogin").show();
        } else {
            $("#emailAlertLogin").hide();
        }
    });

    $("#input-password").blur(function () {
        if (!$(this).val()) {
            $("#passwordAlert").show();
        } else {
            $("#passwordAlert").hide();
        }
    });

    $("#loginForm").submit(function (e) {
        e.preventDefault();

        var email = $("#input-email").val();
        var password = $("#input-password").val();

        if (!isValidEmail(email) || password.trim() === "") {
            $("#errorAlertLogin").show();
            return false;
        }

        this.submit();
    });

    $("#username").blur(function () {
        if (!$(this).val()) {
            $("#usernameAlert").show();
        } else {
            $("#usernameAlert").hide();
        }
    });

    $("#new-email").blur(function () {
        if (!$(this).val()) {
            $("#emailAlertRegister").show();
        } else {
            $("#emailAlertRegister").hide();
        }
    });

    $("#new-password").blur(function () {
        if (!$(this).val()) {
            $("#passwordAlertNew").show();
        } else {
            $("#passwordAlertNew").hide();
        }
    });

    $("#verify-password").blur(function () {
        let passwordNew = $("#new-password").val();

        if (!$(this).val() || passwordNew != $(this).val()) {
            $("#passwordAlertVerify").show();
        } else {
            $("#passwordAlertVerify").hide();
        }
    });

    $("#registerForm").submit(function (e) {
        e.preventDefault();

        let username = $("#username").val();
        let email = $("#new-email").val();
        let passwordNew = $("#new-password").val();
        let passwordVerify = $("#verify-password").val();

        if (passwordNew != passwordVerify) {
            $("#errorAlertRegister").show();
            return false;
        } else if (
            !isValidEmail(email) ||
            passwordNew.trim() === "" ||
            username.trim() === ""
        ) {
            $("passwordAlertVerify").show();
        }

        this.submit();
    });

    $("#editEmailButton").click(function () {
        $("#editEmailForm").show();
    });

    $("#editAboutButton").click(function () {
        $("#editAboutForm").show();
    });

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("search-button")
        .addEventListener("click", function () {
            var searchTerm = document.getElementById("search-input").value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "search_handler.php", true);
            xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
            );
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("search-results").innerHTML =
                        this.responseText;
                }
            };
            xhr.send("search=" + encodeURIComponent(searchTerm));
        });

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".ban-form").forEach((form) => {
            form.addEventListener("submit", function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                fetch("toggleBanUser.php", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        alert(data.message); 
                        if (data.status === "success") {
                            const submitBtn = form.querySelector(
                                'input[type="submit"]'
                            );
                            const newStatus =
                                formData.get("is_banned") == "1" ? "0" : "1"; 
                            formData.set("is_banned", newStatus); 
                            submitBtn.value =
                                submitBtn.value === "Ban" ? "Unban" : "Ban"; 
                            submitBtn.parentNode.querySelector(
                                'input[name="is_banned"]'
                            ).value = newStatus; 
                        }
                    })
                    .catch((error) => console.error("Error:", error));
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('postForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
    
            const formData = new FormData(form);
            
            fetch('makePost.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(html => {
                // Process the response HTML here
                // For example, display a success message or handle errors
                console.log(html);
                if (html.includes("Location: makePost.php")) {
                    window.location.href = 'makePost.php';
                } else {
                    // Display error message to the user
                    document.getElementById('responseContainer').innerHTML = 'Failed to create post. Please try again.';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

});
