<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('anggota/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">Settings Akun</li>
        </ol>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span class="glyphicon glyphicon-ok-sign"></span> <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span class="glyphicon glyphicon-exclamation-sign"></span> <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            Edit Profil
            <a href="javascript:history.back()" class="btn btn-default btn-sm pull-right">
                <span class="glyphicon glyphicon-remove"></span> Batal
            </a>
        </div>
        <div class="panel-body">
            <form action="<?= base_url('anggota/update-profile'); ?>" method="post">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama_anggota" class="form-control"
                        value="<?= session()->get('nama_anggota'); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                        value="<?= session()->get('email_anggota'); ?>" required>
                </div>
                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" name="no_telp" class="form-control"
                        value="<?= session()->get('no_telp') ?? session()->get('no_tlp'); ?>">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?= session()->get('alamat'); ?></textarea>
                </div>
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Update Profil
                </button>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Ubah Password</div>
        <div class="panel-body">
            <form action="<?= base_url('anggota/update-password'); ?>" method="post">
                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" name="old_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="new_password" class="form-control" id="new_password" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                    <span id="password_match_msg" style="margin-top: 5px; display: block; font-weight: bold;"></span>
                </div>
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-lock"></span> Update Password
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('confirm_password').addEventListener('input', function () {
    var pswd = document.getElementById('new_password').value;
    var confirmPswd = this.value;
    var msg = document.getElementById('password_match_msg');
    
    if (confirmPswd === '') {
        msg.innerHTML = '';
    } else if (pswd === confirmPswd) {
        msg.style.color = 'green';
        msg.innerHTML = '✓ Password cocok';
    } else {
        msg.style.color = 'red';
        msg.innerHTML = '✗ Password tidak cocok';
    }
});
</script>