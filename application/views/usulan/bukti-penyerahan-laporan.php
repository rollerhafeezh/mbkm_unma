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
	<?php $this->load->view('usulan/kop-surat') ?>

	<table width="100%">
		<tr>
			<td>
	      <center>
	        <h2 style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SURAT KETERANGAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
	        <h4>Nomor : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/PERPUS/<?= explode(' - ', $detail->homebase)[0] ?>-UNMA/<?= bulan_romawi(date('m')) ?>/<?= date('Y'); ?></h4>
	      </center>
	    </td>
		</tr>
	</table>
	<br>
	<br>
	<table border="0" width="100%" cellpadding="1">
		<tr>
			<td colspan="3">Yang Bertanda Tangan Dibawah Ini : <br> &nbsp;</td>
		</tr>
		<tr>
			<td width="200">Nama</td>
			<td width="15">:</td>
			<td><?= $detail->kepala_perpustakaan ?></td>
		</tr>
		<tr>
			<td width="200">Jabatan</td>
			<td width="15">:</td>
			<td>Kepala Perpustakaan</td>
		</tr>

		<tr>
			<td colspan="3"><br> Menyatakan dengan sesungguhnya bahwa : <br> &nbsp;</td>
		</tr>
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
			<td>Fakultas / Program Studi</td>
			<td>:</td>
			<td><?= ucwords(strtolower($detail->nama_fak)) ?> / <?= $detail->nama_prodi ?></td>
		</tr>
	</table>
	<br>
	<table width="100%" border="0">
		<tr>
			<td style="text-align: justify;">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mahasiswa tersebut telah menyerahkan Laporan <?= $usulan[0]->nm_mk ?> dengan judul <strong><?=  strip_tags($aktivitas_mahasiswa[0]->judul) ?></strong> ke Perpustakaan <?= ucwords(strtolower($detail->nama_fak)) ?>, Universitas Majalengka.
				<br><br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Surat Keterangan ini dibuat dengan sesungguhnya agar dapat dipergunakan sebagaimana mestinya.
			</td>
		</tr>
	</table>
	<br>
	<br>
	<table width="100%">
		<tr>
			<td align="center" width="40%">&nbsp;</td>
	    	<td width="20%">&nbsp;</td>
			<td align="center" width="40%">
				Majalengka, <?= date_indo(date('Y-m-d')) ?>
				<br>
				Kepala Perpustakaan,
				<br>
				<br>
				<br>
				<br>
				<br>
				<strong><?= $detail->kepala_perpustakaan ?></strong>
			</td>
		</tr>
	</table>
</body>
</html>