
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


		<div class="alert bg-info alert-icon-left alert-arrow-left  mb-2" role="alert">
			<span class="alert-icon"><i class="la la-info"></i></span>
			Silahkan lakukan validasi perwalian kepada <b>Dosen Wali</b> & <b>Ketua Program Studi</b> dengan menunjukkan <b>Transkrip Nilai Terbaru</b> dan <b>KRS MBKM</b> yang sudah dicetak pada halaman ini.
		</div>

		<!-- DATA MAHASISWA -->
		<div class="row mb-1 p-2">
			<div class="col-12 text-right mb-2" id="top">
				<div class="btn-group">
				<?php if($_SESSION['app_level']==1){ ?>
					<a href="<?= base_url('krs/drop_krs/'.$detail_mhs_pt->id_mahasiswa_pt.'/'.$semester->id_semester.'/'.$aktivitas_mahasiswa->id_aktivitas) ?>" onclick="return confirm('Apakah anda yakin ingin drop KRS ?');" class="btn btn-danger">DROP KRS</a>
				<?php } ?>
				<?php if($krs_log['status']): ?>
					<a href="<?= base_url('krs/cetak_krs/'.$detail_mhs_pt->id_mahasiswa_pt.'/'.$semester->id_semester) ?><?php if($_SESSION['app_level']!=1){echo $detail_mhs_pt->id_mahasiswa_pt;}?>" target="_blank" class="btn btn-info">Cetak KRS</a>
					<!-- <a href="<?= base_url('krs/cetak_ksm/'.$_SESSION['active_smt'].'/') ?><?php if($_SESSION['app_level']!=1){echo $detail_mhs_pt->id_mahasiswa_pt;}?>" target="_blank" class="btn btn-success">Cetak KSM</a> -->
				<?php endif; ?>
				</div>
			</div>
			<div class="col-lg-2 text-bold-600">
				Nama Mahasiswa
			</div>
			<div class="col-lg-4">
				<?php if($_SESSION['app_level']!=1){ ?>
				<a href="<?=base_url('mahasiswa/detail/'.$detail_mhs_pt->id_mhs)?>" target="_blank"><?=$detail_mhs_pt->nm_pd?></a>
				<?php }else{ echo $detail_mhs_pt->nm_pd; } ?>
			</div>
			<div class="col-lg-2 text-bold-600">
				Program Studi
			</div>
			<div class="col-lg-4">
				<?=$detail_mhs_pt->homebase?>
			</div>
			<div class="col-lg-2 text-bold-600">
				NPM
			</div>
			<div class="col-lg-4">
				<?=$detail_mhs_pt->id_mahasiswa_pt?>
			</div>
			<div class="col-lg-2 text-bold-600">
				Semester
			</div>
			<div class="col-lg-4">
				<?php if(!$krs_log['status']) echo $semester->nama_semester; else smt2nama($krs_log['isi']['id_smt']);?>
			</div>
			<!-- <div class="col-lg-2 text-bold-600">
				Catatan Dosen
			</div>
			<div class="col-lg-4">
				<?php if(!$krs_log['status']) echo $krs_log['isi']; else echo $krs_log['isi']['isi_catatan'];?>
			</div> -->
			<div class="col-lg-2 text-bold-600">
				IPK
				<!-- IPS <?=smt2nama($smt_lalu)?> -->
			</div>
			<div class="col-lg-4">
				<a href="<?= base_url('nilai/index/'.$detail_mhs_pt->id_mahasiswa_pt) ?>"><?= $detail_mhs_pt->ipk ?></a> (<i><small>Maksimal 20 SKS</small></i>)
				<!-- <?php if($ips_smt_lalu){ ?>
				<a target="_blank" href="<?=base_url('krs/lihat_khs/'.$smt_lalu.'/'.$detail_mhs_pt->id_mahasiswa_pt)?>"><?=$ips_smt_lalu->detail[0]->ips == '' ? '0.00' : $ips_smt_lalu->detail[0]->ips?></a>
				<?php }?> 
				<em><small>(maks <?=$batas_sks?> sks)</small></em> -->
			</div>
			<div class="col-lg-2 text-bold-600">
				Program MBKM
			</div>
			<div class="col-lg-4">
				<?= $aktivitas_mahasiswa->nama_jenis_aktivitas_mahasiswa; ?>
			</div>
		</div>
		<!-- DATA MAHASISWA -->

		<!-- DATA KRS -->
		<table width="100%" class="table table-striped table-bordered dataTable" id="dataTables_krs" role="grid">
			<thead>
				<tr role="row">
					<th>Mata Kuliah</th>
					<th>SKS</th>
					<th>Status</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			<tfoot>
				<tr>
					<th style="text-align:right">Total SKS</th>
					<th id="total_sks"></th>
					<th colspan="2">SKS</th>
				</tr>
		    </tfoot>
		</table>
		<!-- DATA KRS -->

		<!-- DATA VALIDASI -->
		<?php 
			echo validation_errors();
			echo form_open('krs/add/'.$detail_mhs_pt->id_mahasiswa_pt.'/'.$semester->id_semester,array('onsubmit'=>'return check()')); 
		?>
		<div id="peringatan" class="alert alert-danger mt-2" style="display:none">Error: Belum ada Kelas yang dikontrak! Silahkan Pilih Kelas Kuliah dari Daftar Semester Dibawah!</div>
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

					<?php if($krs_log['isi']['validasi_keu']!='0'){ ?>
					<div class="col text-center">
						Keuangan<br>
						&nbsp;<br>
						&nbsp;<br>
						TTD<br>
						&nbsp;<br>
						<strong>(<?=$krs_log['isi']['validasi_keu']?>)</strong><br>
						Tanggal : <?=$krs_log['isi']['tgl_validasi_keu']?>
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
		</form>
		<!-- DATA VALIDASI -->

		<!-- PENGAMBILAN KRS -->
		<?php if(!$krs_log['status']){ ?>

		<div class="col-12">
			<?php 
			if($pilih_krs) {
				if($kuliah_mahasiswa['detail'][0]['smt_mhs']<=2) $max=2; else $max=8;
				
				$jml_kontrak=1;
				
				for($i=1;$i<=$max;$i++){
				$listMK=json_decode($this->curl->simple_get(ADD_API.'simak/matkul_krs_show_mhs?group_smt='.$i.'&id_mahasiswa_pt='.$detail_mhs_pt->id_mahasiswa_pt.'&active_smt='.$semester->id_semester));
				if($listMK!=NULL){
			?>
				<div id="accordionKRS" role="tablist" aria-multiselectable="true">
					<div class="card collapse-icon accordion-icon-rotate">
						<div class="card-header bg-success">
						  <h2 class="card-title text-white text-bold-700" style="cursor:pointer" onclick="smt('smt<?=$i?>')">
							Semester <?=$i?></h2>
						</div>
						<div id="smt<?=$i?>" class="pt-1 pl-1" style="display:none">

						<?php 
						foreach ($listMK as $key) { 
							if($key->a_wajib==1){
								$a_wajib='Wajib';
							}else if($key->a_wajib==2){
								$a_wajib='Pilihan';
							}else{
								$a_wajib='n/a';
							}
							
							if($key->nilai_huruf!=NULL){
								$nilai='text-success';
							}else{
								$nilai='';
							}
							?>
							<label class="d-block w-100 <?=$nilai?>" >
								<input type="checkbox" id="L<?=str_replace(' ', '_',$key->id_matkul)?>" onclick="take_kelas('<?=$key->id_matkul?>')">
								<strong><?=$key->kode_mk?></strong> <?=$key->nm_mk?> <i>(<?=$a_wajib .' - '. $key->sks_mk?> SKS)</i> 
								<?= ($key->nilai_huruf) ? '(Nilai : <strong>'.$key->nilai_huruf.'</strong>)':''?> 
							</label>
						<?php } ?>
						</div>
					</div>
				</div>
			<?php }}

				if($kuliah_mahasiswa['detail'][0]['smt_mhs']>2){
				$listMK=json_decode($this->curl->simple_get(ADD_API.'simak/matkul_krs_show_mhs?group_smt=0&id_mahasiswa_pt='.$detail_mhs_pt->id_mahasiswa_pt));
				if($listMK!=NULL){
			?>
			<div id="accordionKRS" role="tablist" aria-multiselectable="true">
				<div class="card collapse-icon accordion-icon-rotate">
					<div class="card-header bg-success">
					  <h2 class="card-title text-white text-bold-700" style="cursor:pointer" onclick="smt('smtext')">
						Mata Kuliah Akhir</h2>
					</div>
					<div id="smtext" class="pt-1 pl-1" style="display:none">
					<?php 
					foreach ($listMK as $key) { 
						if($key->nilai_huruf!=NULL){
							$nilai='text-success';
						}else{
							$nilai='';
						}
						?>
						<label class="d-block w-100 <?=$nilai?>" onclick="take_kelas('<?=$key->id_matkul?>')">
							<input type="checkbox" id="L<?=str_replace(' ', '_',$key->id_matkul)?>">
							<strong><?=$key->kode_mk?></strong> <?=$key->nm_mk?> <i>(<?=$key->sks_mk?> SKS)</i> 
							<?= ($key->nilai_huruf) ? '(Nilai : <strong>'.$key->nilai_huruf.'</strong>)':''?> 
						</label>
					<?php  } ?>
					</div>
				</div>
			</div>
			<?php }}} ?>
		</div>
		</div>

		<?php } ?>
		<div class="jml_krs">
			<a href="#top">
				<div id="err_msg" class="btn bg-info round white px-2">Jumlah SKS : <div id="kontrak_krs">0</div>/<!--BATAS SKS TULIS DISINI--> <?=$batas_sks?> SKS <div id="batas_sks" style="display:none">SKS yang kamu ambil terlalu banyak</div></div>
			</a>
		</div>
		<!-- PENGAMBILAN KRS -->
	</div>
</div>
<script type="text/javascript">
var table
function check()
{
	var total = $("#kontrak_krs").html();
	var batas = <?=$batas_sks?>;
	var x = confirm("Apakah yakin akan diajukan?");
	if (x){	
	
		if(total==0){
			$("#peringatan").show();
			return false;
		}else if(total>batas){
			$("#batas_sks").show();
			$("#err_msg").removeClass("bg-info").addClass("bg-danger");
			$(".btn_save").attr("disabled", true); 
			return false;
		}else{
			$("#batas_sks").hide();
			$("#err_msg").removeClass("bg-danger").addClass("bg-info");
			$(".btn_save").attr("disabled", false); 
			return true;
		};
	}
	return false;
};

function batal(e)
{
	var id_krs = e;
	var x = confirm("Apakah yakin akan dibatalkan?");
	if (x){
		$.ajax({
			type:"POST",
			url: "<?=base_url('krs/batal_krs/')?>",
			cache: false,
			data:{id_krs:id_krs},
			success: function(respond){
				filter()
			}
		});
	}else{
		return false;
	}	
	
};

function drop(e)
{
	var id_krs = e;
	var x = confirm("Apakah yakin akan DROP?");
	if (x){
		$.ajax({
			type:"POST",
			url: "<?=base_url('krs/drop_satu_krs/')?>",
			cache: false,
			data:{id_krs:id_krs},
			success: function(respond){
				filter()
			}
		});
	}else{
		return false;
	}	
	
};

$(".card-header").click(function() {
  var id_matkul = $(this).attr("id_matkul");
  var tab_loaded = $(this).attr("tab_loaded");
  var jml_kontrak = $(this).attr("jml_kontrak");
  if(tab_loaded==0){
	$(this).attr("tab_loaded",1);
	$('.v'+id_matkul).append($('<div>').load('<?=base_url('krs/kelas_kuliah_detail?id_matkul=')?>'+id_matkul+'&jml_kontrak='+jml_kontrak));  
  }
});

function smt(e)
{
	$('#'+e).toggle();
};

function take_kelas()
{
	var state = $(`#L${arguments[0]}`).is(':checked') ? '1' : '0'
	// if (state != true) { 
		var id_mahasiswa_pt = '<?=$detail_mhs_pt->id_mahasiswa_pt?>';
		$.ajax({
			type:"POST",
			url: "<?=base_url('krs/take_kelas/')?>",
			cache: false,
			data:{id_matkul:arguments[0], id_mahasiswa_pt:id_mahasiswa_pt, id_semester: <?=$semester->id_semester?>, status: state},
			success: function(respond){
				filter();
			}
		});
	// }
};

$(document).on("change",'select[name*="ubah_status"]',function(){

	var status = $(this).val();
	var id_krs = $(this).attr('data_id_krs');
	$.ajax({
		type:"POST",
		url: "<?=base_url('krs/ubah_status_krs/')?>",
		cache: false,
		data:{status:status,id_krs:id_krs},
		success: function(respond){
			location.reload();
		}
	});
});

function filter() {
	table.ajax.reload(null,false);
}

$(document).ready(function() {
		table = $('#dataTables_krs').DataTable( {
			paging:false,
			sorting:false,
			language: {
                url : "<?=base_url('assets/datatables/lang/ID.json')?>",
			},
			ajax: {
				url : "<?=base_url('krs/json_krs/')?>",
				type 	: 'GET',
				data	: {id_mhs_pt:'<?=$detail_mhs_pt->id_mahasiswa_pt?>', id_semester: <?=$semester->id_semester?>},
			},
			columns: [
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
				{ data: 'id_krs', searchable:false,render : 
					function ( data, type, row, meta ) {
						if(row.status_krs==0){
							return '<a href="#" onclick="batal('+row.id_krs+')">Batalkan</a>';
						}else{
							<?php if($_SESSION['app_level']!=3){ ?>
								return 'n/a';
							<?php }else{ ?>
								return '<a href="#" onclick="drop('+row.id_krs+')">Drop</a>';
							<?php } ?>
						}
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
					.column( 1 )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Total over this page
				pageTotal = api
					.column( 1, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
	 
				// Update footer
				$( api.column( 1 ).footer() ).html(
					pageTotal
				);

				$("#kontrak_krs").html(pageTotal);
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