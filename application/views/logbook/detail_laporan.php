<style type="text/css">
	.form-group label {
		font-weight: bold;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="d-block">Status</label>
			<?php $status = ['Menunggu Persetujuan', 'Revisi', 'Disetujui']; ?>
			<p><?= $status[$laporan->status] ?></p>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Tgl. Laporan *</label>
			<p><?= date_indo($laporan->tgl_laporan) ?></p>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Lampiran (.pdf) *</label>
			<a class="d-block" <?= $laporan->file != '' ? 'href="'.$laporan->file.'" target="_blank"' : ''; ?> title=""><i class="fa fa-search"></i> Lihat Lampiran</a>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Lampiran Gambar / Foto (.jpeg, .jpg, .png) *</label>
			<a class="d-block" <?= $laporan->file_gambar != '' ? 'href="'.$laporan->file_gambar.'" target="_blank"' : ''; ?> title=""><i class="fa fa-search"></i> Lihat Lampiran</a>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
			<label >Rencana Kegiatan *</label>
			<?= $laporan->rencana_kegiatan ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Pelaksanaan Kegiatan *</label>
			<?= $laporan->pelaksanaan_kegiatan ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Analisis Hasil Kegiatan *</label>
			<?= $laporan->analisis_hasil_kegiatan ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Hambatan dan Upaya Mengatasi Hambatan *</label>
			<?= $laporan->hambatan ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Rencana Perbaikan dan Tindaklanjut *</label>
			<?= $laporan->rencana_perbaikan ?>
		</div>
	</div>
</div>
<hr>
