<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data Buku</li>
            <li class="active">Edit Data Buku</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Edit Buku</h3>
                    <hr />
                    <form action="<?php echo base_url('admin/update-buku');?>" method="post" enctype="multipart/form-data">
                        <div class="form-group col-md-6">
                            <label>Judul Buku</label>
                            <input type="text" class="form-control" name="judul_buku" value="<?php echo $data_buku['judul_buku'];?>" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Pengarang</label>
                            <input type="text" class="form-control" name="pengarang" value="<?php echo $data_buku['pengarang'];?>" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" value="<?php echo $data_buku['penerbit'];?>" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Tahun</label>
                            <input type="text" class="form-control" name="tahun" value="<?php echo $data_buku['tahun'];?>" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Jumlah Eksemplar</label>
                            <input type="number" class="form-control" name="jumlah_eksemplar" value="<?php echo $data_buku['jumlah_eksemplar'];?>" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Kategori Buku</label>
                            <select class="form-control" name="kategori_buku" required="required">
                                <option value="">-- Pilih Kategori Buku --</option>
                                <?php foreach($data_kategori as $kat){ ?>
                                <option value="<?= $kat['id_kategori'];?>" <?php if($data_buku['id_kategori']==$kat['id_kategori']) echo "selected"; ?>><?= $kat['nama_kategori'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="keterangan"><?php echo $data_buku['keterangan'];?></textarea>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Rak</label>
                            <select class="form-control" name="rak" required="required">
                                <option value="">-- Pilih Rak --</option>
                                <?php foreach($data_rak as $rak){ ?>
                                <option value="<?= $rak['id_rak'];?>" <?php if($data_buku['id_rak']==$rak['id_rak']) echo "selected"; ?>><?= $rak['nama_rak'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Cover Buku</label><br/>
                            <img src="/Assets/CoverBuku/<?php echo $data_buku['cover_buku'];?>" width="150px"><br/><br/>
                            <input type="file" name="cover_buku">
                            <small>Format file yang diizinkan : jpg, jpeg, png Maksimal ukuran 1 MB</small>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>E-Book</label><br/>
                            <iframe src="/Assets/E-Book/<?php echo $data_buku['e_book'];?>" width="100%" height="300px"></iframe><br/>
                            <input type="file" name="e_book">
                            <small>Format file yang diizinkan : pdf Maksimal ukuran 10 MB</small>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="<?php echo base_url('admin/master-buku');?>">
                                <button type="button" class="btn btn-danger">Batal</button>
                            </a>
                        </div>
                        <div style="clear:both;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>