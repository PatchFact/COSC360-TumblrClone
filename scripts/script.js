$(document).ready(function () {
    $("#input-email").blur(function () {
        if (!$(this).val()) {
            $("#emailAlert").show();
        } else {
            $("#emailAlert").hide();
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
            $("#errorAlert").show();
            return false;
        }

        this.submit();
    });

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
