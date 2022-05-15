<form id="daftar-dosen" onsubmit="event.preventDefault(); daftar(this)">
	<div class="col-md-8 col-md-offset-3 p-0 error" style="display: none">
		<div class="alert alert-danger mb-4">
			<i class="fa fa-exclamation-triangle mr-2"></i> 
			<span class="error-text">-</span>
		</div>
	</div>

	<div class="col-md-8 col-md-offset-3" style="padding: 20px; background: white; border-radius: 5px;">
		<ul class="nav nav-tabs" style="display: none">
		    <li class="active"><a href="#tab1" data-toggle="tab">Data Dosen</a></li>
		</ul>
		<div class="tab-content">
		    <div class="tab-pane active" id="tab1">
		    	<div class="ed-about-sec1">
                	<h3 class="my-2">Formulir Pendaftaran</h3>
                	<hr>
                    <div class="ed-advanx">
                    	<div class="form-group">
                    		<label for="nidn">NIDN *</label>
                    		<input type="search" class="form-control" id="nidn" name="nidn" placeholder="Masukkan NIDN lengkap" required=""  onblur="clearTypehead('#nidn')">
                    		<small class="text-muted">Tanpa menggunakan karakter spesial, seperti titik(.), spasi( ), dll.</small>
                    		<input type="hidden" name="id_sdm" id="id_sdm">
                    		<input type="hidden" name="nm_sdm" id="nm_sdm">
                    		<input type="hidden" name="jk" id="jk">
                    		<input type="hidden" name="tmpt_lahir" id="tmpt_lahir">
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
                    		<label for="tel">No. Handphone *</label>
                    		<input type="tel" class="form-control" id="tel" name="no_hp" required="" placeholder="Masukkan nomor handphone">
                    	</div>
                    	<div class="form-group">
                    		<label for="email">Email *</label>
                    		<input type="email" class="form-control" id="email" name="email" required="" placeholder="Masukkan alamat email">
                    		<small class="text-muted pl-1">Pastikan alamat email ini dapat Anda akses</small>
                    	</div>

                    	<label for="sk">
                    		<input type="checkbox" id="sk" required=""> <small>Dengan ini saya menyetujui Ketentuan Penggunaan dan Kebijakan Privasi.</small>
                    	</label>
                    </div>
                </div>
                <hr>
		        <a class="btn btn-primary pull-left" onclick="fromTo('#daftar-dosen', '#pilih-peran')">&laquo; Kembali</a>
		        <button class="btn btn-primary btnNext pull-right">Selanjutnya &raquo;</button>
		        <div class="clearfix"></div>
		    </div>
		</div>
	</div>
</form>
<script>
    $(document).ready(function() {
        $('#nidn').typeahead({
            delay: 2,
            autoSelect: false,
            source: function(query, result) {
                $('#nidn').addClass('loading')
                $.ajax({
                    url     : "<?= base_url('api_search_dosen/') ?>" + query,
                    method  : "GET",
                    dataType: "json",
                    success : function(data) {
                        $('#nidn').removeClass('loading')
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
                $.ajax({
                    url     : "<?= base_url('api_detail_dosen/') ?>" + item.id,
                    method  : "GET",
                    dataType: "json",
                    success : function(data) {
                        for (const [key, value] of Object.entries(data)) {
                            $(`#${key}`).val(`${value}`)
                        }
                    },
                    error: function (req) {
                        console.log('Something Error: API Detail Dosen.')
                    }
                })
                
                return item.show;
            }
        });
    });
</script>