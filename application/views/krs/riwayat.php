<table width="100%" class="table responsive table-striped table-bordered compact" role="grid">
	<thead>
		<tr role="row">
			<th>Tahun Akademik</th>
			<th>KRS</th>
			<th>KSM</th>
			<th>KHS</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($riwayat['data'] as $key=>$value){
			$nama_smt=smt2nama2($value['id_smt']);
			echo'
		<tr>
			<td>'.$nama_smt.'</td>
			<td>
				<a href="'.base_url('krs/cetak_krs/'.$value['id_smt'].'/'.$value['id_mahasiswa_pt']).'" target="_blank"><i class="fas fa-print"></i> Cetak</a> 
				<a href="'.base_url('krs/lihat_krs/'.$value['id_smt'].'/'.$value['id_mahasiswa_pt']).'" target="_blank"><i class="fas fa-eye"></i> Lihat</a></td>
			<td>
				<a href="'.base_url('krs/cetak_ksm/'.$value['id_smt'].'/'.$value['id_mahasiswa_pt']).'" target="_blank"><i class="fas fa-print"></i> Cetak</a>
			 	<a href="'.base_url('krs/lihat_ksm/'.$value['id_smt'].'/'.$value['id_mahasiswa_pt']).'" target="_blank"><i class="fas fa-eye"></i> Lihat</a></td>
			<td>
				<a href="'.base_url('krs/cetak_khs/'.$value['id_smt'].'/'.$value['id_mahasiswa_pt']).'" target="_blank"><i class="fas fa-print"></i> Cetak</a>
			 	<a href="'.base_url('krs/lihat_khs/'.$value['id_smt'].'/'.$value['id_mahasiswa_pt']).'" target="_blank"><i class="fas fa-eye"></i> Lihat</a></td>
			
		</tr>
			';
		}
	?>
	</tbody>
</table>