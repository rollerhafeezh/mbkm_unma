<?php
/*----------INISIASI ACTIVE SMT---------------*/

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://data.unma.ac.id/ref/smt?id_smt=active',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$active_smt=json_decode($response)[0]->id_semester;

/*----------INISIASI ACTIVE SMT---------------*/
$hari=array('n/a','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
extract($_GET);

/*----------PRODI---------------*/
if(isset($_GET['prodi'])){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://data.unma.ac.id/datatable/kelas?active_smt='.$active_smt.'&kode_prodi='.$prodi,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);


$kelas=json_decode($response);
/*echo '<pre>';
var_dump($kelas->data);
echo '</pre>';*/
if($kelas->data){
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="https://kampusmerdeka.kemdikbud.go.id/web/assets/img/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <title>Jadwal Kuliah UNMA - MBKM</title>
  </head>
<?php
    echo'<table class="table"><thead><th>Nama Kelas</th><th>Hari, Jam</th></thead><tbody>';
    foreach($kelas->data as $key=>$value){
        if($value->smt!=0 && $value->hari_kuliah!=0){
            
            if($_GET['day']=='today'){
                if($value->hari_kuliah==date("w")){
                    echo'<tr>
                        <td>'.$value->nm_mk.' '.$value->nm_kls.'</td>
                        <td><a href="?mk='.$value->id_kelas_kuliah.'">'.$hari[$value->hari_kuliah].', '.$value->jam_mulai.' s/d '.$value->jam_selesai.'</a></td>
                    </tr>';
                }
            }else{
                echo'<tr>
                    <td>'.$value->nm_mk.' '.$value->nm_kls.'</td>
                    <td><a href="?mk='.$value->id_kelas_kuliah.'">'.$hari[$value->hari_kuliah].', '.$value->jam_mulai.' s/d '.$value->jam_selesai.'</a></td>
                </tr>';
            }
        }
    }
    echo'</tbody></table>';
?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    </body>
</html>
<?php
}else{
    echo 'n/a';
}
/*----------PRODI---------------*/
/*----------MK---------------*/
}else if(isset($_GET['mk'])){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://data.unma.ac.id/simak/kelas_kuliah/?id_kelas_kuliah='.$mk,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);


$matkul=json_decode($response);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://data.unma.ac.id/simak/dosen_kelas_kuliah?id_kelas_kuliah='.$mk,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);


$dosen=json_decode($response);

if($matkul && $matkul[0]->id_smt == $active_smt){
//if($matkul){
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="https://kampusmerdeka.kemdikbud.go.id/web/assets/img/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <title>Detail Kelas Kuliah UNMA - MBKM</title>
  </head>
    <body style="padding:5px">
            <div class="card m-1">
                <h2 class="card-header">Detail Kelas</h2>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-1 font-weight-bold">Nama Mata Kuliah</div>
                        <div class="col-md-9 mb-1"><?=$matkul[0]->kode_mk?> <?=$matkul[0]->nama_kelas?> <a href="https://simakng.unma.ac.id/dhmd/rps/<?=$matkul[0]->id_kelas_kuliah?>" class="badge badge-success">RPS</a></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-1 font-weight-bold">Fakultas - Prodi</div>
                        <div class="col-md-9 mb-1"><?=$matkul[0]->homebase?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-1 font-weight-bold">Semester</div>
                        <div class="col-md-9 mb-1"><?=$matkul[0]->nama_semester?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-1 font-weight-bold">Gedung - Ruang</div>
                        <div class="col-md-9 mb-1"><?=$matkul[0]->nama_gedung?> - <?=$matkul[0]->nama_ruangan?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-1 font-weight-bold">Hari - Jam Kuliah</div>
                        <div class="col-md-9 mb-1"><?=$hari[$matkul[0]->hari_kuliah]?>, <?=$matkul[0]->jam_mulai?> s/d <?=$matkul[0]->jam_selesai?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-1 font-weight-bold">Hari - Jam UTS </div>
                        <div class="col-md-9 mb-1"><?=$matkul[0]->tgl_uts?>, <?=$matkul[0]->jam_mulai_uts?> s/d <?=$matkul[0]->jam_selesai_uts?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-1 font-weight-bold">Hari - Jam UAS</div>
                        <div class="col-md-9 mb-1"><?=$matkul[0]->tgl_uas?>, <?=$matkul[0]->jam_mulai_uas?> s/d <?=$matkul[0]->jam_selesai_uas?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-1 font-weight-bold">Dosen Pengampu</div>
                        <div class="col-md-9 mb-1">
                            <?php
                			//check apakah sudah ada dosen pengampu
                			if(count($dosen)!=0){
                				//jika ada hanya bisa edit yang sudah ada di ajar_dosen
                				//var_dump($dosen);
                				foreach($dosen as $key=>$value){
                					echo $value->nidn.' <strong>'.$value->nm_sdm.'</strong> Beban ('.$value->sks_subst_tot.' SKS)';
                				}
                			}else{
                				//jika belum ada bisa menambahkan
                				echo '- ';
                				
                			}
                		?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-1">
                <h2 class="card-header">Detail Pertemuan</h2>
                <div class="card-body">
<div class="row">

<?php 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://data.unma.ac.id/mbkm/list_pertemuan?id_kelas_kuliah='.$mk,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$list_pertemuan=json_decode($response);
//var_dump($list_pertemuan);
	if($list_pertemuan){
		//$count=1;
		$count=count($list_pertemuan);
		//echo $count;
		foreach($list_pertemuan as $key=>$value)
		{
			$cover=($value->foto != NULL || $value->foto != '')?$value->foto:'https://img.unma.ac.id/image/3amC.jpg';
			$ext   = pathinfo($cover, PATHINFO_EXTENSION);
			$thumb = basename($cover, ".$ext") . '.th.' . $ext;
			
			$jam_mulai=($value->input_jam)?$value->input_jam:'00:00:00';
			$jam_selesai=($value->selesai)?$value->selesai:'00:00:00';
			echo '	
				<div class="col-md-3">
					<div class="card border border-dark">
						<img class="card-img-top" src="https://img.unma.ac.id/images/'.$thumb.'" alt="Card image cap">
						<h3 class="card-header bg-primary text-white">Pertemuan #'.$count.'</h3>
						<div class="card-body">
							<div class="row">
								<div class="col-md-5 font-weight-bold">Hari Tanggal</div>
								<div class="col-md-7">'.$hari[($value->input_hari)?:0].'</div>
							</div>
							<div class="row">
								<div class="col-md-5 font-weight-bold">Jenis Pertemuan</div>
								<div class="col-md-7">'.$value->tipe_kuliah.'</div>
							</div>
							<div class="row">
								<div class="col-md-5 font-weight-bold">Jam Mulai</div>
								<div class="col-md-7">'.$jam_mulai.'</div>
							</div>
							<div class="row">
								<div class="col-md-5 font-weight-bold">Jam Selesai</div>
								<div class="col-md-7">'.$jam_selesai.'</div>
							</div>
							<div class="row">
								<div class="col-md-5 font-weight-bold">Ringkasan</div>
								<div class="col-md-7">'.$value->materi.'</div>
							</div>
							
							<a href="https://simakng.unma.ac.id/meet/kuliah/'.$mk.'/'.$count.'" class="btn btn-primary btn-block mt-2">Detail Pertemuan</a>
						</div>
					</div>
				</div>
					';
			$count--;
		}
	}else{
		echo '<em>belum ada pertemuan</em>';
	}
?>
</div>
                </div>
            </div>
        
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    </body>
</html>
<?php
}else{
    echo 'n/a';
}
/*----------MK---------------*/
/*----------INDEX---------------*/
}else{

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://data.unma.ac.id/ref/prodi',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="https://kampusmerdeka.kemdikbud.go.id/web/assets/img/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <title>Jadwal Kuliah UNMA - MBKM</title>
  </head>
  <body>
    <h1>Jadwal Kuliah Program Studi di Lingkungan Universitas Majalengka</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Program Studi</th>
                <th scope="col">Hari ini</th>
            </tr>
        </thead>
    

<?php
$co=1;
foreach(json_decode($response) as $key=>$value)
{
    if($value->kode_prodi!=0){
    echo'
    <tr>
        <td>'.$co.'</td>
        <td><a href="?prodi='.$value->kode_prodi.'">'.$value->nama_prodi.'</a></td>
        <td><a href="?prodi='.$value->kode_prodi.'&day=today"><i class="bi bi-calendar4-event"></i></a></td>
    </tr>
    ';
    $co++;
    }
}
?>
</tbody>
</table>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

   
  </body>
</html>
<?php 
} 
/*----------INDEX---------------*/
?>