<div class="card">
	<div class="card-header pb-1">
		<h6>Program Kampus Merdeka</h6>
	</div>
	<div class="card-content table-responsive">
		<style type="text/css">
			.table th, .table td {
				padding: 10.5px !important;
			}

			.upload { 
				filter: grayscale(100%);
			}
		</style>

		<table class="table table- mb-0 font-small-3 table-hovered">
			<thead>
				<tr style="background: #eaf3fc;">
					<th  width="1">No</th>
					<th width="1">Identitas Pengusul</th>
					<th >Program</th>
					<th>Aktivitas</th>
					<th width="1">Lokasi</th>
					<!-- <th>Cetak</th> -->
					<th width="1">Status</th>
					<th width="1">#</th>
				</tr>
			</thead>
			<tbody>
				<?php if (count($aktivitas_mahasiswa) < 1): ?>
				<tr>
					<td colspan="7" class="text-center"><i>Belum ada program kampus merdeka yang diambil.</i></td>
				</tr>
				<?php endif; ?>

				<?php $no = 1; foreach($aktivitas_mahasiswa as $row): ?>
				<tr>
					<td class="text-center"><?= $no++ ?>.</td>
					<td>
						<b class="d-block"><?= $detail->nm_pd ?></b>
						<span><?= $detail->id_mahasiswa_pt ?></span> <br>
						<i data-toggle="tooltip" title="<?= isset($detail->nama_pt) ? $detail->nama_pt : 'Universitas Majalengka'; ?>">S1- <?= $detail->nama_prodi ?></i>
					</td>
					<td><?= $row->nama_jenis_aktivitas_mahasiswa ?></td>
					<td  class="text-nowrap">
						<p>TA. <?= $row->nama_semester ?></p>
						<p>
							<span data-toggle="tooltip" title="<?= $row->judul_en != '' ? $row->judul_en : 'The activity title is still blank.' ?>"><?= $row->judul != '' ? $row->judul : 'Judul aktivitas masih kosong.' ?></span>
						</p>
					</td>
					<td>
						-
					</td>
					<td class="font-small-3">
						<?php if ($row->status == 0): ?>
							<span class="badge badge-danger">Belum Pengajuan KRS</span>
						<?php elseif ($row->status == 1): ?>
							<span class="badge badge-warning">Belum Validasi KRS</span>
						<?php else: ?>
							<span class="badge badge-success">Sudah Validasi KRS</span>
						<?php endif; ?>
					</td>
					<td>
						<ul class="p-0 mt-0 list-unstyled font-small-3 text-nowrap">
						<?php if ($row->status < 2): ?>
							<li><a href="javascript:void(0)" style="cursor: no-drop" class="badge badge-secondary"><i class="fa fa-book"></i> &nbsp;Logbook</a></li>
						<?php else: ?>
							<li><a href="<?= base_url('usulan/logbook/'.$row->id_aktivitas) ?>" class="badge badge-info"><i class="fa fa-book"></i> &nbsp;Logbook</a></li>
						<?php endif; ?>
							<li><a href="<?= base_url('krs/add/'.$row->id_mahasiswa_pt.'/'.$row->id_smt) ?>" class="badge badge-info"><i class="fa fa-graduation-cap"></i> &nbsp;KRS</a></li>
						</ul>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>