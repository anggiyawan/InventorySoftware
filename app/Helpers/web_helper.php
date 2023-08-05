<?php

/**
 * Helper untuk pengaturan web
 */


if ( !function_exists('TglToDay'))
{
    function TglToDay( $tgl )
	{
		$unix = strtotime($tgl);
		$hari = date("D", $unix); // hasilnya 3 huruf nama hari bahasa inggris
		# supaya harinya menjadi bahasa indonesia maka harus kita ganti/replace
		$hari = str_replace('Sun', 'Minggu', $hari);
		$hari = str_replace('Mon', 'Senin', $hari);
		$hari = str_replace('Tue', 'Selasa', $hari);
		$hari = str_replace('Wed', 'Rabu', $hari);
		$hari = str_replace('Thu', 'Kamis', $hari);
		$hari = str_replace('Fri', 'Jum\'at', $hari);
		$hari = str_replace('Sat', 'Sabtu', $hari);

		return $hari;
	}
}

if ( !function_exists('DateFormatIndo'))
{
	function DateFormatIndo($date) {
		if ( $date != '0000-00-00 00:00:00' AND isset($date)){
			$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
			$tahun = substr($date, 0, 4);
			$bulan = substr($date, 5, 2);
			$tgl = substr($date, 8, 2);
			
			$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " " . $tahun;
			return $result;
		} else {
			// return '0000-00-00 00:00:00';
		}
	}
}

if ( ! function_exists('Datex'))
{
	function datex( $datetime ){
		$datex = date('Y-m-d H:i:s', strtotime( $datetime ));
		// log_message("error", $datex);
		if ( $datex == '1970-01-01 07:00:00' || $datex == '-0001-11-30 00:00:00' ){
			return '0000-00-00';
		} else {
			return date('Y-m-d', strtotime( $datex ));;
		}
	}
}

if ( ! function_exists('convertTime'))
{
	function convertDate( $datetime, $type = 'date' ){
		$datex = date('Y', strtotime( $datetime ));
		log_message("error", $datex);
		if ($datex <= '1970'){
			if ($type == 'date')
			{
				return '0000-00-00';
			} else {
				return '00:00';
			}
		} else {
			if ($type == 'date')
			{
				return date('Y-m-d', strtotime( $datex ));
			} else {
				return date('H:i', strtotime( $datex ));
			}
		}
	}
}

if ( ! function_exists('FormatCurrency'))
{
	function FormatCurrency($angka){
	
	$currency = number_format($angka,2,',','.');
	return $currency;
 
}
}

/* End of file Web_Helper.php */
/* Location: ./app/Helpers/Web_Helper.php */