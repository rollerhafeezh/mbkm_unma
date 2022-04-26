<div class="card border-info">
	<div class="card-header bg-info">
	<h2 class="card-title text-white"> Detail KRS</h2>
	</div>
	<div class="card-body">
		<h3>Detail Validasi</h3><hr>
		<?php 
			if($krs_note->data){
			$data_validasi=1;
			foreach($krs_note->data as $key=>$value)
			{
				?>
		<div class="row mb-1">
			<div class="col-3">Catatan Dosen Wali</div>
			<div class="col-9"><?=$value->isi_catatan?></div>
		</div>
		<div class="row mb-1">
			<div class="col-3">Validasi Dosen Wali</div>
			<div class="col-9"><?=($value->validasi_krs=='0')?'Belum Acc':'Sudah Acc'?> <em>(tgl:<?=$value->tgl_acc?>)</em></div>
		</div>
		<div class="row mb-1">
			<div class="col-3">Validasi Program Studi</div>
			<div class="col-9"><?=($value->validasi_prodi!='0')?$value->validasi_prodi:'Belum Validasi'?> <em>(tgl:<?=$value->tgl_validasi_prodi?>)</em></div>
		</div>
		<div class="row mb-1">
			<div class="col-3">Validasi Akademik Fakultas</div>
			<div class="col-9"><?=($value->validasi_aka!='0')?$value->validasi_aka:'Belum Validasi'?> <em>(tgl:<?=$value->tgl_validasi_aka?>)</em></div>
		</div>
		<div class="row">
			<div class="col-3">Validasi Keuangan Fakultas</div>
			<div class="col-9"><?=($value->validasi_keu!='0')?$value->validasi_keu:'Belum Validasi'?> <em>(tgl:<?=$value->tgl_validasi_keu?>)</em></div>
		</div>
				<?php
			}
			}else{
				$data_validasi=0;
				echo "Belum Ada Data Validasi";
			}
			echo'<h3 class="mt-2">Detail KRS</h3>';
		if($krs->data){
			$data_krs=1; ?>
		<table width="100%" class="table compact table-stripped">
			<tr>
				<th>Nama Kelas</th>
				<th>SKS</th>
				<th>Status</th>
		<?php 
			foreach($krs->data as $key=>$value)
			{
				switch($value->status_krs){
					default: $status_krs='Belum Diajukan'; break;
					case 1: $status_krs='Belum Dibayar'; break;
					case 2: $status_krs='Sudah Dibayar'; break;
				}
				echo '<tr>
					<td>'.$value->nama_kelas_kuliah.'</td>
					<td>'.$value->sks_mk.'</td>
					<td>'.$status_krs.'</td></tr>';
			}
		?>
		</table>
		<?php  }else{ echo "Belum Ada Data Kelas"; $data_krs=0; } 
		echo'<h3 class="mt-2">Detail Kelas</h3>';
		if($kelas->data){
			$data_kelas=1; ?>
		<table width="100%" class="table compact table-stripped">
			<tr>
				<th>Nama Kelas</th>
				<th>SKS</th>
				<th>Nilai</th>
		<?php 
			foreach($kelas->data as $key=>$value)
			{
				echo '<tr>
					<td>'.$value->nama_kelas_kuliah.'</td>
					<td>'.$value->sks_mk.'</td>
					<td>'.$value->nilai_huruf.'</td>';
			}
		?>
		</table>
		<?php  }else{ echo "Belum Ada Data KRS"; $data_kelas=0; } ?>
	</div>
</div>

<div class="card border-success">
	<div class="card-header bg-success">
	<h2 class="card-title text-white"> Detail Kuliah Mahasiswa</h2>
	</div>
	<div class="card-body">
		<?php
			if($kuliah_mhs['status']==true){
				?>
		<div class="row mb-1">
			<div class="col-3">Status Semester ini</div>
			<div class="col-9"><?=$kuliah_mhs['detail'][0]['id_stat_mhs']?></div>
		</div>
		<div class="row mb-1">
			<div class="col-3">Semester Saat ini</div>
			<div class="col-9"><?=$kuliah_mhs['detail'][0]['smt_mhs']?></div>
		</div>
		<div class="row mb-1">
			<div class="col-3">SKS Semester</div>
			<div class="col-9"><?=$kuliah_mhs['detail'][0]['sks_smt']?></div>
		</div>
		<?php
			}else{
				echo "Belum Ada Data Kuliah Mahasiswa";
			}
		?>
	</div>
</div>

<div class="card border-dark">
	<div class="card-header bg-dark">
	<h2 class="card-title text-white"> Detail Keuangan SKS</h2>
	</div>
	<div class="card-body">
		<?php 
			if($tagihan->data){
			$data_tagihan=1;
			foreach($tagihan->data as $key=>$value)
			{
				if($value->besar_tagihan==$value->sisa_tagihan){
					$data_sisa=1;
				}else{
					$data_sisa=0;
				}
				?>
		<div class="row mb-1">
			<div class="col-3">Tanggal Tagihan</div>
			<div class="col-9"><?=$value->tgl_tagihan?></div>
		</div>
		<div class="row mb-1">
			<div class="col-3">Jenis Tagihan</div>
			<div class="col-9"><?=$value->jenis_tagihan?></div>
		</div>
		<div class="row mb-1">
			<div class="col-3">Tahun Akademik</div>
			<div class="col-9"><?=$value->thn_akademik?> <?=$value->smt_akademik?></div>
		</div>
		<div class="row mb-1">
			<div class="col-3">Besar Tagihan</div>
			<div class="col-9 text-bold-900">Rp. <?=number_format($value->besar_tagihan,0,',','.')?></div>
		</div>
		<div class="row mb-1">
			<div class="col-3">Sisa Tagihan</div>
			<div class="col-9 text-bold-900">Rp. <?=number_format($value->sisa_tagihan,0,',','.')?></div>
		</div>
		
				<?php
			}
			}else{
				$data_sisa=1;
				$data_tagihan=0;
				echo "Belum Ada Data Keuangan";
			}
		?>
	</div>
</div>

<div class="card border-danger">
	<div class="card-header bg-danger">
	<h2 class="card-title text-white">PERHATIAN! BACA DENGAN SEKSAMA</h2>
	</div>
	<div class="card-body">
	<h3>Saya ingin Drop KRS karena ingin pindah Kelas</h3>
	<p>Pindah kelas tidak boleh dilakukan dengan cara DROP KRS, silahkan datang ke Bagian Akademik Fakultas. Dan Minta untuk dibantu dipindahkan kelas kuliahnya.</p>
	<em>selama kelas yang dituju tidak penuh</em>
	<h3>Saya ingin Drop KRS Jadwal Kuliah Saya Bentrok</h3>
	<p>Pihak Akademik Fakultas Telah Menyediakan beberapa pilihan kelas kuliah. Tugas Mahasiswa adalah memilih jadwal yang sesuai, dan pastikan mahasiswa tidak memilih jadwal yang bentrok. Sehingga jadwal bentrok tidak menjadi alasan DROP KRS.</p>
	<em>mohon memilih kelas kuliah secara teliti dan seksama.</em>
	<h3>Tiba-tiba Jadwal Kuliah/ Kelas Kuliah saya berubah (tidak sesuai dengan KRS)</h3>
	<p>Hubungi Pihak Akademik Fakultas. Konfirmasi apakah pihak Akademik melakukan proses pemindahan kelas kuliah anda.</p>
	<em>tanyakan baik-baik kenapa sampai kelas kuliah pilihan anda dipindahkan.</em>
	</div>
</div>

<div class="card border-warning">
	<div class="card-header bg-warning">
	<h2 class="card-title text-white"> Persetujuan Reset KRS</h2>
	</div>
	<div class="card-body">
	<?php if($data_tagihan==0 and $data_krs==0 and $data_validasi==0 and $data_sisa==1) { ?>
		<blockquote class="blockquote pl-1 border-left-warning border-left-3">
			<p class="mb-0">Tidak ada masalah! Lanjut saja KRS!</p>
			<footer class="blockquote-footer">Hooman
				<cite title="Source Title">Admin UNMAKU</cite>
			</footer>
		</blockquote>
	<?php }else if($data_tagihan==0 or ($data_tagihan==1 and $data_sisa==1)) { ?>
		<blockquote class="blockquote pl-1 border-left-warning border-left-3">
			<p class="mb-0">Dengan ini saya menyetujui untuk mengulangi proses KRS dari Awal.</p>
			<footer class="blockquote-footer"><?=$detail_mhs_pt->nm_pd?>
				<cite title="Source Title">Mahasiswa</cite>
			</footer>
		</blockquote>
		<button class="btn btn-block btn-danger" onclick="reset_all()" >RESET KRS</button>
		<small>disclaimer: dengan menekan tombol reset krs maka akan menghapus semua record yang sudah terekam. dan anda harus mengulangi proses krs dari awal</small>
		<?php }else { ?>
			<h3>disclaimer: Kesempatan drop KRS kamu hanya tinggal 1 (satu) kali dalam satu semester sekarang.</h3>
			Fitur ini masih dalam pengembangan. Untuk melakukan Add Drop. Persiapkan Dokumen KRS anda dengan Ketentuan : <br>
			<ol>
				<li>Cetak KRS anda yang sudah disetujui oleh Dosen Wali</li>
				<li>Jika ingin mengurangi kelas, pastikan Dosen Wali Mencoret Data kelas yang ini Dibuang.</li>
				<li>Jika ingin Menambah kelas, pastikan Dosen Wali Menulis Data kelas yang ini ditambahkan.</li>
				<li>Dosen Wali menandatangani KRS yang akan diubah.</li>
				<li>Bawa Ke Pihak Akademik Fakultas untuk diteruskan ke Admin UNMAKU</li>
			</ol>
			Terima Kasih.
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
function reset_all()
{
	var id_mhs_pt='<?=$detail_mhs_pt->id_mahasiswa_pt?>';
	var data_krs='<?=$data_krs?>';
	var data_sisa='<?=$data_sisa?>';
	var data_validasi='<?=$data_validasi?>';
	var data_tagihan='<?=$data_tagihan?>';
	
	var x = confirm("Peringatan Terakhir : Apakah Anda Yakin akan Mengulangi KRS?");
	if (x){
		$.ajax({
			type:"POST",
			url: "<?=base_url('krs/reset_krs/')?>",
			cache: false,
			data:{id_mhs_pt:id_mhs_pt,data_krs:data_krs,data_tagihan:data_tagihan,data_validasi:data_validasi,id_smt:'<?=$_SESSION["active_smt"]?>'},
			success: function(respond){
				toastr.error("Berhasil Reset KRS");
					setTimeout(function () { window.location.replace("<?=base_url('krs/add/')?>"+id_mhs_pt);}, 2000)
			}
		});
	}else{
		return false;
	}
	return false;
}
</script>
