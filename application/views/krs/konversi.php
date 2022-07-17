<style type="text/css">
	.loading {
	    background: url('https://mbkm.unma.ac.id/assets/images/loading.gif');
	    background-repeat: no-repeat;
	    background-position: right;
	    background-size: contain;
	}

	input[type="search"]::-webkit-search-cancel-button {
	  	-webkit-appearance: searchfield-cancel-button;
	  	cursor: pointer;
	}
</style>
<div class="card">
	<div class="card-header pb-1">
		<h6><?= $title ?></h6>
	</div>
	<div class="card-content p-2">
		<?php if(isset($_SESSION['msg'])) { ?>
		<div class="col-12">
			<div class="alert bg-<?=$_SESSION['color']?> alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
		  <span class="alert-icon"><i class="la la-commenting"></i></span>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true"><i class="la la-times"></i></span>
		  </button>
		  <strong><?=$_SESSION['msg']?></strong>
		</div>
		</div>
		<?php  } ?>

		<!-- DATA MAHASISWA -->
		<div class="row mb-1 p-2">
			<div class="col-md-2 text-bold-600">
				Nama Mahasiswa
			</div>
			<div class="col-md-4">
				<?php if($_SESSION['app_level']!=1){ ?>
				<a href="<?=base_url('mahasiswa/detail/'.$detail_mhs_pt->id_mhs)?>" target="_blank"><?=$detail_mhs_pt->nm_pd?></a>
				<?php }else{ echo $detail_mhs_pt->nm_pd; } ?>
			</div>
			<div class="col-md-2 text-bold-600">
				Program Studi
			</div>
			<div class="col-md-4">
				<?=$detail_mhs_pt->homebase?>
			</div>
			<div class="col-md-2 text-bold-600">
				NPM
			</div>
			<div class="col-md-4">
				<?=$detail_mhs_pt->id_mahasiswa_pt?>
			</div>
			<div class="col-md-2 text-bold-600">
				Semester
			</div>
			<div class="col-md-4">
				<?php if(!$krs_log['status']) echo $semester->nama_semester; else smt2nama($krs_log['isi']['id_smt']);?>
			</div>
			<div class="col-md-2 text-bold-600">
				KRS
			</div>
			<div class="col-md-4">
				<a href="javascript:void(0)" title="" data-toggle="modal" data-target="#lihat_krs">Lihat KRS</a>
			</div>
			<div class="col-md-2 text-bold-600">
				Program MBKM
			</div>
			<div class="col-md-4">
				<?= $aktivitas_mahasiswa->nama_jenis_aktivitas_mahasiswa; ?>
			</div>
		</div>
		<!-- DATA MAHASISWA -->

		<!-- Modal Lihat KRS -->
		<div class="modal fade text-left" id="lihat_krs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
		 aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel1">KRS Mahasiswa</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- DATA KRS -->
						<table width="100%" class="table table-striped table-bordered dataTable" id="dataTables_krs" role="grid">
							<thead>
								<tr role="row">
									<th width="1">Kode MK</th>
									<th>Mata Kuliah</th>
									<th>SKS</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<tr>
									<th style="text-align:right">Total SKS</th>
									<th id="total_sks"></th>
									<th>SKS</th>
								</tr>
						    </tfoot>
						</table>
						<!-- DATA KRS -->


						<!-- DATA VALIDASI -->
						<div class="row">
							<div class="col-12">
								<div class="container text-center my-2">
								    <div class="btn-group w-100" role="group">
									<?php if(!$krs_log['status']) { $ttd_mhs="belum diajukan"; $ttd_dosen="belum diajukan"; $tgl_acc=date("d-M-Y"); $pilih_krs=true;?>
								        <button type="submit" class="btn_save btn w-100 btn-info">
								            Ajukan KRS
								        </button>
									<?php } else { $ttd_mhs="TTD"; 
												if($krs_log['isi']['validasi_krs']==0) { 
												$pilih_krs=true;
												$ttd_dosen="belum acc";
												$tgl_acc=date("d-M-Y");
												}else{
													$pilih_krs=false;
													if($_SESSION['app_level']==3){$pilih_krs=true;}
													$ttd_dosen="TTD";
													$tgl_acc=date("d-M-Y",strtotime($krs_log['isi']['tgl_acc']));
												} 
											}?>
								    </div>
								</div>
							</div>
							<div class="col-6 mb-2 text-center">
								&nbsp;<br>
								Yang Mengajukan,<br>
								&nbsp;<br>
								&nbsp;<br>
								<?=$ttd_mhs?><br>
								&nbsp;<br>
								<strong><?=$detail_mhs_pt->nm_pd?></strong><br>
								NPM : <?=$detail_mhs_pt->id_mahasiswa_pt?>
								<input type="hidden" name="id_mahasiswa_pt" value="<?=$detail_mhs_pt->id_mahasiswa_pt?>">
							</div>
							<?php if (isset($detail_mhs_pt->nm_sdm)): ?>
							<div class="col-6 text-center">
								Majalengka, <?=$tgl_acc?><br>
								Menyetujui,<br>
								Dosen Wali<br>
								&nbsp;<br>
								<?=$ttd_dosen?><br>
								&nbsp;<br>
								<strong>(<?=$detail_mhs_pt->nm_sdm?>)</strong><br>
								NIDN : <?=$detail_mhs_pt->nidn?>
							</div>
							<?php endif; ?>
							<?php if($krs_log['status']){ ?>
									<?php if($krs_log['isi']['validasi_aka']!='0'){ ?>
									<div class="col-12 text-center">Mengetahui,</div>
									<div class="col text-center">
										Akademik<br>
										&nbsp;<br>
										&nbsp;<br>
										TTD<br>
										&nbsp;<br>
										<strong>(<?=$krs_log['isi']['validasi_aka']?>)</strong><br>
										Tanggal : <?=$krs_log['isi']['tgl_validasi_aka']?>
									</div>
									<?php } ?>

									<?php if($krs_log['isi']['validasi_koordinator']!='0'){ ?>
									<div class="col text-center">
										Keuangan<br>
										&nbsp;<br>
										&nbsp;<br>
										TTD<br>
										&nbsp;<br>
										<strong>(<?=$krs_log['isi']['validasi_koordinator']?>)</strong><br>
										Tanggal : <?=$krs_log['isi']['tgl_validasi_koordinator']?>
									</div>
									<?php } ?>

									<?php if($krs_log['isi']['validasi_prodi']!='0'){ ?>
									<div class="col text-center">
										Ketua Program Studi<br>
										&nbsp;<br>
										&nbsp;<br>
										TTD<br>
										&nbsp;<br>
										<strong>(<?=$krs_log['isi']['validasi_prodi']?>)</strong><br>
										Tanggal : <?=$krs_log['isi']['tgl_validasi_prodi']?>
									</div>
								<?php } ?>
							<?php } ?>
						<!-- DATA VALIDASI -->
					</div>
				</div>
			</div>
		</div>
		<!-- Modal LIhat KRS -->
	</div>

	<!-- DATA KONVERSI -->
	<button type="button" class="btn btn-sm btn-info float-right mr-2" data-toggle="modal" data-target="#modal_tambah_konversi"><i class="fa fa-plus"></i> &nbsp;Tambah</button>

	<div class="modal fade text-left" id="modal_tambah_konversi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	 aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel1">Tambah Konversi Nilai</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body p-5">
					<form id="form_tambah_konversi" onsubmit="event.preventDefault(); simpan_konversi(this)">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="nm_lemb">Asal Perguruan Tinggi *</label>
									<input type="search" autocomplete="off" name="nm_lemb" id="nm_lemb" class="form-control" required="" placeholder="Masukan perguruan tinggi asal" onblur="clearTypehead('#nm_lemb')">
		                    		<input type="hidden" name="kode_pt" id="kode_pt">
		                    		<input type="hidden" name="id_sp" id="id_sp">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="kode_mk_asal">Kode MK Asal *</label>
									<input type="text" name="kode_mk_asal" id="kode_mk_asal" class="form-control" required="" placeholder="Masukkan Kode MK Asal">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="nm_mk_asal">Nama MK Asal *</label>
									<input type="text" name="nm_mk_asal" id="nm_mk_asal" class="form-control" required="" placeholder="Masukkan Nama MK Asal">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="sks_asal">SKS Asal *</label>
									<input type="number" maxlength="1" name="sks_asal" id="sks_asal" class="form-control" required="" placeholder="Bobot SKS Asal">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="nilai_huruf_asal">Nilai Huruf Asal *</label>
									<input type="text" maxlength="1" name="nilai_huruf_asal" id="nilai_huruf_asal" class="form-control" placeholder="Nilai Huruf Asal" required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="matkul_diakui">Mata Kuliah Diakui *</label>
									<input type="search"  autocomplete="off" name="matkul_diakui" id="matkul_diakui" class="form-control" required="" placeholder="Nama MK Lengkap"  onblur="clearTypehead('#matkul_diakui')">
									<input type="hidden" name="id_matkul" id="id_matkul">
									<input type="hidden" name="sks_diakui" id="sks_diakui">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="nilai_angka_diakui">Nilai Angka Diakui *</label>
									<input type="text" maxlength="1" name="nilai_angka_diakui" id="nilai_angka_diakui" class="form-control" required="" placeholder="Nilai Angka Diakui">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="nilai_huruf_diakui">Nilai Huruf Diakui *</label>
									<input type="text" maxlength="1" name="nilai_huruf_diakui" id="nilai_huruf_diakui" class="form-control" required="" placeholder="Nilai Huruf Diakui">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<button type="submit" class="btn btn-info d-block w-100">SIMPAN</button>
								</div>
							</div>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<table class="table table-xs table-bordered table-striped datatable" id="datatable_konversi" width="100%" style="font-size: 90%">
		<thead>
			<tr>
				<th colspan="5" class="text-center">Nilai Asal</th>
				<th colspan="4" class="text-center">Hasil Konversi</th>
				<th rowspan="2" class="text-center">Aksi</th>
			</tr>
			<tr>
				<th width="1">PT Asal</th>
				<th width="1" >Kode MK</th>
				<th>Nama MK</th>
				<th width="1">SKS</th>
				<th width="1">Nilai</th>

				<th width="1">Kode MK</th>
				<th>Nama MK</th>
				<th width="1">SKS</th>
				<th width="1">Nilai</th>
			</tr>
		</thead>
		<tbody></tbody>
		<!-- <tfoot>
			<tr>
				<td colspan="2">Total SKS Konversi</td>
				<td>0</td>
				<td></td>
				<td colspan="2">Total SKS Diakui</td>
				<td>0</td>
				<td>&nbsp;</td>
				<td></td>
			</tr>
		</tfoot> -->
	</table>
	<!-- DATA KONVERSI -->
</div>
<script type="text/javascript">
var table, table_konversi

function filter() {
	table_konversi.ajax.reload(null,false);
}

function simpan_konversi(form)
{
	var formData = new FormData(form)
	formData.append('id_aktivitas', <?=$aktivitas_mahasiswa->id_aktivitas?>)
	fetch('<?= base_url('krs/simpan_nilai_transfer/') ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			filter()
			toastr.success('Data konversi berhasil disimpan.', 'MBKM UNMA')
		})
	return
}

function hapus_nilai_transfer()
{
	if (confirm('Apakah anda yakin ?')) {
		fetch('<?= base_url('krs/hapus_nilai_transfer/') ?>' + arguments[0])
		.then(response => response.text())
		.then(text => {
			filter()
			console.log(text)
		})
	}
}

function clearTypehead(e) {
	var current = $(e).typeahead("getActive")
	if (current) {
		if (current.name != $(e).val()) {
			$(e).val('');
		}
	} else {
		$(e).val('');
	}
}

$(document).ready(function() {
	$('#nm_lemb').typeahead({
		delay: 2,
		autoSelect: false,
		source: function(query, result) {
			$('#nm_lemb').addClass('loading')
			$.ajax({
				url 	: "<?= base_url('search_pt') ?>",
				method	: "POST",
				data 	: { keyword: query, limit: 10 },
				dataType: "json",
				success	: function(data) {
					$('#nm_lemb').removeClass('loading')
					result($.map(data, function(item) {
						return item;
					}));
				}
			})
		},
		updater: function(item) {
			$('#id_sp').val(item.id) // ID Perguruan Tinggi MHS
			$('#kode_pt').val(item.code) // ID Perguruan Tinggi MHS
	        return item
	    },
	});

	$('#matkul_diakui').typeahead({
		delay: 2,
		autoSelect: false,
		source: function(query, result) {
			$('#matkul_diakui').addClass('loading')
			$.ajax({
				url 	: "<?= base_url('krs/search_matkul') ?>",
				method	: "POST",
				data 	: { keyword: query, limit: 1 },
				dataType: "json",
				success	: function(data) {
					$('#matkul_diakui').removeClass('loading')
					result($.map(data, function(item) {
						return item;
					}));
				}
			})
		},
		updater: function(item) {
			$('#id_matkul').val(item.id) // ID Perguruan Tinggi MHS
			$('#sks_diakui').val(item.sks) // ID Perguruan Tinggi MHS
	        return item
	    },
	});

		table_konversi = $('#datatable_konversi').DataTable({
			paging:false,
			sorting:false,
			"bInfo" : false,
			dom: 'Bfrtip',
			buttons: [
	           'pdf', 'print'
	        ],
			responsive: true,
			ajax: {
				url : "<?=base_url('krs/json_nilai_transfer/')?>",
				type 	: 'GET',
				data	: {id_aktivitas:'<?=$aktivitas_mahasiswa->id_aktivitas?>'},
			},
			columns: [
				{ data: 'nm_lemb', searchable:false},
				{ data: 'kode_mk_asal', searchable:false},
				{ data: 'nm_mk_asal', searchable:false},
				{ data: 'sks_asal', searchable:false},
				{ data: 'nilai_huruf_asal', searchable:false},
				{ data: 'kode_mk', searchable:false},
				{ data: 'nm_mk', searchable:false},
				{ data: 'sks_mk', searchable:false},
				{ data: 'nilai_huruf_diakui', searchable:false},
				{ data: 'id_nilai_transfer', searchable:false, className: 'text-center', render: 
					function ( data, type, row, meta ) {
						return `<a href="javascript:void(0)" onclick="hapus_nilai_transfer(${data})" class="text-danger"><i class="fa fa-trash"></i></a>`;
					}
				},
			],
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};
	 
				// Total over all pages
				total = api
					.column( 2 )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Total over this page
				pageTotal = api
					.column( 2, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Update footer
				$( api.column( 2 ).footer() ).html(
					pageTotal
				);

				pageTotal = api
					.column( 6, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Update footer
				$( api.column( 6 ).footer() ).html(
					pageTotal
				);

			}
		})

		table = $('#dataTables_krs').DataTable( {
			paging:false,
			sorting:false,
			"bInfo" : false,
			language: {
                url : "<?=base_url('assets/datatables/lang/ID.json')?>",
			},
			ajax: {
				url : "<?=base_url('krs/json_krs/')?>",
				type 	: 'GET',
				data	: {id_mhs_pt:'<?=$detail_mhs_pt->id_mahasiswa_pt?>', id_semester: <?=$semester->id_semester?>},
			},
			columns: [
				{ data: 'kode_mk', searchable:false},
				{ data: 'nama_kelas_kuliah', searchable:false, render: 
						function ( data, type, row, meta ) {
						<?php if($_SESSION['app_level']==1){ ?>
							return `${row.smt_mk} - ${data}`;
						<?php }else{ ?>
							return '<a target="_blank" href="<?=base_url()?>/kelas/detail/'+row.id_kelas_kuliah+'">'+data+' ('+row.kode_mk+')</a>';
						<?php } ?>
						}
				},
				{ data: 'sks_mk', searchable:false},
				{ data: 'status_krs', searchable:false, render : 
					function ( data, type, row, meta ) {
							var ket;
							switch(data){
									case 1: ket='Sudah Acc'; break;
									case 2: ket='Sudah Dibayar'; break;
									default: ket='Belum disetujui';
								}
							<?php if($_SESSION['app_level']!=3){ ?>
								
							if(data==1){
								return '<span class="text-success">'+ket+'</span>';
							}else if(data==2){
								return '<span class="text-info">'+ket+'</span>';
							}else{
								return '<span class="text-danger">'+ket+'</a>';
							}
							<?php }else{ ?>
								return '<select name="ubah_status" data_id_krs="'+row.id_krs+'">'+
											'<option value="'+data+'">'+ket+'</option>'+
											'<option value="0">Belum Acc</option>'+
											'<option value="1">Sudah Acc</option>'+
											'<option value="2">Sudah Bayar</option>'+
										'</select>';
								//return data;
							<?php } ?>
					}
				},
			],
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};
	 
				// Total over all pages
				total = api
					.column( 2 )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Total over this page
				pageTotal = api
					.column( 2, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Update footer
				$( api.column( 2 ).footer() ).html(
					pageTotal
				);

			}
		} );
		
		
	} );

</script>
<style>
.jml_krs{
    position: fixed;
    bottom: 5%;
    right: 10%;
    z-index: 1051;
}
.dataTables_filter {
	display: none; 
}
</style>