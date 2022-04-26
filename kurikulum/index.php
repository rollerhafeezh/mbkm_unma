<?php
if(isset($_GET['prodi'])){
extract($_GET)    ;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://data.unma.ac.id/simak/kurikulum?kur_aktif=1&kode_prodi='.$prodi,
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


$kurikulum=json_decode($response);
if($kurikulum)
{
//echo $kurikulum[0]->nm_pro;
//jika ada data
//$kurikulum[0]->id_kur;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://data.unma.ac.id/simak/kurikulum_mk_detail/'.$kurikulum[0]->id_kur,
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
$mkkur=json_decode($response);
if($mkkur){
//DETAIL MK
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

    <title>Kurikulum <?=$kurikulum[0]->nm_pro?> - MBKM</title>
  </head>
  <body>
    <h1>Kurikulum Program Studi <?=$kurikulum[0]->nm_pro?> Universitas Majalengka</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode MK</th>
                <th scope="col">Nama MK</th>
                <th scope="col">SKS</th>
                <th scope="col">Semester</th>
            </tr>
        </thead>
    

<?php
$co=1;
foreach($mkkur as $key=>$value)
{
    if($value->smt!=0){
        echo'
        <tr>
            <td>'.$co.'</td>
            <td>'.$value->kode_mk.'</td>
            <td>'.$value->nm_mk.'</td>
            <td>'.$value->sks_mk.'</td>
            <td>'.$value->smt.'</td>
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
    
}else{
    echo 'n/a';
}   
}else{
    echo 'n/a';
}

}else{
//MAIN INDEX

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://data.unma.ac.id/simak/kurikulum?kur_aktif=1',
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

    <title>Kurikulum UNMA - MBKM</title>
  </head>
  <body>
    <h1>Kurikulum Program Studi di Lingkungan Universitas Majalengka</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Fakultas</th>
                <th scope="col">Program Studi</th>
                <th scope="col">Nama Kurikulum</th>
            </tr>
        </thead>
    

<?php
$co=1;
foreach(json_decode($response) as $key=>$value)
{
    echo'
    <tr>
        <td>'.$co.'</td>
        <td>'.$value->nm_fak.'</td>
        <td><a href="?prodi='.$value->kode_prodi.'">'.$value->nm_pro.'</a></td>
        <td>'.$value->nm_kurikulum_sp.'</td>
    </tr>
    ';
    $co++;
}
?>
</tbody>
</table>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

   
  </body>
</html>
<?php } ?>