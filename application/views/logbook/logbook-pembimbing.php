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
			<td><center><h3><?= (acronym($usulan[0]->nm_mk) == 'KP') ? 'LAPORAN KEMAJUAN' : 'JURNAL' ?> <?= acronym($usulan[0]->nm_mk) ?></h3></center></td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%">
		<tr>
			<td width="200">Nomor Pokok Mahasiswa</td>
			<td width="15">:</td>
			<td><?= $detail->id_mahasiswa_pt ?></td>
		</tr>
		<tr>
			<td>Nama Mahasiswa</td>
			<td>:</td>
			<td><?= $detail->nm_pd ?></td>
		</tr>
		<tr>
			<td>Tahun Akademik</td>
			<td>:</td>
			<td><?= explode(' ', $usulan[0]->nama_semester)[0] ?></td>
		</tr>
		<tr>
			<td>Program Studi</td>
			<td>:</td>
			<td><?= $detail->nama_prodi ?></td>
		</tr>
		<tr>
			<td>Pembimbing</td>
			<td>:</td>
			<td>
				<?php
				$pmb_text = '';
				foreach ($pembimbing as $pmb) {
					$pmb_text .= '<span data-toggle="tooltip" title="Pembimbing ke '.$pmb->pembimbing_ke.'"><sup>['.$pmb->pembimbing_ke.']</sup>'.ucwords(strtolower($pmb->nm_sdm)).'</span>, ';
				}
				echo rtrim($pmb_text, ', ');
				?>
			</td>
		</tr>
		<tr>
			<td valign="top">Judul</td>
			<td  valign="top">:</td>
			<td><strong><?= count($aktivitas_mahasiswa) > 0 ? strip_tags($aktivitas_mahasiswa[0]->judul) : '-' ?></strong></td>
		</tr>
	</table>
	<br>
	<table border="1" cellspacing="0" cellpadding="5" width="100%">
		<tr>
			<th width="15">NO</th>
			<th width="150">TANGGAL</th>
			<th>MATERI YANG DISAMPAIKAN</th>
			<th width="100">PARAF</th>
		</tr>
		<?php 
		$no = 1;
		if (count($bimbingan) < 1) {
			echo "<tr><td align='center' colspan='4'>Belum ada kegiatan bimbingan dilakukan.</td></tr>";
		}
		foreach ($bimbingan as $r_bimbingan) { ?>
		<tr>
			<td align="center"><?= $no++ ?>.</td>
			<td align="center" style="white-space: nowrap;"><?= date_indo(explode(' ', $r_bimbingan->created_at)[0]) ?></td>
			<td><?= strip_tags(urldecode($r_bimbingan->isi), '<br>') ?></td>
			<td><?= $r_bimbingan->nama_user ?></td>
		</tr>
		<?php } ?>
	</table>
	<br>
	<?= ucwords(strtolower($usulan[0]->nm_mk)) ?> telah disetujui untuk diajukan dalam sidang/seminar pada Program Studi <?= $detail->nama_prodi ?>:
	<br>
	<br>
	<table width="100%">
		<tr>
			<td align="center">
				Ketua Program Studi <br> <?= $detail->nama_prodi ?>,
				<br>
				<br>
				TTD
				<br>
				<br>
				<strong style="text-decoration: underline;"><?= $detail->kaprodi ?></strong>
			</td>
			<td align="center">
				Majalengka, <?php echo date_indo(date('Y-m-d')); ?><br>
				Pembimbing,
				<br>
				<br>
				TTD
				<br>
				<br>
				<strong style="text-decoration: underline;"><?= count($pembimbing) > 0 ? $pembimbing[0]->nm_sdm : 'Belum Diatur' ?></strong>
			</td>
		</tr>
	</table>
</body>
</html>