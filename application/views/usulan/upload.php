<div class="card mb-0">
	<form action="" method="POST" enctype="multipart/form-data">
		<div class="card-header pb-0">
			<h6><?= $title ?></h6>

			<div class="heading-elements d-none d-md-block">
				<a class="btn btn-sm btn-danger" href="<?= base_url('usulan') ?>" onclick="return confirm('Apakah anda yakin ingin meninggalkan halaman ini ?')"><i class="ft-arrow-left"></i> Kembali</a>
				<button type="submit" class="btn btn-sm btn-success">Simpan</button>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<fieldset style="border: 1px solid #6B6F82; margin: inherit;" class="p-1 unggah-berkas">
						<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">Unggah Berkas</legend>

						<form action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id_kat_berkas" value="<?= $id_kat_berkas; ?>">
							<div class="custom-file">
	                              <input type="file" class="custom-file-input" id="inputGroupFile02" name="berkas" accept="application/pdf" required="">
	                              <label  class="custom-file-label text-nowrap d-block w-100"  style="padding-right: 6rem; overflow: hidden; text-overflow: ellipsis;" for="inputGroupFile02" aria-describedby="inputGroupFile02">
	                              	<!-- Berkas <?= $nama_kategori ?> -->
	                              	Pilih Berkas
	                          	</label>
	                          </div>
                          <small class="text-muted mt-2 d-block">
                          	<b>Keterangan:</b>
                          	<ol type="1" class="pl-1 m-0">
                          		<li>Berkas yang di-unggah <b>harus file pdf (.pdf)</b>, apabila berkas yang di-unggah dalam bentuk <b>Power Point</b> silahkan konversi terlebih dahulu menggunakan tautan dibawah:
                          			<ul class="pl-0 m-0 list-unstyled">
                          				<li><a href="https://smallpdf.com/id/ppt-ke-pdf" target="_blank"><i class="ft-link"></i> Link Konverter PPT ke PDF - Small PDF</a></li>
                          			</ul>
                          		</li>
                          		<li>Berkas yang di-unggah adalah <b>berkas dengan tanda tangan dan cap asli</b>, bukan fotokopian-an</li>
                          		<li><b>Ukuran maksimal 10 MB</b> untuk berkas yang di-unggah, apabila berkas yang di-unggah melebihi batas maksimal silahkan untuk melakukan <b>Kompresi File Online</b> terlebih dahulu dengan menggunakan link dibawah:
                          			<ul class="pl-0 m-0 list-unstyled">
                          				<li><a href="https://www.ilovepdf.com/id/mengompres-pdf" target="_blank"><i class="ft-link"></i> Link Kompres PDF - I Love PDF</a></li>
                          				<li><a href="https://smallpdf.com/id/mengompres-pdf" target="_blank"><i class="ft-link"></i> Link Kompres PDF - Small PDF</a></li>
                          			</ul>
                          		</li>
                          	</ol>
                          </small>
						</form>
					</fieldset>
				</div>
				<div class="col-md-8">
					<div class="clearfix d-md-none d-block mt-1"></div>
					<fieldset style="border: 1px solid #6B6F82; padding: 10px; margin: inherit; display: block; height: 100vh;">
						<legend style="width: inherit; font-size: inherit; margin: inherit;" class="font-small-3 pl-1 pr-1">Preview Berkas</legend>
						<object width="100%" height="98%"></object>
					</fieldset>
				</div>
			</div>


			<div class="mt-1 d-md-none d-block text-nowrap">
				<a class="btn btn-sm btn-danger w-50" href="<?= base_url('usulan') ?>" onclick="return confirm('Apakah anda yakin ingin meninggalkan halaman ini ?')">Kembali</a>
				<button type="submit" class="btn btn-sm btn-success w-50">Simpan</button>
			</div>
		</div>
	</form>
</div>
