<div class="col-md-4">
	<!-- Informasi Aktivitas -->
	<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="p-1 unggah-berkas">
		<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
			<b>Informasi Aktivitas</b>
		</legend>

		<table border="0" cellspacing="0" cellpadding="3" class="font-small-3">
			<tr>
				<td class="no-wrap" valign="top">Jenis Program</td>
				<td valign="top">:</td>
				<td><?= $aktivitas_mahasiswa->nama_jenis_aktivitas_mahasiswa ?></td>
			</tr>
			<tr>
				<td style="white-space: nowrap">TA. Pelaksanaan</td>
				<td valign="top">:</td>
				<td><?= $aktivitas_mahasiswa->nama_semester ?></td>
			</tr>
			<tr>
				<td>Program Studi</td>
				<td valign="top">:</td>
				<td><?= $detail->homebase ?></td>
			</tr>
			<tr>
				<td>Lokasi</td>
				<td valign="top">:</td>
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

	<!-- Informasi Dosen Pembimbing -->
	<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="px-1 pt-1 unggah-berkas">
		<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
			<b>Dosen Pembimbing Lapangan</b>
		</legend>

		<?php $no = 1; $id_pembimbing = 0; foreach ($pembimbing as $r_pembimbing):  ?>
		<table border="0" cellspacing="0" cellpadding="3" class="font-small-3 mb-1">
			<tr>
				<td width="100" valign="top">Nama Dosen</td>
				<td valign="top">:</td>
				<td><?= $r_pembimbing->nm_sdm ?></td>
			</tr>
			<tr>
				<td>NIDN</td>
				<td>:</td>
				<td>
					<?= $r_pembimbing->nidn ?>
				</td>
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

	<!-- Informasi Dosen Koordinator -->
	<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="px-1 pt-1 unggah-berkas">
		<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
			<b>Koordinator Program</b>
		</legend>

		<?php $no = 1; $id_koordinator = 0; foreach ($koordinator as $r_koordinator):  ?>
		<table border="0" cellspacing="0" cellpadding="3" class="font-small-3 mb-1">
			<tr>
				<td width="100" valign="top">Nama Dosen</td>
				<td valign="top">:</td>
				<td><?= $r_koordinator->nm_sdm ?></td>
			</tr>
			<tr>
				<td>NIDN</td>
				<td>:</td>
				<td>
					<?= $r_koordinator->nidn ?>
				</td>
			</tr>
			<tr>
				<td>No. HP</td>
				<td>:</td>
				<td><?= preg_replace('/^62/', '0', $r_koordinator->no_hp) ?></td>
			</tr>
		</table>
		<?php endforeach; ?>
	</fieldset>
	<!-- Informasi Dosen Koordinator -->
	
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
					<!-- <th>Peran</th> -->
				</tr>
			</thead>
			<tbody>
				<?php $no = 1; $jenis_peran = ['-', 'Ketua', 'Anggota', 'Personal']; foreach ($anggota as $r_anggota): ?>
				<tr>
					<!-- <td><?= $no; $no++ ?>.</td> -->
					<td><?= $r_anggota->id_mahasiswa_pt ?></td>
					<td><?= $r_anggota->nm_pd ?></td>
					<!-- <td><?= $jenis_peran[$r_anggota->jenis_peran] ?></td> -->
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</fieldset>
	<!-- Informasi Peserta -->
	
	<div class="clearfix d-block m-1"></div>

	<!-- Aktivitas -->
	<fieldset style="border: 1px solid #BABFC7; margin: inherit;" class="p-1 unggah-berkas">
		<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">
			<b>Aktivitas</b>
		</legend>
		<style type="text/css">
			.table td,.table  th {
				padding: 10px !important;
			}
		</style>
		<table border="0" cellspacing="0" class="w-100 table-sm table-hover font-small-3">
			<tbody>
				<tr>
					<td><a href="<?= base_url('usulan/logbook/'.$aktivitas_mahasiswa->id_aktivitas) ?>" class="btn btn-sm <?= $this->uri->segment(2) == 'logbook' ? 'btn-info' : 'btn-secondary' ?> d-block w-100">Logbook</a></td>
				</tr>
				<tr>
					<td><a href="<?= base_url('usulan/laporan/'.$aktivitas_mahasiswa->id_aktivitas) ?>" class="btn btn-sm  <?= $this->uri->segment(2) == 'laporan' ? 'btn-info' : 'btn-secondary' ?> d-block w-100">Laporan</a></td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<!-- Aktivitas -->
</div>