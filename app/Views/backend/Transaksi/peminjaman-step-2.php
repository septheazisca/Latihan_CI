<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <!-- Breadcrumb -->
    <div class="row">
        <ol class="breadcrumb">
            <li>
                <a href="#"><span class="glyphicon glyphicon-home"></span></a>
            </li>
            <li>Transaksi</li>
            <li class="active">Peminjaman</li>
        </ol>
    </div>
    <!-- Data Anggota -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Data Anggota</h3>
                    <hr>
                    <div class="form-group col-md-6">
                        <label>ID Anggota</label><br>
                        <?= session()->get('idAgt'); ?>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form-group col-md-6">
                        <label>Nama Anggota</label><br>
                        <?= $dataAnggota['nama_anggota']; ?>
                    </div>
                    <div style="clear: both;"></div>
                    <br>
                    <!-- Keranjang -->
                    <h3>Keranjang Peminjaman Buku</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($dataTemp as $data) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $data['judul_buku']; ?></td>
                                    <td><?= $data['pengarang']; ?></td>
                                    <td><?= $data['penerbit']; ?></td>
                                    <td><?= $data['tahun']; ?></td>
                                    <td>
                                        <button
                                            onclick="doDelete('<?=
                                                                sha1($data['id_buku']); ?>')"
                                            class="btn btn-warning">
                                            <span class="glyphicon glyphicontrash"></span> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if ($jumlahTemp > 0) : ?>
                        <a href="<?= base_url('admin/simpan-transaksi-peminjaman'); ?>" class="btn btn-primary btn-block">
                            Simpan Transaksi Peminjaman Buku
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Data Buku -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Jumlah</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Rak</th>
                                <th>Cover</th>
                                <th>E-Book</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($dataBuku as $data) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $data['judul_buku']; ?></td>
                                    <td><?= $data['pengarang']; ?></td>
                                    <td><?= $data['penerbit']; ?></td>
                                    <td><?= $data['tahun']; ?></td>
                                    <td><?= $data['jumlah_eksemplar']; ?></td>
                                    <td><?= $data['nama_kategori']; ?></td>
                                    <td><?= $data['keterangan']; ?></td>
                                    <td><?= $data['nama_rak']; ?></td>
                                    <td>
                                        <img src="/Assets/CoverBuku/<?=
                                                                    $data['cover_buku']; ?>" width="80">
                                    </td>
                                    <td>
                                        <a href="/Assets/E-Book/<?=
                                                                $data['e_book']; ?>" target="_blank">
                                            <?= $data['e_book']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if (
                                            $data['jumlah_eksemplar'] !=
                                            "0"
                                        ) : ?>
                                            <a href="<?=
                                                        base_url('admin/simpan-temp-pinjam/' . sha1($data['id_buku'])); ?>" class="btn
btn-primary">
                                                Pinjam
                                            </a>
                                        <?php else : ?>
                                            <span class="text-danger">Stok
                                                Habis</span>
                                        <?php endif; ?>
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
<!-- Script -->
<script>
    function doDelete(idDelete) {
        swal({
            title: "Hapus Data Peminjaman?",
            text: "Data ini akan terhapus permanen!",
            icon: "warning",
            buttons: true,
        }).then((ok) => {
            if (ok) {
                window.location.href = '<?= base_url('admin/hapus-temp/'); ?>' +
                    idDelete;
            }
        });
    }
</script>