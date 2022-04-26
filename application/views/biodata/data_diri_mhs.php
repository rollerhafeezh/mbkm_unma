<div id="hasil"></div>
<div class="card border-info">
	<div class="card-header bg-info">
		<span class="card-title lead text-white">Data Diri Mahasiswa</span>
		<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<li><a data-action="collapse"><i class="text-white ft-plus"></i></a></li>
			</ul>
		</div>
	</div>
	<div class="card-content collapse show" style="">
	<div class="card-body">
	<?php foreach ($detail as $key=>$value) { 
		if($key=='jalan'){
			?>
		<div class="form-group row">
			<label class="col-3 label-control"><?=strtoupper(str_replace('_',' ',$key))?></label>
			<div class="col-5">
				<div class="input-group">
				<input type="text" id="jalan" name="jalan" value="<?=$value?:'-'?>" class="form-control" placeholder="Nama Jalan">
				<div class="input-group-append">
						<button onclick="update_data()" class="btn btn-info" type="button">UPDATE</button>
					</div>
				</div>
			</div>
		</div>
	<?php
		}else if($key=='blok'){
			?>
		<div class="form-group row">
			<label class="col-3 label-control"><?=strtoupper(str_replace('_',' ',$key))?></label>
			<div class="col-5">
				<div class="input-group">
				<input type="text" id="blok" name="blok" value="<?=$value?:'-'?>" class="form-control" placeholder="Nama Blok">
				<div class="input-group-append">
						<button onclick="update_data()" class="btn btn-info" type="button">UPDATE</button>
					</div>
				</div>
			</div>
		</div>
	<?php
		}else if($key=='rt'){
			?>
		<div class="form-group row">
			<label class="col-3 label-control"><?=strtoupper(str_replace('_',' ',$key))?></label>
			<div class="col-3">
				<div class="input-group">
				<input type="number" min="0" id="rt" name="rt" value="<?=$value?:'-'?>" class="form-control" placeholder="RT">
				<div class="input-group-append">
						<button onclick="update_data()" class="btn btn-info" type="button">UPDATE</button>
					</div>
				</div>
			</div>
		</div>
	<?php
		}else if($key=='rw'){
			?>
		<div class="form-group row">
			<label class="col-3 label-control"><?=strtoupper(str_replace('_',' ',$key))?></label>
			<div class="col-3">
				<div class="input-group">
				<input type="number" min="0" id="rw" name="rw" value="<?=$value?:'-'?>" class="form-control" placeholder="RW">
				<div class="input-group-append">
						<button onclick="update_data()" class="btn btn-info" type="button">UPDATE</button>
					</div>
				</div>
			</div>
		</div>
	<?php
		}else if($key=='kelurahan'){
			?>
		<div class="form-group row">
			<label class="col-3 label-control"><?=strtoupper(str_replace('_',' ',$key))?></label>
			<div class="col-5">
				<div class="input-group">
				<input type="text" id="kelurahan" name="kelurahan" value="<?=$value?:'-'?>" class="form-control" placeholder="Nama Kelurahan">
				<div class="input-group-append">
						<button onclick="update_data()" class="btn btn-info" type="button">UPDATE</button>
					</div>
				</div>
			</div>
		</div>
	<?php
		}else if($key=='id_wil'){
			?>
		<div class="form-group row">
			<label class="col-3 label-control"><?=strtoupper(str_replace('_',' ',$key))?></label>
			<div class="col-9">
				<select class="id_wil selectize" name="id_wil" placeholder="Nama Kecamatan"></select>
				<small>ID WILAYAH: <?= $value ?></small>
			</div>
		</div>
	<?php
		}else{
	
	?>
		<div class="form-group row">
			<label class="col-3 label-control"><?=strtoupper(str_replace('_',' ',$key))?></label>
			<div class="col-9">
				<?=$value?:'-'?>
			</div>
		</div>
	<?php  } } ?>
	</div>
	</div>
	</div>
<script type="text/javascript">
function update_data(){
	var jalan=$("#jalan").val();
	var blok=$("#blok").val();
	var rt=$("#rt").val();
	var rw=$("#rw").val();
	var kelurahan=$("#kelurahan").val();
	
	$.ajax({
		type:"POST",
		url: "<?php echo base_url('biodata/update_profil') ?>",
		cache: false,
		data:{
			jalan:jalan,
			blok:blok,
			rt:rt,
			rw:rw,
			kelurahan:kelurahan,
		},
		success: function(respond){
			toastr.info(respond);
		}
	})
}
</script>