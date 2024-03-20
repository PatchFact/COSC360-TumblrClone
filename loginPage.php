<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Login";
require "head.php";
?>

<body>
    <div class="loginMain">
        <div class="d-flex flex-column align-items-center mt-5">
            <h1><span class="title">Login</span></h1>
        </div>
        <div class="d-flex flex-column m-5 align-items-center">
            <form action="login.php" method="post" style="width: 22em" id="loginForm">
                <div class="form-group">
                    <label for="input-email">Email address</label>
                    <input type="email" class="form-control" id="input-email" placeholder="Enter email" required />
                    <div class="alert alert-danger alert-dismissible fade show mt-3" id="emailAlert" style="display: none">
                        Please enter your email address.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-password">Password</label>
                    <input type="password" class="form-control" id="input-password" placeholder="Password" required />
                    <div class="alert alert-danger alert-dismissible fade show mt-3" id="passwordAlert" style="display: none">
                        Please enter your password.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
            <div class="alert alert-danger alert-dismissible fade show mt-3" id="errorAlert" style="display: none" role="alert">
                Please enter a valid email address and password.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center mt-5">
            <h1><span class="title">Register</span></h1>
        </div>
        <div class="d-flex flex-column m-5 align-items-center">
            <form action="login.php" method="post" style="width: 22em" id="loginForm">
                <div class="form-group">
                    <label for="input-email">Email address</label>
                    <input type="email" class="form-control" id="input-email" placeholder="Enter email" required />
                    <div class="alert alert-danger alert-dismissible fade show mt-3" id="emailAlert" style="display: none">
                        Please enter your email address.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-password">Password</label>
                    <input type="password" class="form-control" id="input-password" placeholder="Password" required />
                    <div class="alert alert-danger alert-dismissible fade show mt-3" id="passwordAlert" style="display: none">
                        Please enter your password.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
            <div class="alert alert-danger alert-dismissible fade show mt-3" id="errorAlert" style="display: none" role="alert">
                Please enter a valid email address and password.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>

</body>

</html>