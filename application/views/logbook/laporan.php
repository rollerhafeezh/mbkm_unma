<div class="card mb-0">
	<div class="card-header pb-0">
		<h6><?= $title ?></h6>
	</div>
	<div class="card-body">
		<div class="row">
			<?php $this->load->view('logbook/informasi') ?>

			<div class="w-100 d-block d-md-none m-1"></div>

			<div class="col-md-8">
				<fieldset style="border: 1px solid #BABFC7; margin: inherit; font-size: 90%" class="py-1 unggah-berkas">
					<legend style="width: inherit; font-size: inherit; margin: inherit;" class="pl-1 pr-1">
						<b>Aktivitas : Laporan</b>
					</legend>

					<table class="table dataTable table-striped table-bordered" id="datatable_aktivitas">
						<thead>
							<tr>
								<th>No</th>
								<th>Jenis Laporan</th>
								<th>Tanggal Laporan</th>
								<th>Minggu Ke</th>
								<th width="1">Status</th>
								<th width="70">Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>	
				</fieldset>
			</div>
		</div>
	</div>
</div>

<div class="modal fade text-left" id="modal_tambah_laporan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel1"><span class="act">Tambah</span> Laporan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-3">
				<form id="form_tambah_laporan" onsubmit="event.preventDefault(); simpan_laporan(this)">
					<input type="hidden" name="id_aktivitas" value="<?= $aktivitas_mahasiswa->id_aktivitas ?>">
					<input type="hidden" name="jenis_laporan" value="1">
					<input type="hidden" name="id_laporan" id="id_laporan">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="jenis_laporan">Jenis Laporan *</label>
								<select name="jenis_laporan" class="form-control" id="jenis_laporan" required="">
									<option value="" hidden>-- Choose --</option>
									<option value="1">Laporan Awal</option>
									<option value="2">Laporan Mingguan</option>
									<option value="3">Laporan Akhir</option>
								</select>		
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="minggu_ke">Minggu Ke- *</label>
								<select name="minggu_ke" class="form-control" id="minggu_ke" required="">
									<option value="" hidden>-- Choose --</option>
									<?php for ($i=1; $i < 11; $i++) { ?>
									<option value="<?= $i ?>"><?= $i ?></option>
									<?php } ?>	
								</select>		
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="tgl_laporan">Tanggal Laporan *</label>
								<input type="date" name="tgl_laporan" id="tgl_laporan" class="form-control" required="" value="<?= date("Y-m-d") ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="file">Lampiran (.pdf, Maksimum file 8Mb)</label>
								<input type="file" class="form-control" name="file" id="file" accept="application/pdf">
								<a href="#" style="display: none" class=" file" target="_blank"><small><i class="fa fa-download"></i> Download Berkas</small></a>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="file_gambar">Lampiran Gambar / Foto (.jpeg, .jpg, .png, Maksimum file 8Mb)</label>
								<input type="file" class="form-control" name="file_gambar" id="file_gambar" accept="image/*">
								<a href="#" style="display: none" class=" file_gambar" target="_blank"><small><i class="fa fa-download"></i> Download Berkas</small></a>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="rencana_kegiatan">Rencana Kegiatan *</label>
								<textarea name="rencana_kegiatan" id="rencana_kegiatan" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="pelaksanaan_kegiatan">Pelaksanaan Kegiatan *</label>
								<textarea name="pelaksanaan_kegiatan" id="pelaksanaan_kegiatan" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="analisis_hasil_kegiatan">Analisis Hasil Kegiatan *</label>
								<textarea name="analisis_hasil_kegiatan" id="analisis_hasil_kegiatan" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="hambatan">Hambatan dan Upaya Mengatasi Hambatan *</label>
								<textarea name="hambatan" id="hambatan" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="rencana_perbaikan">Rencana Perbaikan dan Tindaklanjut *</label>
								<textarea name="rencana_perbaikan" id="rencana_perbaikan" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" class="btn btn-info d-block w-100 btn_simpan_laporan">SIMPAN</button>
							</div>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>

<div class="modal fade text-left" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel1">Detail Laporan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-3 detail">
				<img src="https://i.pinimg.com/originals/62/c3/79/62c379ae3baad2a6f3810a8ad1a19d47.gif" width="50%" class="d-block" style="margin: 0 auto" alt="Loading ...">
			</div>
		</div>
	</div>
</div>

<script>
	var table


	function simpan_laporan(e) {
		if( document.querySelector("#file").files.length == 0 || document.querySelector("#file_gambar").files.length == 0 ){
		    var konfirmasi = confirm('Simpan laporan tanpa lampiran berkas ?')
		    if (!konfirmasi) {
		    	return
		    }
		}

		for (instance in CKEDITOR.instances) {
			// if (CKEDITOR.instances[instance].getData() == "") {
			// 	console.log('aya nu kosong')
	  //       } else {
            	CKEDITOR.instances[instance].updateElement();
	        // }
    	}

		var formData = new FormData(e)

		fetch('<?= base_url('logbook/kirim/laporan') ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			filter()
			for (instance in CKEDITOR.instances) {
	            	CKEDITOR.instances[instance].setData('');
	    	}

			$('#form_tambah_laporan').trigger("reset");
			$('#modal_tambah_laporan').modal('hide')
			toastr.success('Laporan berhasil disimpan', 'MBKM UNMA')
		})
	}

	$(document).ready(function() {
		$('[data-toggle="popover"]').popover()
		$('[data-toggle="tooltip"]').tooltip()
		table = $('#datatable_aktivitas').DataTable({
			responsive: true,
			"autoWidth" : false,
			ajax: {
				url : "<?=base_url('logbook/json_laporan/')?>",
				type 	: 'GET',
				data	: { id_user:'<?= $_SESSION['id_user'] ?>', id_aktivitas: <?= $aktivitas_mahasiswa->id_aktivitas ?> },
			},
			dom: 	"<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			buttons: [
				{
					extend:'pageLength',
					text:'Data',
					className:'btn btn-light btn-sm',
				},
				{
					extend:'pdf',
					className:'btn btn-danger btn-sm',
				},
				{
	                text: '<i class="fa fa-plus"></i> Tambah Laporan',
	                action: function ( e, dt, node, config ) {
	                    $('#modal_tambah_laporan').modal('show');
	                },
					className:'btn btn-info btn-sm',
	            }
			],
			order: [[2, 'desc']],
			columns: [
				{ data: 'id_laporan', searchable:false, className: 'text-center'},
				{ data: 'jenis_laporan', render : 
					function ( data, type, row, meta ) {
						var jenis_laporan = ['Laporan Awal', 'Laporan Mingguan', 'Laporan Akhir']
						return jenis_laporan[data-1]
					}
				},
				{ data: 'tgl_laporan', className: 'text-center'},
				{ data: 'minggu_ke', className: 'text-center'},
				{ data: 'status', searchable:false, render : 
					function ( data, type, row, meta ) {
						if (data == '0') {
							return '<span class="badge badge-info">Awaiting</span>'
						} else if (data == '1') {
							return '<span class="badge badge-warning">Revision</span>'
						} else {
							return '<span class="badge badge-success">Accepted</span>'
						}
					}
				},
				{ data: 'id_laporan', searchable:false, className: 'text-center', render : 
					function ( data, type, row, meta ) {
						// const today = new Date().getFullYear()+'-'+("0"+(new Date().getMonth()+1)).slice(-2)+'-'+("0"+new Date().getDate()).slice(-2)
						if (row.status == '2') {
							return `<a href="javascript:void(0)" onclick="detail(${row.id_laporan})" class="badge badge-info"><i class="fa fa-search"></i></a>`
						} else {
							return `<a href="javascript:void(0)" data-toggle="tooltip" title="Ubah Laporan" onclick="edit(${row.id_laporan})" class="badge badge-success text-white"><i class="fa fa-edit"></i></a>
								<a href="javascript:void(0)" data-toggle="tooltip" title="Hapus Laporan" onclick="hapus(${row.id_laporan})" class="badge badge-warning"><i class="fa fa-trash text-white"></i></a>
								<a href="javascript:void(0)" data-toggle="tooltip" title="Lihat Laporan" onclick="detail(${row.id_laporan})" class="badge badge-info"><i class="fa fa-search"></i></a>`
						}
					}
				},
			],
		})

		table.on('order.dt search.dt', function () {
	        let i = 1;
	 
	        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
	            this.data(i++);
	        });
	    }).draw();
	})

	$('textarea').each(function(e){
        CKEDITOR.replace( this.id, { removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,Subscript,Superscript,Strikethrough', height: 130 });
    });

	function edit() {
		$('#modal_tambah_laporan').modal('show')
		$('.act').html('Edit')
		fetch('<?= base_url('logbook/detail_laporan/') ?>' + arguments[0] + '/' + 'edit')
		.then(response => response.json())
		.then(json => {
			$('.file').show()
			$('.file_gambar').show()

			$('#id_laporan').val(json.id_laporan)
			$('#tgl_laporan').val(json.tgl_laporan)

			$('.file').attr('href', json.file)
			$('.file_gambar').attr('href', json.file_gambar)
			
			CKEDITOR.instances.rencana_kegiatan.setData(json.rencana_kegiatan);
			CKEDITOR.instances.pelaksanaan_kegiatan.setData(json.pelaksanaan_kegiatan);
			CKEDITOR.instances.analisis_hasil_kegiatan.setData(json.analisis_hasil_kegiatan);
			CKEDITOR.instances.hambatan.setData(json.hambatan);
			CKEDITOR.instances.rencana_perbaikan.setData(json.rencana_perbaikan);

			$(`#minggu_ke option[value=${json.minggu_ke}]`).attr('selected','selected');
			$(`#jenis_laporan option[value=${json.jenis_laporan}]`).attr('selected','selected');
		})
	}

	$('#modal_tambah_laporan').on('hidden.bs.modal', function () {
		$('.act').html('Tambah')
		$('.file').hide()
		$('.file_gambar').hide()
		$('#tgl_laporan').val('')
		for (instance in CKEDITOR.instances) {
        	CKEDITOR.instances[instance].setData('');
    	}
	});

	function detail()
	{
		$('#modal_detail').modal('show')
		fetch('<?= base_url('logbook/detail_laporan/') ?>' + arguments[0])
		.then(response => response.text())
		.then(text => {
			document.querySelector('.detail').innerHTML = text
		})
	}

	function hapus()
	{
		var konfir = prompt('Tulis "HAPUS" untuk menghapus laporan.')
		if (konfir == 'HAPUS') {
			var data = new FormData()
			data.append('id_laporan', arguments[0])

			fetch('<?= base_url('logbook/hapus') ?>', { method: 'POST', body: data })
			.then(response => response.text())
			.then(text => {
				toastr.success('Laporan berhasil dihapus', 'MBKM UNMA')
				filter()
			})
		}
	}

	function filter() {
		table.ajax.reload(null,false);
	}
</script>