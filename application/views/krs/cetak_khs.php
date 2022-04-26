<!DOCTYPE html>
<html>
    <head>
        <title>Kartu Hasil Studi</title>
        <link href="<?php echo base_url();?>themes/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"  media="print" />
        <style>
            body{ font-family: arial, tahoma, verdana; font-size: 10pt !important;}
            table  {border-collapse: collapse;}
            table.krs, table.krs td, table.krs th { border: 1px solid black; }
            table tr th {text-align: center !important; padding: 5px !important;}
            table.table tr td {padding: 10px !important; } 
            h2. h3 { padding: 0px !important; margin: 0px !important; text-align: center; }
            p, hr { padding: 0px !important; margin: 0px !important; }
            .judul { font-size: 13pt !important; }
            hr { border: none; background: none; }
            .coret-merah{ color:red; }
        </style>
    </head>
    <body>
    	<img src="https://simakng.unma.ac.id/assets/logo/logo.png" style="width: 60px; float: left; margin-left: 100px;" >
        <p align="center">
            <b class="judul">UNIVERSITAS MAJALENGKA</b> <br> 
            <b class="judul"><?= $mhs->nama_fak ?></b> <br>
            <small>Jl. KH. Abdul Halim No. 103 Majalengka 45418</small>
        </p>
        <br>
        <div style="border-top: 2px solid black; width: 100%; display: block;">   
		<br>
        <p align="center">
            <b><u style="font-size: 12pt;">KARTU HASIL STUDI </u></b> <br>
            <small><i>Tahun Akademik <?= smt2nama($id_smt) ?></i></small>
        </p>
        <br>
        <table width="100%" style=" text-align: left !important;">
            <tr>
                <td width="80" valign="top">Nama</td>
                <td valign="top">: <?= $mhs->nm_pd ?></td>
                <td valign="top" width="80">Prodi</td>
                <td valign="top">: <?= explode(' - ', $mhs->homebase)[1] ?></td>
            </tr>
            <tr>
                <td valign="top">NPM</td>
                <td valign="top">: <?= $mhs->id_mahasiswa_pt; ?></td>
                
            </tr>
        </table>
        <br>
        <table  class="krs" border="0" cellspacing="0" cellpadding="5" width="100%">
            <thead>
                <tr  style="background-color: #efefef;">
                    <th width="1">No.</th>
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th width="1">SKS</th>
                    <th width="1">Nilai Huruf</th>
                    <th width="1">Indeks</th>
                    <th width="1">SKS x Indeks</th>
				</tr>
            </thead>
            <tbody>
                <?php
					$count=1;
					$total_sks=0;
					$total_bobot=0;
					
					foreach($khs as $key=>$value)
					{
						$bobot=$value->sks_mk*$value->nilai_indeks;
						$total_sks+=$value->sks_mk;
						$kuning=($value->isi_persepsi == 1 || $value->sks_tm == 0)?:'background:orange;';
						$merah=($value->scan_nilai || $value->sks_tm == 0)?:'color:red;';
						$total_bobot+=$bobot;
						echo'
						<tr>
							<td style="'.$merah.' '.$kuning.'">'.$count.'</td>
							<td style="'.$merah.' '.$kuning.'">'.$value->kode_mk.'</td>
							<td style="'.$merah.' '.$kuning.'">'.$value->nm_mk.'<br><i><small>'.(($value->nm_mk_en)?:'-').'</small></i></td>
							<td style="'.$merah.' '.$kuning.'" align="center">'.(($value->isi_persepsi == 1 || $value->sks_tm == 0)?$value->sks_mk:'***').'</td>
							<td style="'.$merah.' '.$kuning.'" align="center">'.(($value->isi_persepsi == 1 || $value->sks_tm == 0)?$value->nilai_huruf:'***').'</td>
							<td style="'.$merah.' '.$kuning.'" align="center">'.(($value->isi_persepsi == 1 || $value->sks_tm == 0)?$value->nilai_indeks:'***').'</td>
							<td style="'.$merah.' '.$kuning.'" align="center">'.(($value->isi_persepsi == 1 || $value->sks_tm == 0)?$bobot:'***').'</td>
						</tr>
						';
						$count++;
					}
				?>
			</tbody>
			<tfoot>
			<tr>
				<th colspan="3">TOTAL</th>
				<th><?=$total_sks?></th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th><?=$total_bobot?></th>
			</tr>
			<tr>
				<th colspan="3">INDEKS PRESTASI SEMESTER = (Jumlah (SKS x Nilai Indeks )) / Jumlah SKS</th>
				<th colspan="4"> <?=$total_bobot?> /  <?=$total_sks?> = <h2><?=number_format(($total_bobot/$total_sks),2,',','.')?></h2></th>
			</tr>
			</tfoot>
        </table>
		<p><i>tanggal cetak : <?=date_indo(date("Y-m-d"))?> <?=date("H:i:s")?> </i></p>
        <em><small><strong>Ket : </strong> <span class="coret-merah">Merah (Nilai Sementara)</span>. Hitam (Nilai Akhir). <span style="color:orange">Orange (Belum Mengisi Survey Persepsi)</span></small></em>
    </body>
</html>

<?php
$catatan=array(
	'id_mahasiswa_pt'	=>$mhs->id_mahasiswa_pt,
	'id_smt'			=>$id_smt,
	'sks_smt'			=>$total_sks
);
//var_dump($catatan);
$url=ADD_API.'simak/kuliah_mahasiswa_patch_sks_smt';
//exec api
$this->curl->simple_put($url,$catatan);
$this->curl->simple_get(ADD_API."dhmd/ips", [ 'id_mahasiswa_pt' => $mhs->id_mahasiswa_pt, 'active_smt' => $id_smt ]);
$this->curl->simple_get(ADD_API."dhmd/ipk", [ 'id_mahasiswa_pt' => $mhs->id_mahasiswa_pt, 'active_smt' => $id_smt ]);
?>