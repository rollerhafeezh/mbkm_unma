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
						<b>Aktivitas : Logbook <i class="fa fa-info-circle" data-toggle="popover" data-original-title="Tips Mengisi Logbook" data-html="true" data-content="
							<ol style='padding: 0 0 0 15px;'>
								<li>Laporkan semua kegiatan harian tim dan kegiatanmu</li>
								<li>Usahakan lebih dari 25 kata</li>
								<li>Tambahkan informasi kelemahan dan kelebihan agenda kegiatan</li>
								<li>Lampirkan berkas pendukung, seperti lampiran/foto kegiatan</li>
								<li>Usahakan isi tepat waktu</li>
								<li>Jangan lupa salin logbook pada dokumen lain seperti word</li>
							</ol>
							"></i></b>
					</legend>

					<table class="table dataTable table-striped table-bordered" id="datatable_aktivitas">
						<thead>
							<tr>
								<th width="1">No</th>
								<th width="1">Tgl. Kegiatan</th>
								<th>Keterangan Logbook</th>
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

<div class="modal fade text-left" id="modal_tambah_logbook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel1"><span class="act">Tambah</span> Logbook</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-3">
				<form id="form_tambah_logbook" onsubmit="event.preventDefault(); simpan_logbook(this)">
					<input type="hidden" name="id_aktivitas" value="<?= $aktivitas_mahasiswa->id_aktivitas ?>">
					<input type="hidden" name="jenis_bimbingan" value="1">
					<input type="hidden" name="id_bimbingan" id="id_bimbingan">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="tgl_kegiatan">Tanggal Kegiatan *</label>
								<input type="date" name="tgl_kegiatan" id="tgl_kegiatan" value="<?= date('Y-m-d') ?>" class="form-control" required="">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="isi">Deskripsi Logbook *</label>
								<textarea name="isi" id="isi" class="form-control"></textarea>
								<small class="text-muted">Deskripsi kegiatan (<i>logbook</i>) minimal 25 karakter</small>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="file">Lampiran (.pdf)</label>
								<input type="file" class="form-control" name="file" id="file" accept="application/pdf">
								<a href="#" style="display: none" class=" file" target="_blank"><small><i class="fa fa-download"></i> Download Berkas</small></a>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="file_gambar">Lampiran Gambar / Foto (.jpeg, .jpg, .png)</label>
								<input type="file" class="form-control" name="file_gambar" id="file_gambar" accept="image/*">
								<a href="#" style="display: none" class=" file_gambar" target="_blank"><small><i class="fa fa-download"></i> Download Berkas</small></a>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" class="btn btn-info d-block w-100 btn_simpan_logbook">SIMPAN</button>
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
				<h4 class="modal-title" id="myModalLabel1">Detail Logbook</h4>
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

	function edit()
	{
		$('#modal_tambah_logbook').modal('show')
		$('.act').html('Edit')
		fetch('<?= base_url('logbook/detail/') ?>' + arguments[0] + '/' + 'edit')
		.then(response => response.json())
		.then(json => {
			$('.file').show()
			$('.file_gambar').show()

			$('#id_bimbingan').val(json.id_bimbingan)
			$('#tgl_kegiatan').val(json.tgl_kegiatan)
			$('.file').attr('href', json.file)
			$('.file_gambar').attr('href', json.file_gambar)
			CKEDITOR.instances.isi.setData(json.isi);
		})
	}

	$('#modal_tambah_logbook').on('hidden.bs.modal', function () {
		$('.act').html('Tambah')
		$('.file').hide()
		$('.file_gambar').hide()
		$('#tgl_kegiatan').val('')
		$('#id_bimbingan').val('')
		CKEDITOR.instances.isi.setData('');
	});

	function detail()
	{
		$('#modal_detail').modal('show')
		fetch('<?= base_url('logbook/detail/') ?>' + arguments[0])
		.then(response => response.text())
		.then(text => {
			document.querySelector('.detail').innerHTML = text
		})
	}

	$(document).ready(function() {
		$('[data-toggle="popover"]').popover()
		$('[data-toggle="tooltip"]').tooltip()
		table = $('#datatable_aktivitas').DataTable({
			responsive: true,
			"autoWidth" : false,
			ajax: {
				url : "<?=base_url('logbook/json_bimbingan/')?>",
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
	                text: '<i class="fa fa-plus"></i> Tambah Logbook',
	                action: function ( e, dt, node, config ) {
	                    $('#modal_tambah_logbook').modal('show');
	                },
					className:'btn btn-info btn-sm',
	            }
			],
			order: [[1, 'desc']],
			columns: [
				{ data: 'id_bimbingan', searchable:false, className: 'text-center'},
				{ data: 'tgl_kegiatan', className: 'text-center'},
				{ data: 'isi', render : 
					function ( data, type, row, meta ) {
						// return jQuery(data).text()
						let doc = new DOMParser().parseFromString(data, 'text/html');
   						return doc.body.textContent || "";
					}
				},
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
				{ data: 'id_bimbingan', searchable:false, className: 'text-center', render : 
					function ( data, type, row, meta ) {
						// const today = new Date().getFullYear()+'-'+("0"+(new Date().getMonth()+1)).slice(-2)+'-'+("0"+new Date().getDate()).slice(-2)
						if (row.status == '2') {
							return `<a href="javascript:void(0)" onclick="detail(${row.id_bimbingan})" class="badge badge-info"><i class="fa fa-search"></i></a>`
						} else {
							return `<a href="javascript:void(0)" data-toggle="tooltip" title="Ubah Logbook" onclick="edit(${row.id_bimbingan})" class="badge badge-success text-white"><i class="fa fa-edit"></i></a>
								<a href="javascript:void(0)" data-toggle="tooltip" title="Hapus Logbook" onclick="hapus(${row.id_bimbingan})" class="badge badge-warning"><i class="fa fa-trash text-white"></i></a>
								<a href="javascript:void(0)" data-toggle="tooltip" title="Lihat Logbook" onclick="detail(${row.id_bimbingan})" class="badge badge-info"><i class="fa fa-search"></i></a>`
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

	function simpan_logbook(e) {
		if( document.querySelector("#file").files.length == 0 || document.querySelector("#file_gambar").files.length == 0 ){
		    var konfirmasi = confirm('Simpan logbook tanpa lampiran berkas ?')
		    if (!konfirmasi) {
		    	return
		    }
		}

		for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
    	}

		var formData = new FormData(e)

		fetch('<?= base_url('logbook/kirim') ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			filter()
			CKEDITOR.instances.isi.setData('');

			$('#form_tambah_logbook').trigger("reset");
			$('#modal_tambah_logbook').modal('hide')
			toastr.success('Logbook berhasil disimpan', 'MBKM UNMA')
		})
	}
	CKEDITOR.replace( 'isi', {
		removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,Subscript,Superscript,Strikethrough',
	});

	function hapus()
	{
		var konfir = prompt('Tulis "HAPUS" untuk menghapus logbook.')
		if (konfir == 'HAPUS') {
			var data = new FormData()
			data.append('id_bimbingan', arguments[0])

			fetch('<?= base_url('logbook/hapus') ?>', { method: 'POST', body: data })
			.then(response => response.text())
			.then(text => {
				toastr.success('Logbook berhasil dihapus', 'MBKM UNMA')
				filter()
			})
		}
	}

	function filter() {
		table.ajax.reload(null,false);
	}
</script>