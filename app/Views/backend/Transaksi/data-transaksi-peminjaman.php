<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <!-- Breadcrumb -->
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphiconhome"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Data Peminjaman</li>
        </ol>
    </div>
    <!-- Title -->
    <div class="row">
        <div class="col-lg-12">
            <h3>Transaksi Peminjaman Buku</h3>
        </div>
    </div>
    <!-- Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table
                        class="table table-bordered table-striped"
                        data-toggle="table"
                        data-search="true"
                        data-pagination="true"
                        data-show-refresh="true"
                        data-show-columns="true">
                        <thead>
                            <tr>
                                <th>No Peminjaman</th>
                                <th>Nama Anggota</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Total Buku</th>
                                <th>Status Transaksi</th>
                                <th>Status Ambil Buku</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataPeminjaman as $data) : ?>
                                <tr>
                                    <td><?= $data['no_peminjaman']; ?></td>
                                    <td><?= $data['nama_anggota']; ?></td>
                                    <td><?= $data['tgl_pinjam']; ?></td>
                                    <td><?= $data['total_pinjam']; ?></td>
                                    <!-- Status Transaksi -->
                                    <td>
                                        <?php
                                        if ($data['status_transaksi'] == 'Berjalan'): ?>
                                            <span class="label label-warning">
                                                Berjalan
                                            </span>
                                        <?php else: ?>
                                            <span class="label label-success">
                                                Selesai
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <!-- Status Ambil -->
                                    <td>
                                        <?= $data['status_ambil_buku']; ?>
                                    </td>
                                    <!-- Opsi -->
                                    <td>
                                        <a href="<?= base_url('admin/detail-transaksi/' . $data['no_peminjaman']); ?>"
                                            class="btn btn-primary btn-sm">
                                            <span class="glyphicon glyphiconeye-open"></span> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>