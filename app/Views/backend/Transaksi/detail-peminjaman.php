<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Transaksi</li>
            <li><a href="<?= base_url('admin/data-transaksi-peminjaman');?>">Data Peminjaman</a></li>
            <li class="active">Detail Peminjaman</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Detail Transaksi Peminjaman</h3>
                    <hr />

                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <td width="200"><strong>No Peminjaman</strong></td>
                                    <td><?= $dataPeminjaman['no_peminjaman'];?></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Anggota</strong></td>
                                    <td><?= $dataPeminjaman['nama_anggota'];?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Pinjam</strong></td>
                                    <td><?= $dataPeminjaman['tgl_pinjam'];?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Buku Dipinjam</strong></td>
                                    <td><?= $dataPeminjaman['total_pinjam'];?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status Transaksi</strong></td>
                                    <td>
                                        <?php if($dataPeminjaman['status_transaksi'] == 'Berjalan'){ ?>
                                        <span class="label label-success">Berjalan</span>
                                        <?php } else { ?>
                                        <span class="label label-danger">Selesai</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status Ambil Buku</strong></td>
                                    <td><?= $dataPeminjaman['status_ambil_buku'];?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4 text-center">
                            <strong>QR Code Peminjaman</strong><br/><br/>
                            <img src="<?= base_url('Assets/qr_code/'.$dataPeminjaman['qr_code']);?>" width="150px">
                        </div>
                    </div>

                    <hr/>
                    <h4>Daftar Buku Dipinjam</h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Cover</th>
                                <th>Judul Buku</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tgl Kembali</th>
                                <th>Status Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 0;
                        foreach($dataDetail as $detail){
                        ?>
                            <tr>
                                <td><?= $no=$no+1;?></td>
                                <td>
                                    <img src="<?= base_url('Assets/CoverBuku/'.$detail['cover_buku']);?>" width="60px">
                                </td>
                                <td><?= $detail['judul_buku'];?></td>
                                <td><?= $detail['pengarang'];?></td>
                                <td><?= $detail['penerbit'];?></td>
                                <td><?= $detail['tgl_kembali'];?></td>
                                <td>
                                    <?php if($detail['status_pinjam'] == 'Sedang Dipinjam'){ ?>
                                    <span class="label label-warning">Sedang Dipinjam</span>
                                    <?php } else { ?>
                                    <span class="label label-success">Sudah Dikembalikan</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                    <a href="<?= base_url('admin/data-transaksi-peminjaman');?>">
                        <button class="btn btn-default">
                            <span class="glyphicon glyphicon-arrow-left"></span> Kembali
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>