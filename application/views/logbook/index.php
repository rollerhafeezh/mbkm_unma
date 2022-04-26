<div class="card mb-0">
	<div class="card-header pb-0">
		<h6><?= $title ?></h6>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-5">
				<!-- Informasi Aktivitas -->
				<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="p-1 unggah-berkas">
					<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
						<b>Informasi Aktivitas</b>
					</legend>

					<table border="0" cellspacing="0" cellpadding="3" class="font-small-3">
						<tr>
							<td width="120" valign="top">Jenis Program</td>
							<td valign="top">:</td>
							<td><?= $aktivitas_mahasiswa->nama_jenis_aktivitas_mahasiswa ?></td>
						</tr>
						<tr>
							<td>TA. Pelaksanaan</td>
							<td>:</td>
							<td><?= $aktivitas_mahasiswa->nama_semester ?></td>
						</tr>
						<tr>
							<td>Program Studi</td>
							<td>:</td>
							<td><?= $detail->homebase ?></td>
						</tr>
						<tr>
							<td>Lokasi</td>
							<td>:</td>
							<td><?= $aktivitas_mahasiswa->lokasi ?></td>
						</tr>
						<tr>
							<td valign="top">Judul</td>
							<td valign="top">:</td>
							<td><?= strip_tags($aktivitas_mahasiswa->judul) ?></td>
						</tr>
						<tr>
							<td valign="top">Jenis Anggota</td>
							<td valign="top">:</td>
							<td><?= $aktivitas_mahasiswa->jenis_anggota == '0' ? 'Personal' : 'Kelompok' ?></td>
						</tr>
					</table>
				</fieldset>
				<!-- Informasi Aktivitas -->
				
				<div class="clearfix d-block m-1"></div>

				<!-- Informasi Peserta -->
				<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="p-1 unggah-berkas">
					<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
						<b>Informasi Peserta (<?= count($anggota) ?> Orang)</b>
					</legend>
					<style type="text/css">
						.table td,.table  th {
							padding: 10px !important;
						}
					</style>
					<table border="0" cellspacing="0" class="w-100 table-sm table-hover font-small-3">
						<thead>
							<tr>
								<!-- <th>No.</th> -->
								<th>NPM</th>
								<th>Nama Mahasiswa</th>
								<th>Peran</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1; $jenis_peran = ['-', 'Ketua', 'Anggota', 'Personal']; foreach ($anggota as $r_anggota): ?>
							<tr>
								<!-- <td><?= $no; $no++ ?>.</td> -->
								<td><?= $r_anggota->id_mahasiswa_pt ?></td>
								<td><?= $r_anggota->nm_pd ?></td>
								<td><?= $jenis_peran[$r_anggota->jenis_peran] ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</fieldset>
				<!-- Informasi Peserta -->
			</div>

			<div class="w-100 d-block d-md-none m-1"></div>

			<div class="col-md-7">
				<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="px-1 unggah-berkas">
					<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
						<b>Logbook Harian / Mingguan / Bulanan</b>
					</legend>

					<form class="form-kirim-materi w-100" enctype="multipart/form-data">
						<div class="row mt-1">
								<div class="col-md-12">
									<textarea class="form-control font-small-3" placeholder="Tulis Sesuatu ..." rows="5" name="isi" required=""></textarea>

									<select class="form-control mt-1" name="id_kegiatan">
										<option value="1">Logbook Harian</option>
										<option value="2">Logbook Mingguan</option>
										<option value="3">Logbook Bulanan</option>
										<option value="4">Laporan Akhir</option>
									</select>
								</div>
								<div class="w-100 d-block mt-1"></div>
								<div class="col-md-8 font-small-3" style="vertical-align: middle; line-height: 2.4">
									<label class="form-help text-info" for="unggah-berkas">
					                    <input type="file" name="file" class="d-none" id="unggah-berkas" onchange="lampirkan_dokumen(this)">
					                    <span title="Maksimal 5 MB"><i class="ft-paperclip"></i>  Lampirkan Berkas</span>
					                </label>
								</div>
								<div class="col-md-4 text-right text-nowrap">
									<!-- <button type="button" class="w-50 btn btn-info btn-sm" data-toggle="collapse" data-target="#meet-collapse" onclick="api.executeCommand('toggleAudio'); api.executeCommand('toggleVideo'); $(this).toggleClass('btn-info btn-danger')" ><i class="ft-video"></i> MEET</button> -->
									<button type="submit" class="w-50 btn btn-success btn-sm"><i class="ft-navigation"></i> KIRIM</button>
								</div>
						</div>
					</form>
					<hr>

					<div class="aktivitas overflow-auto px-1" style="height: 95%">
						<div class="text-center font-small-3 text-italic p-1">
							<img src="https://simakng.unma.ac.id/assets/images/sticky%20battle.gif" class="d-block w-100">
							<i class="fa fa-spin fa-spinner"></i> Sedang Memuat Riwayat Logbook. Silahkan Tunggu ...
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>

<script>
	var is_open = false
	var source = new EventSource('/usulan/sse')
	var offline

	source.onmessage = function(event) {
		if (!$('input').is(':focus')) {
			if (areAllInputsEmpty() && $('input[type="file"]:hover').length == 0 && is_open == false) {
				aktivitas()
				// console.log('aktivitas()')
			}
		}

		// console.log(is_open, $('input[type="file"]:hover').length, $('input').is(':focus'), areAllInputsEmpty())
	}

	$('input[type="file"]').click(function() {
		is_open = true
	})

	function areAllInputsEmpty() {
	  return $("input").filter(function() {
	    return $.trim($(this).val()).length > 0
	  }).length == 0
	}

	function aktivitas()
	{
		fetch('/usulan/riwayat_logbook/1') // Mahasiswa
		.then(response => response.text())
		.then(text => {
			document.querySelector('.aktivitas').innerHTML = text
		})
		.then( () => {
			timeago.render(document.querySelectorAll(".timeago"), "id_ID")
			$('.tooltip').hide()
			$('[data-toggle="tooltip"]').tooltip()
		})
	}

	var upload;
	function lampirkan_dokumen(e) {
		e.parentElement.children[1].innerHTML = `<span class="text-nowrap overflow-hidden" style="width: 200px; text-overflow: ellipsis;">${e.files[0].name}</span> - <a onclick="reset(this, event)" class="text-danger">hapus</a>`
		upload = e
	}

	function reset(e, event) {
		event.preventDefault()
		var inputFile = e.parentElement.parentElement.children[0]
		var label = e.parentElement

		$(inputFile).val('')
		label.innerHTML = '<i class="ft-paperclip"></i>  Lampirkan Berkas'
		is_open = false
	}

	function kirim(e, event) {
		if (e.value != '' && event.keyCode == '13') {
			e.setAttribute('disabled', 'true')
			var formData = new FormData()
			formData.append('isi', e.value)
			formData.append('id_parent', e.dataset.id_parent)
			formData.append('id_aktivitas', e.dataset.id_aktivitas)
			formData.append('jenis_bimbingan', '1')
			
			if (upload)
				formData.append('file', upload.files[0])

			fetch('/bimbingan/kirim', {
				method: 'POST',
				body: formData
			})
			.then(response => response.text())
			.then(text => {
				aktivitas()
				is_open = false
			})
		}
	}

	function hapus(e) {
		var konfirmasi = confirm('Bade Dihapus ?')
		if (konfirmasi) {
			$('input').attr('disabled', 'true')
			fetch('/bimbingan/hapus', {
				method: 'POST',
				body: new URLSearchParams({ 
						id_bimbingan: e.dataset.id_bimbingan, 
						file: e.dataset.file
					})
			})
			.then(response => response.text())
			.then(text => {
				aktivitas()
				is_open = false
			})
		}
	}
</script>