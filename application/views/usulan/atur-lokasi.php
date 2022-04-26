<div class="card">
	<form action="<?= base_url('usulan/atur_lokasi') ?>" method="POST">
		<input type="hidden" name="id_aktivitas" value="<?= $aktivitas_mahasiswa[0]->id_aktivitas ?>">
		<div class="card-header pb-0">
			<h6><?= $title ?> <?= $usulan[0]->nm_mk ?></h6>

			<div class="heading-elements d-none d-md-block">
				<a class="btn btn-sm btn-danger" href="<?= base_url('usulan') ?>" onclick="return confirm('Apakah anda yakin ingin meninggalkan halaman ini ?')"><i class="ft-arrow-left"></i> Kembali</a>
				<button type="submit" class="btn btn-sm btn-success">Simpan</button>
			</div>
		</div>
		<div class="card-body">
			<textarea class="lokasi_ form-control" rows="5" name="lokasi" placeholder="Masukan Nama Lokasi ..."><?= $aktivitas_mahasiswa[0]->lokasi ?></textarea>
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

		fetch("/usulan/atur_lokasi", {
			method: 'POST',
			body: formData
		})
		.then( response => response.text())
		.then(text => {
			toastr.success('Lokasi Berhasil Disimpan.', 'Pemberitahuan')
		})
		.catch(err => {
			console.log(err)
		})
	})		
</script>
