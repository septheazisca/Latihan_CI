<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Perpustakaan Berbasis Website</title>
    <link href="<?= base_url('Assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('Assets/css/datepicker3.css') ?>" rel="stylesheet">
    <link href="<?= base_url('Assets/css/bootstrap-table.css') ?>"
        rel="stylesheet">
    <link href="<?= base_url('Assets/css/styles.css') ?>" rel="stylesheet">
    <link href="<?= base_url('Assets/css/sweetalert2.min.css') ?>"
        rel="stylesheet">
    <script type="text/javascript">
        function getkey(e) {
            if (window.event)
                return window.event.keyCode;
            else if (e)
                return e.which;
            else
                return null;
        }

        function goodchars(e, goods, field) {
            var key, keychar;
            key = getkey(e);
            if (key == null) return true;
            keychar = String.fromCharCode(key);
            //keychar = keychar.toLowerCase();
            //goods = goods.toLowerCase();
            // check goodkeys
            if (goods.indexOf(keychar) != -1)
                return true;
            // control keys
            if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
                return true;
            if (key == 13) {
                var i;
                for (i = 0; i < field.form.elements.length; i++)
                    if (field == field.form.elements[i])
                        break;
                i = (i + 1) % field.form.elements.length;
                field.form.elements[i].focus();
                return false;
            };
            // else return false
            return false;
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= base_url('anggota/dashboard'); ?>">
                    <span>Halaman Anggota</span>
                </a>

                <ul class="user-menu list-inline pull-right" style="margin: 0; padding-top: 15px;">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #fff; text-decoration: none;">
                            <span class="glyphicon glyphicon-user"></span>
                            <?= session()->get('nama_anggota'); ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li>
                                <a href="<?= base_url('anggota/profile'); ?>">
                                    <span class="glyphicon glyphicon-user"></span> Profile
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('anggota/settings'); ?>">
                                    <span class="glyphicon glyphicon-cog"></span> Settings
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= base_url('anggota/logout'); ?>">
                                    <span class="glyphicon glyphicon-log-out"></span> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>