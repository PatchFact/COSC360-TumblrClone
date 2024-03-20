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

        let email = $("#new-email").val();
        let passwordNew = $("#new-password").val();
        let passwordVerify = $("#verify-password").val();

        if (passwordNew != passwordVerify) {
            $("#errorAlertRegister").show();
            return false;
        } else if (!isValidEmail(email) || passwordNew.trim() === "") {
            $("passwordAlertVerify").show();
        }

        this.submit();
    });

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
