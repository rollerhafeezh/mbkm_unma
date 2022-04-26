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
                	<div class="col-md-6 col-md-offset-3 daftar" style="padding: 20px; background: white; border-radius: 5px; display: none">
						<div class="ed-about-sec1 text-center">
		                	<h3 class="my-2">Pendaftaran Berhasil</h3>
		                    <div class="ed-advan text-center">
		                    	<br>
		                    	<img src="<?= base_url('assets/images/validation.png') ?>">
	                        	<p class="mt-4 text-center">Selanjutnya, silahkan lakukan Validasi (<i class="fa fa-check text-success"></i>) kepada Dosen Wali dan Ketua Program Studi sehingga menu program kampus merdeka bisa muncul di akun-mu.</p>
		                    </div>
		                </div>
                	</div>
                	<!-- SEND EMAIL -->

                	<form id="form-daftar" onsubmit="event.preventDefault(); daftar(this)">
                	<div class="col-md-6 col-md-offset-3 p-0 error" style="display: none">
                		<div class="alert alert-danger mb-4">
                			<i class="fa fa-exclamation-triangle mr-2"></i> 
                			<span class="error-text">-</span>
                		</div>
                	</div>

                	<div class="col-md-6 col-md-offset-3" style="padding: 20px; background: white; border-radius: 5px;">
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
			                        		<label for="kode_fak">Fakultas *</label>
			                        		<select class="form-control" id="kode_fak" required="">
			                        			<option value="" hidden="">Pilih Fakultas</option>
			                        			<?php foreach ($fakultas as $row) {
			                        				echo "<option value='$row->kode_fak'>".ucwords(strtolower($row->nama_fak))."</option>";
			                        			} ?>
			                        		</select>
			                        	</div>
			                        	<div class="form-group">
			                        		<label for="kode_prodi">Program Studi *</label>
			                        		<select class="form-control" name="kode_prodi" id="kode_prodi" disabled required="">
			                        			<option value="" hidden="">Pilih Program Studi</option>
			                        		</select>
			                        	</div>
			                        	<div class="form-group">
			                        		<label for="id_mahasiswa_pt">Nomor Induk Mahasiswa (NIM) *</label>
			                        		<input type="text" class="form-control" id="id_mahasiswa_pt" name="id_mahasiswa_pt" placeholder="Masukkan NIM lengkap" required="">
			                        	</div>
			                        	<div class="form-group">
			                        		<label for="nik">Nomor Induk Kependudukan (NIK) *</label>
			                        		<input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK lengkap" required="">
			                        	</div>
			                        	<div class="form-group">
			                        		<label for="tgl_lahir">Tanggal Lahir *</label>
			                        		<input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required="">
			                        	</div>
			                        	<div class="form-group">
			                        		<label for="email">Email *</label>
			                        		<input type="email" class="form-control" id="email" name="email" required="" placeholder="Masukkan alamat email">
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
			                        		</select>
			                        	</div>
			                        	<label for="sk">
			                        		<input type="checkbox" id="sk" required=""> <small>Dengan ini saya menyetujui Ketentuan Penggunaan dan Kebijakan Privasi.</small>
			                        	</label>
				                    </div>
				                </div>
				                <hr>
						        <a class="btn btn-primary btnNext pull-right" onclick="return validasi_data()">Selanjutnya</a>
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
		                        		<span class="text-muted">Fakultas</span>
		                        		<span class="show nama_fak" style="color: black; text-transform: capitalize;">-</span> <br>
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
						        <button class="btn btn-primary pull-right">Selanjutnya</button>
						        <a class="btn btn-primary btnPrevious" >Kembali</a>
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
	var dataa = {};

	var kode_prodi = document.querySelector('#kode_prodi');
	var kode_fak = document.querySelector('#kode_fak');

	kode_fak.addEventListener('change', (e) => {
		fetch('<?= base_url('search_prodi') ?>/' + kode_fak.value)
		.then(response => response.text())
		.then(text => {
			kode_prodi.innerHTML = text;
			kode_prodi.removeAttribute('disabled');
		})
	})

	function validasi_data() {
		let e = document.querySelector('#form-daftar')

		if (e.checkValidity()) {
			var formData = new FormData(e)

			fetch('<?= base_url('search_mhs') ?>', { method: 'POST', body: formData })
			.then(response => response.json())
			.then(data => {
				if (data.error) {
					$('.error').fadeIn()
					$('.error-text').text(data.error.message)

					document.body.scrollTop = 0;
  					document.documentElement.scrollTop = 0;
				} else {	
					for (const [key, value] of Object.entries(data.data)) {
						if (key == 'mulai_smt') {
							$(`.${key}`).html(`${value.toString().substring(0, 4)} ${((value.toString().substring(-1) == '1') ? 'Genap' : 'Ganjil')}`)
						} else {
							$(`.${key}`).html(`${value}`)
						}
					}

					$(`.program`).html(e[7].selectedOptions[0].text)
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
		var formData = new FormData(e)

		fetch('<?= base_url('daftar/simpan') ?>', { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			$('.daftar').show()
			$('#form-daftar').hide()
		})
		
		return 
	}

	$(document).ready(function() {
	  	$('.btnPrevious').click(function(){
		  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
		});

		// $('#fakultas').typeahead({
		// 	source: function(query, result) {
		// 		$.ajax({
		// 			url 	: "<?= base_url('search_pt') ?>",
		// 			method	: "POST",
		// 			data 	: { keyword: query, limit: 1 },
		// 			dataType: "json",
		// 			success	: function(data) {
		// 				result($.map(data, function(item) {
		// 					return item;
		// 				}));
		// 			}
		// 		})
		// 	},
		// 	updater: function(item) {
		//         $('#program_studi').removeAttr('readonly')
		//         dataa.pt_id = item.id
		//         dataa.pt_code = item.code
		//         return item
		//     },
		// });

		$('#program_studi').typeahead({
			source: function(query, result) {
				$.ajax({
					url 	: "<?= base_url('search_prodi') ?>",
					method	: "POST",
					data 	: { keyword: query, limit: 1, pt_id: dataa.pt_id },
					dataType: "json",
					success	: function(data) {
						result($.map(data, function(item) {
							if (item) {
								dataa.prodi_id = item[0].id
								dataa.prodi_code = item[0].code

								return `${item[0].jenjang_didik} - ${item[0].name}`;
							}
						}));
					}
				})
			},
			updater: function(item) {
				return item;
		    }
		});
	});

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