<div class="row mb-1">
<?php 
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
<?php  } ?>
<div class="col-md-3 text-bold-600">
	Catatan Dosen
</div>
<div class="col-md-3">
	<mark><?=$krs_log->isi?></mark>
</div>
<div class="col-md-6 text-right">
	<a href="<?= base_url('krs/cetak_krs') ?>" target="_blank" class="btn btn-sm btn-success"><i class="ft ft-printer"></i> Cetak PDF</a>
</div>
</div>
	
<table width="100%" class="table responsive table-striped table-bordered base-style dataTable" id="dataTables_krs" role="grid">
	<thead>
		<tr role="row">
			<th>Kelas Kuliah</th>
			<!--<th>SKS</th>-->
			<th>Jadwal</th>
			<th>Status</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<blockquote class="blockquote mt-1 pl-1 border-left-primary border-left-3">
<p class="mb-0">
	Kelas Mata Kuliah yang muncul pada <i>Menu</i> Kartu Rencana Studi (KRS) ini adalah Kelas Mata Kuliah yang sudah dipilih pada Semester Berjalan (<?=$_SESSION['nama_smt']?>). Untuk melihat Kelas Mata Kuliah pada semester sebelumnya silahkan pilih menu <a href="<?=base_url('krs/krsriwayat')?>">Riwayat KRS</a>.
</p>
</blockquote >
<style>
.dataTables_filter {
display: none; 
}
</style>
<script type="text/javascript">
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
				location.reload();
			}
		});
	}else{
		return false;
	}	
	
};
	$(document).ready(function() {
		$('#dataTables_krs').DataTable( {
			paging:false,
			language: {
                url : "<?=base_url('assets/datatables/lang/ID.json')?>",
			},
			ajax: {
				url : "<?=base_url('krs/json_krs/')?>",
				type 	: 'GET',
				
			},
			columns: [
				{ data: 'nama_kelas_kuliah', searchable:false,render : 
					function ( data, type, row, meta ) {
						return row.smt_mk+data+' ('+row.sks_mk+' SKS)';
					}},
				//{ data: 'sks_mk', searchable:false},
				{ data: 'nama_ruangan', searchable:false,render : 
					function ( data, type, row, meta ) {
						return 'Gedung <strong>'+row.nama_gedung+'</strong> Ruang <strong>'+data+'</strong> <br>Hari <strong>'+row.hari_kuliah+'</strong> Jam '+row.jam_mulai+' s/d '+row.jam_selesai;
					}
				},
				{ data: 'status_krs', searchable:false, render : 
					function ( data, type, row, meta ) {
						if(data==1){
							return '<span class="text-success">Sudah Acc/ Belum Dibayar</span>';
						}else if(data==2){
							return 'Sudah Dibayar';
						}else{
							return 'Belum disetujui';
						}
					}
				},
				{ data: 'id_krs', searchable:false,render : 
					function ( data, type, row, meta ) {
						if(row.status_krs==0){
							return '<a href="#" onclick="batal('+row.id_krs+')">Batalkan</a>';
						}else{
							return 'n/a';
						}
					}
				},
			],
		} );
	} );
</script>