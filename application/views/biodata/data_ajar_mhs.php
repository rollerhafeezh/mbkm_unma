<div id="accordionWrapa1" role="tablist" aria-multiselectable="true" class="">
	<div class="card">
		<div id="heading1" class="card-header bg-info" role="tab">
			<a data-toggle="collapse" href="#accordion1" aria-expanded="true" aria-controls="accordion1" class="card-title lead text-white">Data Ajar Mahasiswa</a>
		</div>
		<div id="accordion1" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading1" class="collapse show  border-info" style="">
			<div class="card-content">
				<div class="card-body">
		
	<div class="form-group row">
	  <label class="col-md-3 label-control" for="projectinput1">NPM</label>
	  <div class="col-md-9">
		<?php echo $detail->id_mahasiswa_pt; ?>
		</div>
	</div>
	<div class="form-group row">
	  <label class="col-md-3 label-control" for="projectinput1">Fakultas-Prodi</label>
	  <div class="col-md-9">
		<?php echo $detail->homebase; ?>
		</div>
	</div>
	<div class="form-group row">
	  <label class="col-md-3 label-control" for="projectinput1">Semester Diterima/ Sekarang</label>
	  <div class="col-md-9">
		<?php echo $detail->diterima_smt; ?>
		</div>
	</div>
	<div class="form-group row">
	  <label class="col-md-3 label-control" for="projectinput1">Dosen Wali</label>
	  <div class="col-md-9">
		<?php
			if($detail->id_dosen==0){
				echo'Belum mendapatkan Dosen Wali';
			}else{
				echo $detail->nm_sdm;
			}
		if($_SESSION['app_level'] == 6 or $_SESSION['app_level'] == 3) { ?>
			<a href="<?=base_url('mahasiswa/add_dosen/'.$detail->nipd)?>">+ Dosen Wali</a>
			<?php } ?>
		</div>
	</div>
	<div class="form-group row">
	  <label class="col-md-3 label-control" for="projectinput1">Dosen Wali SIMAK Lama</label>
	  <div class="col-md-9">
		<?php
			
				echo $detail->nama_dosen;
			
		?>
		</div>
	</div>
	</div>
	</div>
	</div>
	<!--CARD ATAS-->
	<div id="heading2" class="card-header  bg-success">
			<a data-toggle="collapse" href="#accordion2" aria-expanded="false" aria-controls="accordion2" class="card-title lead collapsed text-white">Data Ajar Detail</a>
		</div>
		<div id="accordion2" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading2" class="collapse border-success" aria-expanded="false">
			<div class="card-content">
				<div class="card-body">
	<?php foreach ($detail as $key=>$value) { if($value!=NULL){?>
		<div class="form-group row">
			<label class="col-md-3 label-control"><?=strtoupper(str_replace('_',' ',$key))?></label>
			<div class="col-md-9">
				<?=$value?>
			</div>
		</div>
	<?php  }} ?>
	</div>
	</div>
	</div>
	</div>
	</div>