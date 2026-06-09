<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="dashboard"><span class="glyphicon glyphiconhome"></span></a></li>
            <li class="active">Daftar Buku</li>
        </ol>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Data Buku</div>
        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Rak</th>
                        <th>E-Book</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($buku as $b) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $b['judul_buku']; ?></td>
                            <td><?= $b['pengarang']; ?></td>
                            <td><?= $b['nama_kategori'] ?? '-'; ?></td>
                            <td><?= $b['nama_rak'] ?? '-'; ?></td>
                            <td>
                                <?php if (!empty($b['e_book'])) { ?>
                                    <a href="<?= base_url('Assets/EBook/' . $b['e_book']); ?>" target="_blank" class="btn btn-xs btn-primary">Lihat</a>
                                    <a href="<?= base_url('Assets/EBook/' . $b['e_book']); ?>" download class="btn btn-xs btn-success">Download</a>
                                <?php } else { ?>
                                    <span class="text-muted">Tidak ada</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>