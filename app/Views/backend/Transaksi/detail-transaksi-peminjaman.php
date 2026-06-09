<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <!-- Breadcrumb -->
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphiconhome"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Detail Peminjaman</li>
        </ol>
    </div>
    <div class="row">
        <!-- Informasi -->
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Informasi Transaksi
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <th width="250">
                                No Peminjaman
                            </th>
                            <td>
                                <?= $transaksi['no_peminjaman']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Anggota</th>
                            <td>
                                <?= $transaksi['nama_anggota']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Pinjam</th>
                            <td>
                                <?= date(
                                    'd F Y',
                                    strtotime($transaksi['tgl_pinjam'])
                                ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Buku</th>
                            <td>
                                <span class="badge">
                                    <?= $transaksi['total_pinjam']; ?>
                                    Buku
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status Transaksi</th>
                            <td>
                                <?php
                                if ($transaksi['status_transaksi'] == 'Berjalan'): ?>
                                    <span class="label label-warning">
                                        Berjalan
                                    </span>
                                <?php else: ?>
                                    <span class="label label-success">
                                        Selesai
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Status Ambil Buku</th>
                            <td>
                                <?php
                                if ($transaksi['status_ambil_buku'] == 'Sudah Diambil'): ?>
                                    <span class="label label-success">
                                        Sudah Diambil
                                    </span>
                                <?php else: ?>
                                    <span class="label label-danger">
                                        Belum Diambil
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- QR -->
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading text-center">
                    QR Code Peminjaman
                </div>
                <div class="panel-body text-center">
                    <?php if (!empty($transaksi['qr_code'])): ?>
                        <img
                            src="<?=
                                    base_url('assets/qr_code/' . $transaksi['qr_code']); ?>"
                            class="img-responsive img-thumbnail"
                            style="margin:auto;max-width:180px;">
                    <?php else: ?>
                        <div class="alert alert-warning">
                            QR Code belum tersedia
                        </div>
                    <?php endif; ?>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!-- Daftar Buku -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Daftar Buku Dipinjam
                </div>
                <div class="panel-body">
                    <table
                        class="table table-bordered table-striped"
                        data-toggle="table"
                        data-search="true"
                        data-pagination="true">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Buku</th>
                                <th>Judul Buku</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Status Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($detailBuku as $buku): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <?= $buku['id_buku']; ?>
                                    </td>
                                    <td>
                                        <?= $buku['judul_buku']; ?>
                                    </td>
                                    <td>
                                        <?= $buku['pengarang']; ?>
                                    </td>
                                    <td>
                                        <?= $buku['penerbit']; ?>
                                    </td>
                                    <td>
                                        <?= $buku['tahun']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($buku['status_pinjam'] == 'Sedang Dipinjam'): ?>
                                            <span class="label label-warning">
                                                Sedang Dipinjam
                                            </span>
                                        <?php else: ?>
                                            <span class="label label-success">
                                                Sudah Dikembalikan
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= date(
                                            'd-m-Y',
                                            strtotime($buku['tgl_kembali'])
                                        ); ?>
                                    </td>

                                    <td>
                                        <?php if ($buku['status_pinjam'] == 'Sedang Dipinjam'): ?>
                                            <a href="<?= base_url('admin/proses-pengembalian/' . $transaksi['no_peminjaman'] . '/' . $buku['id_buku']); ?>"
                                                class="btn btn-success btn-xs"
                                                onclick="return confirm('Yakin buku ini sudah dikembalikan?')">
                                                <span class="glyphicon glyphicon-ok"></span>
                                                Kembalikan
                                            </a>
                                        <?php else: ?>
                                            <span class="label label-success">
                                                Selesai
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a href="<?= base_url('admin/data-transaksi-peminjaman');
                                ?>"
                        class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>