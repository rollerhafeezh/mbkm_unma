<?php if (count($bimbingan) < 1): ?>
	<div class="text-center font-small-3 text-italic p-1">Kegiatan bimbingan masih kosong.</div>

<?php else: $i = 1;?>
	<?php foreach ($bimbingan as $r_bimbingan): ?>
	<div class="media font-small-3 mb-1 pb-1 mt-1" style="line-height: 1.5; <?= ($i != count($bimbingan)) ? 'border-bottom: 1px solid rgba(0, 0, 0, 0.1);' : ''; ?>">
        <div class="media-body position-relative">
        	<small class="position-absolute timeago" style="right: 0; top: 0" data-toggle="tooltip" title="<?= date_indo(explode(' ', $r_bimbingan->created_at)[0]).' '.explode(' ', $r_bimbingan->created_at)[1] ?>" datetime="<?= $r_bimbingan->created_at ?>"><?= $r_bimbingan->created_at ?></small>
            <p class="text-bold-600 mb-0">
                <a
                    <?php if($r_bimbingan->id_user == $_SESSION['id_user']): ?>
                    onclick="hapus(this)" 
                    data-id_bimbingan="<?= $r_bimbingan->id_bimbingan ?>"
                    data-file="<?= $r_bimbingan->file ?>"
                    <?php endif; ?>
                >
                    <span class="text-info">
                        <?= $r_bimbingan->nama_user ?>
                    </span> 
                    (<?= $r_bimbingan->level_name ?>) 
                    
                    <span class="badge badge-success"><i class="ft-bookmark"></i> <?= $r_bimbingan->nama_kegiatan != '' ? 'Revisi '.$r_bimbingan->nama_kegiatan : 'Bimbingan' ?></span>
                    <span class="badge badge-info <?= $_SESSION['id_user'] == $r_bimbingan->id_user ? 'd-inline-block' : 'd-none' ?>">Saya</span>
                </a>
            </p>
            <p class="m-0"><?= strip_tags(urldecode($r_bimbingan->isi), '<br>') ?></p>

            <?php if ($r_bimbingan->file != ''): ?>
            <a href="<?= $r_bimbingan->file ?>" class="d-block font-small-2 text-center w-100 p-1" style="border: 1px dashed silver; margin-top: 5px;" data-toggle="tooltip" title="<?= $r_bimbingan->file ?>" target="_blank">
                <i class="ft-download"></i> Unduh Berkas
            </a>
            <?php endif; ?>
            
            <?php
            $i++;
			$komentar	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/bimbingan?id_parent='.$r_bimbingan->id_bimbingan)) ?: [];

			// INPUT KOMENTAR
			if (count($komentar) < 1):
            ?>
        	<div class="card-content mt-1 ml-2" bis_skin_checked="1">
                <fieldset class="form-group position-relative has-icon-left mb-0">
                    <input required onkeypress="kirim(this, event)" type="text" class="form-control font-small-3" placeholder="Tulis sesuatu ..." data-id_parent="<?= $r_bimbingan->id_bimbingan ?>" data-id_aktivitas="<?= $aktivitas_mahasiswa[0]->id_aktivitas ?>">
                    <small class="form-help font-small-2">Tekan <b>Enter</b> untuk mengirim.</small>
                    <label class="form-help font-small-2 float-right text-info text-right">
	                    <input type="file" name="file" class="d-none" onchange="lampirkan_dokumen(this)">
	                    <span data-toggle="tooltip" title="Maksimal 5 MB"><i class="ft-paperclip"></i>  Lampirkan Berkas</span>
	                </label>
                    <div class="form-control-position" bis_skin_checked="1">
                        <i class="ft-message-square"></i>
                    </div>
                </fieldset>
            </div>

            <!-- LIST KOMENTAR -->
        	<?php else: ?>
        	<?php foreach ($komentar as $r_komentar): ?>
            <div class="media mt-1" >
                <div class="media-left pr-2" ></div>
                <div class="media-body position-relative" >
        			<small class="position-absolute timeago" style="right: 0; top: 0"  data-toggle="tooltip" title="<?= date_indo(explode(' ', $r_komentar->created_at)[0]).' '.explode(' ', $r_komentar->created_at)[1] ?>"  datetime="<?= $r_komentar->created_at ?>"><?= $r_komentar->created_at ?></small>
                    <p class="text-bold-600 mb-0">
                        <a
                            <?php if($r_komentar->id_user == $_SESSION['id_user']): ?>
                            onclick="hapus(this)" 
                            data-id_bimbingan="<?= $r_komentar->id_bimbingan ?>"
                            data-file="<?= $r_komentar->file ?>"
                            <?php endif; ?>
                        >
                            <span class="text-info">
                                <?= $r_komentar->nama_user ?>
                            </span> 
                            (<?= $r_komentar->level_name ?>) 
                            <span class="badge badge-info <?= $_SESSION['id_user'] == $r_komentar->id_user ? 'd-inline-block' : 'd-none' ?>">Saya</span>
                        </a>
                    </p>
                    <p class="m-0"><?= strip_tags(urldecode($r_komentar->isi), '<br>') ?></p>

                    <?php if ($r_komentar->file != ''): ?>
                    <a href="<?= $r_komentar->file ?>" class="d-block font-small-2 text-center w-100 p-1" style="border: 1px dashed silver; margin-top: 5px;" data-toggle="tooltip" title="<?= $r_komentar->file ?>" target="_blank">
                    	<i class="ft-download"></i> Unduh Berkas
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        	<?php endforeach; ?>

            <div class="card-content mt-1 ml-2" bis_skin_checked="1">
                <fieldset class="form-group position-relative has-icon-left mb-0">
                    <input required onkeypress="kirim(this, event)" type="text" class="form-control font-small-3" placeholder="Tulis sesuatu ..." data-id_parent="<?= $r_bimbingan->id_bimbingan ?>" data-id_aktivitas="<?= $aktivitas_mahasiswa[0]->id_aktivitas ?>">
                    <small class="form-help font-small-2">Tekan <b>Enter</b> untuk mengirim.</small>
                    <label class="form-help font-small-2 float-right text-info text-right">
	                    <input type="file" name="file" class="d-none" onchange="lampirkan_dokumen(this)">
	                    <span data-toggle="tooltip" title="Maksimal 5 MB"><i class="ft-paperclip"></i>  Lampirkan Berkas</span>
	                </label>
                    <div class="form-control-position" bis_skin_checked="1">
                        <i class="ft-message-square"></i>
                    </div>
                </fieldset>
            </div>
        	<?php endif; ?>
        </div>
    </div>
	<?php endforeach; ?>
<?php endif; ?>