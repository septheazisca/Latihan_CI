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
    <!-- Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Input Anggota</h3>
                    <hr>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('admin/peminjaman-step-2'); ?>"
                        method="post">
                        <div class="form-group col-md-6">
                            <label for="id_anggota">Pilih Anggota</label>
                            <select class="form-control" name="id_anggota" id="id_anggota" required>
                                <option value="" disabled selected>-- Pilih ID atau Nama Anggota --</option>
                                <?php foreach ($dataAnggota as $agt) : ?>
                                    <option value="<?= $agt['id_anggota']; ?>">
                                        <?= $agt['id_anggota']; ?> - <?= $agt['nama_anggota']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div style="clear: both;"></div>
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">
                                Next
                            </button>
                            <a href="<?= base_url('admin/peminjaman-step-1'); ?>"
                                class="btn btn-danger">
                                Batal
                            </a>
                        </div>
                        <div style="clear: both;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('anggotaSearch').addEventListener('input', function() {
        let value = this.value;
        let options = document.querySelectorAll('#anggotaList option');
        options.forEach(function(option) {
            if (option.value === value) {
                let id = option.getAttribute('data-id');
                document.getElementById('id_anggota').value = id;
            }
        });
    });
</script>