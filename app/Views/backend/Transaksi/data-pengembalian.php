<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Pengembalian Buku</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Data Pengembalian Buku</h3>
                    <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" 
                        data-show-columns="true" data-search="true" 
                        data-pagination="true" data-sort-name="name" data-sort-order="desc">
                        <thead>
                            <tr>
                                <th data-sortable="true">No Peminjaman</th>
                                <th data-sortable="true">Nama Anggota</th>
                                <th data-sortable="true">Tgl Pinjam</th>
                                <th data-sortable="true">Total Buku</th>
                                <th data-sortable="true">Status</th>
                                <th data-sortable="true">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 0;
                        foreach($dataPeminjaman as $data){
                        ?>
                            <tr>
                                <td><?= $data['no_peminjaman'];?></td>
                                <td><?= $data['nama_anggota'];?></td>
                                <td><?= $data['tgl_pinjam'];?></td>
                                <td><?= $data['total_pinjam'];?></td>
                                <td>
                                    <span class="label label-warning">Sedang Dipinjam</span>
                                </td>
                                <td>
                                    <a href="#" onclick="doKembali('<?= sha1($data['no_peminjaman']);?>')">
                                        <button type="button" class="btn btn-sm btn-success">
                                            <span class="glyphicon glyphicon-check"></span> Proses Pengembalian
                                        </button>
                                    </a>
                                    <a href="<?= base_url('admin/detail-peminjaman/').sha1($data['no_peminjaman']);?>">
                                        <button type="button" class="btn btn-sm btn-info">
                                            <span class="glyphicon glyphicon-search"></span> Detail
                                        </button>
                                    </a>
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

<script type="text/javascript">
function doKembali(idKembali){
    swal({
        title   : "Proses Pengembalian Buku?",
        text    : "Pastikan buku sudah dikembalikan dengan baik!",
        icon    : "warning",
        buttons : {
            cancel : {
                text    : "Batal",
                visible : true,
            },
            confirm : {
                text  : "Ya, Kembalikan!",
                value : true,
            }
        },
        dangerMode : false,
    })
    .then(ok => {
        if(ok){
            window.location.href = '<?= base_url();?>/admin/proses-pengembalian/' + idKembali;
        } else {
            $(this).removeAttr('disabled')
        }
    })
}
</script>