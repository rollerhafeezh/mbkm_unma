<div class="row">
	<?php 
$kelas_kuliah=json_decode($this->curl->simple_get(ADD_API.'simak/kelas_kuliah_krs?active_smt='.$_SESSION['active_smt'].'&id_matkul='.$id_matkul));

if($kelas_kuliah==NULL){
echo "<h4 class='text-center text-danger'>Kelas Kuliah Belum di Atur</h4>";
}else{
foreach($kelas_kuliah as $val){
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
				<div class="btn btn-info btn-block btn-sm" onclick="take_kelas('<?=$val->id_kelas_kuliah?>-<?=$id_matkul?>')">Ambil Kelas</div>
			<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } }?>
</div>