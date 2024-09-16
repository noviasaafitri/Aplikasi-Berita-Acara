<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reset Password</title>


    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>/Assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/Assets/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>/Assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url() ?>/Assets/img/logo.png" type="image/png">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-4">
                                    <div class=" text-center">
                                        <img src="<?= base_url() ?>Assets/img/log_asli.png" alt="Logo" class="img-fluid mx-auto d-block" />
                                    </div>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
                                    </div>
                                    <?php if (session()->getFlashdata('errors')) : ?>
                                        <div class="alert alert-danger">
                                            <?= session()->getFlashdata('errors')['token'] ?? '' ?>
                                            <?= session()->getFlashdata('errors')['repassword'] ?? '' ?>
                                        </div>
                                    <?php endif; ?>
                                    <?= form_open('auth/proses_reset_password', ['class' => 'user']) ?>
                                    <input type="hidden" name="token" value="<?= esc($token) ?>">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user" placeholder="Password Baru" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="repassword" class="form-control form-control-user" placeholder="Ulangi Password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Reset Password</button>
                                    <?= form_close() ?>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth/login') ?>">Kembali ke Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>

</body>

</html>