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
                	<div class="col-md-8 col-md-offset-2 daftar" style="padding: 20px; background: white; border-radius: 5px; display: none">
						<div class="ed-about-sec1 text-center">
		                	<h3 class="my-2">Pendaftaran Berhasil</h3>
                        	<p class="mt-4 text-center">
                        		Selamat, pendaftaran kamu berhasil. Silahkan login untuk melakukan aktivasi akun. <br>
                        		<small><i class="fa fa-info-circle"></i> Periksa email kamu untuk memperoleh informasi login.</small>
                        	</p>
		                    <div class="ed-advan text-center">
		                    	<br>
		                    	<img src="<?= base_url('assets/images/validation.png') ?>" style="max-width: 100%">
		                    </div>
		                </div>
                	</div>
                	<!-- SEND EMAIL -->

                	<div class="col-md-8 col-md-offset-2" id="pilih-peran" style="padding: 20px; background: white; border-radius: 5px;">
                		<form onsubmit="event.preventDefault(); return pilih_peran(this)">
	                		<div class="ed-about-sec1">
	            				<!-- <h4 class="my-2 pull-right">1/2</h4> -->
			                	<h3 class="my-2">Pilih Peran</h3>
			                	<hr>
			                    <div class="ed-advanx">
			                    	<div class="form-group">
		                        		<label for="pilih_posisi">Pilih posisi yang sesuai *</label>
		                        		<select class="form-control" id="pilih_posisi" required="" name="pilih_posisi">
		                        			<option value="" hidden>Pilih Posisi</option>
		                        			<option value="1">Mahasiswa</option>
		                        			<option value="2">Dosen</option>
		                        			<option value="3" disabled="">Mitra (Coming Soon)</option>
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

                	<div id="formulir-pendaftaran"></div>

                </div>
            </div>
        </div>
    </div>
</section>
<script>
	function pilih_peran(e) {
		if (e[0].value == '1') {
			// fromTo('#pilih-peran', '#daftar-mahasiswa')
			$('#formulir-pendaftaran').load('<?= base_url('landing/formulir_mahasiswa') ?>', function () {
				$('#pilih-peran').hide()
			})
		} else if (e[0].value == '2') {
			// fromTo('#pilih-peran', '#daftar-dosen')
			$('#formulir-pendaftaran').load('<?= base_url('landing/formulir_dosen') ?>', function () {
				$('#pilih-peran').hide()
			})
		} else if (e[0].value == '3') {
			// fromTo('#pilih-peran', '#daftar-mitra')
			alert('Formulir pendaftaran mitra sedang dalam perbaikan.')
		}

		return
	}

	function fromTo(from, to) {
		$(from).hide()
		$(to).fadeIn()
	}

	function validasi_data() {
		let e = document.querySelector('#daftar-mahasiswa')

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
						if (key == 'ipk') {
							if (value < 3) {
								$(`.ipk`).html(`${value}`)
							}
						}

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
		$('button').html('<i class="fa fa-spin fa-spinner"></i> Menyimpan ...')
		$('button').attr('disabled', 'true')
		grecaptcha.ready(function() {
          grecaptcha.execute('6Ldh9pofAAAAAHRKrF24CnM9p3Mvhxr-qLCIF5x6', {action: 'submit'}).then(function(token) {
			var formData = new FormData(e)
			formData.append('token', token)

			fetch('<?= base_url('daftar/simpan') ?>', { method: 'POST', body: formData })
			.then(response => response.json())
			.then(json => {
				$('button').html('Selanjutnya &raquo;')
				$('button').removeAttr('disabled')
				if (json.error) {
					$('.error').fadeIn()
					$('.error-text').text(json.error.message)

					document.body.scrollTop = 0;
  					document.documentElement.scrollTop = 0;
				} else {
					$('.error').hide()
					$('.daftar').show()
					$('#daftar-mahasiswa').hide()
				}
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
</script>