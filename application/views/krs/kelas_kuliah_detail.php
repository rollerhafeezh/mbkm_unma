<?php if ($lunas == 'ok') { ?>
<div class="row">
	<?php 
$kelas_kuliah=json_decode($this->curl->simple_get(ADD_API.'simak/kelas_kuliah_krs?active_smt='.$id_smt.'&id_matkul='.$id_matkul));

if($kelas_kuliah==NULL){
echo "<div class='col-md-12'><div class='alert alert-warning text-center'><i class='fa fa-info-circle'></i> Kelas kuliah belum tersedia. Silahkan hubungi bagian akademik fakultas.</div></div>";
}else{ ?>
<div class="col-md-12">
	<div class="alert bg-info alert-icon-left alert-arrow-left  mb-2" role="alert">
		<span class="alert-icon"><i class="la la-info"></i></span>
		Mahasiswa kampus merdeka hanya diperbolehkan mengambil <b>Kelas Reguler</b>.
	</div>
</div>
<?php foreach($kelas_kuliah as $val){
$kkk=json_decode($this->curl->simple_get(ADD_API.'simak/kontraktor_kelas_kuliah?id_kelas_kuliah='.$val->id_kelas_kuliah));
?>
	<div class="col-lg-4 col-md-6 col-sm-12">
		<div class="card border-info">
			<div class="card-content">
				<div class="card-body">
				<p class="h4"><?=$val->smt_mk?><?=$val->nama_kelas_kuliah?></p>
					<p>
					Kuota <?=$kkk?>/<?=$val->kuota_kelas?><br>
					<?=$val->kode_mk?><br>
					<?=$val->sks_mk?> SKS<br>
					Gedung <?=$val->nama_gedung?><br>
					Ruang <?=$val->nama_ruangan?><br>
					Hari <?=$val->hari_kuliah?> Jam <?=$val->jam_mulai?> s/d <?=$val->jam_selesai?>
					</p>
					<p class="text-bold-600">Dosen Pengampu Kelas:</p>
				
				<?php $ampu_kuliah=json_decode($this->curl->simple_get(ADD_API.'simak/dosen_kelas_kuliah?id_kelas_kuliah='.$val->id_kelas_kuliah));
				if($ampu_kuliah==NULL){
				echo "<p>Dosen Belum di Atur</p>";
				}else{
				foreach($ampu_kuliah as $ampu){ ?>

				<?=$ampu->nidn?> <?=$ampu->nm_sdm?><br>
				<?php }} 
				if($kkk >= $val->kuota_kelas){
				?>
				<div class="btn btn-danger btn-block btn-sm">Kelas Penuh</div>
			<?php }else{ ?>
				<div class="btn btn-info btn-block btn-sm" onclick="take_kelas_kuliah('<?=$val->id_kelas_kuliah?>-<?=$id_matkul?>')">Ambil Kelas</div>
			<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } }?>
</div>
<?php } else if($lunas=='bayar'){
	?>
	<div class="alert bg-warning alert-icon-left alert-arrow-left mb-0" role="alert">
		<span class="alert-icon"><i class="la la-info"></i></span>
		Silahkan melakukan pembayaran <b>Heregristrasi</b> terlebih dahulu. Pembayaran bisa dilakukan menggunakan akun Mahasiswa pada UNMAKU (Logout terlebih dahulu).
	</div>
<?php
/*--------------------LUNAS OKE END---------------*/
}else if($lunas=='err1'){
	?>
	<pre>
		Status Tagihan = NOT PAID
		Status Pembayaran = PAID
		HUBUNGI BAUK!
	</pre>
<?php
}else if($lunas=='err2'){
	?>
	<pre>
		Status Tagihan = PAID
		Status Pembayaran = NOT PAID
		HUBUNGI BAUK!
	</pre>
<?php
}else if($lunas=='err3'){
	?>
	<pre>
		BELUM BISA KRSAN BANG!
	</pre>
<?php
}else{
	?>
	<div class="btn text-center text-white btn-lg btn-danger btn-outline-primary">Silahkan Melakukan Pembayaran Registrasi/ Heregristrasi Terlebih Dahulu</div>
	<div class="text-bold-700">Untuk mencetak Invoice silahkan ke Menu Keuangan > Invoice</div>
<?php
}