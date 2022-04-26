<table width="100%" class="table responsive table-striped table-bordered compact dataTable" id="dataTables_dosen_wali" role="grid">
	<thead>
		<tr role="row">
			<th>NPM</th>
			<th>Nama Mahasiswa</th>
			<th>Program Studi</th>
			<th>Tahun Akademik</th>
			<th>Program</th>
			<th>Dosen Wali</th>
			<th>Prodi</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<blockquote class="blockquote mt-2 pl-1 border-left-primary border-left-3">
	<p class="mb-0">Data Mahasiswa Yang Mengajukan Program Merdeka Belajar Kampus Merdeka (MBKM)</p>
</blockquote>
<script type="text/javascript">
	var table;
	function validasi_mbkm() {
		if (confirm('Validasi MBKM Mahasiswa ?')) {
			var formData = new FormData()
			formData.append('id_aktivitas', arguments[0])
			formData.append('validasi_prodi', arguments[1])

			fetch('<?= base_url('krs/validasi_mahasiswa_mbkm') ?>', 
				{ 
					method: 'POST', 
					body: formData
				}
			)
			.then(response => response.text())
			.then(text => {
				filter()
				if (text == 'success') {
					toastr.success('Validasi Mahasiswa MBKM Berhasil.', 'UNMAKU')
				} else {
					toastr.error('Validasi Mahasiswa MBKM Gagal.', 'UNMAKU')
				}
			})
		}
	}

	function filter() {
        table.ajax.reload()
    }

	$(document).ready(function() {
		table = $('#dataTables_dosen_wali').DataTable( {
			serverSide: true,
			processing: true,
			ajax: {
				url : "<?=base_url('datatable/json/get/perwalian_mbkm/')?>",
				type 	: 'GET',
				data	:{ nidn:'<?=$_SESSION['username']?>',id_smt:'<?=$_SESSION['active_smt']?>'},
			},
			order:[6,'asc'],
			lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
			columns: [
				{ data: 'npm', name:'mahasiswa_pt.id_mahasiswa_pt' },
				// { data: 'nm_pd', name:'mahasiswa.nm_pd', render : 
				// 	function ( data, type, row, meta ) {
				// 		return '<a href="<?=base_url()?>perwalian/detail/'+row.npm+'">'+data+'</a>';
				// 	}},
				{ data: 'nm_pd', name:'mahasiswa.nm_pd'},
				{ data: 'homebase', searchable:false},
				{ data: 'nama_semester', searchable:false},
				{ data: 'nama_jenis_aktivitas_mahasiswa', name:'jenis_aktivitas_mahasiswa.nama_jenis_aktivitas_mahasiswa' },
				{ data: 'validasi_dosen_wali', searchable:false, render : 
					function ( data, type, row, meta ) {
						if(data==0)
						{
							return `<div class="text-center text-danger">Belum</div>`;
						}else{
							return `<div class="text-center text-success">Ya</div>`;
						}
					}
				},
				{ data: 'validasi_prodi', searchable:false, render : 
					function ( data, type, row, meta ) {
						if(data==0)
						{
							return `<div class="text-center text-danger" onclick="validasi_mbkm('${row.id_aktivitas}', '${(data == 1 ? '0' : '1')}')">Belum</div>`;
						}else{
							return `<div class="text-center text-success" onclick="validasi_mbkm('${row.id_aktivitas}', '${(data == 1 ? '0' : '1')}')">Ya</div>`;
						}
					}
				},
			],
		} );
	} );
</script>