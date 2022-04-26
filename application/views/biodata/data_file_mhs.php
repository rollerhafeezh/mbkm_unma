<div id="accordionWrapa1" role="tablist" aria-multiselectable="true" class="mt-2">
	<div class="card">
		<div id="heading1" class="card-header bg-info" role="tab">
			<a data-toggle="collapse" href="#accordion1" aria-expanded="true" aria-controls="accordion1" class="card-title lead text-white">File Mahasiswa</a>
		</div>
		<div id="accordion1" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading1" class="collapse show  border-info" style="">
			<div class="card-content">
				<div class="card-body">
					<div class="row">
					<?php 
					
					foreach($jenis_file as $key=>$value){
						$file=json_decode($this->curl->simple_get(ADD_API.'filez/get_file?id_mhs='.$id_mhs.'&jenis_file='.$key));
						//var_dump($file);
						if($file){
							echo'
							<div class="col-xl-3 col-md-6 col-sm-12">
								<div class="card">
									<a data-fancybox="gallery" href="https://simakng.unma.ac.id/files/mahasiswa/large/'.$file[0]->nama_file.'"> 
										<img id="s'.$key.'" src="https://simakng.unma.ac.id/files/mahasiswa/large/'.$file[0]->nama_file.'"  class="card-img-top img-fluid" alt="https://simakng.unma.ac.id/files/mahasiswa/large/'.$file[0]->nama_file.'"></a>
										<div class="card-body">
											<h4 class="card-title">'.nama_filez($key).'</h4>
											<input type="file" jenis_file="'.$key.'">
										</div>
								</div>
							</div>';
						}else{
							echo'
							<div class="col-xl-3 col-md-6 col-sm-12">
								<div class="card">
									<div class="card-body">
											<img id="p'.$key.'" style="display:none" class="card-img-top img-fluid">
											<h4 class="card-title mt-2">'.nama_filez($key).'</h4>
											<input type="file" jenis_file="'.$key.'">
										</div>
								</div>
							</div>';
						}
						
					}
					?>
					</div>
				<small>untuk avatar disarankan memilih gambar dengan rasio 1:1</small>
				</div>
			</div>
		</div>
	<!--CARD ATAS-->
	<div id="heading2" class="card-header  bg-success">
			<a data-toggle="collapse" href="#accordion2" aria-expanded="false" aria-controls="accordion2" class="card-title lead collapsed text-white">FILE PMB</a>
		</div>
		<div id="accordion2" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading2" class="collapse border-success" aria-expanded="false">
			<div class="card-content">
				<div class="card-body">
					<div class="row">
					<?php 
					if($file_pmb){
						//var_dump($file_mhs);
						foreach ($file_pmb as $key=>$value){
							echo '
							<div class="col-xl-3 col-md-6 col-sm-12">
							<div class="card">
										<a data-fancybox="gallery" href="'.URL_DOC.$value->nama_file.'"> <img src="'.URL_DOC.$value->nama_file.'" width="20%" class="card-img-top img-fluid" alt="'.$value->nama_file.'"></a>
										<div class="card-body">
											<h4 class="card-title">'.nama_filez($value->jenis_file).'</h4>
										</div>
								</div>
							</div>';
						}
					}else{
						echo "<p>n/a</p>";
					}
					?>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
	<!--CARD 2-->
<script type="text/javascript">

function readURL(input,jenis_file) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#p'+jenis_file).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
};

$("input[type='file']").on("change", function () {
	// var val 			= $(this).val();
	var jenis_file 		= $(this).attr("jenis_file");
	console.log(jenis_file);
	
	$('#p'+jenis_file).show();
	$('#s'+jenis_file).hide();
	readURL(this,jenis_file);
	
	var formData 		= new FormData();
	formData.append('cover', $(this)[ 0 ].files[ 0 ]);
	formData.append('jenis_file', $(this).attr('jenis_file'));
	
	// send data
	$.ajax({
		url: '<?=base_url('biodata/upload/')?>',
		type: 'POST',
		data: formData,
		contentType: false,
		processData: false,
		success : function( response ) {
			//var json=JSON.parse(response);
			toastr.info(response.message);
		}
	});
	
});
</script>

