<html>
<head>
	<title><?= $title ?></title>
	<style type="text/css">
		@page {
			margin-top: 10mm;
			margin-header: 0;
			margin-footer: 5mm;
		}
	</style>
</head>
<body style="font-family: calibri; font-size: 11pt">
	<?php $this->load->view('usulan/kop-surat') ?>

	<table width="100%">
		<tr>
			<td>
				<center>
					<h3>
						DAFTAR HADIR <br>
						<?= strtoupper($penjadwalan->nama_kegiatan) ?>
						<!-- SEMINAR <?= strtoupper($usulan[0]->nm_mk) ?> (<?= acronym($usulan[0]->nm_mk) ?>) --> <br>
						<?= strtoupper($detail->nama_fak) ?> - UNIVERSITAS MAJALENGKA <br>
						TAHUN AKADEMIK <?= explode(' ', $usulan[0]->nama_semester)[0] ?>
					</h3>
				</center>
			</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%">
		<tr>
			<td>Hari, Tanggal</td>
			<td>:</td>
			<td><?= konversi_hari(date('w', strtotime($penjadwalan->tanggal))).', '.date_indo($penjadwalan->tanggal) ?></td>
		</tr>
		<tr>
			<td>Nama Mahasiswa</td>
			<td>:</td>
			<td><?= $detail->nm_pd ?></td>
		</tr>
		<tr>
			<td width="200">Nomor Pokok Mahasiswa</td>
			<td width="15">:</td>
			<td><?= $detail->id_mahasiswa_pt ?></td>
		</tr>
		<tr>
			<td>Program Studi</td>
			<td>:</td>
			<td><?= $detail->nama_prodi ?></td>
		</tr>
		<tr>
			<td valign="top">Judul</td>
			<td  valign="top">:</td>
			<td><?= count($aktivitas_mahasiswa) > 0 ? $aktivitas_mahasiswa[0]->judul : '-' ?></td>
		</tr>
	</table>
	<br>
	<?php
	// $jadwal_sekarang = json_decode($this->curl->simple_get(ADD_API.'aktivitas/penjadwalan?id_aktivitas='.$aktivitas_mahasiswa[0]->id_aktivitas)) ?: [];
	$jadwal_sekarang = json_decode($this->curl->simple_get(ADD_API.'aktivitas/penjadwalan?id_aktivitas='.$aktivitas_mahasiswa[0]->id_aktivitas)) ?: [];

	if (count($jadwal_sekarang) > 0) {
		$peserta_hadir = json_decode($this->curl->simple_get(ADD_API.'aktivitas/penjadwalan?peserta_hadir=1&daftar_hadir=1&id_penjadwalan='.$jadwal_sekarang[0]->id_penjadwalan.'&id_kegiatan='.$_REQUEST['id_kegiatan'])) ?: [];
	} else {
		$peserta_hadir = [];
	}
	?>
	<table border="1" cellspacing="0" cellpadding="5" width="100%">
		<tr bgcolor="silver">
			<th width="15">NO</th>
			<th width="130">NO IDENTITAS</th>
			<th>NAMA</th>
			<th width="170">PERAN</th>
			<th width="100">TANDA TANGAN</th>
		</tr>
		<tr>
	        <td align="center"><?= $i = 1 ?>.</td>
	        <td align="center"><?= $penjadwalan->nidn ?></td>
	        <td><?= $penjadwalan->nm_sdm ?></td>
	        <td>KETUA SIDANG</td>
			<td align="center">TTD</td>
	    </tr>
		<?php
		foreach ($pembimbing as $r_pembimbing) {
		?>
		<tr>
	        <td align="center"><?= $i += 1 ?>.</td>
	        <td align="center"><?= $r_pembimbing->nidn ?></td>
	        <td><?= $r_pembimbing->nm_sdm ?></td>
	        <td>DOSEN PEMBIMBING <?= $r_pembimbing->pembimbing_ke ?></td>
			<td align="center">TTD</td>
	    </tr>
		<?php
		}

		foreach ($penguji as $r_penguji) {
		?>
		<tr>
	        <td align="center"><?= $i += 1 ?>.</td>
	        <td align="center"><?= $r_penguji->nidn ?></td>
	        <td><?= $r_penguji->nm_sdm ?></td>
	        <td>DOSEN PENGUJI <?= $r_penguji->penguji_ke ?></td>
			<td align="center">TTD</td>
	    </tr>
		<?php } ?>
		<tr>
	        <td align="center"><?= $i += 1 ?>.</td>
	        <td align="center"><?= $detail->id_mahasiswa_pt ?></td>
	        <td><?= $detail->nm_pd ?></td>
	        <td>PENYAJI</td>
			<td align="center">TTD</td>
	    </tr>
		<?php
		$i += 1;
		for ($ii = 1; $ii <= count($peserta_hadir); $ii++) {

			if ($ii <= count($peserta_hadir)) {
				$index = $ii;
			 	$detail = json_decode($this->curl->simple_get(ADD_API.'simak/detail_user/'.$peserta_hadir[$index-1]->id_user.'/'.$peserta_hadir[$index-1]->src_detail)) ?: [];
		        $detail_aka	=json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$peserta_hadir[$index-1]->id_user));
		    ?>
				<tr>
		            <td align="center"><?= $i ?>.</td>
		            <td align="center"><?= $peserta_hadir[$index-1]->id_user ?></td>
		            <td><?= $detail[0]->nama_user ?></td>
		            <td>MAHASISWA</td>
					<td align="center">TTD</td>
		        </tr>

		    <?php
			} else {
			?>
				<tr>
		            <td align="center"><?= $i ?>.</td>
		            <td align="center">&nbsp;</td>
		            <td>&nbsp;</td>
		            <td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
		        </tr>
			<?php
			} 
			$i++;
		} 
		?>
	</table>
	<br>
	<table width="100%">
		<tr>
			<td width="60%">
				&nbsp;
			</td>
			<td align="center">
				Majalengka, <?= date_indo(date('Y-m-d')) ?> <br>
				Ketua Sidang,
				<br>
				<br>
				<?= $data != '' ? 'TTD' : '<br>' ?>
				<br>
				<br>
				<strong><?= $penjadwalan->nm_sdm; ?></strong>
				<!-- ....................................... -->
			</td>
		</tr>
	</table>
</body>
</html>