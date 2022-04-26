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
		<?php if (count($penguji) < 1): ?>
			<div class="font-small-3 alert alert-warning text-center">Dosen Penguji belum di-ploting oleh administrator. <br>
				Silahkan hubungi <b>Bagian Akademik</b> atau <b>Ketua Program Studi</b>.</div>
		<?php else: ?>
		<div class="row">
			<!-- Seminar / Sidang Online -->
			<?php
			$jadwal_sekarang = json_decode($this->curl->simple_get(ADD_API.'aktivitas/penjadwalan?id_aktivitas='.$aktivitas_mahasiswa[0]->id_aktivitas.'&tanggal='.date('Y-m-d').'&mulai='.date('H:i:s').'&selesai='.date('H:i:s', strtotime('+15 minutes')))) ?: [];

			if (count($jadwal_sekarang) > 0) {
			?>
			<div class="col-md-12">
				<div id="meet"></div>
				<script src='https://meet.jit.si/external_api.js'></script>
				<script type="text/javascript">
				const domain = 'meet.jit.si';
				const options = {
				    roomName: '<?= $jadwal_sekarang[0]->event_id ?>',
				    width: '100%',
				    height: 500,
				    parentNode: document.querySelector('#meet'),
				    interfaceConfigOverwrite: {
				    	TOOLBAR_BUTTONS: [
					        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
					        'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
					        'livestreaming', 'etherpad', 'settings', 'raisehand',
					        'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
					        'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone',
					        'e2ee', 'security'
					    ]
				    },
				    userInfo: {
				        displayName: '<?=$_SESSION['nama_user']?> (PENYAJI)'
				    }
				};
				const api = new JitsiMeetExternalAPI(domain, options);
			 	api.executeCommand('subject', '<?= $jadwal_sekarang[0]->nama_kegiatan.' ('.$aktivitas_mahasiswa[0]->id_aktivitas.')' ?>');
				</script>
				<div class="clearfix d-block m-1"></div>
			</div>
			<!-- Seminar / Sidang Online -->
			<?php } else { ?>
			<div class="col-md-12 collapse" tabindex="0" id="meet-collapse">
				<div id="meet"></div>
				<script src='https://meet.jit.si/external_api.js'></script>
				<script>
					const domain = 'meet.jit.si';
					const options = {
					    roomName: 'meet_penguji_<?= $aktivitas_mahasiswa[0]->id_aktivitas ?>',
					    width: '100%',
					    height: 500,
					    parentNode: document.querySelector('#meet'),
					    configOverwrite: { 
					    	startWithAudioMuted: true,
					    	startWithVideoMuted: true,
					    },
					 	interfaceConfigOverwrite: { 
					    	TOOLBAR_BUTTONS: [
						        'closedcaptions', 'desktop', 'fullscreen',
						        'fodeviceselection', 'chat',
						        'raisehand',
						        'videoquality', 'shortcuts',
						        'tileview',
						    ]
					    },
					    userInfo: {
					        displayName: '<?=$_SESSION['nama_user']?> (MAHASISWA)'
					    }
					};
					const api = new JitsiMeetExternalAPI(domain, options);
						api.executeCommand('subject', '<?= strtoupper($usulan[0]->nm_mk) ?>')
				</script>
				<div class="clearfix d-block m-1"></div>
			</div>
			<?php } ?>

			<div class="col-md-5">
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
						&nbsp; <a target="_blank" href="javascript:void(0)" class="badge badge-info" data-toggle="collapse" data-target="#meet-collapse" onclick="api.executeCommand('toggleAudio'); api.executeCommand('toggleVideo'); $(this).toggleClass('btn-info btn-danger')"><i class="ft-video"></i> Meet</a>
						<!-- &nbsp; <a target="_blank" href="<?= base_url('bimbingan/logbook_penguji') ?>" class="badge badge-info"><i class="ft-download"></i> Unduh</a> -->
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
		fetch('/bimbingan/aktivitas/2')
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
			formData.append('jenis_bimbingan', '2')
			
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