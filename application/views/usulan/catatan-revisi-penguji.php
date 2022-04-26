<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
	<style type="text/css">
		@page {
			margin-top: 10mm;
			margin-header: 0;
		}
	</style>
</head>
<body style="font-family: calibri; font-size: 11pt">
	<table width="100%">
		<tr>
			<td>
				<center>
					<h3>FORMAT CATATAN REVISI <?= strtoupper($penjadwalan->nama_kegiatan) ?><!-- SEMINAR <?= strtoupper($usulan[0]->nm_mk) ?> (<?= acronym($usulan[0]->nm_mk) ?>) --></h3>
				</center>
	    	</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" cellpadding="1" style="margin-left: 40px;">
		<tr>
			<td width="200">Nama Mahasiswa</td>
			<td width="15">:</td>
			<td><?= $detail->nm_pd ?></td>
		</tr>
		<tr>
			<td>Nomor Pokok Mahasiswa</td>
			<td>:</td>
			<td><?= $detail->id_mahasiswa_pt ?></td>
		</tr>
		<tr>
			<td>Lokasi</td>
			<td>:</td>
			<td><?= $aktivitas_mahasiswa[0]->lokasi ?></td>
		</tr>
		<tr>
			<td valign="top">Judul <?= ucwords(strtolower($usulan[0]->nm_mk)) ?></td>
			<td valign="top">:</td>
			<td style="line-height: 1.5"><?= count($aktivitas_mahasiswa) > 0 ? strip_tags($aktivitas_mahasiswa[0]->judul) : '-' ?></td>
		</tr>
		<tr>
			<td>Penguji</td>
			<td>:</td>
			<td>
				<?php
				$peng_txt = '';
				foreach ($penguji as $pen) {
					$peng_txt .= '<span data-toggle="tooltip" title="Penguji ke '.$pen->penguji_ke.'"><sup>['.$pen->penguji_ke.']</sup>'.ucwords(strtolower($pen->nm_sdm)).'</span>, ';
				}
				echo rtrim($peng_txt, ', ');
				?>
			</td>
		</tr>
	</table>
	<br>
	<table width="100%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td width="100%" height="650" valign="top">
				<h3>Catatan Revisi:</h3>
				<?php
				if ($data != '') {
					$bimbingan	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/bimbingan?level_name=Dosen&id_aktivitas='.$aktivitas_mahasiswa[0]->id_aktivitas.'&jenis_bimbingan=2&id_kegiatan='.$penjadwalan->id_kegiatan)) ?: [];
					$no = 1;
					foreach ($bimbingan as $r_bimbingan) {
						// echo strip_tags(str_replace('#REVISI', '', urldecode($r_bimbingan->isi)), '<br>').' <br>';
						echo strip_tags(urldecode($r_bimbingan->isi), '<br>').' <br><br>';
						$no++;
					}
				}
				?>
			</td>
		</tr>
	</table>
	<br>
	
	<br>
	<table width="100%">
		<tr>
			<td width="60%">&nbsp;</td>
			<td align="center" width="40%">
				<br>
				Majalengka, <?= date_indo(date('Y-m-d')) ?> <br>
				<?php if(count($penguji) > 0): ?>
				Dosen Penguji,
	     	 	<br>
				<br>
				<?= $data == 1 ? 'TTD' : '<br>' ?>
				<br>
				<br>
				<strong style="text-decoration: underline;"><?= $penguji[0]->nm_sdm ?></strong>
				<?php endif; ?>
			</td>
		</tr>
	</table>
</body>
</html>