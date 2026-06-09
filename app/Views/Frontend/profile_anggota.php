<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphiconhome"></span></a></li>
            <li class="active">Profile Anggota</li>
        </ol>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Data Diri</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4 text-center">

                    <?php
                    $nama = session()->get('nama_anggota') ?? 'User';
                    // Mengambil huruf pertama dan mengubahnya ke huruf kapital
                    $inisial = strtoupper(substr(trim($nama), 0, 1));
                    ?>
                    <div class="profile-avatar-initial">
                        <?= $inisial; ?>
                    </div>
                    <h4><b><?= $nama; ?></b></h4>
                    <p class="text-muted">Anggota Perpustakaan</p>
                </div>
                <div class="col-md-8">
                    <table class="table table-striped">
                        <tr>
                            <th>Nama</th>
                            <td><?= session()->get('nama_anggota'); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= session()->get('email_anggota') ?? '-';
                                ?></td>
                        </tr>
                        <tr>
                            <th>No Telp</th>
                            <td><?= session()->get('no_tlp') ?? '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= session()->get('alamat') ?? '-'; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar-initial {
    width: 80px;
    height: 80px;
    line-height: 80px; /* Menyeimbangkan teks secara vertikal */
    border-radius: 50%; /* Membuat bentuk lingkaran bulat penuh */
    background-color: #337ab7; /* Warna utama Bootstrap (bisa diganti sesuai selera) */
    color: #ffffff; /* Warna teks putih */
    font-size: 40px; /* Ukuran teks inisial huruf */
    font-weight: 400;
    margin: 0 auto 15px auto; /* Menengahkan posisi elemen */
    text-align: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Efek bayangan halus */
}
</style>