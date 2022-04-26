<?php  
	$nilai_pemb = count($nilai_pembimbing) < 1 ? '0' : $nilai_pembimbing[0]->rata_rata_nilai;
 	$nilai_peng = count($nilai_penguji) < 1 ? '0' : $nilai_penguji[0]->rata_rata_nilai;
 	$nilai_ket = count($nilai_ketua_sidang) < 1 ? '0' : $nilai_ketua_sidang[0]->rata_rata_nilai;

 	$nilai_angka = 0;
 	foreach ($nilai as $r_nilai) {
 		$nilai_angka += $r_nilai->rata_rata_nilai;
 	}

 	$nilai_angka = round($nilai_angka / count($nilai), 2);
 ?>

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
					<h3>
						BERITA ACARA <?= strtoupper($penjadwalan->nama_kegiatan) ?>
						<!--  SEMINAR <?= strtoupper($usulan[0]->nm_mk) ?> (<?= acronym($usulan[0]->nm_mk) ?>) -->
					</h3>
				</center>
	    	</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%">
		<tr>
			<td style="text-align: justify; line-height: 1.5">
				<?php $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu']; ?>
				Pada hari ini, <?= $hari[date('w', strtotime($penjadwalan->tanggal))] ?> tanggal <?= date_indo($penjadwalan->tanggal)  ?> pukul <?= substr($penjadwalan->mulai, 0, 5)  ?> WIB sampai dengan <?= substr($penjadwalan->selesai, 0, 5)  ?> WIB telah dilaksanakan <?= $penjadwalan->nama_kegiatan ?> <!-- Seminar <?= ucwords(strtolower($usulan[0]->nm_mk)) ?> --> Mahasiswa Tahun Akademik <?= explode(' ', $_SESSION['nama_smt'])[0] ?>, Program Studi <?=  $detail->nama_prodi ?>, menyatakan bahwa :
			</td>
		</tr>
	</table>
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
			<td valign="top">Judul <?= ucwords(strtolower($usulan[0]->nm_mk)) ?></td>
			<td valign="top">:</td>
			<td style="line-height: 1.5"><?= count($aktivitas_mahasiswa) > 0 ? strip_tags($aktivitas_mahasiswa[0]->judul) : '-' ?></td>
		</tr>
		<tr>
			<td>Pembimbing</td>
			<td>:</td>
			<td>
				<?php
					$pmb_text = '';
					foreach ($pembimbing as $pmb) {
						$pmb_text .= '<sup>['.$pmb->pembimbing_ke.']</sup>'.ucwords(strtolower($pmb->nm_sdm)).', ';
					}
					echo rtrim($pmb_text, ', ');
				?>
			</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" cellpadding="2">
	  <tr>
	    <td colspan="2">Dengan hasil pengujian sebagai berikut :</td>
	  </tr>
	  <tr>
	    <td width="240">DINYATAKAN</td>
 	    <td>: 
 	    	<?php 
 	    		if ($data == 1) {
 	    			echo ($nilai_angka <= 70) ? "<del>LULUS</del> / TIDAK LULUS *)" : "LULUS / <del>TIDAK LULUS</del> *)";
 	    		} else {
 	    			echo "LULUS / TIDAK LULUS *)";
 	    		}
 	    	?>
 		</td>
	  </tr>
	  <tr>
	    <td>DENGAN NILAI</td>
	    <td>: <u>&nbsp;&nbsp;&nbsp;&nbsp; <?= $data != '' ? $nilai_angka : '' ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
	  </tr>
	  <tr>
	    <td>NILAI HURUF</td>
	    <td>: <u>&nbsp;&nbsp;&nbsp;&nbsp; <?= $data != '' ? nilai_mutu($nilai_angka) : '' ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
	  </tr>
	  <tr>
	  	<td colspan="2">
	  		Demikian berita acara ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
	  	</td>
	  </tr>
	</table>
	<br>
	<table width="100%">
		<tr>
			<td>*) Coret yang tidak sesuai.</td>
		</tr>
	</table>
	<br>
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
</body>
</html>