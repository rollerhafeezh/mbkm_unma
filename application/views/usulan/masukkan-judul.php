<div class="card">
	<form action="" method="POST">
		<input type="hidden" name="id_aktivitas" value="<?= $aktivitas_mahasiswa[0]->id_aktivitas ?>">
		<div class="card-header pb-0">
			<h6><?= $title ?> <?= $usulan[0]->nm_mk ?></h6>

			<div class="heading-elements d-none d-md-block">
				<a class="btn btn-sm btn-danger" href="<?= base_url('usulan') ?>" onclick="return confirm('Apakah anda yakin ingin meninggalkan halaman ini ?')"><i class="ft-arrow-left"></i> Kembali</a>
				<button type="submit" class="btn btn-sm btn-success">Simpan</button>
			</div>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label for="judul" class="form-label">Masukkan Judul (<i>Bahasa Indonesia</i>)</label>
				<textarea class="judul_ form-control" rows="5" id="judul" name="judul" placeholder="Masukkan Judul Dalam Bahasa Indonesia"><?= $aktivitas_mahasiswa[0]->judul ?></textarea>
				<small class="form-help">Gunakan Penulisan Yang Rapih !</small>
			</div>
			<div class="form-group">
				<label for="judul_en" class="form-label">Masukkan Judul (<i>Bahasa Inggris</i>)</label>
				<textarea class="judul_en_ form-control" id="judul_en" rows="5" name="judul_en" placeholder="Masukkan Judul Dalam Bahasa Inggris"><?= $aktivitas_mahasiswa[0]->judul_en ?></textarea>
				<small class="form-help">Silahkan <a href="https://translate.google.com/?hl=id#view=home&op=translate&sl=id&tl=en&text=<?= $aktivitas_mahasiswa[0]->judul ?>" target="_blank">Klik Disini</a> Untuk Mendapatkan Judul Dalam Bahasa Inggris.</small>
			</div>
			<div class="mt-1 d-md-none d-block text-nowrap">
				<a class="btn btn-sm btn-danger" href="<?= base_url('usulan') ?>" onclick="return confirm('Apakah anda yakin ingin meninggalkan halaman ini ?')"><i class="ft-arrow-left"></i> Kembali</a>
				<button type="submit" class="btn btn-sm btn-success w-50">Simpan</button>
			</div>
		</div>
	</form>
</div>

<script>
	var form = document.querySelector('form')
	form.addEventListener('submit', event => {
		event.preventDefault()
		var formData = new FormData(form)

		fetch("/usulan/masukkan_judul", {
			method: 'POST',
			body: formData
		})
		.then( response => response.text())
		.then(text => {
			toastr.success('Judul Berhasil Disimpan.', 'Pemberitahuan')
		})
		.catch(err => {
			console.log(err)
		})
	})		
</script>