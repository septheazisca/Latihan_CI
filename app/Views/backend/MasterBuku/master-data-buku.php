<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">Master Data Buku</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Master Data Buku
                        <a href="<?= base_url('admin/input-buku');?>">
                            <button type="button" class="btn btn-sm btn-primary pull-right">+ Tambah Data Buku</button>
                        </a>
                    </h3>
                    <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                        <thead>
                            <tr>
                                <th data-sortable="true">No</th>
                                <th data-sortable="true">Cover Buku</th>
                                <th data-sortable="true">Judul Buku</th>
                                <th data-sortable="true">Pengarang</th>
                                <th data-sortable="true">Penerbit</th>
                                <th data-sortable="true">Tahun</th>
                                <th data-sortable="true">Jumlah Eksemplar</th>
                                <th data-sortable="true">Kategori Buku</th>
                                <th data-sortable="true">Keterangan</th>
                                <th data-sortable="true">Rak</th>
                                <th data-sortable="true">E-Book</th>
                                <th data-sortable="true">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 0;
                        foreach($dataBuku as $data){
                        ?>
                            <tr>
                                <td><?php echo $no=$no+1;?></td>
                                <td><img src="/Assets/CoverBuku/<?php echo $data['cover_buku'];?>" width="80px"></td>
                                <td><?php echo $data['judul_buku'];?></td>
                                <td><?php echo $data['pengarang'];?></td>
                                <td><?php echo $data['penerbit'];?></td>
                                <td><?php echo $data['tahun'];?></td>
                                <td><?php echo $data['jumlah_eksemplar'];?></td>
                                <td><?php echo $data['nama_kategori'];?></td>
                                <td><?php echo $data['keterangan'];?></td>
                                <td><?php echo $data['nama_rak'];?></td>
                                <td><a href="/Assets/E-Book/<?php echo $data['e_book'];?>" target="_blank"><?php echo $data['e_book'];?></a></td>
                                <td>
                                    <a href="<?= base_url('admin/edit-buku/').sha1($data['id_buku']);?>">
                                        <button type="button" class="btn btn-sm btn-success">Edit</button>
                                    </a>
                                    <a href="#" onclick="doDelete('<?= sha1($data['id_buku']);?>')">
                                        <button type="button" class="btn btn-sm btn-danger">Hapus</button>
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
function doDelete(idDelete){
    swal({
        title : "Hapus Data Buku?",
        text  : "Data ini akan terhapus permanen!!",
        icon  : "warning",
        buttons : true,
        dangerMode : false,
    })
    .then(ok => {
        if(ok){
            window.location.href = '<?= base_url();?>/admin/hapus-buku/' + idDelete;
        } else {
            $(this).removeAttr('disabled')
        }
    })
}
</script>