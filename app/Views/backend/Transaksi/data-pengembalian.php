<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li>Transaksi</li>
            <li class="active">Data Pengembalian</li>
        </ol>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            Data Pengembalian Buku
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
                        <th>No Pengembalian</th>
                        <th>No Peminjaman</th>
                        <th>Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Denda</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($pengembalian as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?= $row['no_pengembalian']; ?>
                            </td>
                            <td>
                                <?= $row['no_peminjaman']; ?>
                            </td>
                            <td>
                                <?= $row['nama_anggota']; ?>
                            </td>
                            <td>
                                <?= $row['judul_buku']; ?>
                            </td>
                            <td>
                                <?= date(
                                    'd-m-Y',
                                    strtotime($row['tgl_pengembalian'])
                                ); ?>
                            </td>
                            <td>
                                <?php if ($row['denda'] > 0): ?>
                                    <span class="label label-danger">
                                        Rp <?=
                                            number_format($row['denda'], 0, ',', '.'); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="label label-success">
                                        Tidak Ada
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $row['nama_admin']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>