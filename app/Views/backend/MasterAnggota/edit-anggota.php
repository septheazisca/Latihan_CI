<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li><a href="<?= base_url('admin/master-data-anggota'); ?>">Master Data Anggota</a></li>
            <li class="active">Edit Data Anggota</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Edit Anggota</h3>
                    <hr />
                    <form action="<?php echo base_url('admin/update-anggota'); ?>" method="post">
                        <div class="form-group col-md-6">
                            <label>Nama Anggota</label>
                            <input type="text" class="form-control" name="nama"
                                placeholder="Masukkan Nama Anggota"
                                value="<?php echo $data_anggota['nama_anggota']; ?>" required>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Jenis Kelamin</label>
                            <select class="form-control" name="jenis" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" <?php if ($data_anggota['jenis_kelamin'] == "L") echo "selected"; ?>>Laki-laki</option>
                                <option value="P" <?php if ($data_anggota['jenis_kelamin'] == "P") echo "selected"; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>No Telepon</label>
                            <input type="text" class="form-control" name="no_tlp"
                                placeholder="Masukkan No Telepon"
                                value="<?php echo $data_anggota['no_tlp']; ?>" required>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="alamat"
                                placeholder="Masukkan Alamat"
                                value="<?php echo $data_anggota['alamat']; ?>" required>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email"
                                placeholder="Masukkan Email"
                                value="<?php echo $data_anggota['email']; ?>" required>
                        </div>

                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" value="<?php echo $data_anggota['password_anggota']; ?>"
                                placeholder="Masukkan Password" required>
                        </div>

                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="<?= base_url('admin/master-data-anggota'); ?>">
                                <button type="button" class="btn btn-danger">Batal</button>
                            </a>
                        </div>
                        <div style="clear:both;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div>