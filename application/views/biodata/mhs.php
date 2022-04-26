<div id="tabpanes">
<ul class="nav nav-tabs nav-underline no-hover-bg nav-justified">
  <li class="nav-item">
	<a class="nav-link active" id="mahasiswa_data_diri" data-toggle="tab" href="#data_diri" aria-controls="data_diri" aria-expanded="true">Data Diri</a>
  </li>
  <li class="nav-item">
	<a class="nav-link" id="mahasiswa_data_ajar" data-toggle="tab" href="<?=base_url('biodata/data_ajar_mhs/')?>" aria-controls="data_ajar" aria-expanded="false">Akademik</a>
  </li>
  <li class="nav-item">
	<a class="nav-link" id="mahasiswa_data_file" data-toggle="tab" href="<?=base_url('biodata/data_file_mhs/')?>" aria-controls="data_file" aria-expanded="false">Dokumen</a>
  </li>
</ul>

<div class="tab-content pt-1">
  <div role="tabpanel" class="tab-pane active" id="data_diri" aria-labelledby="mahasiswa_data_diri" aria-expanded="true">
	<?php $this->load->view('biodata/data_diri_mhs'); ?>
  </div>
</div>
</div>
<script type="text/javascript">
	$( function() {
    $( "#tabpanes" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.fail(function() {
          ui.panel.html(
            "Data belum dapat terload" );
        });
      }
    });
  } );
</script>