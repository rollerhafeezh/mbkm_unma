<?php

if(!function_exists('sendsms')) {
  function sendsms($no_hp, $pesan) {
    $textmessage = urlencode($pesan);
    $url = 'http://api.nusasms.com/api/v3/sendsms/plain?user=nununurdiana_api&password=3C0W4sd&SMSText='.$textmessage.'&GSM='.$no_hp;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); $output = curl_exec($ch);
    curl_close($ch);
    //if(!$output){ $output = file_get_contents($smsgatewaydata); }
    //if($return == '1'){ return $output; }else{ echo "Sent"; }
    return true;

  }
}

if(!function_exists('rupiah')) {
  function rupiah($angka){
    $hasil_rupiah = number_format($angka,0,',','.');
    return $hasil_rupiah;
 }
}

if(!function_exists('nilai_mutu')) {
  function nilai_mutu($nilai){
    if ($nilai >= 80) {
        $nilai_mutu = 'A';
    } elseif ($nilai >= 70 AND $nilai < 80) {
        $nilai_mutu = 'B';
    } elseif ($nilai >= 50 AND $nilai < 70) {
        $nilai_mutu = 'C';
    } elseif ($nilai < 50) {
        $nilai_mutu = 'D';
    }  

    return $nilai_mutu;
 }
}


if(!function_exists('baku')) {

  function baku($value) {

    return ucwords(strtolower($value));

  }

}

if(!function_exists('smt2nama2')) {

	function smt2nama2($value)
	{
		$thn_aka=substr($value,0,4);
		$thn_akademik=$thn_aka.'/'.($thn_aka+1);
		
		//untuk keterangan tagihan
		$smt=str_split($value);
		if($smt[4]==1){
			$smt_akademik='Ganjil';
		}elseif($smt[4]==2){
			$smt_akademik='Genap';
		}else{
			$smt_akademik='Pendek';
		}
		
		return $thn_akademik.' '.$smt_akademik;
	}

}

if(!function_exists('smt2nama')) {

	function smt2nama($value)
	{
		$thn_aka=substr($value,0,4);
		$thn_akademik=$thn_aka.'/'.($thn_aka+1);
		
		//untuk keterangan tagihan
		$smt=str_split($value);
		if($smt[4]==1){
			$smt_akademik='Ganjil';
		}elseif($smt[4]==2){
			$smt_akademik='Genap';
		}else{
			$smt_akademik='Pendek';
		}
		
		echo $thn_akademik.' '.$smt_akademik;
	}

}

if(!function_exists('konversi_hari')) {



	function konversi_hari($id_hari)

	{

		$arr_hari = ['Minggu','Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu','Minggu'];

		return $arr_hari[$id_hari];

	}

}



if ( ! function_exists('date_indo'))
{
    function date_indo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun;
    }
}

if ( ! function_exists('bulan'))
{
    function bulan($bln)
    {
        switch ($bln)
        {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

//Format Shortdate
if ( ! function_exists('shortdate_indo'))
{
    function shortdate_indo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[2];
        $bulan = short_bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.'/'.$bulan.'/'.$tahun;
    }
}
  
if ( ! function_exists('short_bulan'))
{
    function short_bulan($bln)
    {
        switch ($bln)
        {
            case 1:
                return "01";
                break;
            case 2:
                return "02";
                break;
            case 3:
                return "03";
                break;
            case 4:
                return "04";
                break;
            case 5:
                return "05";
                break;
           case 6:
                return "06";
                break;
            case 7:
                return "07";
                break;
            case 8:
                return "08";
                break;
            case 9:
                return "09";
                break;
            case 10:
                return "10";
                break;
            case 11:
                return "11";
                break;
            case 12:
                return "12";
                break;
        }
    }
}

//Format Medium date
if ( ! function_exists('mediumdate_indo'))
{
    function mediumdate_indo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[2];
        $bulan = medium_bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.'-'.$bulan.'-'.$tahun;
    }
}
  
if ( ! function_exists('medium_bulan'))
{
    function medium_bulan($bln)
    {
        switch ($bln)
        {
            case 1:
                return "Jan";
                break;
            case 2:
                return "Feb";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Apr";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Ags";
                break;
            case 9:
                return "Sep";
                break;
            case 10:
                return "Okt";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Des";
                break;
        }
    }
}


//Long date indo Format
if ( ! function_exists('longdate_indo'))
{
    function longdate_indo($tanggal)
    {
        $ubah = gmdate($tanggal, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];
        $bulan = bulan($pecah[1]);
  
        $nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
        $nama_hari = "";
        if($nama=="Sunday") {$nama_hari="Minggu";}
        else if($nama=="Monday") {$nama_hari="Senin";}
        else if($nama=="Tuesday") {$nama_hari="Selasa";}
        else if($nama=="Wednesday") {$nama_hari="Rabu";}
        else if($nama=="Thursday") {$nama_hari="Kamis";}
        else if($nama=="Friday") {$nama_hari="Jumat";}
        else if($nama=="Saturday") {$nama_hari="Sabtu";}
        return $nama_hari.','.$tgl.' '.$bulan.' '.$thn;
    }
}

if ( ! function_exists('nama_filez'))
{
    function nama_filez($jenis_file)
    {
	   switch($jenis_file)
        {
    		default : return "n/a"; break;
    		case 1 :
    		return "Pas Foto PMB"; break;
    		case 2 :
    		return "Foto KTP"; break;
    		case 3 :
    		return "Kartu Keluarga"; break;
    		case 4 :
    		return "Ijazah Terakhir Mahasiswa / Surat Keterangan Lulus"; break;
    		case 5 :
    		return "Transkip Nilai Mahasiswa Pindahan / Alih Jenjang"; break;
    		case 6 :
    		return "Surat Keterangan Berkelakuan Baik dari Kepolisian"; break;
    		case 7 :
    		return "Surat Keterangan Sehat dari Dokter"; break;
    		case 8 :
    		return "Surat Keterangan Pindah"; break;
    		case 9 :
    		return "Surat Rekomendasi Mutasi"; break;
    		case 10 :
    		return "File Pendukung Keluar Mahasiswa"; break;
    		case 11 :
    		return "File Persetujuan Tugas Mengajar Dosen"; break;
    		case 18 :
    		return "Pas Foto"; break;
    		case 19 :
    		return "KTP"; break;
    		case 20 :
    		return "Kartu Keluarga"; break;
    		case 21 :
    		return "Ijazah Terakhir"; break;
    		case 22 :
    		return "Avatar"; break;
    	}
    }
}

if ( ! function_exists('time_elapsed_string'))
{
    function time_elapsed_string($datetime, $full = false) {
    	$now = new DateTime;
    	$ago = new DateTime($datetime);
    	$diff = $now->diff($ago);
    		$diff->w = floor($diff->d / 7);
    	$diff->d -= $diff->w * 7;
    		$string = array(
    		'y' => 'tahun',
    		'm' => 'bulan',
    		'w' => 'minggu',
    		'd' => 'hari',
    		'h' => 'jam',
    		'i' => 'menit',
    		's' => 'detik',
    	);
    	foreach ($string as $k => &$v) {
    		if ($diff->$k) {
    			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
    		} else {
    			unset($string[$k]);
    		}
    	}
    		if (!$full) $string = array_slice($string, 0, 1);
    	return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
    }
}

function bulan_romawi($bulan){
    switch ($bulan){
        case '01':
            return "I";
            break;
        case '02':
            return "II";
            break;
        case '03':
            return "III";
            break;
        case '04':
            return "IV";
            break;
        case '05':
            return "V";
            break;
        case '06':
            return "VI";
            break;
        case '07':
            return "VII";
            break;
        case '08':
            return "VIII";
            break;
        case '09':
            return "IX";
            break;
        case '10':
            return "X";
            break;
        case '11':
            return "XI";
            break;
        case '12':
            return "XII";
            break;
    }
}

function acronym($string) {
    $words = explode(" ", $string);
    $acronym = "";

    foreach ($words as $w) {
      $acronym .= $w[0];
    }

    return $acronym;
}