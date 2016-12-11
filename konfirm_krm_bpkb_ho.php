<?
session_start();
$dir="../";
$MySelf = basename($_SERVER['PHP_SELF']);
include($dir."library.php");
include($dir."find_lib.php");

if (periksalogin($_SESSION['username'],$_SESSION['password']) != 0 && (cekHakAkses($_SESSION['id_group'],'4000213') != 0)){
    pageheader("PT. Capella Dinamik Nusantara - Konfirmasi Pengiriman BPKB Dari HO ",$dir);
	validateTanyaForm();
	lov($dir);
	$grp_operator = $_SESSION['id_group'];
	if (isset($_GET['aksi'])){
		if ($_GET['aksi']=="confirm"){
			//UPDATE Status Data Mutasi BPKB
			$connSimpan=bukaDatabase();
			if($connSimpan){
				beginTrans();
				$retvalue = 0;
				//var_dump($_POST);
				for ($i=0; $i<count($_POST['konfirmasi']); $i++) {
					$username = $_SESSION['username'];
					$NoBPKB = $_POST['konfirmasi'][$i];		
					$kdcabang = $_POST['kdcabang1'];
					$tglkrm = $_POST['tglkrm1'];
					$nokrm = $_POST['nokrm1'];
					$ssqlUpdate = "Update trn_mutasi_bpkb SET tgl_pengiriman = '$tglkrm', no_pengiriman = '$nokrm', m_by = '$username', m_time = NOW() WHERE no_bpkb = '$NoBPKB';";
					//echo $ssqlUpdate;
					if(!mysql_query($ssqlUpdate, $connSimpan)) {
						echo "<p class = 'err'>Err. 1: Gagal Simpan, Proses dibatalkan !</p>";?>
						<form name="frm" method="post" action="konfirm_krm_bpkb_ho.php">
							<input type="submit" value="Klik untuk Kembali" name="B4">
							<input type="hidden" maxlength="10" name="kdcab" id="kdcab" size="10" class="uppercase" value="<? echo $kdcabang ?>"/> 
							<input type="hidden" maxlength="10" name="tglkrim" id="tglkrim" size="10" class="uppercase" value="<? echo $tglkrm ?>"/> 
							<input type="hidden" maxlength="30" name="nokrim" id="nokrim" size="30" class="uppercase" value="<? echo $nokrm ?>"/> 
						</form> <?
						rollbackTrans();
						break;
					}
					else {
						$retvalue = $retvalue + 1;
					}
				}
				if ($retvalue == count($_POST['konfirmasi'])) {
					echo "<p>Verifikasi Update Pengiriman BPKB dari HO Berhasil Disimpan (".count($_POST['konfirmasi'])." Record)</p>";?>
					<form name="frm" method="post" action="konfirm_krm_bpkb_ho.php">
							<input type="submit" value="Klik untuk Kembali" name="B3">
							<input type="hidden" maxlength="10" name="kdcab" id="kdcab" size="10" class="uppercase" value="<? echo $kdcabang ?>"/> 
							<input type="hidden" maxlength="10" name="tglkrim" id="tglkrim" size="10" class="uppercase" value="<? echo $tglkrm ?>"/> 
							<input type="hidden" maxlength="30" name="nokrim" id="nokrim" size="30" class="uppercase" value="<? echo $nokrm ?>"/> 
						</form> <?
					commitTrans();
				}
				tutupDatabase($connSimpan);
			}
		} else if ($_GET['aksi']=="detail"){
			detail_Form($_GET['nobpkb'], $_GET['cabang']); 
		} else if ($_GET['aksi']=="tampil") {
			if(isset($_POST['kd_cabang'], $_POST['tgl_krm'], $_POST['no_krm'])){
				if($_POST['kd_cabang'] == ""){
					echo "<p>Kode Cabang harap diisi dengan benar</p>";
					Form();
					filter();
				}
				else if(($_POST['tgl_krm'] == "") || (formatTanggal($_POST['tgl_krm']) == false)){
					echo "<p>Tanggal Pengiriman harap diisi dengan benar</p>";
					Form();
					filter();
				}
				else if($_POST['no_krm'] == ""){
					echo "<p>No. Pengiriman harap diisi dengan benar</p>";
					Form();
					filter();
				}
				else{
					ViewTable($_POST['kd_cabang'], $_POST['tgl_krm'], $_POST['no_krm']);
				}
			}
			else{
				ViewTable($_POST['kdcab'], $_POST['tglkrim'], $_POST['nokrim']);
			}
		}
	}
	else {
		Form();
		filter();
	}
    pagefooter($dir);
}
else {
  header ("Location: ".$dir."index.php");
}

function filter(){
	unset($fa);
	$kd_cabang = isset($_POST['kd_cabang'])?$_POST['kd_cabang']:"";
	$pic_trm = isset($_POST['pic_trm'])?$_POST['pic_trm']:"";
	$tgl_trm = isset($_POST['tgl_trm'])?$_POST['tgl_trm']:"";
	$from = isset($_POST['from'])?$_POST['from']:"0";
	$from = ($from=="")?"0":$from;
	$fa = array("kd_cabang" => $kd_cabang,"no_urut" => $no_urut,"no_sp"=>$no_sp,"tgl_sp"=>$tgl_sp,"no_bpkb"=>$no_bpkb,"no_mesin"=>$no_mesin,"nama_pemilik"=>$nama_pemilik,
				"alamat_pemilik"=>$alamat_pemilik,"dari_lokasi"=>$dari_lokasi,"ke_lokasi"=>$ke_lokasi,"keterangan"=>$keterangan,"no_polisi"=>$no_polisi,
				"no_faktur_penjualan"=>$no_faktur_penjualan,"tgl_faktur_penjualan"=>$tgl_faktur_penjualan,"kd_qq"=>$kd_qq,"kd_cust"=>$kd_cust);
	tampil($fa,$from);
}

function validateTanyaForm() {
?>
<script language = "Javascript">
	var n;
	function validateChecked() {
		n = 0;
		var theForm = document.form_konfirmasi;
		for (i=0; i<theForm.elements.length; i++) {
			if (theForm.elements[i].name=='konfirmasi[]') {
				if (theForm.elements[i].checked) {
					n = n + 1;
				}
			}
		}

		if (n < 1) {
			alert("Tidak ada No. BPKB yang dipilih/dicheck !");
			return false;
		}
		else {
			document.form_konfirmasi.n.value = n;
			return true;
		}
	}
</script>

<SCRIPT LANGUAGE="JavaScript">
	function check(status) {		
		var theForm = document.form_konfirmasi;
		for (i=0; i<theForm.elements.length; i++) {
			if (theForm.elements[i].name=='konfirmasi[]') {
				theForm.elements[i].checked = status;
			}
		}	
	}
</script> 
<?
}

function formatTanggal($date){
	if ( preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
		return true;
	}
	else{
		return false;
	}
}

function tampil($fa=array(),$from=0){
	global $TEXT, $MySelf;
	$conn = bukaDatabase();
	if($conn){
		$ssql = "Select kd_cabang, no_urut, no_sp, DATE_FORMAT(tgl_sp,'%Y-%m-%d') AS tgl_sp, no_bpkb, no_mesin, nama_pemilik, alamat_pemilik, dari_lokasi, ke_lokasi, keterangan, 
				no_polisi, no_faktur_penjualan, DATE_FORMAT(tgl_faktur_penjualan,'%Y-%m-%d') AS tgl_faktur_penjualan, kd_qq, kd_cust, pic_trm_ho From trn_mutasi_bpkb where 
				tgl_pengiriman is null and tgl_permintaan is not null Order By kd_cabang Limit %from, %perpage;";
		$ssql2 = "Select count(*) From trn_mutasi_bpkb where tgl_pengiriman is null and tgl_permintaan is not null ;";
		//echo $ssql;
		//echo ssql2;
		$maxrec = 0;
		$perpage = $TEXT['perpage'];
		if ($rs = mysql_query($ssql2)){
			if ($rec = mysql_fetch_row($rs)){
				$maxrec = $rec[0];
			}
		}
		$ssql = str_replace("%perpage",$perpage,$ssql);
		$ssql = str_replace("%from",$from,$ssql);
		if ($rs = mysql_query($ssql)){
			if ($rec = mysql_fetch_array($rs)){
				?>
				<br />
				<br />
				<table border="0" cellspacing="2" width="60%" align="center">
					<tr>
						<td><p>From Record / Max Record : <?echo ($from+1);?> / <?echo $maxrec;?></p></td>
						<td><?navigatorGeneral($from,$maxrec,$perpage);?></td>
					</tr>
				</table>
				<table border="0" cellspacing="2" width="60%" align="center">
				    <tr align="center" bgcolor="<?echo $TEXT['tr_dtl_color'];?>">
						<td nowrap="nowrap" width="3%"><b>No.</b></td>
						<td nowrap="nowrap" width="10%"><b>Kode Cabang</b></td>
						<td nowrap="nowrap" width="15%"><b>No. SP</b></td>
						<td nowrap="nowrap" width="10%"><b>Tgl. SP</b></td>
						<td nowrap="nowrap" width="20%"><b>No. BPKB</b></td>
						<td nowrap="nowrap" width="15%"><b>No. Mesin</b></td>
						<td nowrap="nowrap" width="5%"><b>Nama Pemilik</b></td>
						<td nowrap="nowrap" width="5%"><b>No. Polisi</b></td>
						<td nowrap="nowrap" width="20%"><b>Kode QQ</b></td>
						<td nowrap="nowrap" width="5%"><b>View</b></td>
						<!--
						<td nowrap="nowrap" width="5%"><b>No. Urut</b></td>
						<td nowrap="nowrap" width="15%"><b>Alamat Pemilik</b></td>
						<td nowrap="nowrap" width="10%"><b>Dari Lokasi</b></td>
						<td nowrap="nowrap" width="20%"><b>Ke Lokasi</b></td>
						<td nowrap="nowrap" width="15%"><b>Keterangan</b></td>
						<td nowrap="nowrap" width="15%"><b>No. Faktur Penjualan</b></td>
						<td nowrap="nowrap" width="10%"><b>Tgl. Faktur Penjualan</b></td>
						<td nowrap="nowrap" width="15%"><b>Kode Customer</b></td>
						-->
				    </tr>
					<?
				    $brs = $from+1;
				    do {
						if ($brs%2 == 0){
							?><tr class = "genapoff" onmouseover="this.style.backgroundColor='<?echo $TEXT['hover_color'];?>';" onmouseout="this.style.backgroundColor='<?echo $TEXT['genap_color'];?>';"><?
						}else{
							?><tr class = "ganjiloff" onmouseover="this.style.backgroundColor='<?echo $TEXT['hover_color'];?>';" onmouseout="this.style.backgroundColor='<?echo $TEXT['ganjil_color'];?>';"><?
					    }
							$kd_cabang = $rec['kd_cabang'];
							$no_urut = $rec['no_urut'];
							$no_sp = $rec['no_sp'];
							$tgl_sp = $rec['tgl_sp'];
							$no_bpkb = $rec['no_bpkb'];
							$no_mesin = $rec['no_mesin'];
							$nama_pemilik = $rec['nama_pemilik'];
							$alamat_pemilik = $rec['alamat_pemilik'];
							$dari_lokasi = $rec['dari_lokasi'];
							$ke_lokasi = $rec['ke_lokasi'];
							$keterangan = $rec['keterangan'];
							$no_polisi = $rec['no_polisi'];
							$no_faktur_penjualan = $rec['no_faktur_penjualan'];
							$tgl_faktur_penjualan = $rec['tgl_faktur_penjualan'];
							$kd_qq = $rec['kd_qq'];
							$kd_cust = $rec['kd_cust'];?>
							<td nowrap="nowrap"><? echo $brs; ?></td>
							<td nowrap="nowrap"><? echo $kd_cabang; ?></td>
							<td nowrap="nowrap"><? echo $no_sp; ?></td>
							<td nowrap="nowrap"><? echo $tgl_sp; ?></td>
							<td nowrap="nowrap"><? echo $no_bpkb; ?></td>
							<td nowrap="nowrap"><? echo $no_mesin; ?></td>
							<td nowrap="nowrap"><? echo $nama_pemilik; ?></td>
							<td nowrap="nowrap"><? echo $no_polisi; ?></td>
							<td nowrap="nowrap"><? echo $kd_qq; ?></td>
							<td nowrap="nowrap">
								<a target="_blank" href="<?echo $MySelf;?>?aksi=detail&nobpkb=<? echo $rec['no_bpkb']; ?>&cabang=<? echo $rec['kd_cabang']; ?>">Detail</a></td>
							<!--
							<td nowrap="nowrap"> echo $no_urut; ?></td>
							<td nowrap="nowrap"> echo $alamat_pemilik; ?></td>
							<td nowrap="nowrap"> echo $dari_lokasi; ?></td>
							<td nowrap="nowrap"> echo $ke_lokasi; ?></td>
							<td nowrap="nowrap"> echo $keterangan; ?></td>
							<td nowrap="nowrap"> echo $no_faktur_penjualan; ?></td>
							<td nowrap="nowrap"> echo $tgl_faktur_penjualan; ?></td>
							<td nowrap="nowrap"> echo $kd_cust; ?></td>
							-->
						</tr>
						<?
						$brs = $brs + 1;
				    } while ($rec = mysql_fetch_array($rs));
				?>
				</table>
				<?
			}else{
				echo "<p>Tidak ada data !</p>";
			}
	    }
		tutupDatabase($conn);
	}
}

function Form() {
	global $MySelf;
?>
	<p>
	<b>----------------------------------------<br>
	Konfirmasi Pengiriman BPKB Dari HO<br>
	----------------------------------------</b>
	</p>
	<form name="frmmenu" method="post" action="konfirm_krm_bpkb_ho.php?aksi=tampil">
		<table border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#11517F" width="600">
			<tr>
				<td width="30%">Kode Cabang</td>
				<td width="80%"><input type="text" maxlength="8" name="kd_cabang" id="kd_cabang" size="8" class="uppercase" value=""/>
				<input id="Hlov" type="button" onclick="popUp('tampilkd_pt', 'kd_cabang');" value="?" />*ALL untuk tampil semua</td>
			</tr>
			<tr>
				<td width="30%">Tanggal Pengiriman</td>
				<td width="50%"><input type="text" maxlength="10" name="tgl_krm" id="tgl_krm" size="10" class="uppercase" value=""/> Format[YYYY-MM-DD]</td>
			</tr>
			<tr>
				<td width="30%">No. Pengiriman</td>
				<td width="50%"><input type="text" maxlength="30" name="no_krm" id="no_krm" size="30" class="uppercase" value=""/></td>
			</tr>
			<tr>
				<td width="50%"><input type="submit" value="Submit" name="B1"><input type="reset" value="Reset" name="B2" /></td>
				<td width="80%" class="uang">
<?					$javascript = "javascript:changeAction('frmmenu','".$MySelf."?aksi=filter');"?>
					<input type="button" id="flush" onclick="window.location.href='<?echo $MySelf;?>';" value="Flush" />
					<input type="submit" id="filter" onclick="<?echo $javascript;?>" value="Filter" />
					<input type="hidden" id="from" name="from" />
				</td>
			</tr>
		</table>
	</form>
<?
}

function ViewTable($kdcabang, $tglkrm, $nokrm){
	global $TEXT;
	$conn = bukaDatabase();
	if($conn){
		if(strtolower($kdcabang) == "all"){
			$ssql = "Select kd_cabang, no_urut, no_sp, DATE_FORMAT(tgl_sp,'%Y-%m-%d') AS tgl_sp, no_bpkb, no_mesin, nama_pemilik, alamat_pemilik, dari_lokasi, ke_lokasi, keterangan, 
					 no_polisi, no_faktur_penjualan, DATE_FORMAT(tgl_faktur_penjualan,'%Y-%m-%d') AS tgl_faktur_penjualan, kd_qq, kd_cust, pic_trm_ho From trn_mutasi_bpkb
					 Where tgl_permintaan is not null and tgl_pengiriman is null;";
		}
		else{
			$ssql = "Select kd_cabang, no_urut, no_sp, DATE_FORMAT(tgl_sp,'%Y-%m-%d') AS tgl_sp, no_bpkb, no_mesin, nama_pemilik, alamat_pemilik, dari_lokasi, ke_lokasi, keterangan, 
					 no_polisi, no_faktur_penjualan, DATE_FORMAT(tgl_faktur_penjualan,'%Y-%m-%d') AS tgl_faktur_penjualan, kd_qq, kd_cust, pic_trm_ho From trn_mutasi_bpkb
					 Where tgl_permintaan is not null and tgl_pengiriman is null and kd_cabang = '$kdcabang';";
		}
		//echo $ssql;
		if ($rs = mysql_query($ssql)){
			if ($rec = mysql_fetch_array($rs)){ ?>
				<form name="form_konfirmasi" action="konfirm_krm_bpkb_ho.php?aksi=confirm" method="post" onsubmit="return validateChecked();">
				<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Konfirmasi Pengiriman BPKB Dari HO</b><br>
					Kode Cabang <u><? echo $kdcabang ?></u> <br>
					Tgl. Pengiriman <u><? echo $tglkrm ?></u> <br>
					No. Pengiriman <u><? echo $nokrm ?></u> <br>
				</p>
				
					<table border="0" cellspacing="2" width="85%" align="center">
						<tr align="center" bgcolor="#FFB6C1">
							<td nowrap="nowrap" width="3%"><b>No.</b></td>
							<td nowrap="nowrap" width="7%"><b>Check</b></td>	
							<td nowrap="nowrap" width="10%"><b>Kode Cabang</b></td>
							<td nowrap="nowrap" width="15%"><b>No. SP</b></td>
							<td nowrap="nowrap" width="10%"><b>Tgl. SP</b></td>
							<td nowrap="nowrap" width="20%"><b>No. BPKB</b></td>
							<td nowrap="nowrap" width="15%"><b>No. Mesin</b></td>
							<td nowrap="nowrap" width="5%"><b>Nama Pemilik</b></td>
							<td nowrap="nowrap" width="5%"><b>No. Polisi</b></td>
							<td nowrap="nowrap" width="20%"><b>Kode QQ</b></td>
							<td nowrap="nowrap" width="5%"><b>View</b></td>
							<!--
							<td nowrap="nowrap" width="5%"><b>No. Urut</b></td>
							<td nowrap="nowrap" width="15%"><b>Alamat Pemilik</b></td>
							<td nowrap="nowrap" width="10%"><b>Dari Lokasi</b></td>
							<td nowrap="nowrap" width="20%"><b>Ke Lokasi</b></td>
							<td nowrap="nowrap" width="15%"><b>Keterangan</b></td>
							<td nowrap="nowrap" width="15%"><b>No. Faktur Penjualan</b></td>
							<td nowrap="nowrap" width="10%"><b>Tgl. Faktur Penjualan</b></td>
							<td nowrap="nowrap" width="15%"><b>Kode Customer</b></td>
							-->
						</tr> <?
						$brs = 1;
						do {				
							$kd_cabang = $rec['kd_cabang'];
							$no_urut = $rec['no_urut'];
							$no_sp = $rec['no_sp'];
							$tgl_sp = $rec['tgl_sp'];
							$no_bpkb = $rec['no_bpkb'];
							$no_mesin = $rec['no_mesin'];
							$nama_pemilik = $rec['nama_pemilik'];
							$alamat_pemilik = $rec['alamat_pemilik'];
							$dari_lokasi = $rec['dari_lokasi'];
							$ke_lokasi = $rec['ke_lokasi'];
							$keterangan = $rec['keterangan'];
							$no_polisi = $rec['no_polisi'];
							$no_faktur_penjualan = $rec['no_faktur_penjualan'];
							$tgl_faktur_penjualan = $rec['tgl_faktur_penjualan'];
							$kd_qq = $rec['kd_qq'];
							$kd_cust = $rec['kd_cust'];
							if ($brs%2 == 0) { ?>
								<tr class = "genapoff" onmouseover="this.style.backgroundColor='<?echo $TEXT['hover_color'];?>';" onmouseout="this.style.backgroundColor='<?echo $TEXT['genap_color'];?>';"> <?php
							} 
							else { ?>
								<tr class = "ganjiloff" onmouseover="this.style.backgroundColor='<?echo $TEXT['hover_color'];?>';" onmouseout="this.style.backgroundColor='<?echo $TEXT['ganjil_color'];?>';"><?php
							} ?>
							<input type="hidden" name="kdcabang1" value="<? echo $kdcabang; ?>">
							<input type="hidden" name="tglkrm1" value="<? echo $tglkrm; ?>">
							<input type="hidden" name="nokrm1" value="<? echo $nokrm; ?>">
							<td nowrap="nowrap"><? echo $brs; ?></td>
							<td nowrap="nowrap"><center><input type="checkbox" name="konfirmasi[]" value="<? echo $no_bpkb; ?>"></center></td>
							<td nowrap="nowrap"><? echo $kd_cabang; ?></td>
							<td nowrap="nowrap"><? echo $no_sp; ?></td>
							<td nowrap="nowrap"><? echo $tgl_sp; ?></td>
							<td nowrap="nowrap"><? echo $no_bpkb; ?></td>
							<td nowrap="nowrap"><? echo $no_mesin; ?></td>
							<td nowrap="nowrap"><? echo $nama_pemilik; ?></td>
							<td nowrap="nowrap"><? echo $no_polisi; ?></td>
							<td nowrap="nowrap"><? echo $kd_qq; ?></td>
							<td nowrap="nowrap">
								<a target="_blank" href="<?echo $MySelf;?>?aksi=detail&nobpkb=<? echo $rec['no_bpkb']; ?>&cabang=<? echo $rec['kd_cabang']; ?>">Detail</a></td>
							<!--
							<td nowrap="nowrap"> echo $no_urut; ?></td>
							<td nowrap="nowrap"> echo $alamat_pemilik; ?></td>
							<td nowrap="nowrap"> echo $dari_lokasi; ?></td>
							<td nowrap="nowrap"> echo $ke_lokasi; ?></td>
							<td nowrap="nowrap"> echo $keterangan; ?></td>
							<td nowrap="nowrap"> echo $no_faktur_penjualan; ?></td>
							<td nowrap="nowrap"> echo $tgl_faktur_penjualan; ?></td>
							<td nowrap="nowrap"> echo $kd_cust; ?></td>
							-->
						</tr> <?php	
							$brs = $brs + 1;						
						}
						while ($rec = mysql_fetch_array($rs)); ?>
					</table>
					<table border = 0 cellspacing="0" width="30%" align="center">
						<tr>
							<td><div align="right"><input type="button" name="CheckAll" value="Check All" onClick="check(true)"></div></td>
							<td><div align="left"><input type="button" name="UnCheckAll" value="Uncheck All" onClick="check(false)"></div></td>
							<td width="85%" colspan=2><div align = "center"><input type="submit" value="Submit"></div></td>
						</tr>
					</table>
				</form>
				<?		
			} 
			else {
				echo "<p>Tidak ada Permintaan Mutasi BPKB dari SO !</p>";
			}
			tutupDatabase($conn);
		}
	}
}

function detail_Form($nobpkb, $kodecabang) {
	global $TEXT;
	$conn = bukaDatabase();
	if($conn){
		$ssql = "Select kd_cabang, no_urut, no_sp, DATE_FORMAT(tgl_sp,'%Y-%m-%d') AS tgl_sp, no_bpkb, " .
				"no_mesin, nama_pemilik, alamat_pemilik, dari_lokasi, ke_lokasi, keterangan, " . 
				"no_polisi, no_faktur_penjualan, DATE_FORMAT(tgl_faktur_penjualan,'%Y-%m-%d') AS tgl_faktur_penjualan, " .
				"kd_qq, kd_cust, pic_trm_ho From trn_mutasi_bpkb " .
				"Where kd_cabang = '$kodecabang' And no_bpkb = '$nobpkb' ;";
		//echo $ssql;
		if ($rs = mysql_query($ssql)){
			if ($rec = mysql_fetch_array($rs)){ ?>
				<form name="form_konfirmasi" action="konfirm_mnt_bpkb_ho.php?aksi=confirm" method="post" onsubmit="return validateChecked();">
				<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Detail BPKB</b><br>
					Kode Cabang <u><? echo $kodecabang ?></u> <br>
					No. BPKB <u><? echo $nobpkb ?></u> <br>
				</p>
					<table border="1" cellspacing="2" width="85%" align="center">
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Kode Cabang</b></td>
							<td nowrap="nowrap"><? echo $rec['kd_cabang']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>No. Urut</b></td>
							<td nowrap="nowrap"><? echo $rec['no_urut']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>No. SP</b></td>
							<td nowrap="nowrap"><? echo $rec['no_sp']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Tgl. SP</b></td>
							<td nowrap="nowrap"><? echo $rec['tgl_sp']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>No. BPKB</b></td>
							<td nowrap="nowrap"><? echo $rec['no_bpkb']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>No. Mesin</b></td>
							<td nowrap="nowrap"><? echo $rec['no_mesin']; ?></td>
						</tr>	
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Nama Pemilik</b></td>
							<td nowrap="nowrap"><? echo $rec['nama_pemilik']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Alamat Pemilik</b></td>
							<td nowrap="nowrap"><? echo $rec['alamat_pemilik']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Dari Lokasi</b></td>
							<td nowrap="nowrap"><? echo $rec['dari_lokasi']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Ke Lokasi</b></td>
							<td nowrap="nowrap"><? echo $rec['ke_lokasi']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Keterangan</b></td>
							<td nowrap="nowrap"><? echo $rec['keterangan']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>No. Polisi</b></td>
							<td nowrap="nowrap"><? echo $rec['no_polisi']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>No. Faktur Penjualan</b></td>
							<td nowrap="nowrap"><? echo $rec['no_faktur_penjualan']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Tgl. Faktur Penjualan</b></td>
							<td nowrap="nowrap"><? echo $rec['tgl_faktur_penjualan']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Kode QQ</b></td>
							<td nowrap="nowrap"><? echo $rec['kd_qq']; ?></td>
						</tr>
						<tr>
							<td bgcolor="#FFB6C1" nowrap="nowrap" width="15%"><b>Kode Customer</b></td>
							<td nowrap="nowrap"><? echo $rec['kd_cust']; ?></td>
						</tr>
					</table>
				</form>
				<?		
			} 
			else {
				echo "<p>Detail data BPKB tidak ditemukan !</p>";
			}
			tutupDatabase($conn);
		}
	}
}
?>