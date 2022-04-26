<div class="card border-info">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Filter Pencarian : </h4>
		<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<li><a data-action="collapse"><i class="text-white ft-plus"></i></a></li>
			</ul>
		</div>
	</div>
	<div class="card-content collapse" style="">
		<div class="card-body">
			<div class="form-group row">
			  <label class="col-md-3 label-control" for="kode_fak">Fakultas</label>
			  <div class="col-md-9">
			  <select name="kode_fak" id="kode_fak" required class="form-control">
			  <option value="<?=$_SESSION['kode_fak']?>" selected>Semua</option>
				<?php

					foreach($fakultas as $r){
						echo'<option value="'.$r->kode_fak.'"> '.$r->nama_fak.'</option>';
					}
				?>
				</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-3 label-control" for="kode_prodi">Program Studi</label>
				<div class="col-md-9">
					<select id="kode_prodi" name="kode_prodi" class="form-control" required>
					<option value="<?=$_SESSION['kode_prodi']?>">Pilih Program Studi</option>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-3 label-control" for="id_smt">Semester</label>
				<div class="col-md-9">
					<select id="id_smt" name="id_smt" class="form-control" required/>
						<option value="0">Semua</option>
						<?php
							foreach ($nama_semester as $r){
								if($_SESSION['active_smt']==$r->id_semester) $selected='selected'; else $selected='';
								echo'<option value="'.$r->id_semester.'" '.$selected.'> '.$r->nama_semester.'</option>';
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-md-3 label-control" for="kelas_mhs">Kelas Mahasiswa</label>
				<div class="col-md-9">
					<select id="kelas_mhs" name="kelas_mhs" class="form-control" required>
						<option value="0">Semua Kelas</option>
						<option value="1">Reg</option>
						<option value="2">Non Reg</option>
					</select>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-md-12 label-control" for="kelas_mhs">Validasi</label>
				<div class="col-md-3">
					<select id="validasi_krs" name="validasi_krs" class="form-control" required>
						<option value="all">Dosen</option>
						<option value="1">Ya</option>
						<option value="0">Belum</option>
					</select>
				</div>
				<div class="col-md-3">
					<select id="validasi_aka" name="validasi_aka" class="form-control" required>
						<option value="all">Akademik</option>
						<option value="1">Ya</option>
						<option value="0">Belum</option>
					</select>
				</div>
				<div class="col-md-3">
					<select id="validasi_keu" name="validasi_keu" class="form-control" required>
						<option value="all">Keuangan</option>
						<option value="1">Ya</option>
						<option value="0">Belum</option>
					</select>
				</div>
				<div class="col-md-3">
					<select id="validasi_prodi" name="validasi_prodi" class="form-control" required>
						<option value="all">Prodi</option>
						<option value="1">Ya</option>
						<option value="0">Belum</option>
					</select>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-md-3 label-control" for="tabel_refresh">Otomatis Refresh Tabel</label>
				<div class="col-md-9">
					<input type="checkbox" value="1" checked id="tabel_refresh">
				</div>
			</div>

			
		</div>
	</div>
</div>

<table width="100%" class="table responsive table-striped table-bordered compact dataTable" id="dataTables_dosen_wali" role="grid">
	<thead>
		<tr role="row">
			<th>NPM</th>
			<th>Nama Mahasiswa</th>
			<th>Dosen Wali</th>
			<th>Keuangan</th>
			<th>Akademik</th>
			<th>Prodi</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<blockquote class="blockquote mt-2 pl-1 border-left-primary border-left-3">
	<p class="mb-0">Table tidak otomatis ter-refresh ketika berhasil validasi. Mencegah data tabel kembali ke atas</p>
</blockquote>
<script type="text/javascript">
	var table;
	$(document).ready(function() {
		table = $('#dataTables_dosen_wali').DataTable( {
			serverSide: true,
			processing: true,
			
			language: {
                url : "<?=base_url('assets/datatables/lang/ID.json')?>",
			},
			dom: 	"<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			lengthMenu: [
				[ 5, 10, 25, 50, -1 ],
				[ '5', '10', '25', '50', 'Semua Data' ]
			],
			pageLength: 5,
			buttons: [
				{
					extend:'pageLength',
					text:'Tampilkan Data',
					className:'btn btn-light',
				},
				{
					extend:'pdf',
					className:'btn btn-danger',
				},
				{
					extend:'excel',
					className:'btn btn-success',
				},
			],
			ajax: {
				url : "<?=base_url('datatable/json/get/validasi_krs/')?>",
				type 	: 'GET',
				data	:
						function(d){
							d.kode_fak =$("#kode_fak").val();
							d.kode_prodi = $("#kode_prodi").val();
							d.kelas_mhs=$("#kelas_mhs").val();
							d.id_smt=$("#id_smt").val();
							d.validasi_aka=$("#validasi_aka").val();
							d.validasi_krs=$("#validasi_krs").val();
							d.validasi_keu=$("#validasi_keu").val();
							d.validasi_prodi=$("#validasi_prodi").val();
						},
				
			},
			order:[1,'asc'],
			lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
			columns: [
				{ data: 'npm', name:'id_mahasiswa_pt',  render : 
					function ( data, type, row, meta ) {
						if(row.validasi_krs==1)
							return '<a target="_blank" href="<?=base_url()?>mahasiswa/detail/'+row.id_mhs+'">'+data+'</a>';
						else
							return data
					} },
				{ data: 'nm_pd', name:'mahasiswa.nm_pd', render : 
					function ( data, type, row, meta ) {
						if(row.validasi_krs==1)
							return '<a href="<?=base_url()?>krs/add/'+row.npm+'">'+data+'</a>';
						else
							return data
					}},
				{ data: 'validasi_krs', searchable:false, render : 
					function ( data, type, row, meta ) {
						if(data==0)
						{
							return '<div class="text-center text-danger">Belum</div>';
						}else{
							return '<div class="text-center text-success">Ya</div>';
						}
					}},
					{ data: 'validasi_keu', searchable:false, render : 
					function ( data, type, row, meta ) {
						if(data==0 && row.validasi_krs==0)
						{
							return '<div class="text-center text-warning">Tunggu Dosen Wali</div>';
						}
							else if(data==0 && row.validasi_krs!=0)
						{
							<?php if($_SESSION['app_level']==7){ ?>
							return '<div class="text-center text-info"><a style="cursor:pointer;" class="valid text-info"  siapa="keu" npm="'+row.npm+'" onclick="validasi(\'keu\',\''+row.npm+'\')">Validasi</a></div>';
							<?php }else { ?>
							return '<div class="text-center text-danger">Belum</div>';
							<?php } ?>
						}else{
							<?php if($_SESSION['app_level']==7){ ?>
							return '<div class="text-center text-danger"><a style="cursor:pointer;" class="valid text-success"  siapa="keu" npm="'+row.npm+'" onclick="unvalidasi(\'keu\',\''+row.npm+'\')">Ya</a></div>';
							<?php }else { ?>
							return '<div class="text-center text-success">Ya</div>';
							<?php } ?>
						}
					}},
					{ data: 'validasi_aka', searchable:false, render : 
					function ( data, type, row, meta ) {
						if(data==0 && row.validasi_krs==0)
						{
							return '<div class="text-center text-warning">Tunggu Dosen Wali</div>';
						}
							else if(data==0 && row.validasi_krs!=0)
						{
							<?php if($_SESSION['app_level']==6){ ?>
							return '<div class="text-center text-info"><a style="cursor:pointer;" class="valid text-info" siapa="aka" npm="'+row.npm+'" onclick="validasi(\'aka\',\''+row.npm+'\')">Validasi</a></div>';
							<?php }else { ?>
							return '<div class="text-center text-danger">Belum</div>';
							<?php } ?>
						}else{
							<?php if($_SESSION['app_level']==6){ ?>
							return '<div class="text-center text-success"><a style="cursor:pointer;" class="valid text-success" siapa="aka" npm="'+row.npm+'" onclick="unvalidasi(\'aka\',\''+row.npm+'\')">Ya</a></div>';
							<?php }else { ?>
							return '<div class="text-center text-success">Ya</div>';
							<?php } ?>
						}
					}},
					{ data: 'validasi_prodi', searchable:false, render : 
					function ( data, type, row, meta ) {
						if(data==0 && row.validasi_krs==0)
						{
							return '<div class="text-center text-warning">Tunggu Dosen Wali</div>';
						}
							else if(data==0 && row.validasi_krs!=0)
						{
							<?php if($_SESSION['app_level']==12){ ?>
							return '<div class="text-center text-info"><a style="cursor:pointer;" class="valid text-info"  siapa="prodi" npm="'+row.npm+'" onclick="validasi(\'prodi\',\''+row.npm+'\')">Validasi</a></div>';
							<?php }else { ?>
							return '<div class="text-center text-danger">Belum</div>';
							<?php } ?>
						}else{
							<?php if($_SESSION['app_level']==12){ ?>
							return '<div class="text-center text-success"><a style="cursor:pointer;" class="valid text-success"  siapa="prodi" npm="'+row.npm+'" onclick="unvalidasi(\'prodi\',\''+row.npm+'\')">Ya</a></div>';
							<?php }else { ?>
							return '<div class="text-center text-success">Ya</div>';
							<?php } ?>
						}
					}},
			],
		} );
		
	
	
	$('#id_smt').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
		console.log($(this).val());
    });
	
	$('#kode_prodi').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
		console.log($(this).val());
    });

    $('#kelas_mhs').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
		console.log($(this).val());
    });
	
	$('#validasi_aka').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
		console.log($(this).val());
    });
	$('#validasi_keu').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
		console.log($(this).val());
    });
	$('#validasi_krs').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
		console.log($(this).val());
    });
	$('#validasi_prodi').change(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
		console.log($(this).val());
    });

	$.ajaxSetup({
		type:"POST",
		url: "<?php echo base_url('ref/prodi_fak_clean') ?>",
		cache: false,
	});

	$("#kode_fak").change(function(){
		table.ajax.reload(null,false);
		var value=$(this).val();
		console.log(value);
		if(value>0){
			$.ajax({
			data:{id:value},
			success: function(respond){
				$("#kode_prodi").html(respond);
				}
			})
		}

	});

	} );

function validasi(oleh,id_mhs_pt)
	{
		var oleh = oleh;
		var id_mhs_pt = id_mhs_pt;
		var id_smt = $('#id_smt').val();
		var x = confirm("Apakah yakin akan dikonfirmasi?");
		if (x){
			$.ajax({
				type:"POST",
				url: "<?=base_url('krs/proses_validasi/')?>",
				cache: false,
				data:{id_mhs_pt:id_mhs_pt,oleh:oleh,id_smt:id_smt},
				success: function(respond){
					//console.log(respond);
					toastr.info('Validasi Berhasil');
					//table.ajax.reload(null,false); 
				}
			});
		}else{
			return false;
		}	
	}
function unvalidasi(oleh,id_mhs_pt)
	{
		var oleh = oleh;
		var id_mhs_pt = id_mhs_pt;
		var id_smt = $('#id_smt').val();
		var x = confirm("Apakah yakin akan Hapus Validasi?");
		if (x){
			$.ajax({
				type:"POST",
				url: "<?=base_url('krs/proses_unvalidasi/')?>",
				cache: false,
				data:{id_mhs_pt:id_mhs_pt,oleh:oleh,id_smt:id_smt},
				success: function(respond){
					//console.log(respond);
					toastr.warning('Hapus Validasi Berhasil');
					//table.ajax.reload(null,false); 
				}
			});
		}else{
			return false;
		}	
	}
</script>