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
					<h3>FORM PENILAIAN <?= strtoupper($penjadwalan->nama_kegiatan) ?> <!-- SEMINAR <?= strtoupper($usulan[0]->nm_mk) ?> (<?= acronym($usulan[0]->nm_mk) ?>) --></h3>
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
			<td style="line-height: 1.5"><?= count($aktivitas_mahasiswa) > 0 ? strip_tags($aktivitas_mahasiswa[0]->judul) : '' ?></td>
		</tr>
		<tr>
			<td>Pembimbing</td>
			<td>:</td>
			<td><?= $pembimbing[0]->nm_sdm ?></td>
		</tr>
	</table>
	<br>
	<table border="1" width="100%" cellpadding="7" cellspacing="0">
		<tr bgcolor="silver">
			<th rowspan="2" align="center" style="vertical-align: middle;"><b>Penilaian</b></th>
			<th colspan="4" align="center" >Komponen Nilai</th>
			<th rowspan="2" align="center" width="150" style="vertical-align: middle;">Rata-rata</th>
		</tr>
		<tr bgcolor="silver">
			<th width="100" align="center">Bimbingan</th>
			<th width="100" align="center">Laporan</th>
			<th width="100" align="center">Presentasi</th>
			<th width="100" align="center">Sikap</th>
		</tr>
		<?php
			$nilai_akhir = 0;
			$jenis_nilai = ['Pembimbing', 'Penguji', 'Ketua Sidang'];

		if ($data != '') {
			foreach ($nilai as $r_nilai) { 
		?>
		<tr>
			<td>
				Nilai <?= $jenis_nilai[$r_nilai->jenis_nilai-1] ?> <br>(<?= $r_nilai->nm_sdm ?>)
			</td>
			<td align="center" bgcolor="<?= $r_nilai->nilai_1 == '0' ? 'silver' : '' ?>">
				<?= $r_nilai->nilai_1 == '0' ? '' : $r_nilai->nilai_1 ?>
			</td>
			<td align="center" bgcolor="<?= $r_nilai->nilai_2 == '0' ? 'silver' : '' ?>">
				<?= $r_nilai->nilai_2 == '0' ? '' : $r_nilai->nilai_2 ?>
			</td>
			<td align="center" bgcolor="<?= $r_nilai->nilai_3 == '0' ? 'silver' : '' ?>">
				<?= $r_nilai->nilai_3 == '0' ? '' : $r_nilai->nilai_3 ?>
			</td>
			<td align="center" bgcolor="<?= $r_nilai->nilai_4 == '0' ? 'silver' : '' ?>">
				<?= $r_nilai->nilai_4 == '0' ? '' : $r_nilai->nilai_4 ?>
			</td>
			<td align="center">
				<?php $nilai_akhir += $r_nilai->rata_rata_nilai; echo $r_nilai->rata_rata_nilai; ?>
			</td>
		</tr>
		<?php } } else { ?>
		<tr>
			<td>Nilai Pembimbing I</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Nilai Pembimbing II</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Nilai Penguji</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Nilai Ketua Sidang</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php } ?>
		<tr bgcolor="silver">
			<th align="center" colspan="5">
				Nilai Akhir = (Total Rata-rata) / <?= $data != '' ? count($nilai) : '...........' ?>
			</th>
			<th align="center">
				<span class="nilai_angka"><?= $data != '' ? round($nilai_akhir / count($nilai), 2) : '.....' ?></span> (<span class="nilai_huruf"><?= $data != '' ? nilai_mutu(round($nilai_akhir / count($nilai), 2)) : '.....' ?></span>)
			</th>
		</tr>
	</table>
	<br>
	<table width="100%" border="0" cellpadding="5">
		<tr>
			<td style="white-space: nowrap; line-height: 1.5">
				Sehingga nilai akhir yang dicapai adalah: <u>&nbsp;&nbsp;&nbsp;&nbsp; <?= $data != '' ? round($nilai_akhir / count($nilai), 2) : '' ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
			</td>
		</tr>
		<tr>
			<td style="white-space: nowrap; line-height: 1.5">
				Dengan huruf mutu: <u>&nbsp;&nbsp;&nbsp;&nbsp; <?= $data != '' ? nilai_mutu(round($nilai_akhir / count($nilai), 2)) : '' ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="line-height: 1.5">
				Mahasiswa diwajibkan mengumpulkan laporan kerja praktek (sudah dijilid <i>hardcover</i>) selambat-lambatnya tanggal <u>&nbsp;&nbsp;&nbsp;<?= date_indo(date("Y-m-d", strtotime("+7 day", strtotime($penjadwalan->tanggal)))) ?>&nbsp;&nbsp;&nbsp;</u>
			</td>
		</tr>

	</table>
	<br>
	<br>
	<table width="100%">
		<tr>
			<td align="center" width="40%">
				<br>
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
	    	<td width="20%"></td>
			<td align="center" width="40%">
				Majalengka, <?= date_indo(date('Y-m-d')) ?> <br>
				Dosen Pembimbing,
				<br>
				<br>
				<?= $data == 1 ? 'TTD' : '<br>' ?>
				<br>
				<br>
				<strong style="text-decoration: underline;"><?= $pembimbing[0]->nm_sdm ?></strong>
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="3" align="center">
				<br>
				<br>
				Ketua Sidang,
	     	 	<br>
				<br>
				<?= $data == 1 ? 'TTD' : '<br>' ?>
				<br>
				<br>
				<strong style="text-decoration: underline;"><?= $penjadwalan->nm_sdm ?></strong>
			</td>
		</tr>
	</table>
	<br>
	<table>
		<tr>
			<td>Ketentuan huruf mutu:</td>
		</tr>
		<tr>
			<td>A (Baik Sekali)</td>
			<td>(80 &#8804; NA &#8804; 100)</td>
		</tr>
		<tr>
			<td>B (Baik)</td>
			<td>(70 &#8804; NA &#8804; 79)</td>
		</tr>
		<tr>
			<td>C (Cukup)</td>
			<td>(50 &#8804; NA &#8804; 69)</td>
		</tr>
		<tr>
			<td>D (Kurang)</td>
			<td>(NA &#8804; 49) harus mengulang seminar/sidang</td>
		</tr>
	</table>
</body>
</html>