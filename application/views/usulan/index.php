<div class="alert bg-info alert-icon-left alert-arrow-left  mb-2" role="alert">
	<span class="alert-icon"><i class="la la-info"></i></span>
	<b>Ploting Dosen Pembimbing</b> dilakukan oleh Ketua Program Studi.
</div>
<div class="card">
	<div class="card-header pb-1">
		<h6><?= $title ?></h6>
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
					<th>Identitas Pengusul</th>
					<th >Program</th>
					<th>Aktivitas</th>
					<th >Pembimbing</th>
					<th >Koordinator</th>
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
							<span data-toggle="tooltip" title="<?= $row->judul_en != '' ? $row->judul_en : '-' ?>"><?= $row->judul != '' ? $row->judul : '-' ?></span>
						</p>
					</td>
					<td><?= $row->nama_dosen_pembimbing != '' ? $row->nama_dosen_pembimbing : '-' ?><br><?= $row->nidn_dosen_pembimbing ?></td>
					<td><?= $row->nama_dosen_koordinator != '' ? $row->nama_dosen_koordinator : '-' ?><br><?= $row->nidn_dosen_koordinator ?></td>
					<td class="font-small-3">
						<!-- STATUS KRS -->
						<?php if ($row->status == 0): ?>
							<span class="badge badge-danger">Belum Pengajuan KRS</span>
						<?php elseif ($row->status == 1 and !isset($detail->nama_pt)): ?>
							<span class="badge badge-warning">Belum Validasi KRS</span> <br><br>
							<ul class="p-0 mt-0 list-unstyled text-nowrap">
								<li>1. Dosen Wali</li>
								<li>2. Ketua Prodi</li>
							</ul>
						<?php elseif($row->status == 1 AND isset($detail->nama_pt)): ?>
							<span class="badge badge-warning">Belum Validasi KRS</span> <br><br>
							<ul class="p-0 mt-0 list-unstyled text-nowrap">
								<li>1. BAAK / Wakil Rektor I</li>
							</ul>
						<?php else: ?>
							<span class="badge badge-success">Sudah Validasi KRS</span>
						<?php endif; ?>
						<!-- STATUS KRS -->
					</td>
					<td>
						<ul class="p-0 mt-0 list-unstyled text-nowrap">
						<?php if ($row->status < 2): ?>
							<li><a href="javascript:void(0)" style="cursor: no-drop" class="badge badge-secondary" data-toggle="tooltip" title="Belum Pengajuan KRS"><i class="fa fa-book"></i> &nbsp;Aktivitas</a></li>
						<?php elseif ($row->nama_dosen_koordinator == '' OR $row->nama_dosen_pembimbing == ''): ?>
							<li><a href="javascript:void(0)" style="cursor: no-drop" class="badge badge-secondary" data-toggle="tooltip" title="Dosen Pembimbing / Koordinator Masih Kosong"><i class="fa fa-book"></i> &nbsp;Aktivitas</a></li>
						<?php else: ?>
							<li><a href="<?= base_url('usulan/logbook/'.$row->id_aktivitas) ?>" class="badge badge-info"><i class="fa fa-book"></i> &nbsp;Aktivitas</a></li>
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