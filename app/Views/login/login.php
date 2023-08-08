<?php

use NextG\RwAdminApp\App\Configuration;


if(isset($_SESSION['error'])) {
    $error = "<div class='alert alert-danger' role='alert'>{$_SESSION['error']}</div>";
    echo $error;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/login.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="<?= Configuration::$ROOT; ?>public/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script


</head>

<body>

    <div class="container-fluid">

        <div class="row">
                <div class="col-sm-6 bg-side">

                </div>
                <div class="col-sm-6 content-login d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="public/img/logo.png" alt="" srcset="" width="34">
                        <div class="logo-text">BGM RW 05</div>
                    </div>

                    <div class="d-flex flex-row align-self-center login">
                        <div class="login-container">
                            <div class="welcome">Selamat datang</div>
                            <div class="login-text">Log in di bawah untuk akses akun mu</div>
                            <form action="login" method="POST" class="mt-3" id="formLogin">
                                <div class="mb-2">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukan username" required>
                                </div>
                                <div class="mb-2">
                                    <label for="password" class="form-label">Passwod</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" required>
                                </div>
                                <button type="submit" class="btn btn-login">Login</button>
                            </form>

                        </div>
                    </div>
                </div>
        </div>

    </div>

<script src="public/js/login.js"></script>


</body>


</html>