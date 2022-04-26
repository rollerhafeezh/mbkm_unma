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
	<body style="font-family: calibri;font-size: 11pt">
		<?php $this->load->view('usulan/kop-surat') ?>
		<table width="100%">
			<tr>
				<td><center><h2>FORMULIR PENDAFTARAN <?= strtoupper($usulan[0]->nm_mk) ?></h2></center></td>
			</tr>
		</table>
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
				<td>Tempat, Tanggal Lahir</td>
				<td>:</td>
				<td><?= ucwords(strtolower($detail->tmp_lahir)) ?>, <?= date_indo($detail->tgl_lahir) ?></td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td><?= $detail->jk == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
			</tr>
			<tr>
				<td>Agama</td>
				<td>:</td>
				<td><?= $detail->agama ?></td>
			</tr>
			<tr>
				<td>Kewarganegaraan</td>
				<td>:</td>
				<td>WNI</td>
			</tr>
			<tr>
				<td valign="top">Alamat</td>
				<td valign="top">:</td>
				<td><?= $detail->jalan ?> <?= $detail->blok ?> RT <?= $detail->rt.' / RW '.$detail->rw ?> <?= ucwords(strtolower($detail->kecamatan.' '.$detail->kabupaten.' '.$detail->provinsi)) ?></td>
			</tr>
			<tr>
				<td>Telp/HP</td>
				<td>:</td>
				<td><?= $detail->no_hp ?></td>
			</tr>
			<tr>
				<td>Fakultas / Program Studi</td>
				<td>:</td>
				<td><?= ucwords(strtolower($detail->nama_fak)).' / '.$detail->nama_prodi ?></td>
			</tr>
			<tr>
				<td>Tahun Akademik</td>
				<td>:</td>
				<td><?= explode(' ', $usulan[0]->nama_semester)[0] ?></td>
			</tr>
		</table>
		<br>
			<div style="border: 2px solid #000;width: 2.8cm;height: 3.8cm;margin: 0 auto; text-align: center; vertical-align: middle;">
				<br><br><br>
				<small>Foto Berwarna 3x4</small>
			</div>
		<br>
		<table width="100%">
			<tr>
				<td align="center">
					<br>
					Dosen Wali,
					<br>
					<br>
					<br>
					<br>
					<br>
					<strong style="text-decoration: underline;"><?= $detail->nm_sdm ?></strong>
				</td>
				<td align="center">
					Majalengka, <?php echo date_indo(date('Y-m-d')); ?><br>
					Yang Mengajukan,
					<br>
					<br>
					<br>
					<br>
					<br>
					<strong><?= $detail->nm_pd ?></strong>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<br>
					<br>	
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