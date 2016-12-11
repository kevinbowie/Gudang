<?
include("var.php");

function pageheader($judul,$dir="",$info=false){
?>
<html>
<head>
<title><? echo $judul; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="<? echo $dir;?>def.css.php"/>
<?/*<!--link rel="stylesheet" type="text/css" href="<? echo $dir;?>style.css"/-->*/?>
<script type="text/javascript" src="<? echo $dir;?>def.js.php"></script>
<script src="../lhpbk/amcharts/amcharts.js" type="text/javascript"></script>
<script src="../lhpbk/amcharts/pie.js" type="text/javascript"></script>
<script src="../lhpbk/amcharts/serial.js" type="text/javascript"></script>
<script src="../lhpbk/amcharts/xy.js" type="text/javascript"></script>
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="620" id="AutoNumber1">
  <tr>
    <td width="100%">
    <p align="right">
	<font face="Verdana" size="2" color="#444444">

<?
if (isset($_SESSION['username']) && isset($_SESSION['password'])){
?><script type="text/javascript">clock();</script> | 
<?
}
?>

<a href="<? echo $dir;?>menu.php">Home</a> | <a href="mailto:it@cdn.co.id">Contact us</a> || <a href="http://www.cdn.co.id/tagihan/Sistem%20Tagihan-FIN.html" target="petunjuk1">Lihat Petunjuk</a> ||| <a href="http://www.cdn.co.id/tagihan/LHPKB.pdf" target="petunjuk2">LHPBK</a>

<?
if (isset($_SESSION['username']) && isset($_SESSION['password'])){
?>
 | <br /><a href="http://www.cdn.co.id/tagihan/DAFTARREKHO.pdf" target="_blank">Daftar Rek.HO Medan</a><img src="http://www.cdn.co.id/tagihan/images/new.gif" /> | <a href="<? echo $dir;?>logout.php">Logout</a>
<?
}
?>

</font>
    </p>
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber4">
      <tr>
        <td width="33"><img border="0" src="<? echo $dir;?>images/ptcdn.gif" width="300" height="58" /></td>
        <td width="33">&nbsp;</td>
        <td width="34"><img border="0" src="<? echo $dir;?>images/logohonda.gif" width="250" height="50"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="100%" background="<? echo $dir;?>images/kurvaatas.gif" height="17" align="center"></td>
  </tr>
</table>
<br />
<?
if (!isset($_SESSION['username']))
   tampilInfo();
return 0;
}

function pageheader_accounting($judul,$dir="",$info=false){
?>
<html>
<head>
<title><? echo $judul; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="<? echo $dir;?>def.css.php"/>
<?/*<!--link rel="stylesheet" type="text/css" href="<? echo $dir;?>style.css"/-->*/?>
<script type="text/javascript" src="<? echo $dir;?>def.js.php"></script>
<script src="../lhpbk/amcharts/amcharts.js" type="text/javascript"></script>
<script src="../lhpbk/amcharts/pie.js" type="text/javascript"></script>
<script src="../lhpbk/amcharts/serial.js" type="text/javascript"></script>
<script src="../accounting.js" type="text/javascript"></script>
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="620" id="AutoNumber1">
  <tr>
    <td width="100%">
    <p align="right">
	<font face="Verdana" size="2" color="#444444">

<?
if (isset($_SESSION['username']) && isset($_SESSION['password'])){
?><script type="text/javascript">clock();</script> | 
<?
}
?>

<a href="<? echo $dir;?>menu.php">Home</a> | <a href="mailto:it@cdn.co.id">Contact us</a> || <a href="http://www.cdn.co.id/tagihan/Sistem%20Tagihan-FIN.html" target="petunjuk1">Lihat Petunjuk</a> ||| <a href="http://www.cdn.co.id/tagihan/LHPKB.pdf" target="petunjuk2">LHPBK</a>

<?
if (isset($_SESSION['username']) && isset($_SESSION['password'])){
?>
 | <br /><a href="http://www.cdn.co.id/tagihan/DAFTARREKHO.pdf" target="_blank">Daftar Rek.HO Medan</a><img src="http://www.cdn.co.id/tagihan/images/new.gif" /> | <a href="<? echo $dir;?>logout.php">Logout</a>
<?
}
?>

</font>
    </p>
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber4">
      <tr>
        <td width="33"><img border="0" src="<? echo $dir;?>images/ptcdn.gif" width="300" height="58" /></td>
        <td width="33">&nbsp;</td>
        <td width="34"><img border="0" src="<? echo $dir;?>images/logohonda.gif" width="250" height="50"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="100%" background="<? echo $dir;?>images/kurvaatas.gif" height="17" align="center"></td>
  </tr>
</table>
<br />
<?
if (!isset($_SESSION['username']))
   tampilInfo();
return 0;
}

function pagefooter($dir=""){
?>
<br />
<br />
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="620" id="AutoNumber1">
	<tr>
		<td>
			<div align="center"><img border="0" src="<? echo $dir;?>images/oneheart.png" width="140"></div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="100%" bgcolor="#FF0000">
			<div align="center"></div>
		</td>
	</tr>  
	<tr>
		<td width="100%">
			<p align="center">
			<font class="copy" face="Arial, Helvetica, sans-serif" size="1" color="#999999">
			Copyright &#169 2004 PT Capella Dinamik Nusantara. All rights reserved.&nbsp;&nbsp;</font>
			</p>
		</td>
	</tr>
</table>
</center>        
</body>
</html>
<?
return 0;
}

function pageheaderpanjang($judul,$info=false){
?>
<html>
<head>
<title><? echo $judul; ?></title>
<style type=text/css>A:link  {
        color : 000066;
        text-decoration : none;
 }
 A:visited  {
        color : 0000FF;
        text-decoration : none;
 }
 A:hover  {
        color : FF0000;
        text-decoration : none;
 } 
 body     { 
        font-family: Verdana;
        font-size: 10pt; 
 }
 table    { 
        font-family: Verdana;
        font-size: 10px;
          }
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin=0 topmargin=0 marginwidth=0 marginheight=0">
<center>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
    <td width="100%">
    <p align="right">
	<font face="Verdana" size="2" color="#999999"><a href="menu.php">Home</a> | <a href="SiteMap.php">Site map</a> | <a href="mailto:cdnmedan@indosat.net.id">Contact us</a> | <a href="logout.php">Logout [ <b><? echo strtoupper($_SESSION['username']); ?></b> ]</a></font>
    </p>
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber4">
      <tr>
        <td width="33?">
        <img border="0" src="images/ptcdn.gif" width="300" height="58" /></td>
        <td width="33?">&nbsp;</td>
        <td width="34?" align="right">
        <img border="0" src="images/logohonda.gif" width="250" height="50" /></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="100%" bgcolor="#FF0000">&nbsp;</td>
  </tr>
</table>
<?
return 0;
}

function pagefooterpanjang(){
?>
<br />
<br />
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
    <td width="100%" bgcolor="#FF0000">
    <div align="center"><img border="0" src="images/footer.gif" width="327" height="20" /></div>
    </td>
  </tr>
  <tr>
    <td width="100%">
    <p align="center">
    <font class="copy" face="Arial, Helvetica, sans-serif" size="1" color="#999999">
    Copyright &#169 2004 PT Capella Dinamik Nusantara. All rights reserved.&nbsp;&nbsp;</font>
	</p></td>
  </tr>
</table>
</center>        
</body>
</html>
<?
return 0;
}
function tampilInfo($str=""){
?>
	<table border = 1 bordercolor = "#FF0000">
	<?if ($str != "") {?>
	 <tr>
	  <td>
	   <font size = 3><pre align="left"><? echo $str;?></pre></font>
	  </td>
	 </tr>
	<?
	}
	echo ambilPengumuman(); ?>
	</table>
	<?
}

function bukaDatabase(){
	//$conn = mysql_pconnect("localhost","root","cdn2008@indosat.co.id");
	$conn = mysql_pconnect("localhost","root","cdn2008@indosat.co.id");
	if(!$conn) {
	  echo "<font color='red'><h1>Maaf, service sementara tidak aktif!</h1></font><br>";
	  exit;
	}else {
	  mysql_select_db("tagihan",$conn);
	}  
	return $conn;
}

function tutupDatabase($conn){
	mysql_close($conn);
}

function bukaDatabase_bohdar_acc(){
	//$conn = mysql_pconnect("localhost","root","cdn2008@indosat.co.id");
	$conn_acc = mysql_pconnect("localhost","root","cdn2008@indosat.co.id");
	if(!$conn_acc) {
	  echo "<font color='red'><h1>Maaf, service sementara tidak aktif!</h1></font><br>";
	  exit;
	}else {
	  mysql_select_db("bohdar_acc",$conn_acc);
	}  
	return $conn_acc;
}

function tutupDatabase_bohdar_acc($conn_acc){
	mysql_close($conn_acc);
}

function bukaDatabase_assessment(){
	//$conn = mysql_pconnect("localhost","root","cdn2008@indosat.co.id");
	$conn_assessment = mysql_pconnect("localhost","root","cdn2008@indosat.co.id", true);
	if(!$conn_assessment) {
	  echo "<font color='red'><h1>Maaf, service sementara tidak aktif!</h1></font><br>";
	  exit;
	}else {
	  mysql_select_db("assessment",$conn_assessment);
	}  
	return $conn_assessment;
}

function tutupDatabase_assessment($conn_assessment){
	mysql_close($conn_assessment);
}

function ambilPengumuman(){
	$retvalue = "";
	$conn=bukaDatabase();
	if($conn){
	$ssql = "Select Contain From mst_pemberitahuan Where date(PeriodeBerlaku) >= date(now()) And Status = 1;";
	if ($rs = mysql_query($ssql)){
		if ($rec = mysql_fetch_array($rs)){
			do{
				$retvalue .='<tr><td>'.$rec['Contain'].'&nbsp;</td></tr>';
			}while($rec = mysql_fetch_array($rs));
		}
	}  
	tutupDatabase($conn);
	}
	return $retvalue;
}

function periksaLogin($username,$password){
	// 0 gagal
	$retvalue = 0;
	$conn=bukaDatabase();
	if($conn){
	  $ssql = "Select username, password From mst_operator Where username = '$username' and password = '$password' and status = 1;";
		if ($rs = mysql_query($ssql)){
		    if ($rec = mysql_fetch_array($rs)){
		        if ($username = $rec['username'] && $password = $rec['password']){
		     	   $retvalue = 1;
			    }
			}
		}  
	  tutupDatabase($conn);
	}
	return $retvalue;
}

function cekHakAkses($id_group,$menu){
	$conn=bukaDatabase();
	if($conn){
		$ssql = "select count(*) from mst_akses where id_group = '$id_group' and menu = '$menu' and enabled = 1;";
		if ($rs = mysql_query($ssql)){
			if ($rec = mysql_fetch_row($rs)){
				if ($rec[0] < 1){
					return 0;
				}else{
					return 1;
				}
			}
		}
		tutupDatabase($conn);
	}
	return $retvalue;
}

function ambilDetailUser($username, $password, &$kd_intern, &$kd_dept, &$keterangan, &$id_group, &$ada, &$kodept="", &$kodeassessment=""){
	$conn=bukaDatabase();
	if($conn){
	    $ssql = "Select a.id_group, a.kd_intern, a.kd_dept, b.nama as keterangan, a.kodept, a.kodeassessment, " .
				 "case when a.kd_csc is null then '0' else a.kd_csc end as kd_csc " .
			     "From mst_operator a inner join mst_relasi b on a.kd_intern = b.kd_intern " .
			     "Where a.Username = '$username' and a.Password = '$password' and a.Status = 1;";
		//echo $ssql;
		if ($rs = mysql_query($ssql)){
		    if ($rec = mysql_fetch_array($rs)){
				$kd_intern = $rec['kd_intern'];
				if ($rec['kd_csc']=="0") {
					$kd_dept = $rec['kd_dept'];
				} else {
					$kd_dept = $rec['kd_csc'];
				}
				$keterangan = $rec['keterangan'];
				$id_group = $rec['id_group'];
				$kodept = $rec['kodept'];
				$kodeassessment = $rec['kodeassessment'];
				$ada = 1;
			}else{
				$ada = 0;
			}
		}
		tutupDatabase($conn);
	}
}

function ambilNamaDealer($kd_intern){
	$conn=bukaDatabase();
	$NamaDealer="";
	if($conn){
	    $ssql = "Select keterangan from mst_dealer where kd_intern = '$kd_intern' ;";
	    if ($rs = mysql_query($ssql)){
			if ($rec = mysql_fetch_array($rs)){
				$NamaDealer = $rec['keterangan'];
			}else{
				$NamaDealer = "";
			}
	    }else{
			echo '<div align="center" class="err">Error : Syntax sql !!<br/>Sql Err:'.mysql_error().'</div><br/>';
		}
		tutupDatabase($conn);
	}
	return $NamaDealer;
}

function getRunNum($awalan,$username){
	$runnum = 0;
	$ssql = "Select runnum From mst_runnum Where awalan = '$awalan';";
	if ($rs = mysql_query($ssql)){
		if ($rec = mysql_fetch_array($rs)){
			$runnum = $rec['runnum'] + 1;
			$ssql = "update mst_runnum set runnum = '$runnum', modiby = '$username', moditime = now() where awalan = '$awalan'";
			mysql_query($ssql);
		}else{
			$ssql = "insert into mst_runnum (awalan, runnum, creaby, creatime) values ('$awalan',1,'$username',now());";
			mysql_query($ssql);
			$runnum = 1;
		}
	}
	return $runnum;
}

function TanggalIndo($tanggal){
	$ctahun = (int) substr($tanggal,0,4);
	$cbulan = (int) substr($tanggal,5,2);
	$chari = (int) substr($tanggal,8,2);
	$xtanggal = mktime(0,0,0,$cbulan,$chari,$ctahun);
	$hari=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
	$bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
	$nhari=date('w',$xtanggal);
	return $hari[$nhari] . ', ' . $chari . ' ' . $bulan[((int) $cbulan)-1] . ' ' . $ctahun;
}		  

function TanggalIndoCustom($tanggal){
	$ctahun = (int) substr($tanggal,0,4);
	$cbulan = (int) substr($tanggal,5,2);
	$chari = (int) substr($tanggal,8,2);
	$xtanggal = mktime(0,0,0,$cbulan,$chari,$ctahun);
	$hari=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
	$bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
	$nhari=date('w',$xtanggal);
	return $chari . ' ' . $bulan[((int) $cbulan)-1] . ' ' . $ctahun;
}	
function BuatHariNew($nama, $selected){
?>  <select name="<? echo $nama; ?>" ><?
	for($i=1;$i<=31;$i++) {
        if($i==$selected) {
    ?>		<option value="<? echo str_pad($i,2,'0',STR_PAD_LEFT); ?>" selected><? echo str_pad($i,2,'0',STR_PAD_LEFT); ?></option>
    <?  }else{
    ?>   	<option value="<? echo str_pad($i,2,'0',STR_PAD_LEFT); ?>"><? echo str_pad($i,2,'0',STR_PAD_LEFT); ?></option>
    <?  }
    }
?>	</select><?		  
}

function BuatHari($x){
	for($i=1;$i<=31;$i++) {
	    if($i==$x){
	?>  	<option value="<? echo str_pad($i,2,'0',STR_PAD_LEFT); ?>" selected><? echo str_pad($i,2,'0',STR_PAD_LEFT); ?></option>
	<?  }else {
	?>  	<option value="<? echo str_pad($i,2,'0',STR_PAD_LEFT); ?>"><? echo str_pad($i,2,'0',STR_PAD_LEFT); ?></option>
	<?  }
	}
}

function BuatBulanNew($nama, $selected){
?>  <select name="<? echo $nama; ?>" >
<?  for($i=1;$i<=12;$i++) {
        if($i==$selected) {
    ?>  	<option value="<? echo str_pad($i,2,'0',STR_PAD_LEFT); ?>" selected><? echo str_pad($i,2,'0',STR_PAD_LEFT); ?></option>
    <?  }else {
    ?>  	<option value="<? echo str_pad($i,2,'0',STR_PAD_LEFT); ?>"><? echo str_pad($i,2,'0',STR_PAD_LEFT); ?></option>
    <?  }
    }
?>  </select>
<?		  
}

function BuatTahunNew($nama, $selected){
?>  <select name="<? echo $nama; ?>" >
<?  for($i=2008;$i<=2018;$i++) {
        if($i==$selected) {
    ?>  	<option value="<? echo $i; ?>" selected><? echo $i; ?></option>
    <?  }else {
    ?>  	<option value="<? echo $i; ?>"><? echo $i; ?></option>
    <?  }
    }
?>	</select>
<?		  
}

function BuatBulan($x){
	for($i=1;$i<=12;$i++) {
	    if($i==$x) {
	?> 		<option value="<? echo str_pad($i,2,'0',STR_PAD_LEFT); ?>" selected><? str_pad($i,2,'0',STR_PAD_LEFT); ?></option>
	<?  }else {
	?> 		<option value="<? echo str_pad($i,2,'0',STR_PAD_LEFT); ?>"><? str_pad($i,2,'0',STR_PAD_LEFT); ?></option>
	<?  }
	}
}

function BuatTahun($x){
	for($i=2004;$i<=2020;$i++) {
	   if($i==$x) {
	?>		<option value="<? echo $i; ?>" selected><? echo $i; ?></option>
	<?	}else {
	?>		<option value="<? echo $i; ?>"><? echo $i; ?></option>
	<?	}
	}
}

function PeriksaString($unsafe_string){
    // create array containing bad words
    $badwords = array(";","--","select","drop","insert","xp_","delete");
    $goodwords = array(":","---","choose","leave","add"," ","remove");    
    // check for occurences of $badwords
    for($i=0; $i<7; $i++) {
        $unsafe_string = str_replace($badwords[$i], $goodwords[$i], $unsafe_string);
    }
    $unsafe_string = addslashes($unsafe_string);
    $unsafe_string = trim($unsafe_string);
    $safe_string = $unsafe_string;
    return $safe_string;
}

function isValidDate($tgl, $bln, $thn){
	$result = 0;
	$konversi = mktime(0,0,0,$bln,$tgl,$thn);
	if ((intval(date("d",$konversi)) == intval($tgl)) && 
	    (intval(date("m",$konversi)) == intval($bln)) && 
		(intval(date("Y",$konversi)) == intval($thn)))
		$result = 1;
	return $result;	
}

function disclaimer($pusat=0){
	if($pusat==0){
?>		<br />
		<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="300">
			<tr>
				<td>&nbsp;</td>
				<td>
				<font style="font-size: 12pt;" color="#FF0000" face="Tahoma">Disclaimer :</font>
				</td>
			</tr>
			<tr>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">1.</font>
				</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				Jika informasi yang ditampilkan berbeda dengan 
				</font>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				faktur fisik, maka informasi yang diakui kebenarannya adalah faktur fisik.
				</font>
				</td>
			</tr>
			<tr>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">2.</font>
				</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				Jika ada gangguan teknis, segera hubungi 
				</font>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				marketing untuk mendapatkan informasi tagihan Anda dan hal ini tidak bisa dijadikan alasan keterlambatan pembayaran.
				</font>
				</td>
			</tr>
		</table>
<?	}else{
?>		<br />
		<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="300">
			<tr>
				<td>&nbsp;</td>
				<td>
				<font style="font-size: 12pt;" color="#FF0000" face="Tahoma">Disclaimer :</font>
				</td>
			</tr>
			<tr>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">1.</font>
				</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				Setelah proses upload PIC diwajibkan melakukan
				</font>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				pengecekan kembali hasil upload.
				</font>
				</td>
			</tr>
			<tr>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">2.</font>
				</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				Untuk setiap perubahan terhadap data yang
				</font>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				telah diupload, maka hasil perubahan harus diupload kembali
				dan diinfomasikan ke dealer yang bersangkutan.
				</font>
				</td>
			</tr>
			<tr>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">3.</font>
				</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				Jika ada gangguan teknis maka informasi yang
				</font>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<font style="font-size: 10pt;" color="#e56717" face="Tahoma">
				penting harus disampaikan ke dealer melalui media 
				komunikasi lainnya.
				</font>
				</td>
			</tr>
		</table>
<?	}
}

function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip=$_SERVER['HTTP_CLIENT_IP'];
    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
		$ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function beginTrans(){
	$conn=bukaDatabase();
	@mysql_query("BEGIN");
	tutupDatabase($conn);
}

function commitTrans(){
	$conn=bukaDatabase();
	@mysql_query("COMMIT");
	tutupDatabase($conn);
}

function rollbackTrans(){
	$conn=bukaDatabase();
	@mysql_query("ROLLBACK");
	tutupDatabase($conn);
}

function xbeginTrans() {
	@mysql_query("BEGIN");
}

function xcommitTrans(){
	@mysql_query("COMMIT");
}

function xrollbackTrans(){
	@mysql_query("ROLLBACK");
}

function beginTrans_bohdarACC(){
	$conn=bukaDatabase_bohdar_acc();
	@mysql_query("BEGIN");
	tutupDatabase_bohdar_acc($conn);
}

function commitTrans_bohdarACC(){
	$conn=bukaDatabase_bohdar_acc();
	@mysql_query("COMMIT");
	tutupDatabase_bohdar_acc($conn);
}

function rollbackTrans_bohdarACC(){
	$conn=bukaDatabase_bohdar_acc();
	@mysql_query("ROLLBACK");
	tutupDatabase_bohdar_acc($conn);
}

function alert($str){
    echo "<script type=\"text/javascript\">
	      alert('$str');
	      </script>";
}

function TokenPartHolder($tanggal,$kd_intern,$key){
    $retval = md5($tanggal.$kd_intern.$key);
	$one = substr($retval,4,1);
	$two = substr($retval,9,1);
	$three = substr($retval,14,1);
	$four = substr($retval,19,1);
	$five = substr($retval,24,1);
	$six = substr($retval,29,1);
	$retval = $one . $two . $three . $four . $five . $six;
	return $retval;
}

function fmtHtml($val){
	return $val == 0?"-":$val;
}

function right($value, $count){
    return substr($value, ($count*-1));
}

function left($string, $count){
    return substr($string, 0, $count);
}

function contains($str, $content, $ignorecase=true){
    if ($ignorecase){
        $str = strtolower($str);
        $content = strtolower($content);
    }  
    return strpos($content,$str) ? true : false;
}

function lov($dir, $width=450, $height=510){
?>
<script type="text/javascript">
<!--
function popUp(lov, id) {
	var dir;
	var url;
	dir = '<?echo $dir; ?>';
	url = dir + 'lov.php?lov=' + lov + '&id=' + id + '&from=0';
	w = open(url,"winLov","Scrollbars=1,resizable=1,width=<? echo $width; ?>,height=<? echo $height; ?>");
	if (w.opener == null) 
		w.opener = self;
	w.focus();
}
//-->
</script>
<?
}

function cekTgl($strTgl){
    list($thn,
         $bln,
         $tgl)=explode("-",$strTgl);
    //alert($tgl.'-'.$bln.'-'.$thn);
    if (isValidDate($tgl,$bln,$thn)==0){
	    return false;
    }
    return true;
}

function getFilter($fa){
	//if ($fa!="") {
		$retVal = "";
		$tmp = " Where ";
		foreach ($fa as $i => $value) {
			if (($fa[$i]!="")||($fa[$i]!=null)){
				$tmp .= $i." like '%".$fa[$i]."%' and ";
			}
		}
		$retVal = ($tmp == " Where ")?"":left($tmp,strlen($tmp)-4);
	//} else {
	//	$retVal = "";
	//}
	return $retVal;
}

function navigatorGeneral($from,$maxrec,$perpage){
	$maxrec--;
	echo '<p align = "right">';
	$javascript = "javascript:filter('0');";
	if ($from != 0){
		echo '&nbsp;<a href="#" onclick="'.$javascript.'"><< First</a>     ';
	}else{
		echo '<< First     ';
	}
	
	$prev = ($from - $perpage);
	if ($prev >= 0){
		$javascript = "javascript:filter('".$prev."');";
		echo '&nbsp;<a href="#" onclick="'.$javascript.'">Prev</a>     ';
	}else{
		echo "&nbsp;Prev     ";
	}

	$next = ($from + $perpage);
	if ($next <= $maxrec){
		$javascript = "javascript:filter('".$next."');";
		echo '&nbsp;<a href="#" onclick="'.$javascript.'">Next</a>     ';
	}else{
		echo "&nbsp;Next     ";
	}  

	//$last = $maxrec % $perpage;
	//$pbg = ceil($maxrec / $perpage);
	$last = $maxrec - ($maxrec % $perpage);
	if($from != $last){
		if ($last < 0) $last = 0;
		$javascript = "javascript:filter('".$last."');";
		echo '&nbsp;<a href="#" onclick="'.$javascript.'">Last >></a>';
	}else{
		echo "&nbsp;Last>>     ";
	}
	echo "</p>";
}

# Wake on LAN - (c) HotKey@spr.at, upgraded by Murzik <tomurzik@inbox.ru>
function wakeonlan($addr, $mac){
	$addr_byte = explode(':', $mac);
	$hw_addr = '';

	for ($a=0; $a < 6; $a++) $hw_addr .= chr(hexdec($addr_byte[$a]));

	$msg = chr(255).chr(255).chr(255).chr(255).chr(255).chr(255);

	for ($a = 1; $a <= 16; $a++)    $msg .= $hw_addr;

	// send it to the broadcast address using UDP
	// SQL_BROADCAST option isn't help!!
	$s = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
	if ($s == false) {
		echo "Error creating socket!\n";
		echo "Error code is '".socket_last_error($s)."' - " . socket_strerror(socket_last_error($s));
	}else {
		// setting a broadcast option to socket:
		$opt_ret =  socket_set_option($s, 1, 6, TRUE);
		if($opt_ret < 0){
			echo "setsockopt() failed, error: " . strerror($opt_ret) . "\n";
		}
		$e = socket_sendto($s, $msg, strlen($msg), 0, $addr, 2050);
		socket_close($s);
		//echo "Magic Packet sent (".$e.") to ".$addr.", MAC=".$mac;
	}
}

function sleeponlan($addr){
	$s = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
	if ($s == false){
		echo "Error creating socket!\n";
		echo "Error code is '".socket_last_error($s)."' - " . socket_strerror(socket_last_error($s));
	}else{
		$r = socket_connect($s, $addr, 9999);
		if ($r < 0){
			echo "socket_connect() failed.\nReason: ($result) " . socket_strerror($result) . "\n";
		}else{
			$msg = "shutdown";
			$e = socket_write($s, $msg, strlen($msg));
			socket_close($s);
		}
	}
}

function findExts($filename){ 
	$filename = strtolower($filename) ; 
	$exts = split("[/\\.]", $filename) ; 
	$n = count($exts)-1; 
	$exts = $exts[$n]; 
	return $exts; 
}

function remove_ext($str) {
  $noext = preg_replace('/(.+)\..*$/', '$1', $str);
  return $noext; 
}
?>
