<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Dashboard</li>
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Dashboard</h1>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-3">
			<div class="panel panel-blue panel-widget ">
				<div class="row no-padding">
					<div class="col-sm-3 col-lg-5 widget-left">
						<em class="glyphicon glyphicon-shopping-cart glyphicon-l"></em>
					</div>
					<div class="col-sm-9 col-lg-7 widget-right">
						<div class="large"><?= $total_buku; ?></div>
						<div class="text-muted">Total Buku</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-3">
			<div class="panel panel-orange panel-widget">
				<div class="row no-padding">
					<div class="col-sm-3 col-lg-5 widget-left">
						<em class="glyphicon glyphicon-comment glyphicon-l"></em>
					</div>
					<div class="col-sm-9 col-lg-7 widget-right">
						<div class="large"><?= $total_anggota; ?></div>
						<div class="text-muted">Total Anggota</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-3">
			<div class="panel panel-teal panel-widget">
				<div class="row no-padding">
					<div class="col-sm-3 col-lg-5 widget-left">
						<em class="glyphicon glyphicon-user glyphicon-l"></em>
					</div>
					<div class="col-sm-9 col-lg-7 widget-right">
						<div class="large"><?= $total_peminjaman; ?></div>
						<div class="text-muted">Total Peminjaman</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-3">
			<div class="panel panel-red panel-widget">
				<div class="row no-padding">
					<div class="col-sm-3 col-lg-5 widget-left">
						<em class="glyphicon glyphicon-stats glyphicon-l"></em>
					</div>
					<div class="col-sm-9 col-lg-7 widget-right">
						<div class="large"><?= $peminjaman_berjalan; ?></div>
						<div class="text-muted">Sedang Dipinjam</div>
					</div>
				</div>
			</div>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Grafik Peminjaman Buku Tahun <?= date('Y') ?></div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div><!--/.row-->

	<div class="row">

		<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="glyphicon glyphicon-book"></span>
					Daftar Peminjaman Buku Berjalan
				</div>

				<div class="panel-body">

					<div class="table-responsive">

						<table class="table table-bordered table-striped table-hover">

							<thead>
								<tr>
									<th>No</th>
									<th>No Peminjaman</th>
									<th>Nama Anggota</th>
									<th>Tanggal Pinjam</th>
									<th>Total Buku</th>
									<th>Status</th>
								</tr>
							</thead>

							<tbody>

								<?php if (!empty($peminjamanBerjalan)) : ?>

									<?php $no = 1; ?>
									<?php foreach ($peminjamanBerjalan as $row) : ?>

										<tr>
											<td><?= $no++; ?></td>
											<td><?= $row['no_peminjaman']; ?></td>
											<td><?= $row['nama_anggota']; ?></td>
											<td><?= date('d-m-Y', strtotime($row['tgl_pinjam'])); ?></td>
											<td><?= $row['total_pinjam']; ?></td>
											<td>
												<span class="label label-warning">
													<?= $row['status_transaksi']; ?>
												</span>
											</td>
										</tr>

									<?php endforeach; ?>

								<?php else : ?>

									<tr>
										<td colspan="6" class="text-center">
											Tidak ada transaksi peminjaman yang sedang berjalan
										</td>
									</tr>

								<?php endif; ?>

							</tbody>

						</table>

					</div>

				</div>

			</div>

		</div>

	</div>

</div> <!--/.main-->

<script>
	var dataPinjam = <?= json_encode($grafikPinjam); ?>;
</script>

</html>