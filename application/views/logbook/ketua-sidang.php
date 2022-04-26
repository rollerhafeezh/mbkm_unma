<div class="card mb-0">
	<div class="card-header pb-0">
		<h6><?= $title ?></h6>

		<div class="heading-elements">
			<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-jadwal"><i class="ft-calendar"></i> Jadwal Seminar / Sidang</button>
		</div>
		<div class="modal fade text-left" id="modal-jadwal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" bis_skin_checked="1" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-lg" role="document" bis_skin_checked="1">
				<div class="modal-content" bis_skin_checked="1">
					<div class="modal-header border-bottom-0" bis_skin_checked="1">
						<h6 class="modal-title" id="myModalLabel17">Jadwal Seminar / Sidang</h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body p-0 rounded-bottom table-responsive" bis_skin_checked="1">
						<style type="text/css">
							.table th, .table td {
								padding: 10.5px !important;
							}

							.upload { 
								filter: grayscale(100%);
							}

							table.jadwal-seminar-sidang tr:last-child td {
							    border: none;
							}
						</style>
						<table class="table table- mb-0 font-small-3 table-hovered jadwal-seminar-sidang">
							<thead>
								<tr style="background: #eaf3fc;">
									<th  width="1">No</th>
									<th>Nama Kegiatan</th>
									<th>Dosen Penguji</th>
									<th>Tempat</th>
									<th>Tanggal</th>
									<th width="1">Mulai</th>
									<th width="1">Selesai</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php if (count($penjadwalan) < 1): ?>
								<tr>
									<td class="text-italic text-center" colspan="7">Jadwal Kegiatan Masih Kosong.</td>
								</tr>
								<?php else:
								$no = 1; 
								foreach ($penjadwalan as $r_penjadwalan) { ?>
								<tr>
									<td><?= $no; $no++ ?></td>
									<td><?= $r_penjadwalan->nama_kegiatan; ?></td>
									<td>
										<?php
											$list_penguji = json_decode($this->curl->simple_get(ADD_API.'aktivitas/penguji?id_aktivitas='.$r_penjadwalan->id_aktivitas.'&id_kegiatan='.$r_penjadwalan->id_kegiatan)) ?: [];
											foreach ($list_penguji as $r_penguji) {
												echo "<span data-toggle='tooltip' title='Penguji ke-$r_penguji->penguji_ke'>$r_penguji->nm_sdm</span>,<br>";
											}
										?>
									</td>
									<!-- <td><a target="_blank" href="<?= $r_penjadwalan->tautan ?>"><?= $r_penjadwalan->tempat; ?></a></td> -->
									<td><?= $r_penjadwalan->tempat; ?></td>
									<td><a target="_blank" href="<?= $r_penjadwalan->event_link ?>" target="_blank"><?= konversi_hari(date('w', strtotime($r_penjadwalan->tanggal))).', '.date_indo($r_penjadwalan->tanggal) ?></a></td>
									<td><?= $r_penjadwalan->mulai; ?></td>
									<td><?= $r_penjadwalan->selesai; ?></td>
									<td class="text-center">
										<?php if ($r_penjadwalan->tanggal == date('Y-m-d')): ?>
										<a href="<?= base_url('bimbingan/dosen_penguji') ?>" class="badge badge-info">Seminar</a>
										<?php else: ?>
										<a href="<?= 'https://pkl.unma.ac.id/'.$r_penjadwalan->slug.'/berita_acara/'.$r_penjadwalan->id_mahasiswa_pt.'?nama_smt='.$_SESSION['nama_smt'].'&data=1&id_kegiatan='.$r_penjadwalan->id_kegiatan ?>" target="_blank"><img src="http://a0.pise.pw/QJGVA">  Berita Acara</a>
										<!-- <a href="javascript:void(0)" class="badge badge-secondary">Seminar</a> -->
										<?php endif; ?>
									</td>
								</tr>
								<?php }
								endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<?php if (count($penjadwalan) < 1): ?>
			<div class="font-small-3 alert alert-warning text-center">Jadwal seminar / sidang dan ketua sidang belum di-input oleh administrator. <br>
				Silahkan hubungi <b>Bagian Akademik</b> atau <b>Ketua Program Studi</b>.</div>
		<?php else: ?>
		<div class="row">
			<div class="col-md-5">
				<!-- Informasi Dosen Pembimbing -->
				<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="px-1 pt-1 unggah-berkas">
					<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
						<b>Informasi Dosen Pembimbing</b>
					</legend>

					<?php $no = 1; foreach ($pembimbing as $r_pembimbing):  ?>
					<table border="0" cellspacing="0" cellpadding="3" class="font-small-3 mb-1">
						<tr>
							<td colspan="3"><b>Pembimbing Ke-<?= $r_pembimbing->pembimbing_ke ?></b></td>
						</tr>
						<tr>
							<td width="100" valign="top">Nama Dosen</td>
							<td valign="top">:</td>
							<td><?= $r_pembimbing->nm_sdm ?></td>
						</tr>
						<tr>
							<td>NIDN</td>
							<td>:</td>
							<td><?= $r_pembimbing->nidn ?></td>
						</tr>
						<tr>
							<td>No. HP</td>
							<td>:</td>
							<td><?= preg_replace('/^62/', '0', $r_pembimbing->no_hp) ?></td>
						</tr>
					</table>
					<?php endforeach; ?>
				</fieldset>
				<!-- Informasi Dosen Pembimbing -->

				<div class="clearfix d-block m-1"></div>

				<!-- Informasi Dosen Penguji -->
				<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="px-1 pt-1 unggah-berkas">
					<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
						<b>Informasi Dosen Penguji</b>
					</legend>

					<?php $no = 1; foreach ($penguji as $r_penguji):  ?>
					<table border="0" cellspacing="0" cellpadding="3" class="font-small-3 mb-1">
						<tr>
							<td colspan="3"><b>Penguji Ke-<?= $r_penguji->penguji_ke ?></b></td>
						</tr>
						<tr>
							<td width="100" valign="top">Nama Dosen</td>
							<td valign="top">:</td>
							<td><?= $r_penguji->nm_sdm ?></td>
						</tr>
						<tr>
							<td>NIDN</td>
							<td>:</td>
							<td><?= $r_penguji->nidn ?></td>
						</tr>
						<tr>
							<td>No. HP</td>
							<td>:</td>
							<td><?= preg_replace('/^62/', '0', $r_penguji->no_hp) ?></td>
						</tr>
						<tr>
							<td>Kegiatan</td>
							<td>:</td>
							<td><?= $r_penguji->nama_kegiatan ?></td>
					</table>
					<?php endforeach; ?>
				</fieldset>
				<!-- Informasi Dosen Penguji -->

				<div class="clearfix d-block m-1"></div>

				<!-- Informasi Ketua Sidang -->
				<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="px-1 pt-1 unggah-berkas">
					<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
						<b>Informasi Ketua Sidang</b>
					</legend>

					<?php $no = 1; foreach ($penjadwalan as $r_penjadwalan):  ?>
					<table border="0" cellspacing="0" cellpadding="3" class="font-small-3 mb-1">
						<tr>
							<td width="100" valign="top">Nama Dosen</td>
							<td valign="top">:</td>
							<td><?= $r_penjadwalan->nm_sdm ?></td>
						</tr>
						<tr>
							<td>NIDN</td>
							<td>:</td>
							<td><?= $r_penjadwalan->nidn ?></td>
						</tr>
						<tr>
							<td>No. HP</td>
							<td>:</td>
							<td><?= preg_replace('/^62/', '0', $r_penjadwalan->no_hp) ?></td>
						</tr>
						<tr>
							<td>Kegiatan</td>
							<td>:</td>
							<td><?= $r_penjadwalan->nama_kegiatan ?></td>
						</tr>
					</table>
					<?php endforeach; ?>
				</fieldset>
				<!-- Informasi Dosen Penguji -->

				<div class="clearfix d-block m-1"></div>

				<!-- Informasi Aktivitas -->
				<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="p-1 unggah-berkas">
					<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
						<b>Informasi Aktivitas</b>
					</legend>

					<table border="0" cellspacing="0" cellpadding="3" class="font-small-3">
						<tr>
							<td width="100" valign="top">Jenis Aktivitas</td>
							<td valign="top">:</td>
							<td><?= ucwords(strtolower($usulan[0]->nm_mk)) ?></td>
						</tr>
						<tr>
							<td>T. Akademik</td>
							<td>:</td>
							<td><?= $usulan[0]->nama_semester ?></td>
						</tr>
						<tr>
							<td>Program Studi</td>
							<td>:</td>
							<td><?= $detail->nama_prodi ?></td>
						</tr>
						<tr>
							<td>Lokasi</td>
							<td>:</td>
							<td><?= $aktivitas_mahasiswa[0]->lokasi ?></td>
						</tr>
						<tr>
							<td valign="top">Judul</td>
							<td valign="top">:</td>
							<td><?= $aktivitas_mahasiswa[0]->judul ?></td>
						</tr>
						<tr>
							<td valign="top">Jenis Anggota</td>
							<td valign="top">:</td>
							<td><?= $aktivitas_mahasiswa[0]->jenis_anggota == '0' ? 'Personal' : 'Kelompok' ?></td>
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
				<!-- <div class="row mt-1">
					<div class="col-md-12">
						<textarea class="form-control font-small-3" placeholder="Tulis Materi ..." rows="5"></textarea>
					</div>
					<div class="w-100 d-block mt-1"></div>
					<div class="col-8 font-small-3" style="vertical-align: middle; line-height: 2.4">
						<a href="#" data-toggle="tooltip" title="Klik untuk melampirkan dokumen."><i class="ft-paperclip"></i> Lampirkan Dokumen</a>
					</div>
					<div class="col-4">
						<button class="btn btn-success w-100 btn-sm"><i class="ft-navigation"></i> KIRIM</button>
					</div>
				</div>
				<hr> -->
				<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="px-1 unggah-berkas">
					<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
						<b>Catatan Revisi</b>
					</legend>
					<div class="aktivitas overflow-auto px-1" style="height: 95%"></div>
				</fieldset>
			</div>
		</div>
	<?php endif; ?>
	</div>
</div>
<script>
	var is_open = false
	var source = new EventSource('/bimbingan/sse')
	var offline

	source.onmessage = function(event) {
		if (!$('input').is(':focus')) {
			if (areAllInputsEmpty() && $('input:hover').length == 0 && is_open == false) {
				aktivitas()
				// console.log('aktivitas()')
			}
		}

		// console.log(is_open, $('input:hover').length, $('input').is(':focus'), areAllInputsEmpty())
	}

	$('input').click(function() {
		is_open = true
	})

	function areAllInputsEmpty() {
	  return $("input").filter(function() {
	    return $.trim($(this).val()).length > 0
	  }).length == 0
	}

	function aktivitas()
	{
		fetch('/bimbingan/aktivitas/3')
		.then(response => response.text())
		.then(text => {
			document.querySelector('.aktivitas').innerHTML = text
		})
		.then( () => {
			timeago.render(document.querySelectorAll(".timeago"), "id_ID")
			$('.tooltip').hide()
			// $('[data-toggle="tooltip"]').tooltip()
			$("body").tooltip({ selector: '[data-toggle=tooltip]' })
			is_open = false
			upload = null
		})
	}

	var upload;
	function lampirkan_dokumen(e) {
		e.parentElement.children[1].innerHTML = `<span class="text-nowrap overflow-hidden" style="width: 200px; text-overflow: ellipsis;">${e.files[0].name}</span> - <a onclick="reset(this, event)" class="text-danger">hapus</a>`
		upload = e
		// console.log(upload)
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
			formData.append('jenis_bimbingan', '8')
			
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