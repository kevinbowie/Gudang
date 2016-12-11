<?
function InfoCDBackup($userlogin, $tanggal){
	$retvalue = true; //belum diinput penerimaan CD Backup
	$conn=bukaDatabase();
	//format tanggal YYYY-MM-DD => YYYYMM-1
	//$lastmonth = date("Ym", strtotime('-1 month', strtotime($tanggal)));
	//$lastmonth = date("Ym", strtotime('-31 days', strtotime($tanggal)));
	$lastmonth = date("Ym", mktime(0, 0, 0, date("m", strtotime($tanggal))-1, 1, date("Y", strtotime($tanggal))));
	//echo $lastmonth . " <br>";
	if($conn){
		$ssql = "Select kode From mst_unit_usaha where kode_portal = '$userlogin' ;" ;
		if ($rs = mysql_query($ssql)){
			$total = mysql_num_rows($rs); //2 record
			//echo $total . " <br>";
			if ($rec = mysql_fetch_array($rs))
			{
				$jumlah = 0;
				do	
				{
					$kode = $rec['kode'];
					$ssqlCek = "Select count(*) from trn_terima_cd_backup where periode_cd = '$lastmonth' and kode = '$kode' ;";
					//echo $ssqlCek . " <br>";
					$rsCek = mysql_query($ssqlCek);
					$rowCek = mysql_fetch_row($rsCek);
					if ($rowCek[0] > 0){
						$jumlah = $jumlah + 1; //dilooping jumlah
					}
				}
				while ($rec = mysql_fetch_array($rs));
			}
			//echo $jumlah . " <br>";
			if ($total == $jumlah) {
				$retvalue = false; //sudah diinput penerimaan CD Backup
			}
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

/*function KirimCDBackup($userlogin, $tanggal){
	$retvalue = true; //belum diinput penerimaan CD Backup
	$conn=bukaDatabase();
	//format tanggal YYYY-MM-DD => YYYYMM-1
	$tgl = gmdate("d",strtotime("+7 hour"));
	if ($tgl > 15) {
		$lastmonth = date("Ym", strtotime('-1 month', strtotime($tanggal)));
		//echo $lastmonth . " <br>";
		if($conn){
			$ssql = "Select kode From mst_unit_usaha where kode_portal = '$userlogin' ;" ;
			if ($rs = mysql_query($ssql)){
				$total = mysql_num_rows($rs); //2 record
				//echo $total . " <br>";
				if ($rec = mysql_fetch_array($rs))
				{
					$jumlah = 0;
					do	
					{
						$kode = $rec['kode'];
						$ssqlCek = "Select count(*) from trn_terima_cd_backup where periode_cd = '$lastmonth' and kode = '$kode' ;";
						//echo $ssqlCek . " <br>";
						$rsCek = mysql_query($ssqlCek);
						$rowCek = mysql_fetch_row($rsCek);
						if ($rowCek[0] > 0){
							$jumlah = $jumlah + 1; //dilooping jumlah
						}
					}
					while ($rec = mysql_fetch_array($rs));
				}
				//echo $jumlah . " <br>";
				if ($total == $jumlah) {
					$retvalue = false; //sudah diinput penerimaan CD Backup
				}
			}
			tutupDatabase($conn);
		}
	} else {
		$retvalue = false; //belum lewat tanggal 15
	}
	return $retvalue;
}*/

function UploadFileHDSB($kodept, $tanggal){
	$retvalue = true; //belum upload file HDSB
	if ($kodept == "RRO" || $kodept == "KRO") {
		$retvalue = false; //Lokasi RRO dan KRO tidak perlu cek Upload File HDSB
	} else {
		$conn=bukaDatabase();
		//format tanggal YYYY-MM-DD => YYYYMM-1
		$tgl = date("d",strtotime($tanggal));
		$bulan = date("m",strtotime($tanggal));
		$tahun = date("Y",strtotime($tanggal));
		$hari_tgl = date("w",strtotime($tanggal));
		if ($tgl > 5) {
			if (($hari_tgl != 0 && $hari_tgl != 6)) //kalau bukan sabtu dan minggu cek apakah sudah upload file HDSB atau belum
			{
				if($conn){
					$ssqlCek = "SELECT count(*) FROM trn_catatan_upload " .
							"WHERE DAY(TglUpload) = '$tgl' and MONTH(TglUpload) = '$bulan' and YEAR(TglUpload) = '$tahun' and Jenis = 'HDSB' " .
							"and kode = '$kodept' ;";
					//echo $ssqlCek . " <br>";
					//echo $kodept . " kode <br>";
					//echo $tanggal . " tanggal <br>";
					//echo $jlhunit . " unit <br>";
					$rsCek = mysql_query($ssqlCek);
					$rowCek = mysql_fetch_row($rsCek);
					if ($rowCek[0] > 0){
						$retvalue = false; //sudah upload file HDSB
					}
				}
				tutupDatabase($conn);
			}
			else
			{
				$retvalue = false; //tidak termasuk hari sabtu dan minggu
			}
		} else {
			$retvalue = false; //belum lewat tanggal 5
		}
	}
	return $retvalue;
}

function UploadUnitHDSB($kodept, $tanggal, $jlhunit){
	$retvalue = true; //belum upload file HDSB
	if ($kodept == "RRO" || $kodept == "KRO") {
		$retvalue = false; //Lokasi RRO dan KRO tidak perlu cek Unit HDSB
	} else {
		$conn=bukaDatabase();
		//format tanggal YYYY-MM-DD => YYYYMM-1
		$tgl = date("d",strtotime($tanggal));
		$hari_tgl = date("w",strtotime($tanggal));
		//if ($tgl > 5) {
			if (($hari_tgl != 0 && $hari_tgl != 6)) //kalau bukan sabtu dan minggu cek apakah sudah upload file HDSB atau belum
			{
				if($conn){
					$ssqlCek = "Select count(*) from trn_hdsb where kode_cabang = '$kodept' and tglfaktur = '$tanggal' ;";
					//echo $ssqlCek . " <br>";
					//echo $kodept . " kode <br>";
					//echo $tanggal . " tanggal <br>";
					//echo $jlhunit . " unit <br>";
					$rsCek = mysql_query($ssqlCek);
					$rowCek = mysql_fetch_row($rsCek);
					if ($rowCek[0] == $jlhunit){
						$retvalue = false; //sudah upload HDSB dan cocok dengan jumlah unit harian tutup LHPBK
					}
				}
				tutupDatabase($conn);
			}
			else
			{
				$retvalue = false; //tidak termasuk hari sabtu dan minggu
			}
		//} else {
		//$retvalue = false; //belum lewat tanggal 5
		//}
	}
	return $retvalue;
}

function UploadFileACC($kodept, $tanggal, $jlhunitkds){
	$retvalue = true; //belum upload file ACC
	if ($kodept == "RRO" || $kodept == "KRO") {
		$retvalue = false; //Lokasi RRO dan KRO tidak perlu cek Unit ACC
	} else {
		//$conn=bukaDatabase();
		$conn_bohdar_acc=bukaDatabase_bohdar_acc();
		//format tanggal YYYY-MM-DD => YYYYMM-1
		//$tgl = date("d",strtotime($tanggal));
		//$hari_tgl = date("w",strtotime($tanggal));		
		//if (($hari_tgl != 0 && $hari_tgl != 6)) //kalau bukan sabtu dan minggu cek apakah sudah upload file ACC atau belum
		//{
			if($conn_bohdar_acc){
				$ssqlCek = "Select count(*) from H1_CDN_KONTRAK where KODE_CABANG = '$kodept' and TGLKONTRAK = '$tanggal' and STATUS <> 'C' ;";
				//echo $ssqlCek . " <br>";
				//echo $kodept . " kode <br>";
				//echo $tanggal . " tanggal <br>";
				//echo $jlhunit . " unit <br>";
				$rsCek = mysql_query($ssqlCek);
				$rowCek = mysql_fetch_row($rsCek);
				if ($rowCek[0] == $jlhunitkds){
					$retvalue = false; //sudah upload ACC dan cocok dengan jumlah unit KDS harian tutup LHPBK
				}
			}
			tutupDatabase($conn_bohdar_acc);
		//}
		//else
		//{
		//	$retvalue = false; //tidak termasuk hari sabtu dan minggu
		//}
	}
	return $retvalue;
}

function LapPICAKDS($kodept, $tanggal){
	$retvalue = true; //belum upload file PICA Overdue KDS
	if ($kodept == "RRO" || $kodept == "KRO") {
		$retvalue = false; //Lokasi RRO dan KRO tidak perlu cek PICA Overdue KDS
	} else {
		$conn=bukaDatabase();
		//format tanggal YYYY-MM-DD => YYYYMM-1
		$tgl = date("d",strtotime($tanggal));
		$hari_tgl = date("w",strtotime($tanggal));
		if ($tgl > 5) {
			if (($hari_tgl != 0 && $hari_tgl != 6)) //kalau bukan sabtu dan minggu cek apakah sudah upload file PICA Overdue KDS atau belum
			{
				//echo $tanggal . " <br>";
				//$lastmonth = date("Ym", strtotime('-31 days', strtotime($tanggal)));
				$lastmonth = date("Ym", mktime(0, 0, 0, date("m", strtotime($tanggal))-1, 1, date("Y", strtotime($tanggal))));
				//echo $lastmonth . " <br>";
				if($conn){
					$ssqlCek = "Select count(*) from trn_overdue where periode = '$lastmonth' and kode_cabang = '$kodept' ;";
					//echo $ssqlCek . " <br>";
					$rsCek = mysql_query($ssqlCek);
					$rowCek = mysql_fetch_row($rsCek);
					if ($rowCek[0] > 0){
						$retvalue = false; //sudah upload PICA Overdue KDS
					}
				}
				tutupDatabase($conn);
			}
			else
			{
				$retvalue = false; //tidak termasuk hari sabtu dan minggu
			}
		} else {
			$retvalue = false; //belum lewat tanggal 5
		}
	}
	return $retvalue;
}

function KirimCDBackup($userlogin, $tanggal){
	$retvalue = true; //belum diinput penerimaan CD Backup
	if ($userlogin == "RRO" || $userlogin == "KRO") {
		$retvalue = false; //Lokasi RRO dan KRO tidak perlu cek Kirim CD Backup
	} else {
		$conn=bukaDatabase();
		//format tanggal YYYY-MM-DD => YYYYMM-1
		$tgl = date("d",strtotime($tanggal));
		$hari_tgl = date("w",strtotime($tanggal));
		if ($tgl > 20) {
			if (($hari_tgl != 0 && $hari_tgl != 6)) //kalau bukan sabtu dan minggu cek apakah sudah terima cd backup atau belum
			{
				//echo $tanggal . " <br>";
				//$lastmonth = date("Ym", strtotime('-31 days', strtotime($tanggal)));
				$lastmonth = date("Ym", mktime(0, 0, 0, date("m", strtotime($tanggal))-1, 1, date("Y", strtotime($tanggal))));
				//echo $lastmonth . " <br>";
				if($conn){
					$ssql = "Select kode From mst_unit_usaha where kode_portal = '$userlogin' ;" ;
					if ($rs = mysql_query($ssql)){
						$total = mysql_num_rows($rs); //2 record
						//echo $total . " <br>";
						if ($rec = mysql_fetch_array($rs))
						{
							$jumlah = 0;
							do	
							{
								$kode = $rec['kode'];
								$ssqlCek = "Select count(*) from trn_terima_cd_backup where periode_cd = '$lastmonth' and kode = '$kode' ;";
								//echo $ssqlCek . " <br>";
								$rsCek = mysql_query($ssqlCek);
								$rowCek = mysql_fetch_row($rsCek);
								if ($rowCek[0] > 0){
									$jumlah = $jumlah + 1; //dilooping jumlah
								}
							}
							while ($rec = mysql_fetch_array($rs));
						}
						//echo $jumlah . " <br>";
						if ($total == $jumlah) {
							$retvalue = false; //sudah diinput penerimaan CD Backup
						}
					}
					tutupDatabase($conn);
				}
			}
			else
			{
				$retvalue = false;
			}
		} else {
			$retvalue = false; //belum lewat tanggal 15
		}
	}
	return $retvalue;
}

function CekVersiBOHDAR($token, $kodept) {
	if ($kodept == "RRO" || $kodept == "KRO") { 
		$retvalue = false; //khusus rro dan kro diabaikan
	} else {
		$retvalue = true;
		//$token = SOSGL1601041601051630102104B8295
		$cek = substr($token, -9);
		//$cek = 2104B8295
		$versibohdartoken = substr($cek, 0, 3);
		//$versibohdartoken = 210
		if ($versibohdartoken == 217) {
			$retvalue = false; //sudah update ke versi bohdar terbaru
		}
		
		return $retvalue;
	}
}

function CekTokenTutupHarian($token, $tgltutup, $kodept, $jlhunit, $token1, $jlhunitkredit, $jlhunitkds, $jlhunitcmd, &$unitlog){
	if ($kodept == "RRO" || $kodept == "KRO") { 
		$retvalue = false;
	} else {
		$retvalue = true; //default token tutup harian tidak valid
		//SOSGL (kodept) 160104 (tgllpk) 1601051630 (tgltutupharian) 10 (penjualan unit) 210 (versi bohdar) ABCDEF (passkey)
		//$totalkarakter = strlen($token);
		//echo $kodept . " <br>";
		/*if ($kodept == "POSTBH") {
			$potong = 6;
			$cut = $totalkarakter - 31; //POSTBH1601041601051630102104B8295
			$ambiljlhunit = substr($token, 22, $cut);
		} else {
			$potong = 5;
			$cut = $totalkarakter - 30; //SOSGL1601041601051630102104B8295
			$ambiljlhunit = substr($token, 21, $cut);
			//SODRI1601111601111839 17 21074D005
		}	*/	
		$kode0 = substr($token,0,-6);
		$passkey = substr($token,-6);
		$kode1 = strtoupper(substr(md5($kode0 . "SUPPORT2015"), 0, 6));
		$periode_unit = preg_replace("/[^0-9]/", "", substr($token, 0, -9));
		$tgllpk = substr($periode_unit,0,6);
		$tgltutup = date('ymd', strtotime($tgltutup));
		$ambiljlhunit = substr($periode_unit,16);
		
		//Log Tutup Harian 2
		// 1
		$jlhunitkredit = str_pad($jlhunitkredit, 4, "0", STR_PAD_LEFT);
		// 2
		$jlhunitkds = str_pad($jlhunitkds, 4, "0", STR_PAD_LEFT);
		// 3
		$jlhunitcmd = str_pad($jlhunitcmd, 4, "0", STR_PAD_LEFT);
		//Token 1 // 000100020003D1FC10
		$passkey1 = substr($token1, -6); //D1FC10
		//Penambahan KodePT dan TglLPK untuk log token tutup harian 2 LHPBK
		//21 April 2016 (Update Tgl 17 Mei 2016)
		//if (strlen($token1) > 18) {
		$kode2 = $kodept . $tgllpk . $jlhunitkredit . $jlhunitkds . $jlhunitcmd;
		//} else {
		//	$kode2 = $jlhunitkredit . $jlhunitkds . $jlhunitcmd;
		//}
		$kode3 = strtoupper(substr(md5($kode2 . "ITCDN2015"), 0, 6));
		//$jlhkarakter = strlen($token) - 6;
		//$kode0 = substr($token, 0, $jlhkarakter);
		//$passkey = substr($token, -6);
		//$kode1 = strtoupper(substr(md5($kode0 . "SUPPORT2015"), 0, 6));
		//$tgllpk = substr($token, $potong, 6);
		if ($passkey1 == $kode3) {
			if ($passkey == $kode1) {
				if (($ambiljlhunit == $jlhunit) && !UploadUnitHDSB($kodept, $tgltutup, $jlhunit) && !UploadUnitHDSB($kodept, $tgltutup, $ambiljlhunit)) {
					if ($tgllpk == $tgltutup) {
						$retvalue = false; //cocok tgllpk dengan tgltutup, cocok passkey token dengan kode1 (validasi), cocok jlhunit bohdar dan input portal
					}
				}
			} 
		}
		//echo $token . " <br>";
		//echo strlen($token) . " <br>";
		//echo $jlhkarakter . " <br>";
		//echo $kode0 . " <br>";
		//echo $passkey . " <br>";
		//echo $kode1 . " <br>";
		//echo "TglLPKBOHDAR " . $tgllpk . " <br>";
		//echo "TglTutupPortal " .$tgltutup . " <br>";
		//echo $totalkarakter . " <br>";
		//echo "JlhUnitToken " . $ambiljlhunit . " <br>";
		//echo "JlhUnitInput " . $jlhunit . " <br>";
		$unitlog = $ambiljlhunit;
		return $retvalue;
	}
}

function NotValidRincianSaldoBank($kd_relasi, $tanggal){
	$retvalue = true; //belum diinput rincian saldo bank
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi Where kd_relasi = '$kd_relasi' and tanggal = '$tanggal' and id_acc like '310%' ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = false; //sudah diinput rincian saldo bank
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function AmbilKodeDept($kodept){
	$retvalue = "";
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*), kd_dept From mst_operator Where KodePT = '$kodept' group by kd_dept ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = $row[1]; 
		}
		//tutupDatabase($conn);
	}
	return $retvalue;
}

function CekGiro($kdcabang, $saldogiro){
	$retvalue = true;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "SELECT SUM(A.nominal) as jumlah " .
				"FROM trn_kas_giro A " .
				"where A.kdcabang = '$kdcabang' and A.status = 0 ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			if ($row[0] == $saldogiro) {
				$retvalue = false;
			}
		}
		//tutupDatabase($conn);
	}
	return $retvalue;
}

function AmbilUpdatePeriodeTerbaru($kodept){
	$retvalue = "";
	$conn=bukaDatabase();
	if($conn){
		$ssql = "SELECT Max(periode) FROM trn_overdue Where Kode_cabang = '$kodept' ";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = $row[0]; 
		}
		//tutupDatabase($conn);
	}
	return $retvalue;
}

function ValidSaldoAkhirKasBank($kd_relasi, $saldobank, $saldokastunai, $saldokasgiromundur){
	$retvalue = false;
	$conn = bukaDatabase();
	$cabang = $kd_relasi;
	$ssql2 = "SELECT max(date(tanggal)) as tanggal FROM trn_kasbank WHERE kd_relasi = '$cabang' ;";
	//echo $ssql2;
	if ($rs2 = mysql_query($ssql2)){
	if ($rec2 = mysql_fetch_array($rs2)){
		do	
		{
		$tanggalmax = $rec2['tanggal']; //24
		
		//$bulan = right($tanggalmax,5,2);
		//2015-10-26
		//$bulan = substr($tanggalmax,5,2);
		//$tanggal = substr($tanggalmax,8,2);
		//$tahun = substr($tanggalmax,0,4);

		//$tanggalnow = date("Y-m-d",mktime(0,0,0,$bulan,$tanggal+1,$tahun)); //25
		$tanggalnow = date("Y-m-d", strtotime("+1 day", strtotime($tanggalmax))); //25
		//$tanggallalu = date("Y-m-d",mktime(0,0,0,$bulan,$tanggal-1,$tahun));
		}
		while ($rec2 = mysql_fetch_array($rs2));
		}
	}
	//25
	$ssql = "SELECT sum(a.nilai) as saldo, b.tipe, b.jenis
				FROM trn_transaksi a
				INNER JOIN mst_account b on a.id_acc = b.id_acc
				WHERE a.tanggal = '$tanggalnow' AND a.kd_relasi = '$cabang'
				GROUP BY b.tipe, b.jenis
				ORDER BY b.tipe, b.jenis ;";
	$i = 0;
	//24
	$ssql1 = "SELECT saldo_bank, saldo_kas_tunai, saldo_kas_giro_mundur
			FROM trn_kasbank WHERE tanggal = '$tanggalmax' AND kd_relasi = '$cabang' ;";
	$j = 0;
	//echo $ssql;
	//echo $ssql1;
	
	$tipe = "";
	$jenis = "";
	$saldo = 0;
	
	$saldo_akhir_bank = 0;
	$saldo_akhir_kas_tunai = 0;
	$saldo_akhir_kas_giro = 0;
	
	if ($rs = mysql_query($ssql)){
	if ($rec = mysql_fetch_array($rs)){
		do	
		{		
		$tipe = $rec['tipe'];
		$jenis = $rec['jenis'];
		$saldo = $rec['saldo'];
		
		if ($tipe == "KB") {
			if ($jenis == 1) {
				//Penerimaan
				$saldo_akhir_bank = $saldo_akhir_bank + $saldo;
			} else {
				//Pengeluaran
				$saldo_akhir_bank = $saldo_akhir_bank - $saldo;
			}
		} else if ($tipe == "KT") {
			if ($jenis == 1) {
				//Penerimaan
				$saldo_akhir_kas_tunai = $saldo_akhir_kas_tunai + $saldo;
			} else {
				//Pengeluaran
				$saldo_akhir_kas_tunai = $saldo_akhir_kas_tunai - $saldo;
			}
		} else if ($tipe == "KG") {
			if ($jenis == 1) {
				//Penerimaan
				$saldo_akhir_kas_giro = $saldo_akhir_kas_giro + $saldo;
			} else {
				//Pengeluaran
				$saldo_akhir_kas_giro = $saldo_akhir_kas_giro - $saldo;
			}
		}
		$i++;
		}
		while ($rec = mysql_fetch_array($rs));
		}
	}
	
	if ($rs1 = mysql_query($ssql1)){
	if ($rec1 = mysql_fetch_array($rs1)){
		do	
		{
		$saldo_bank = $rec1['saldo_bank'];
		$saldo_kas_tunai = $rec1['saldo_kas_tunai'];
		$saldo_kas_giro_mundur = $rec1['saldo_kas_giro_mundur'];
		$j++;
		}
		while ($rec1 = mysql_fetch_array($rs1));
		}
	}
	
	tutupDatabase($conn);
	$saldo_akhir_bank = $saldo_akhir_bank + $saldo_bank;
	$saldo_akhir_kas_tunai = $saldo_akhir_kas_tunai + $saldo_kas_tunai;
	$saldo_akhir_kas_giro = $saldo_akhir_kas_giro + $saldo_kas_giro_mundur;
	
	if ($saldo_akhir_bank != $saldobank) {
		$retvalue = true;
	}
	if ($saldo_akhir_kas_tunai != $saldokastunai) {
		$retvalue = true;
	}
	if ($saldo_akhir_kas_giro != $saldokasgiromundur) {
		$retvalue = true;
	}
	return $retvalue;
}

function ValidSaldoAkhirKasBankCSC($kd_relasi, $saldobank, $saldokastunai, $saldokasgiromundur){
	$retvalue = false;
	$conn = bukaDatabase();
	$cabang = $kd_relasi;
	$ssql2 = "SELECT max(date(tanggal)) as tanggal FROM trn_kasbank_csc WHERE kd_relasi = '$cabang' ;";
	//echo $ssql2;
	if ($rs2 = mysql_query($ssql2)){
	if ($rec2 = mysql_fetch_array($rs2)){
		do	
		{
		$tanggalmax = $rec2['tanggal']; //24
		
		//$bulan = right($tanggalmax,5,2);
		//2015-10-26
		//$bulan = substr($tanggalmax,5,2);
		//$tanggal = substr($tanggalmax,8,2);
		//$tahun = substr($tanggalmax,0,4);

		//$tanggalnow = date("Y-m-d",mktime(0,0,0,$bulan,$tanggal+1,$tahun)); //25
		$tanggalnow = date("Y-m-d", strtotime("+1 day", strtotime($tanggalmax))); //25
		//$tanggallalu = date("Y-m-d",mktime(0,0,0,$bulan,$tanggal-1,$tahun));
		}
		while ($rec2 = mysql_fetch_array($rs2));
		}
	}
	//25
	$ssql = "SELECT sum(a.nilai) as saldo, b.tipe, b.jenis
				FROM trn_transaksi_csc a
				INNER JOIN mst_account_csc b on a.id_acc = b.id_acc
				WHERE a.tanggal = '$tanggalnow' AND a.kd_relasi = '$cabang'
				GROUP BY b.tipe, b.jenis
				ORDER BY b.tipe, b.jenis ;";
	$i = 0;
	//24
	$ssql1 = "SELECT saldo_bank, saldo_kas_tunai, saldo_kas_giro_mundur
			FROM trn_kasbank_csc WHERE tanggal = '$tanggalmax' AND kd_relasi = '$cabang' ;";
	$j = 0;
	//echo $ssql;
	//echo $ssql1;
	
	$tipe = "";
	$jenis = "";
	$saldo = 0;
	
	$saldo_akhir_bank = 0;
	$saldo_akhir_kas_tunai = 0;
	$saldo_akhir_kas_giro = 0;
	//$saldo_akhir_kas_regular = 0;
	
	if ($rs = mysql_query($ssql)){
	if ($rec = mysql_fetch_array($rs)){
		do	
		{		
		$tipe = $rec['tipe'];
		$jenis = $rec['jenis'];
		$saldo = $rec['saldo'];
		
		if ($tipe == "KB") {
			if ($jenis == 1) {
				//Penerimaan
				$saldo_akhir_bank = $saldo_akhir_bank + $saldo;
			} else {
				//Pengeluaran
				$saldo_akhir_bank = $saldo_akhir_bank - $saldo;
			}
		} else if ($tipe == "KT" || $tipe == "RL") {
			if ($jenis == 1) {
				//Penerimaan
				$saldo_akhir_kas_tunai = $saldo_akhir_kas_tunai + $saldo;
			} else {
				//Pengeluaran
				$saldo_akhir_kas_tunai = $saldo_akhir_kas_tunai - $saldo;
			}
		} else if ($tipe == "KG") {
			if ($jenis == 1) {
				//Penerimaan
				$saldo_akhir_kas_giro = $saldo_akhir_kas_giro + $saldo;
			} else {
				//Pengeluaran
				$saldo_akhir_kas_giro = $saldo_akhir_kas_giro - $saldo;
			}
		}
		$i++;
		}
		while ($rec = mysql_fetch_array($rs));
		}
	}
	
	if ($rs1 = mysql_query($ssql1)){
	if ($rec1 = mysql_fetch_array($rs1)){
		do	
		{
		$saldo_bank = $rec1['saldo_bank'];
		$saldo_kas_tunai = $rec1['saldo_kas_tunai'];
		$saldo_kas_giro_mundur = $rec1['saldo_kas_giro_mundur'];
		$j++;
		}
		while ($rec1 = mysql_fetch_array($rs1));
		}
	}
	
	tutupDatabase($conn);
	$saldo_akhir_bank = $saldo_akhir_bank + $saldo_bank;
	$saldo_akhir_kas_tunai = $saldo_akhir_kas_tunai + $saldo_kas_tunai;
	$saldo_akhir_kas_giro = $saldo_akhir_kas_giro + $saldo_kas_giro_mundur;
	
	if ($saldo_akhir_bank != $saldobank) {
		$retvalue = true;
	}
	if ($saldo_akhir_kas_tunai != $saldokastunai) {
		$retvalue = true;
	}
	if ($saldo_akhir_kas_giro != $saldokasgiromundur) {
		$retvalue = true;
	}
	return $retvalue;
}

function ambilTglPeriodeLast($kdrelasi){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select date(DATE_ADD(tanggal, INTERVAL 1 DAY)) as tanggal " .
				"From trn_kasbank Where kd_relasi  = '$kdrelasi' order by tanggal desc ;";
		//$kdrelasi = SO-SDR
		$rs = mysql_query($ssql);
		if ($rec = mysql_fetch_array($rs)){
			$retvalue = $rec['tanggal'];
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function ambilTglPeriodeLastCSC($kdrelasi){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select date(DATE_ADD(tanggal, INTERVAL 1 DAY)) as tanggal " .
				"From trn_kasbank_csc Where kd_relasi  = '$kdrelasi' order by tanggal desc ;";
		//$kdrelasi = CSCLGS
		$rs = mysql_query($ssql);
		if ($rec = mysql_fetch_array($rs)){
			$retvalue = $rec['tanggal'];
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function ambilDataKDS($kdrelasi, $periode){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select case when targetqtykds is null then 0 * faktor else targetqtykds * faktor end as targetqtykds " .
				"From mst_target_kds " .
				"where kd_relasi = '" . $kdrelasi . "' and periode = '" . $periode . "' ";
		//$kdrelasi = SO-SDR
		//echo $ssql;
		$rs = mysql_query($ssql);
		if ($rec = mysql_fetch_array($rs)){
			if ($rec['targetqtykds'] == 0) {
				$retvalue = "<i>(belum di-set)</i>";
			} else {
				$retvalue = $rec['targetqtykds'];
			}
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function periksaTargetKDS($kd_relasi, $tanggal){
	if (jalanKDS($kd_relasi)==1) {
		$retvalue = 0; //Default target KDS tidak dalam batas toleransi (batas bawah dan batas atas)
		//$kdrelasi = SO-SDR		
		//$tanggal = 2016-03-08
		$last_tanggal = date("Y-m-t", strtotime($tanggal)); //2016-03-31
		$last_tglLPK = date("d", strtotime($last_tanggal)); //hari kerja 31
		$periodeLPK = date("Ym", strtotime($tanggal)); //201603
		$tglLPK = date("d", strtotime($tanggal)); //tgl LPK 08
		//$tgl_awal_bulan_depan = date("Y-m-d", strtotime(date("Y-m-t", strtotime($tanggal)) . " +1 days");
		$periode = "";
		//echo $tglLPK . " <br>";	
		if ($tglLPK >= 8 && $tglLPK <= 14) {
			$periode = $periodeLPK . "A";
			$awaltanggal = date("Y-m", strtotime($tanggal)) . "-01";
			$daritanggal = date("Y-m", strtotime($tanggal)) . "-01";
			$sampaitanggal = date("Y-m-d", strtotime($tanggal . " -1 days")); 
		} else if ($tglLPK >= 16 && $tglLPK <= 22) {
			$periode = $periodeLPK . "B";
			$awaltanggal = date("Y-m", strtotime($tanggal)) . "-01";
			$daritanggal = date("Y-m", strtotime($tanggal)) . "-08";
			$sampaitanggal = date("Y-m-d", strtotime($tanggal . " -1 days"));
		} else if ($tglLPK >= 24 && $tglLPK <= ($last_tglLPK - 1)) {
			$periode = $periodeLPK . "C";
			$awaltanggal = date("Y-m", strtotime($tanggal)) . "-01";
			$daritanggal = date("Y-m", strtotime($tanggal)) . "-16";
			$sampaitanggal = date("Y-m-d", strtotime($tanggal . " -1 days"));
		} else if ($tglLPK >= 01 && $tglLPK <= 06) { //Akhir Bulan 
			$periode = date("Ym", strtotime($periodeLPK . "-1 month")) . "D"; //201604D
			$periodeLPK = date("Ym", strtotime($periode . "-1 month")); //201604
			$awaltanggal = date("Y-m", strtotime($tanggal . "-1 month")) . "-01"; //2016-04-01
			$daritanggal = date("Y-m", strtotime($tanggal . "-1 month")) . "-24"; //2016-04-24
			$sampaitanggal = date("Y-m-t", strtotime($tanggal . "-1 month")); //2016-04-30
		}
		
		$flag = substr($periode, -1);
		$conn=bukaDatabase();
		if ($periode == "") {
			$retvalue = 1; //Masih belum ada periodeTarget KDS yang akan dicek. Bypass
		} else {
			if (belumAdaEvaluasiKDS($kd_relasi, $periode)) {
				//$conn=bukaDatabase();
				$qtykreditsales = ambilQtyKreditSales($awaltanggal, $sampaitanggal, $kd_relasi); //Kumulatif Qty Kredit Sales
				$qtykreditkds = ambilQtyKreditKDS($awaltanggal, $sampaitanggal, $kd_relasi); //Kumulatif Qty KDS
				$realisasi = ambilQtyKreditKDS($daritanggal, $sampaitanggal, $kd_relasi); //Realisasi Qty KDS Per KU
				//$qtykreditcmd = ambilQtyKreditCMD($daritanggal, $sampaitanggal, $kd_relasi);
				$batasbawah = 0;
				$batasatas = 0;
				if($conn){
					$ssql = "Select targetqtykds, targetpersenkds, faktor " .
							"From mst_target_kds Where kd_relasi = '$kd_relasi' and periode = '$periodeLPK' ;";
					//echo $ssql . "<br>";
					$rs = mysql_query($ssql, $conn);
					$row = mysql_fetch_row($rs);
					//echo $row[0] . "<br>";
					//echo $row[1] . "<br>";
					if ($row[0] > 0){
						//Untuk mendapatkan nilai batas bawah dan batas atas penjualan unit KDS
						if ($flag == "D") {
							$batasbawah = ceil($row[0] * $row[2] * 1); //Langsung dikali 1 karena da full day per bulan
						} else {
							$batasbawah = ceil($row[0] * $row[2] * (($tglLPK-1)/$last_tglLPK)); //RoundUp
						}
						$batasatas1 = ceil($batasbawah * (1+0.5)); //50%
						$batasatas2 = ceil($qtykreditsales * ($row[1]/100)); //12% = 12/100
						$batasatas = max($batasatas1, $batasatas2);
					}
					
					if ($qtykreditkds < $batasbawah) {
						$evaluasi = -1; //Melanggar batas bawah
					} else if ($qtykreditkds > $batasatas) {
						$evaluasi = 1; //Melebihi batas atas
					} else {
						$evaluasi = 0; //Dalam Tahap Toleransi
					}
					
					if ($flag == "A") {
						$jto_sohead = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-07 +3 days"));
						$jto_rssfin = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-07 +6 days"));
					} else if ($flag == "B") {
						$jto_sohead = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-15 +3 days"));
						$jto_rssfin = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-15 +6 days"));
					} else if ($flag == "C") {
						$jto_sohead = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-23 +3 days"));
						$jto_rssfin = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-23 +6 days"));
					} else if ($flag == "D") {
						$jto_sohead = date("Y-m-d", strtotime($sampaitanggal . " +3 days")); //Akhir bulan tanggal +3 hari
						$jto_rssfin = date("Y-m-d", strtotime($sampaitanggal . " +6 days")); //Akhir bulan tanggal +6 hari
					}
					
					$ssqlEvaluasi = "insert into trn_evaluasi_kds (kd_relasi, periode, tanggal, batasatas, batasbawah, " .
							"realisasi, kumulatif, evaluasi, duedate_sohead, approve_sohead, duedate_rss, approve_rss, duedate_fin, approve_fin, " .
							"keterangan, status, creaby, creatime) " .
							"values ('$kd_relasi', '$periode', '$tanggal', $batasatas, $batasbawah, $realisasi, $qtykreditkds, $evaluasi, " .
							"'$jto_sohead', null, '$jto_rssfin', null, '$jto_rssfin', null, null, 0, '', now()) ;";
					mysql_query($ssqlEvaluasi, $conn);
					
					tutupDatabase($conn);
				}
				
				if ($flag == "D") {
					if ($qtykreditkds >= $batasbawah && $qtykreditkds <= $batasatas) { //Untuk KU4 cek Qty kredit KDS batas bawah dan batas atas
						$retvalue = 1; //Target KDS dalam batas toleransi (batas bawah dan batas atas)
					}
				} else {
					if ($qtykreditkds >= $batasbawah) { //Cukup cek Qty kredit KDS batas bawah (KU1, 2, 3)
						$retvalue = 1; //Target KDS dalam batas toleransi (batas bawah)
					}
				}
			} else {
				//Sudah ada record evaluasi KDS
				$retvalue = 2; //Sudah pernah evaluasi KDS, tinggal followup di approve SOHEAD, RSS dan FIN
				//$keterangan = "";
				//$approve_sohead = "";
				//$approve_rss = "";
				//$conn=bukaDatabase();
				if($conn){
					$ssql =	"Select date(approve_sohead) as approve_sohead, date(approve_rss) as approve_rss, date(approve_fin) as approve_fin, " .
							"date(duedate_sohead) as duedate_sohead, date(duedate_rss) as duedate_rss, date(duedate_fin) as duedate_fin, keterangan, evaluasi " . 
							"From trn_evaluasi_kds Where kd_relasi = '$kd_relasi' and periode = '$periode' ";
					//echo $ssql;
					$rs = mysql_query($ssql, $conn);
					$row = mysql_fetch_row($rs);
					if ($row[3] != null){
						//Untuk mendapatkan nilai batas bawah dan batas atas penjualan unit KDS
						$approve_sohead = $row[0];
						$approve_rss = $row[1];
						$approve_fin = $row[2];
						
						$duedate_sohead = $row[3];
						$duedate_rss = $row[4];
						$duedate_fin = $row[5];
						
						$keterangan = $row[6];
						$evaluasi = $row[7];
					}
					tutupDatabase($conn);
				}
				
				if ($flag == "D" && $evaluasi == 0) {
					$retvalue = 1; //Capai Target KDS (Batas bawah dan Batas atas)
				} else if ($flag != "D" && $evaluasi >= 0) {
					$retvalue = 1; //Capai Target KDS (Batas bawah dan Batas atas)
				} else {
					//$flag = substr($periode, -1);
					$tglserver = date("Y-m-d", strtotime("+7 hours")); //tanggal server untuk sebagai tanggal hari ini
					//echo "tgl server " . $tglserver . " <br>";
					//echo "duedate sohead " . $duedate_sohead . " <br>";
					//echo "approve sohead " . $approve_sohead . " <br>";
					//echo "duedate rss " . $duedate_rss . " <br>";
					//echo "approve rss " . $approve_rss . " <br>";
					//Cek pengisian evaluasi 3C minimal 30 karakter
					if (strlen($keterangan) > 30) {
						/*
						if ($flag == "A") {
							$jto_sohead = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-07 +3 days"));
						} else if ($flag == "B") {
							$jto_sohead = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-14 +3 days"));
						} else if ($flag == "C") {
							$jto_sohead = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-21 +3 days"));
						} else if ($flag == "D") {
							$jto_sohead = date("Y-m-d", strtotime(date("Y-m-t", strtotime($tanggal)) . " +3 days")); //Akhir bulan tanggal +3 hari
						}
						*/
						if ($tanggal <= $duedate_sohead) { //diganti menggunakan tanggal LHPBK aktif masing-masing SO
							$retvalue = 1; //Masih dalam tanggal toleransi pengisian keterangan evaluasi KDS
						}
					}
					//Cek Approve SOHEAD +3 hari dari duedate RSS
					if ($approve_sohead != null) {
						if (($approve_sohead <= $duedate_rss) && ($tanggal <= $duedate_rss)) { //diganti menggunakan tanggal LHPBK aktif masing-masing SO
							$retvalue = 1; //Masih dalam tanggal toleransi approve SO HEAD sebelum melewati duedate RSS dan duedate RSS masih dibawah tgl server hari ini
						}
					}
					
					if ($approve_rss != null && $approve_fin != null) {
						$retvalue = 1; //Sudah di-approve RSS / FIN
						//Tidak perlu cek lagi approve berlaku dari RSS dan FIN
						//Cek Approve RSS dan FIN +6 hari dari $tanggal
						/*
						if ($flag == "A") {
							$jto_rssfin = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-07 +6 days"));
						} else if ($flag == "B") {
							$jto_rssfin = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-14 +6 days"));
						} else if ($flag == "C") {
							$jto_rssfin = date("Y-m-d", strtotime(date("Y-m", strtotime($tanggal)) . "-21 +6 days"));
						} else if ($flag == "D") {
							$jto_rssfin = date("Y-m-d", strtotime(date("Y-m-t", strtotime($tanggal)) . " +6 days")); //Akhir bulan tanggal +6 hari
						}
						if ($tglserver <= $jto_rssfin) {
							$retvalue = 1; //Masih dalam tanggal toleransi approve RSS / FIN
						}
						*/
					}
				}
			}
		}
	} else {
		$retvalue = 1; //jalan KDS hanya diwilayah ACEH
	}
	return $retvalue;
}

function jalanKDS($kd_relasi){
	$retvalue = 0;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) as ADA " .
				"From mst_operator Where kd_dept = '$kd_relasi' and akseskds = 'ACEH' ;";
		//$kdrelasi = SO-SDR
		//echo $ssql;
		$rs = mysql_query($ssql);
		if ($rec = mysql_fetch_array($rs)){
			$retvalue = $rec['ADA'];
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function ambilQtyKreditSales($daritanggal, $sampaitanggal, $kd_relasi){
	$retvalue = 0;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select sum(case when jlh_unit_kredit is null then 0 else jlh_unit_kredit end) as jlh_unit_kredit " .
				"From trn_kasbank Where kd_relasi = '$kd_relasi' and " .
				"tanggal between '$daritanggal' and '$sampaitanggal' ;";
		//$kdrelasi = SO-SDR
		//echo $ssql;
		$rs = mysql_query($ssql);
		if ($rec = mysql_fetch_array($rs)){
			$retvalue = $rec['jlh_unit_kredit'];
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function ambilQtyKreditKDS($daritanggal, $sampaitanggal, $kd_relasi){
	$retvalue = 0;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select sum(case when jlh_unit_kds is null then 0 else jlh_unit_kds end) as jlh_unit_kds " .
				"From trn_kasbank Where kd_relasi = '$kd_relasi' and " .
				"tanggal between '$daritanggal' and '$sampaitanggal' ;";
		//$kdrelasi = SO-SDR
		$rs = mysql_query($ssql);
		if ($rec = mysql_fetch_array($rs)){
			$retvalue = $rec['jlh_unit_kds'];
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function belumAdaEvaluasiKDS($kd_relasi, $periode) {
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) as ADA " .
				"From trn_evaluasi_kds Where kd_relasi = '$kd_relasi' and periode = '$periode' ";
		//$kdrelasi = SO-SDR, $periode = 201603B
		$rs = mysql_query($ssql);
		if ($rec = mysql_fetch_array($rs)){
			if ($rec['ADA'] == 0) {
				$retvalue = true; //Belum ada evaluasi KDS untuk koderelasi dan periode tersebut
			}
		}
		tutupDatabase($conn);
	}
	return $retvalue;	
}

function ambilTglLHPBKLast($kd_relasi){
	$retvalue = 0;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "SELECT max(date(tanggal)) as tanggal FROM trn_kasbank WHERE kd_relasi = '$kd_relasi' ;";
		//$kdrelasi = SO-SDR
		//echo $ssql;
		$rs = mysql_query($ssql);
		if ($rec = mysql_fetch_array($rs)){
			$retvalue = $rec['tanggal'];
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existTarget($kd_relasi, $periode){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_target Where kd_relasi = '$kd_relasi' and periode = '$periode' ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existTargetKDS($kd_relasi, $periode){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_target_kds Where kd_relasi = '$kd_relasi' and periode = '$periode' ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existPartNo($part_no,$conn="xxx"){
	$retvalue = false;
	$flag = 0;
	if ($conn == "xxx"){
		$conn=bukaDatabase();
		$flag = 1;
	}
	if($conn){
		$ssql = "Select count(*) From mst_part Where part_no = '$part_no';";
		$rs = mysql_query($ssql,$conn);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		if ($flag == 1){
			tutupDatabase($conn);
		}
	}
	return $retvalue;
}

function existKdGroupMenu($kd_group_menu){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_group_menu Where kd_group_menu = '$kd_group_menu';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdGroupAcc($id_group_acc){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_group_account Where id_group_acc = '$id_group_acc';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdGroupAccCSC($id_group_acc){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_group_account_csc Where id_group_acc = '$id_group_acc';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdAcc($id_acc){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_account Where id_acc = '$id_acc' and enabled = '1' ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdAccCSC($id_acc){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_account_csc Where id_acc = '$id_acc' and enabled = '1' ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKodePerk($kodeperk){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_perk Where no_perk = '$kodeperk' ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdIDTransaksi($id){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi Where id = '$id';";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdIDTransaksiCSC($id){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi_csc Where id = '$id';";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdIDPengiriman($id){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_laporan Where id = '$id';";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdBulanTahunKU($kd_relasi, $laporan_ku, $bulan_ku, $tahun_ku){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_laporan Where kd_relasi = '$kd_relasi' and laporan_ku = '$laporan_ku' and bulan_ku = '$bulan_ku' and tahun_ku = '$tahun_ku' ;";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existMenu($menu){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_menu Where menu = '$menu';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existRelasiOnTagihan($kd_relasi){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_tagihan Where kepada = '$kd_relasi';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existDeptOnTagihan($kd_dept){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_tagihan Where Dari = '$kd_dept';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existPerihalOnTagihan($kd_perihal){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_tagihan Where kd_perihal = '$kd_perihal';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existNoSuratOnBayar($no_surat){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_bayar Where no_surat = '$no_surat';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdPerihal($kd_perihal){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_perihal Where kd_perihal = '$kd_perihal';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existNoSurat($no_surat){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_tagihan Where no_surat = '$no_surat' and status = 1;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existNoBayar($no_bayar){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_bayar Where no_bayar = '$no_bayar';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function CekTempNoBayar($no_bayar){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From temp_bayar Where no_bayar = '$no_bayar' and status = 'CLOSE' ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existTempNoBayar($no_bayar){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From temp_bayar Where no_bayar = '$no_bayar';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdDept($kd_dept){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_dept Where kd_dept = '$kd_dept';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdCSC($kd_csc){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_csc Where kd_csc = '$kd_csc';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKodePT($kodept){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_operator Where kodept = '$kodept';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKode($id_kode){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_kode Where id_kode = '$id_kode';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existAlasan($kd_dept, $tanggal){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_alasan Where kd_dept='$kd_dept' && date(tanggal)='$tanggal';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existIdGroupOnAkses($id_group){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_akses Where id_group = '$id_group';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdGroupMenuOnMenu($kd_group_menu){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_menu Where kd_group_menu = '$kd_group_menu';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdGroupAccOnAcc($id_group_acc){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_account Where id_group_acc = '$id_group_acc';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdGroupAccOnAccCSC($id_group_acc){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_account_csc Where id_group_acc = '$id_group_acc';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdAccOnTrn($id_acc){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi Where id_acc = '$id_acc';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdAccOnTrnCSC($id_acc){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi_csc Where id_acc = '$id_acc';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existIdOnTrnTransaksiDtl($id){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi_dtl Where id = '$id';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existIdOnTrnTransaksiDtlCSC($id){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi_dtl_csc Where id = '$id';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existIdKdRelasiOnTrnTransaksiDtl($id,$kd_relasi){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi_dtl Where id = '$id' And kd_relasi = '$kd_relasi';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existIdKdRelasiOnTrnTransaksiDtlCSC($id,$kd_relasi){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi_dtl_csc Where id = '$id' And kd_relasi = '$kd_relasi';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existIDGroup($id){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_group Where id_group = '$id';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existIDGroupOnOperator($id){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_operator Where id_group = '$id';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdInternOnOperator($kd_intern){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_operator Where kd_intern = '$kd_intern';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdRelasi($kd_relasi){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_relasi Where kd_relasi = '$kd_relasi';";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existUsername($username){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_operator Where username = '$username';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function SudahTutupPeriode($id, $tanggal, $kdrelasi){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_kasbank Where kd_relasi = '$kdrelasi' AND tanggal = '$tanggal' ;";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function SudahTutupPeriodeCSC($id, $tanggal, $kdrelasi){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_kasbank_csc Where kd_relasi = '$kdrelasi' AND tanggal = '$tanggal' ;";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existTransaksiLHPBK($kdrelasi, $tanggal){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_transaksi Where kd_relasi = '$kdrelasi' AND tanggal = '$tanggal' ;";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function findCount($ssql){
	$retvalue = 0;
	$conn=bukaDatabase();
	if($conn){
		if ($rs = mysql_query($ssql)){
			if ($rec = mysql_fetch_row($rs)){
				$retvalue = $rec[0];
			}
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKodeUnitUsaha($kode){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From mst_unit_usaha Where kode = '$kode';";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existTerimaCdBackup($kode,$periode){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trn_terima_cd_backup Where kode = '$kode' and periode_cd = '$periode';";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existBypassODKDS($kode,$periode)
{
	$retvalue = false;
	$conn = bukaDatabase();
	if($conn){
		$ssql = "SELECT COUNT(*) FROM trn_bypass_overdue_kds WHERE kode = '$kode' AND periode = '$periode';";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existKdIDTglLapKU($id)
{
	$retvalue = false;
	$conn = bukaDatabase();
	if($conn){
		$ssql = "SELECT COUNT(*) FROM mst_laporan WHERE ID = '$id' ;";
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function existNoGiro ($nogiro){
	$retvalue = false;
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select count(*) From trm_kas_giro Where nogiro = '$nogiro';";
		//echo $ssql;
		$rs = mysql_query($ssql);
		$row = mysql_fetch_row($rs);
		if ($row[0] > 0){
			$retvalue = true;
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}
?>
