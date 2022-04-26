<table border="0" width="100%">
	<tr>
		<td width="15%">
			<img src="<?= base_url('assets/logo/'.strtolower(explode(' - ', $detail->homebase)[0])) ?>.png" width="120">
		</td>
		<td width="85%">
			<center>
				<font style="font-size:20pt; line-height:30px;font-weight: bold;letter-spacing: 2px">UNIVERSITAS MAJALENGKA</font><br>
				<font style="font-size:<?= strlen($detail->nama_fak) <= 20 ? '30pt' : '20pt'; ?>; line-height:30px;font-weight: bold;letter-spacing: 3px"><?= $detail->nama_fak ?></font><br>
				
				<?php
					$prodi = json_decode($this->curl->simple_get(ADD_API.'ref/prodi?kode_fak='.$detail->kode_fak));
					$i = 1;
					foreach ($prodi as $row) {
						?>
							<font style="font-size:15pt; line-height:10px;"><?= $row->nama_prodi ?>
								<?php if ($i <  count($prodi)): ?>
								 - 
								<?php endif; $i++; ?>
							</font>
							<!-- <font style="font-size:11pt; line-height:10px;">Program Studi <?= $row->nama_prodi ?> Ter-Akreditasi "<?=$row->akreditasi?>" SK Nomor: <?=$row->sk_akreditasi?></font><br> -->
						<?php
					}
				?>
				
				<br>
				<font style="line-height:1.2em; font-size: 10pt;font-weight: bold">
				Sekretariat : <?= $detail->alamat ?>
				 </font>
			</center>
		</td>
	</tr>
</table>

<div style="width: 100%;height: 2px;background-color: #000; margin-bottom: 1px;"></div>
<div style="width: 100%;height: 4px;background-color: #000"></div>

<br>