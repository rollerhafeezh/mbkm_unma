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
			<p><?= $status[$bimbingan->status] ?></p>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Tgl. Kegiatan *</label>
			<p><?= date_indo($bimbingan->tgl_kegiatan) ?></p>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Deskripsi Logbook *</label>
			<?= $bimbingan->isi ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Lampiran (.pdf) *</label>
			<a class="d-block" <?= $bimbingan->file != '' ? 'href="'.$bimbingan->file.'" target="_blank"' : ''; ?> title=""><i class="fa fa-search"></i> Lihat Lampiran</a>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label >Lampiran Gambar / Foto (.jpeg, .jpg, .png) *</label>
			<a class="d-block" <?= $bimbingan->file_gambar != '' ? 'href="'.$bimbingan->file_gambar.'" target="_blank"' : ''; ?> title=""><i class="fa fa-search"></i> Lihat Lampiran</a>
		</div>
	</div>
</div>
<hr>
