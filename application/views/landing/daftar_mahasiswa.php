<form id="daftar-mahasiswa" onsubmit="event.preventDefault(); daftar(this)">
	<div class="col-md-8 col-md-offset-3 p-0 error" style="display: none">
		<div class="alert alert-danger mb-4">
			<i class="fa fa-exclamation-triangle mr-2"></i> 
			<span class="error-text">-</span>
		</div>
	</div>

	<div class="col-md-8 col-md-offset-3" style="padding: 20px; background: white; border-radius: 5px;">
		<ul class="nav nav-tabs" style="display: none">
		    <li class="active"><a href="#tab1" data-toggle="tab">Data Mahasiswa</a></li>
		    <li><a href="#tab2" data-toggle="tab">Verifikasi Data</a></li>
		</ul>
		<div class="tab-content">
		    <div class="tab-pane active" id="tab1">
		    	<div class="ed-about-sec1">
    				<h4 class="my-2 pull-right">1/2</h4>
                	<h3 class="my-2">Formulir Pendaftaran</h3>
                	<hr>
                    <div class="ed-advanx">
                    	<div class="form-group">
                    		<label for="smt">Tahun Akademik Pelaksanaan *</label>
                    		<p><?= $smt->nama_semester ?></p>
                    		<input type="hidden" name="id_smt" value="<?= $smt->id_semester ?>">
                    	</div>
                    	<div class="form-group">
                    		<label for="nama_pt">Perguruan Tinggi Asal *</label>
                    		<input type="search" autocomplete="off" name="nama_pt" id="nama_pt" class="form-control" required="" placeholder="Masukan perguruan tinggi asal" onblur="clearTypehead('#nama_pt')">
                    		<input type="hidden" name="kode_pt" id="kode_pt">
                    		<input type="hidden" name="id_sp" id="id_sp">
                    	</div>

                    	<div id="mahasiswa-pmm" style="display: none;">
                        	<div class="form-group">
                        		<label for="nama_prodi">Program Studi Asal *</label>
                        		<input type="search" autocomplete="off" name="nama_prodi" id="nama_prodi" class="form-control" required="" placeholder="Masukan program studi asal" onblur="clearTypehead('#nama_prodi')">
                    			<input type="hidden" name="kode_prodi" id="kode_ps">
                    			<input type="hidden" name="id_sms" id="id_sms">
                        	</div>
                        	<div class="form-group">
                        		<label for="nim">Nomor Induk Mahasiswa (NIM) *</label>
                        		<input type="search" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM lengkap" required=""  autocomplete="off">
                        		<small class="text-muted">Tanpa menggunakan karakter spesial, seperti titik(.), spasi( ), dll.</small>
                        		<input type="hidden" name="id_reg_pd" id="id_reg_pd">
                        		<input type="hidden" name="id_pd" id="id_pd">
                        		<input type="hidden" name="id_mahasiswa_pt" id="nipd">
                        		<input type="hidden" name="mulai_smt" id="mulai_smt">
                        	</div>
                    	</div>

                    	<div id="mahasiswa-unma" style="display: none;">
                        	<div class="form-group">
                        		<label for="kode_fak">Fakultas Asal *</label>
                        		<select class="form-control" id="kode_fak">
                        			<option value="" hidden="">Pilih Fakultas</option>
                        			<?php foreach ($fakultas as $row) {
                        				echo "<option value='$row->kode_fak'>".ucwords(strtolower($row->nama_fak))."</option>";
                        			} ?>
                        		</select>
                        	</div>
                        	<div class="form-group">
                        		<label for="kode_prodi">Program Studi Asal *</label>
                        		<select class="form-control" name="kode_prodi" id="kode_prodi" disabled readonly>
                        			<option value="" hidden="">Pilih Program Studi</option>
                        		</select>
                        	</div>
                        	<div class="form-group">
                        		<label for="id_mahasiswa_pt">Nomor Induk Mahasiswa (NIM) *</label>
                        		<input type="search" class="form-control" id="id_mahasiswa_pt" name="id_mahasiswa_pt" placeholder="Masukkan NIM lengkap" required="">
                        	</div>
                    	</div>

                    	<div class="form-group">
                    		<label for="nik">Nomor Induk Kependudukan (NIK) *</label>
                    		<input type="search" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK lengkap" required="">
                    	</div>
                    	<div class="form-group">
                    		<label for="tgl_lahir">Tanggal Lahir *</label>
                    		<input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required="">
                    	</div>
                    	<div class="form-group">
                    		<label for="email">Email *</label>
                    		<input type="email" class="form-control" id="email" name="email" required="" placeholder="Masukkan alamat email">
                    		<small class="text-muted pl-1">Pastikan alamat email ini dapat Anda akses</small>
                    	</div>
                    	<div class="form-group">
                    		<label for="no_hp">No. Handphone *</label>
                    		<input type="tel" class="form-control" id="no_hp" name="no_hp" required="" placeholder="Masukkan alamat email">
                    		<small class="text-muted pl-1">Pastikan alamat email ini dapat Anda akses</small>
                    	</div>
                    	<div class="form-group">
                    		<label for="id_jenis_aktivitas_mahasiswa">Jenis Program *</label>
                    		<select class="form-control" id="id_jenis_aktivitas_mahasiswa" name="id_jenis_aktivitas_mahasiswa" required="">
                    			<option value="" hidden>Pilih Jenis Program</option>
                    			<option value="13">Magang</option>
                    			<option value="14">Kampus Mengajar</option>
                    			<option value="15">Riset atau Penelitian</option>
                    			<option value="16">Proyek Kemanusiaan</option>
                    			<option value="17">Wirausaha</option>
                    			<option value="18">Studi Independen</option>
                    			<option value="99">Pertukaran Pelajar</option>
                    		</select>
                    	</div>

                    	<label for="sk">
                    		<input type="checkbox" id="sk" required=""> <small>Dengan ini saya menyetujui Ketentuan Penggunaan dan Kebijakan Privasi.</small>
                    	</label>
                    </div>
                </div>
                <hr>
		        <a class="btn btn-primary pull-left" onclick="fromTo('#daftar-mahasiswa', '#pilih-peran')">&laquo; Kembali</a>
		        <a class="btn btn-primary btnNext pull-right validasi_data" onclick="return validasi_data()">Selanjutnya &raquo;</a>
		        <div class="clearfix"></div>
		    </div>

		    <div class="tab-pane" id="tab2">
		    	<div class="ed-about-sec1">
    				<h4 class="my-2 pull-right">2/2</h4>
                	<h3 class="my-2">Verifikasi Data</h3>
                	<hr>
                    <div class="ed-advanx">
                		<span class="text-muted">Nama</span>
                		<span class="show nm_pd" style="color: black;">-</span> <br>
                		<span class="text-muted">Tanggal Lahir</span>
                		<span class="show tgl_lahir" style="color: black;">-</span> <br>
                		<span class="text-muted">Jenis Kelamin</span>
                		<span class="show jk" style="color: black;">-</span> <br>
                		<span class="text-muted">NIM</span>
                		<span class="show id_mahasiswa_pt" style="color: black;">-</span> <br>
                		<span class="text-muted">Perguruan Tinggi</span>
                		<span class="show pt_name" style="color: black;">Universitas Majalengka</span> <br>
                		<!-- <span class="text-muted">Fakultas</span>
                		<span class="show nama_fak" style="color: black; text-transform: capitalize;">-</span> <br> -->
                		<span class="text-muted">Program Studi</span>
                		<span class="show nama_prodi" style="color: black;">-</span> <br>
                		<span class="text-muted">Jenjang</span>
                		<span class="show jenjang" style="color: black;">S1</span> <br>
                		<span class="text-muted">Semester Masuk</span>
                		<span class="show mulai_smt" style="color: black;">-</span> <br>
                		<span class="text-muted">Program Kampus Merdeka</span>
                		<span class="show program" style="color: black;">-</span> <br>
                    </div>
                </div>
                <hr>
		        <button class="btn btn-primary pull-right">Selanjutnya &raquo;</button>
		        <a class="btn btn-primary btnPrevious" >&laquo; Kembali</a>
		        <div class="clearfix"></div>
		    </div>
		</div>
	</div>
</form>
<script>
	var dataa = {};

	var kode_prodi = document.querySelector('#kode_prodi');
	var kode_fak = document.querySelector('#kode_fak');

	kode_fak.addEventListener('change', (e) => {
		fetch('<?= base_url('search_prodi') ?>/' + kode_fak.value)
		.then(response => response.text())
		.then(text => {
			kode_prodi.innerHTML = text;
			kode_prodi.removeAttribute('readonly');
		})
	})
	
	$(document).ready(function() {
		$('.btnPrevious').click(function(){
		  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
		});
		
		$('#nama_pt').typeahead({
			delay: 2,
			autoSelect: false,
			source: function(query, result) {
				$('#nama_pt').addClass('loading')
				$.ajax({
					url 	: "<?= base_url('search_pt') ?>",
					method	: "POST",
					data 	: { keyword: query, limit: 1 },
					dataType: "json",
					success	: function(data) {
						$('#nama_pt').removeClass('loading')
						result($.map(data, function(item) {
							return item;
						}));
					}
				})
			},
			updater: function(item) {
				if (item.code == '041043') {
			        $('#kode_fak').removeAttr('disabled', 'true')
			        $('#kode_prodi').removeAttr('disabled', 'true')
			        $('#id_mahasiswa_pt').removeAttr('disabled', 'true')

			        $('#nama_prodi').attr('disabled', 'true')
			        $('#nim').attr('disabled', 'true')

			        $('#mahasiswa-pmm').hide()
			        $('#mahasiswa-unma').show()
				} else {
			        $('#kode_fak').attr('disabled', 'true')
			        $('#kode_prodi').attr('disabled', 'true')
			        $('#id_mahasiswa_pt').attr('disabled', 'true')
			        
			        $('#nama_prodi').removeAttr('disabled')
			        $('#nim').removeAttr('disabled')

			        $('#mahasiswa-unma').hide()
			        $('#mahasiswa-pmm').show()
			        dataa.pt_id = item.id
			        dataa.pt_code = item.code
				}

				$('#id_sp').val(item.id) // ID Perguruan Tinggi MHS
				$('#kode_pt').val(item.code) // ID Perguruan Tinggi MHS
		        return item
		    },
		});

		$('#nama_prodi').typeahead({
			source: function(query, result) {
				$('#nama_prodi').addClass('loading')
				$.ajax({
					url 	: "<?= base_url('api_search_prodi') ?>",
					method	: "POST",
					data 	: { keyword: query, limit: 1, pt_id: dataa.pt_id },
					dataType: "json",
					success	: function(data) {
						$('#nama_prodi').removeClass('loading')
						result($.map(data, function(item) {
							if (item) {
								dataa.prodi_id = item[0].id
								dataa.prodi_code = item[0].code

								return item;
							}
						}));
					}
				})
			},
			updater: function(item) {
				$('#kode_ps').val(item.code) // Kode Prodi MHS PMM
				$('#id_sms').val(item.id) // ID SMS MHS PMM

				return item;
				// return `${item.jenjang_didik} - ${item.name}`;
		    }
		});

		$('#nim').typeahead({
			delay: 2,
			autoSelect: false,
			source: function(query, result) {
				$('#nim').addClass('loading')
				$.ajax({
					url 	: "<?= base_url('api_search_mhs/') ?>" + query,
					method	: "GET",
					dataType: "json",
					success	: function(data) {
						$('#nim').removeClass('loading')
						result($.map(data, function(item) {
							if (item) {
								return item;
							}
						}));
					},
					error: function (req) {
						console.log('Something Error!')
					}
				})
			},
			updater: function(item) {
				$('#nipd').val(item.nim)
				$('#id_pd').val(item.id)
				return item.show;
		    }
		});
	});
</script>