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
	        <h3>FORMULIR PENDAFTARAN SEMINAR <?= strtoupper($usulan[0]->nm_mk) ?> (<?= acronym($usulan[0]->nm_mk) ?>)</h3>
	        <h3>PROGRAM STUDI <?= strtoupper($detail->nama_prodi) ?> <?= $detail->nama_fak ?></h3>
	        <h3>UNIVERSITAS MAJALENGKA</h3>
	        <h3>TAHUN AKADEMIK <?= explode(' ', $usulan[0]->nama_semester)[0] ?></h3>
	      </center>
	    </td>
		</tr>
	</table>
	<br>
	<div style="width: 100%;height: 2px;background-color: #000"></div>
	<br>
	<table border="0" width="100%" cellpadding="5">
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
		<tr>
			<td>Tempat, Tanggal Lahir</td>
			<td>:</td>
			<td><?= ucwords(strtolower($detail->tmp_lahir)) ?>, <?= date_indo($detail->tgl_lahir) ?></td>
		</tr>
	</table>
	<table border="0" width="100%" cellpadding="5">
	  <tr>
	    <td colspan="4">Syarat-syarat yang harus dipenuhi</td>
	  </tr>
	  <tr>
	    <td>1.</td>
	    <td colspan="3">Tanda bukti telah menyelesaikan administrasi umum dan keuangan</td>
	  </tr>
	  <tr>
	    <td>2.</td>
	    <td colspan="3">Menyerahkan berkas ke jurusan paling lambat 3 (tiga) hari sebelum seminar</td>
	  </tr>
	  <tr>
	    <td></td>
	    <td valign="top">a.</td>
	    <td>Draf <?= $usulan[0]->nm_mk ?> (<?= acronym($usulan[0]->nm_mk) ?>) rangkap 2 yang telah disetujui oleh pembimbing dengan bukti telah dibubuhi tanda tangan</td>
	    <td>
				<table border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</td>
	  </tr>
	  <tr>
	    <td></td>
	    <td>b.</td>
	    <td>Ringkasan draf <?= acronym($usulan[0]->nm_mk) ?> rangkap 10</td>
	    <td>
				<table border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</td>
	  </tr>
	  <tr>
	    <td></td>
	    <td>c.</td>
	    <td>Softcopy <?= (acronym($usulan[0]->nm_mk) == 'KP') ? 'Laporan Kemajuan' : 'Kartu Bimbingan' ?> <?= acronym($usulan[0]->nm_mk) ?></td>
	    <td>
				<table border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</td>
	  </tr>
	  <tr>
	    <td></td>
	    <td>d.</td>
	    <td>Softcopy power point hasil <?= acronym($usulan[0]->nm_mk) ?> 1 buah (bentuk CD sudah diberi nama dan NPM)</td>
	    <td>
				<table border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</td>
	  </tr>
	  <tr>
	    <td></td>
	    <td>e.</td>
	    <td>Fotocopy Kartu Tanda Mahasiswa (KTM) 1 buah</td>
	    <td>
				<table border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</td>
	  </tr>
	  <tr>
	    <td></td>
	    <td>f.</td>
	    <td>Berkas dimasukan ke dalam map warna <?= strtolower($detail->warna_map) ?></td>
	    <td></td>
	  </tr>
	</table>
	<br>
	<table width="100%">
		<tr>
			<td align="center" width="40%">
				Kasubag Administrasi Umum <br>dan Keuangan,
	      		<br>
				<br>
				<br>
				<br>
				<br>
				<strong style="text-decoration: underline;"><?= $detail->kasubbag_keuangan ?></strong>
			</td>
	   	 	<td width="20%"></td>
			<td align="center" width="40%">
				<br>
				Pembimbing,
				<br>
				<br>
				<br>
				<br>
				<br>
				<strong style="text-decoration: underline;"><?= count($pembimbing) > 0 ? $pembimbing[0]->nm_sdm : 'Belum Diatur' ?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				<br> <br>
				Ketua Program Studi <br> <?= $detail->nama_prodi ?>,
				<br>
				<br>
				<br>
				<br>
				<br>
				<strong style="text-decoration: underline;"><?= $detail->kaprodi ?></strong>
			</td>
		</tr>
	</table>
</body>
</html>