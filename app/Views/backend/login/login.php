<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Anggota Perpustakaan</title>
    <link href="<?= base_url('Assets/css/bootstrap.min.css'); ?>"
        rel="stylesheet">
    <link href="<?= base_url('Assets/css/sweetalert2.min.css'); ?>"
        rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            /* background perpustakaan */
            background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center;
                    background-size: cover;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    position: relative;
            }

            /* overlay gelap biar tulisan jelas */
            body::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.55);
            }

            .login-card {
                position: relative;
                background: rgba(255, 255, 255, 0.95);
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                width: 100%;
                max-width: 380px;
                z-index: 1;
            }

            .login-title {
                text-align: center;
                font-weight: bold;
                margin-bottom: 20px;
                font-size: 18px;
                color: #333;
            }

            .form-control {
                border-radius: 8px;
                height: 45px;
            }

            .btn-login {
                border-radius: 8px;
                height: 45px;
                font-weight: bold;
                background: #2e7d32;
                border: none;
                transition: 0.3s;
            }

            .btn-login:hover {
                background: #1b5e20;
            }

            .footer-text {
                text-align: center;
                margin-top: 15px;
                font-size: 12px;
                color: #666;
            }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-title">
            📚 Login Anggota Perpustakaan
        </div>
        <form action="<?= base_url('admin/autentikasi-login'); ?>" method="post">
            <div class="form-group">
                <input class="form-control"
                    placeholder="Username"
                    name="username"
                    type="text"
                    required autofocus>
            </div>
            <div class="form-group">
                <input class="form-control"
                    placeholder="Password"
                    name="password"
                    type="password"
                    required>
            </div>
            <button type="submit" class="btn btn-primary btn-login btn-block">
                Login
            </button>
        </form>
        <div class="footer-text">
            Silakan login untuk masuk ke sistem
        </div>
    </div>
    <script src="<?= base_url('Assets/js/jquery-1.11.1.min.js'); ?>"></script>
    <script src="<?= base_url('Assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('Assets/js/sweetalert2.min.js'); ?>"></script>
    <?php if (session()->getFlashdata('success')): ?>
        <script>
            $(document).ready(function() {
                swal("Success!", "<?= session()->getFlashdata('success'); ?>", "success");
            });
        </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <script>
            $(document).ready(function() {
                swal("Error!", "<?= session()->getFlashdata('error'); ?>", "error");
            });
        </script>
    <?php endif; ?>
</body>

</html>