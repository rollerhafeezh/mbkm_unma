<?php 

//echo "Belum Masa Pengisian KRS"; exit();

if($_SESSION['app_level']!=1){$link_mhs=$detail_mhs_pt->id_mahasiswa_pt;}else{$link_mhs='';}
if(isset($_SESSION['msg'])) { ?>
<div class="col-12">
	<div class="alert bg-<?=$_SESSION['color']?> alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
  <span class="alert-icon"><i class="la la-commenting"></i></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true"><i class="la la-times"></i></span>
  </button>
  <strong><?=$_SESSION['msg']?></strong>
</div>
</div>
<?php  }
if($krs_temp_log['status']){echo "Sudah Mengajukan Add Drop"; exit();}
if($lunas=='ok'){
/*-----------LUNAS OKE START----------------*/
	
?>
<div class="row mb-1">
<div class="col-2 text-bold-600">
	Nama Mahasiswa
</div>
<div class="col-4">
	<?=$detail_mhs_pt->nm_pd?>
</div>
<div class="col-2 text-bold-600">
	Program Studi
</div>
<div class="col-4">
	<?=$detail_mhs_pt->homebase?>
</div>
<div class="col-2 text-bold-600">
	NPM
</div>
<div class="col-4">
	<?=$detail_mhs_pt->id_mahasiswa_pt?>
</div>
<div class="col-2 text-bold-600">
	Semester
</div>
<div class="col-4">
	<?php if(!$krs_log['status']) echo $_SESSION['nama_smt']; else smt2nama($krs_log['isi']['id_smt']);?>
</div>
</div>
	
<table width="100%" class="table responsive table-striped table-bordered base-style dataTable" id="dataTables_krs" role="grid">
	<thead>
		<tr role="row">
			<th>Kelas Kuliah</th>
			<th>SKS</th>
			<th>Jadwal</th>
			
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
<?php 

echo validation_errors();
echo form_open('krs/add_drop/'.$link_mhs,array('onsubmit'=>'return check()')); 
?>
<div id="peringatan" class="alert alert-danger mt-2" style="display:none">Error: Belum ada Kelas yang dikontrak! Silahkan Pilih Kelas Kuliah dari Daftar Semester Dibawah!</div>
<input type="hidden" name="id_mahasiswa_pt" value="<?=$detail_mhs_pt->id_mahasiswa_pt?>">
<div class="row">
<div class="col-12">
	<textarea name="alasan" required onfocus="this.select();" title="Alasan Wajib Diisi" class="form-control mt-1" placeholder="Tuliskan alasan kenapa ingin melakukan drop KRS. Wajib diisi."></textarea>
</div>
<div class="col-12">
<div class="container text-center my-2">
    <div class="btn-group w-100" role="group">
		<button type="submit" class="btn_save btn w-100 btn-danger">
			AJUKAN ADD DROP KRS
		</button>
</div>
</div>
</div>
</form>
<div class="col-12">
	
	<?php 
		$pilih_krs=true;
		if($pilih_krs) {
		if($kuliah_mahasiswa['detail'][0]['smt_mhs']<=2) $max=2; else $max=8;
		$jml_kontrak=1;
		for($i=1;$i<=$max;$i++){
		$listMK=json_decode($this->curl->simple_get(ADD_API.'simak/matkul_krs_show_mhs?group_smt='.$i.'&id_mahasiswa_pt='.$detail_mhs_pt->id_mahasiswa_pt.'&active_smt='.$_SESSION['active_smt']));
		if($listMK!=NULL){
	?>
	<div id="accordionKRS" role="tablist" aria-multiselectable="true">
		<div class="card collapse-icon accordion-icon-rotate">
			<div class="card-header bg-success">
			  <h2 class="card-title text-white text-bold-700" style="cursor:pointer" onclick="smt('smt<?=$i?>')">
				Semester <?=$i?></h2>
			</div>
			<div id="smt<?=$i?>" style="display:none">
			<?php 
			foreach ($listMK as $key) { 
				if($key->nilai_huruf!=NULL){
					$nilai='text-success';
				}else{
					$nilai='';
				}
				?>
				<div tab_loaded=0 jml_kontrak="<?=$jml_kontrak?>" id_matkul="<?=$key->id_matkul?>" id="<?=$key->kode_mk?>" class="card-header">
				<a data-toggle="collapse" href="#L<?=str_replace(' ', '_',$key->kode_mk)?>" aria-expanded="false" aria-controls="L<?=str_replace(' ', '_',$key->kode_mk)?>" class="card-title lead collapsed <?=$nilai?>">
				<?=$key->kode_mk?> <?=$key->nm_mk?> <?=($key->nilai_huruf)?'(Nilai : <strong>'.$key->nilai_huruf.'</strong>)':''?></a>
				</div>
					<div id="L<?=str_replace(' ', '_',$key->kode_mk)?>"  role="tabpanel" data-parent="#accordionKRS" aria-labelledby="<?=$key->kode_mk?>" class="collapse">
						<div class="card-content">
							<div class="card-body">
								<div class="v<?=$key->id_matkul?>"></div>
							</div>
						</div>
					</div>
			<?php  } ?>
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
			<div id="smtext" style="display:none">
			<?php 
			foreach ($listMK as $key) { 
				if($key->nilai_huruf!=NULL){
					$nilai='text-success';
				}else{
					$nilai='';
				}
				?>
				<div tab_loaded=0 jml_kontrak="<?=$jml_kontrak?>" id_matkul="<?=$key->id_matkul?>" id="<?=$key->kode_mk?>" class="card-header">
				<a data-toggle="collapse" href="#L<?=str_replace(' ', '_',$key->kode_mk)?>" aria-expanded="false" aria-controls="L<?=str_replace(' ','_',$key->kode_mk)?>" class="card-title lead collapsed <?=$nilai?>">
				<?=$key->kode_mk?> <?=$key->nm_mk?> <?=($key->nilai_huruf)?'(Nilai : <strong>'.$key->nilai_huruf.'</strong>)':''?></a>
				</div>
					<div id="L<?=str_replace(' ','_',$key->kode_mk)?>"  role="tabpanel" data-parent="#accordionKRS" aria-labelledby="<?=$key->kode_mk?>" class="collapse">
						<div class="card-content">
							<div class="card-body">
								<div class="v<?=$key->id_matkul?>"></div>
							</div>
						</div>
					</div>
			<?php  } ?>
			</div>
		</div>
	</div>
	<?php }}} ?>
</div>
</div>
<div class="jml_krs">
	<a href="#top">
		<div id="err_msg" class="btn bg-info round white px-2">Jumlah SKS : <div id="kontrak_krs">0</div>/<!--BATAS SKS TULIS DISINI--> <?=$batas_sks?> SKS 
		<div id="batas_sks" style="display:none">Jumlah SKS harus Sama dengan Batas</div></div>
	</a>
</div>
<style>
.dataTables_filter {
display: none; 
}
</style>
<script type="text/javascript">
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
}

function batal(e)
{
	var id_krs_temp = e;
	var x = confirm("Apakah yakin akan dibatalkan?");
	if (x){
		$.ajax({
			type:"POST",
			url: "<?=base_url('krs/batal_krs_temp/')?>",
			cache: false,
			data:{id_krs_temp:id_krs_temp},
			success: function(respond){
				location.reload();
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
}

function take_kelas(val)
{
	var id_kelas_kuliah = val;
	var id_mahasiswa_pt = '<?=$detail_mhs_pt->id_mahasiswa_pt?>';
	$.ajax({
		type:"POST",
		url: "<?=base_url('krs/take_kelas_temp/')?>",
		cache: false,
		data:{id_kelas_kuliah:id_kelas_kuliah,id_mahasiswa_pt:id_mahasiswa_pt},
		success: function(respond){
			location.reload();
		}
	});
}

$(document).ready(function() {
		$('#dataTables_krs').DataTable( {
			paging:false,
			sorting:false,
			language: {
                url : "<?=base_url('assets/datatables/lang/ID.json')?>",
			},
			ajax: {
				url : "<?=base_url('krs/json_krs_temp/')?>",
				type 	: 'GET',
				data	: {id_mhs_pt:'<?=$detail_mhs_pt->id_mahasiswa_pt?>'},
			},
			columns: [
				{ data: 'nama_kelas_kuliah', searchable:false, render: 
						function ( data, type, row, meta ) {
						<?php if($_SESSION['app_level']==1){ ?>
							return data;
						<?php }else{ ?>
							return '<a target="_blank" href="<?=base_url()?>/kelas/detail/'+row.id_kelas_kuliah+'">'+data+'</a>';
						<?php } ?>
						}
				},
				{ data: 'sks_mk', searchable:false},
				{ data: 'nama_ruangan', searchable:false,render : 
					function ( data, type, row, meta ) {
						return 'Gedung <strong>'+row.nama_gedung+'</strong> Ruang <strong>'+data+'</strong> <br>Hari <strong>'+row.hari_kuliah+'</strong> Jam '+row.jam_mulai+' s/d '+row.jam_selesai;
					}
				},
				{ data: 'id_krs_temp', searchable:false,render : 
					function ( data, type, row, meta ) {
						return '<a href="#" onclick="batal('+data+')">Batalkan</a>';
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
.card-header {
    padding: 0.5rem 1rem;
}
</style>
<?php
}else if($lunas=='bayar'){
	?>
	<div class="btn text-center text-white btn-lg btn-danger btn-outline-primary">Silahkan Melakukan Pembayaran Registrasi/ Heregristrasi Terlebih Dahulu</div>
	<div class="text-bold-700">Untuk mencetak Invoice silahkan ke Menu Keuangan > Invoice</div>
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
}else{
	?>
	<div class="btn text-center text-white btn-lg btn-danger btn-outline-primary">Silahkan Melakukan Pembayaran Registrasi/ Heregristrasi Terlebih Dahulu</div>
	<div class="text-bold-700">Untuk mencetak Invoice silahkan ke Menu Keuangan > Invoice</div>
<?php
}

?>