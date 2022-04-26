<!DOCTYPE html>
<html>
    <head>
        <title>Kartu Studi Mahasiswa</title>
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
        </style>
    </head>
    <body>
        <img src="<?= base_url('assets/logo/logo.png') ?>" style="width: 60px; float: left; margin-left: 100px;" >
        <p align="center">
            <b class="judul">UNIVERSITAS MAJALENGKA</b> <br> 
            <b class="judul"><?= $mhs->nama_fak ?></b> <br>
            <small>Jl. KH. Abdul Halim No. 103 Majalengka 45418</small>
        </p>
        <br>
        <div style="border-top: 2px solid black; width: 100%; display: block;">   
        <br> <br>     
        <p align="center">
            <b><u style="font-size: 12pt;">KARTU STUDI MAHASISWA</u></b> <br>
            <small><i>Tahun Akademik <?= smt2nama($id_smt)?></i></small>
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
        <table  class="krs" border="0" cellspacing="0" cellpadding="2" width="100%">
            <thead>
                <tr  style="background-color: #efefef;">
                    <th width="1">No.</th>
                    <th>Nama Kelas Kuliah</th>
                    <th width="1">Waktu</th>
                    <th width="160">Tempat</th>
                    <th width="1">Bobot SKS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $sks = 0;
                foreach ($krs['data'] as $row) {
                $sks = $sks + $row['sks_mk'];
                ?>
                <tr>
                    <td align="center"><?= $no ?>.</td>
                    <td><?= $row['nama_kelas_kuliah'] ?></td>
                    <td align="center"><?= $row['hari_kuliah'] ?> - <?= $row['jam_mulai'] ?></td>
                    <td align="center"><?= $row['nama_gedung'].' (R. '.$row['nama_ruangan'].')' ?></td>
                    <td align="center"><?= $row['sks_mk'] ?></td>
                </tr>
                <?php

                    $no++;
                    }
                ?>
                <tr>
                    <td colspan="4" align="center">Jumlah</td>
                    <td align="center"><?= $sks ?></td>
                </tr>
            </tbody>
        </table>

        <br>
        <table width="100%" border="0" style="position: relative; right : 0;">
            <tr>
                <td align="center">
                    <br><br>

                    Mahasiswa<br><br><br>TTD<br><br>
                    <u><b><?= $mhs->nm_pd ?></b></u><br>
                </td>
                <td align="center">
                    Majalengka, <?= date_indo($validasi['data'][0]['tgl_acc']); ?><br>

                    Dosen Wali<br><br><br>TTD<br><br>
                    <u><b><?= $mhs->nm_sdm ?></b></u><br>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" style="position: relative; right : 0;">
            <tr>
                <td align="center">
                    <br><br>

                    Akademik<br><br>TTD<br><?= date_indo($validasi['data'][0]['tgl_validasi_aka']); ?><br><br>
                    <u><b><?= $validasi['data'][0]['validasi_aka'] ?></b></u><br>
                </td>
                <td align="center">
                    Mengetahui<br><br>

                    Ketua Program Studi<br><br>TTD<br><?= date_indo($validasi['data'][0]['tgl_validasi_prodi']); ?><br><br>
                    <u><b><?= $validasi['data'][0]['validasi_prodi'] ?></b></u><br>
                </td> 
                <td align="center">
                    <br><br>

                    Keuangan<br><br>TTD<br><?= date_indo($validasi['data'][0]['tgl_validasi_keu']); ?><br><br>
                    <u><b><?= $validasi['data'][0]['validasi_keu'] ?></b></u><br>
                </td>
            </tr>
        </table>
       
    </body>
</html>                  