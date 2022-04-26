<style type="text/css">
	.loading {
	    background: url('<?= base_url('assets/images/loading.gif') ?>');
	    background-repeat: no-repeat;
	    background-position: right;
	    background-size: contain;
	}

	input[type="search"]::-webkit-search-cancel-button {
	  	-webkit-appearance: searchfield-cancel-button;
	  	cursor: pointer;
	}
</style>
<section>
    <div class="head-2" style="background: url(https://allwinrx.com/wp-content/uploads/2020/01/hnds.jpg); background-position: right">
        <div class="container">
            <div class="head-2-inn head-2-inn-padd-top" style="text-align: left !important;">
                <h1 class="pb-0">Daftarkan Dirimu</h1>
                <p>Daftarkan dirimu disini sehingga tim MBKM UNMA bisa melihat perkembangan sesuai program yang kamu ambil</p>
            </div>
        </div>
    </div>
</section>
<section class="pop-cour">
    <div class="container com-sp">
        <div class="row">
            <div class="cor about-sp">
                <div class="row">
                	<!-- SEND EMAIL -->
                	<div class="col-md-8 col-md-offset-3 daftar" style="padding: 20px; background: white; border-radius: 5px; display: none">
						<div class="ed-about-sec1 text-center">
		                	<h3 class="my-2">Pendaftaran Berhasil</h3>
                        	<p class="mt-4 text-center">Selamat, pendaftaran anda berhasil. Silahkan login untuk melakukan aktivasi akun.</p>
		                    <div class="ed-advan text-center">
		                    	<br>
		                    	<img src="<?= base_url('assets/images/validation.png') ?>" style="max-width: 100%">
		                    </div>
		                </div>
                	</div>
                	<!-- SEND EMAIL -->

                	<div class="col-md-8 col-md-offset-3" id="pilih-peran" style="padding: 20px; background: white; border-radius: 5px;">
                		<form onsubmit="event.preventDefault(); return pilih_peran(this)">
	                		<div class="ed-about-sec1">
	            				<!-- <h4 class="my-2 pull-right">1/2</h4> -->
			                	<h3 class="my-2">Pilih Peran</h3>
			                	<hr>
			                    <div class="ed-advanx">
			                    	<div class="form-group">
		                        		<label for="smt">Pilih posisi yang sesuai *</label>
		                        		<select class="form-control" required="" name="pilih_posisi">
		                        			<option value="" hidden>Pilih Posisi</option>
		                        			<option value="1">Mahasiswa</option>
		                        			<option value="2">Dosen</option>
		                        			<option value="3">Mitra</option>
		                        		</select>
		                        	</div>
			                    </div>
			                </div>
			                <hr>
			                <div class="d-100 text-center" style="width: 100%">
					        	<button class="btn btn-primary btnNext">Selanjutnya &raquo;</button>
					        	<br><br>
			                	Sudah punya akun ? <a class="text-primary" href="https://satu.unma.ac.id"><b>Masuk</b></a>
			                </div>
					        <div class="clearfix"></div>
                		</form>
                	</div>

                	<form id="form-daftar" onsubmit="event.preventDefault(); daftar(this)" style="display: none; ">
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
					                        		<input type="search" autocomplete="off" name="nama_prodi_asal" id="nama_prodi" class="form-control" required="" placeholder="Masukan program studi asal" onblur="clearTypehead('#nama_prodi')">
				                        			<input type="hidden" name="kode_prodi_asal" id="kode_ps">
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
				                        		<label for="id_jenis_aktivitas_mahasiswa">Jenis Program *</label>
				                        		<select class="form-control" id="id_jenis_aktivitas_mahasiswa" name="id_jenis_aktivitas_mahasiswa" required="" onchange="jenis_aktivitas(this)">
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

				                        	<div class="pmm" style="display: none">
					                        	<div class="form-group">
					                        		<label for="nama_pt_tujuan">Perguruan Tinggi Tujuan *</label>
					                        		<input type="search" autocomplete="off" name="nama_pt_tujuan" id="nama_pt_tujuan" class="form-control" required="" placeholder="Masukan perguruan tinggi asal" onblur="clearTypehead('#nama_pt_tujuan')" disabled="">
					                        		<input type="hidden" name="kode_pt_tujuan" id="kode_pt_tujuan">
					                        	</div>

					                        	<div id="target-pmm" style="display: none;">
						                        	<div class="form-group">
						                        		<label for="nama_prodi_tujuan">Program Studi Tujuan *</label>
						                        		<input type="search" autocomplete="off" name="nama_prodi_tujuan" id="nama_prodi_tujuan" class="form-control" required="" disabled placeholder="Masukan program studi asal" onblur="clearTypehead('#nama_prodi_tujuan')">
						                        	</div>
					                        	</div>

					                        	<div id="target-unma" style="display: none;">
						                        	<div class="form-group">
						                        		<label for="kode_fak">Fakultas Tujuan *</label>
						                        		<select class="form-control" id="kode_fak" disabled>
						                        			<option value="" hidden="">Pilih Fakultas</option>
						                        			<?php foreach ($fakultas as $row) {
						                        				echo "<option value='$row->kode_fak'>".ucwords(strtolower($row->nama_fak))."</option>";
						                        			} ?>
						                        		</select>
						                        	</div>
						                        	<div class="form-group">
						                        		<label for="kode_prodi">Program Studi Tujuan *</label>
						                        		<select class="form-control" name="kode_prodi" id="kode_prodi" disabled readonly>
						                        			<option value="" hidden="">Pilih Program Studi</option>
						                        		</select>
						                        	</div>
					                        	</div>
					                        </div>

				                        	<label for="sk">
				                        		<input type="checkbox" id="sk" required=""> <small>Dengan ini saya menyetujui Ketentuan Penggunaan dan Kebijakan Privasi.</small>
				                        	</label>
					                    </div>
					                </div>
					                <hr>
							        <a class="btn btn-primary pull-left" onclick="fromTo('#form-daftar', '#pilih-peran')">&laquo; Kembali</a>
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

                </div>
            </div>
        </div>
    </div>
</section>
<script>

	function jenis_aktivitas (e) {
		if (e.value == '99') {
			$('.pmm').show()
		}
	}

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

		$('#nama_pt_tujuan').typeahead({
			delay: 2,
			autoSelect: false,
			source: function(query, result) {
				$('#nama_pt_tujuan').addClass('loading')
				$.ajax({
					url 	: "<?= base_url('search_pt') ?>",
					method	: "POST",
					data 	: { keyword: query, limit: 1 },
					dataType: "json",
					success	: function(data) {
						$('#nama_pt_tujuan').removeClass('loading')
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

			        $('#nama_prodi').attr('disabled', 'true')

			        $('#target-pmm').hide()
			        $('#target-unma').show()
				} else {
			        $('#kode_fak').attr('disabled', 'true')
			        $('#kode_prodi').attr('disabled', 'true')
			        
			        $('#nama_prodi').removeAttr('disabled')

			        $('#target-unma').hide()
			        $('#target-pmm').show()
					
				}
				
				$('#kode_pt_tujuan').val(item.code) // ID Perguruan Tinggi MHS

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


	function pilih_peran(e) {
		if (e[0].value == '1') {
			fromTo('#pilih-peran', '#form-daftar')
		}

		return
	}

	function fromTo(from, to) {
		$(from).hide()
		$(to).fadeIn()
	}

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

	function validasi_data() {
		let e = document.querySelector('#form-daftar')

		if (e.checkValidity()) {
			var formData = new FormData(e)

			$('.validasi_data').html('<i class="fa fa-spin fa-spinner"></i>')
			fetch('<?= base_url('search_mhs') ?>', { method: 'POST', body: formData })
			.then(response => response.json())
			.then(data => {
				$('.validasi_data').html('Selanjutnya &raquo;')
				if (data.error) {
					$('.error').fadeIn()
					$('.error-text').text(data.error.message)

					document.body.scrollTop = 0;
  					document.documentElement.scrollTop = 0;
				} else {	
					for (const [key, value] of Object.entries(data.data)) {
						if (key == 'reg_pd') {
							$('#id_reg_pd').val(value.toLowerCase())
						}

						if (key == 'mulai_smt') {
							$('#mulai_smt').val(value)
						}

						if (key == 'mulai_smt') {
							$(`.${key}`).html(`${value.toString().substring(0, 4)} ${((value.toString().substring(-1) == '1') ? 'Genap' : 'Ganjil')}`)
						} else {
							$(`.${key}`).html(`${value}`)
						}
					}

					$(`.program`).html($('#id_jenis_aktivitas_mahasiswa').find(":selected").text())
					$('.error').fadeOut()
					$('.nav-tabs > .active').next('li').find('a').trigger('click');
				}
			})
		} else {
			e.reportValidity();
		}

		return false
	}

	function daftar(e) {
		grecaptcha.ready(function() {
          grecaptcha.execute('6Ldh9pofAAAAAHRKrF24CnM9p3Mvhxr-qLCIF5x6', {action: 'submit'}).then(function(token) {
			var formData = new FormData(e)
			formData.append('token', token)

			fetch('<?= base_url('daftar/simpan') ?>', { method: 'POST', body: formData })
			.then(response => response.text())
			.then(text => {
				// $('.daftar').show()
				// $('#form-daftar').hide()
			})
			
			return 
          });
        });

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


	// function validateMail(p1, p2) {
	// 	if (p1.value != p2.value) {
	// 	    p2.setCustomValidity('Alamat email tidak cocok');
	// 	} else {
	// 	    p2.setCustomValidity('');
	// 	}
	// }

	// function validasi_data() {
	// 	let e = document.querySelector('#form-daftar')

	// 	if (e.checkValidity()) {
	// 		var formData = new FormData(e)
	// 		console.log(e[8])
	// 		dataa.nim = document.querySelector('#nim').value.replaceAll('.', '')
	// 		dataa.nik = document.querySelector('#nik').value
	// 		dataa.birthdate = document.querySelector('#birthdate').value
	// 		// dataa.jenis_aktivtas_mahasiswa = e[8].value

	// 		$.ajax({
	// 			url 	: "<?= base_url('search_mhs') ?>",
	// 			method	: "POST",
	// 			data 	: dataa,
	// 			dataType: "json",
	// 			success	: function(data) {
	// 				if (data.error) {
	// 					$('.error').fadeIn()
	// 					$('.error-text').text(data.error.message)
	// 				} else {
	// 					for (const [key, value] of Object.entries(data.data)) {
	// 						if (key == 'first_semester') {
	// 							$(`.${key}`).html(`${value.toString().substring(0, 4)} ${((value.toString().substring(-1) == '1') ? 'Genap' : 'Ganjil')}`)
	// 						} else {
	// 							$(`.${key}`).html(`${value}`)
	// 						}
	// 					}

	// 					$(`.program`).html(e[8].text)
	// 					$('.error').fadeOut()
	// 					$('.nav-tabs > .active').next('li').find('a').trigger('click');
	// 				}
	// 			}
	// 		})
	// 	} else {
	// 		e.reportValidity();
	// 	}

	// 	return false
	// }

	// function validasi_akun() {
	// 	let email = document.querySelector('#email')
	// 	let email_2 = document.querySelector('#email_2')
	// 	let password = document.querySelector('#password')

	// 	if (email.checkValidity() && email_2.checkValidity() && password.checkValidity() ) {
	// 		$('.nav-tabs > .active').next('li').find('a').trigger('click');
	// 	} else {
	// 		password.reportValidity();
	// 		email_2.reportValidity();
	// 		email.reportValidity();
	// 		return
	// 	}
	// }
</script>