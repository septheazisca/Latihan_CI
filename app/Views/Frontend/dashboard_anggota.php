<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2
main">

    <!-- BREADCRUMB -->
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphiconhome"></span></a></li>
            <li class="active">Dashboard Anggota</li>
        </ol>
    </div>
    <!-- TITLE -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <small>Selamat datang, <?= $nama; ?></small>
            </h1>
        </div>
    </div>
    <!-- PANEL -->
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-blue panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-4 widget-left">
                        <em class="glyphicon glyphicon-book glyphicon-l"></em>
                    </div>
                    <div class="col-sm-8 widget-right">
                        <div class="large"><?= $total_buku; ?></div>
                        <div class="text-muted">Total Buku</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-orange panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-4 widget-left">
                        <em class="glyphicon glyphicon-repeat glyphicon-l"></em>
                    </div>
                    <div class="col-sm-8 widget-right">
                        <div class="large"><?= $pinjam; ?></div>
                        <div class="text-muted">Dipinjam</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-teal panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-4 widget-left">
                        <em class="glyphicon glyphicon-ok glyphicon-l"></em>
                    </div>
                    <div class="col-sm-8 widget-right">
                        <div class="large"><?= $kembali; ?></div>
                        <div class="text-muted">Dikembalikan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-red panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-4 widget-left">
                        <em class="glyphicon glyphicon-download glyphicon-l"></em>
                    </div>
                    <div class="col-sm-8 widget-right">
                        <div class="large"><?= $ebook; ?></div>
                        <div class="text-muted">Ebook</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- TABEL -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Buku Terbaru</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
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
                                    <td>
                                        <?php if ($b['e_book']) { ?>
                                            <a href="<?= base_url('Assets/EBook/' . $b['e_book']); ?>" target="_blank" class="btn btn-xs btn-primary">Lihat</a>
                                            <a href="<?= base_url('Assets/EBook/' . $b['e_book']); ?>" download class="btn btn-xs btn-success">Download</a>
                                        <?php } else { ?>
                                            <span class="text-muted">-</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- SCRIPT -->
<script src="<?= base_url('Assets/js/chart.min.js'); ?>"></script>
<script>
    var ctx = document.getElementById("line-chart").getContext("2d");
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun"],
            datasets: [{
                label: "Data Buku",
                data: [5, 10, 8, 15, 20, 18],
                fill: false,
                borderWidth: 2
            }]
        }
    });
</script>