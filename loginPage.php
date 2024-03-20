<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Login";
require "head.php";
?>

<body>
    <?php require "navbar.php" ?>

    <div class="loginMain">
        <div class="d-flex flex-column align-items-center mt-3">
            <h1 class="title">Login</h1>
        </div>
        <div class="d-flex flex-column m-3 align-items-center">
            <form action="login.php" method="post" class="loginPageForm" id="loginForm">
                <div class="form-group">
                    <label for="input-email">Email address</label>
                    <input type="email" class="form-control" id="input-email" name="input-email" placeholder="Enter email" required />
                    <div class="alert alert-danger fade show mt-3" id="emailAlertLogin" style="display: none">
                        Please enter your email address.
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-password">Password</label>
                    <input type="password" class="form-control" id="input-password" name="input-password" placeholder="Password" required />
                    <div class="alert alert-danger fade show mt-3" id="passwordAlert" style="display: none">
                        Please enter your password.
                    </div>
                </div>
                <small><a href="#" id="password-forgot" class="form-text text-muted mb-3">
                        Forgot my password
                    </a>
                </small>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="admin-check" />
                    <label class="form-check-label" for="admin-check">Admin</label>
                </div>
                <button type="submit" class="btn btn-primary mt-5">
                    Submit
                </button>
            </form>
            <div class="alert alert-danger fade show mt-3" id="errorAlertLogin" style="display: none" role="alert">
                Please enter a valid email address and password.
            </div>
        </div>

        <div class="d-flex flex-column align-items-center mt-5">
            <h1><span class="title">Register</span></h1>
        </div>
        <div class="d-flex flex-column m-3 align-items-center">
            <form action="register.php" method="post" class="loginPageForm" id="registerForm">
                <div class="form-group">
                    <label for="new-email">Email address</label>
                    <input type="email" class="form-control" id="new-email" placeholder="Enter email" required />
                    <div class="alert alert-danger fade show mt-3" id="emailAlertRegister" style="display: none">
                        Please enter your email address.
                    </div>
                </div>
                <div class="form-group">
                    <label for="new-password">Password</label>
                    <input type="password" class="form-control" id="new-password" placeholder="Password" required />
                    <div class="alert alert-danger fade show mt-3" id="passwordAlertNew" style="display: none">
                        Please enter a password.
                    </div>
                </div>
                <div class="form-group">
                    <label for="verify-password">Verify Password</label>
                    <input type="password" class="form-control" id="verify-password" placeholder="Password" required />
                    <div class="alert alert-danger fade show mt-3" id="passwordAlertVerify" style="display: none">
                        Passwords must match.
                    </div>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="admin-check" />
                    <label class="form-check-label" for="admin-check">Admin</label>
                </div>
                <button type="submit" class="btn btn-primary mt-5">
                    Submit
                </button>
            </form>
            <div class="alert alert-danger fade show mt-3" id="errorAlertRegister" style="display: none" role="alert">
                Please enter a valid email address and password.
            </div>
        </div>
    </div>

</body>

</html>