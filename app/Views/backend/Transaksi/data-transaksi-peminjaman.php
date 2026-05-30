<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Data Peminjaman</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Transaksi Peminjaman Buku
                        <a href="<?= base_url('admin/peminjaman-step-1');?>">
                            <button type="button" class="btn btn-sm btn-primary pull-right">+ Transaksi Peminjaman</button>
                        </a>
                    </h3>
                    <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                        <thead>
                            <tr>
                                <th data-sortable="true">No Peminjaman</th>
                                <th data-sortable="true">Nama Anggota</th>
                                <th data-sortable="true">Tanggal Peminjaman</th>
                                <th data-sortable="true">Total Buku Yang Dipinjam</th>
                                <th data-sortable="true">Status Transaksi</th>
                                <th data-sortable="true">Status Ambil Buku</th>
                                <th data-sortable="true">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 0;
                        foreach($dataPeminjaman as $data){
                        ?>
                            <tr>
                                <td><?php echo $data['no_peminjaman'];?></td>
                                <td><?php echo $data['nama_anggota'];?></td>
                                <td><?php echo $data['tgl_pinjam'];?></td>
                                <td><?php echo $data['total_pinjam'];?></td>
                                <td>
                                    <?php if($data['status_transaksi'] == 'Berjalan'){ ?>
                                    <span class="label label-success">Berjalan</span>
                                    <?php } else { ?>
                                    <span class="label label-danger">Selesai</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo $data['status_ambil_buku'];?></td>
                                <td>
                                    <a href="<?= base_url('admin/detail-peminjaman/').sha1($data['no_peminjaman']);?>">
                                        <button type="button" class="btn btn-sm btn-info">
                                            <span class="glyphicon glyphicon-search"></span> Lihat Detail
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