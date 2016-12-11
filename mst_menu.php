<?
session_start();
$dir="../";
$MySelf = basename($_SERVER['PHP_SELF']);
include($dir."library.php");
include($dir."find_lib.php");
include(str_replace(".php","",$MySelf)."_lib.php");
if (periksalogin($_SESSION['username'],$_SESSION['password']) != 0 && (cekHakAkses($_SESSION['id_group'],'0000110') != 0)){
	pageheader("PT. Capella Dinamik Nusantara - Data Menu",$dir);
	lov($dir);
	if (!isset($_GET['aksi'])){
		tambah_Form();
		tampil();
	}else{
		if($_GET['aksi']=="addsave"){
			tambah_Save($_POST['menu'],$_POST['kd_group_menu'],$_POST['keterangan'],$_POST['link'],$_SESSION['username']);
		}else if ($_GET['aksi']=="edit"){
			perbaiki_Form($_GET['id']); 
		}else if($_GET['aksi']=="editsave"){
			perbaiki_Save($_GET['id'],$_POST['kd_group_menu'],$_POST['keterangan'],$_POST['link'],$_SESSION['username']);
		}else if($_GET['aksi']=="delete"){
			hapus_Confirm($_GET['id']); 
		}else if($_GET['aksi']=="deleteconfirmed"){
			hapus_Confirmed($_GET['id']);
		}else if($_GET['aksi']=="filter"){
			unset($fa);
			$menu = isset($_POST['menu'])?$_POST['menu']:"";
			$kd_group_menu = isset($_POST['kd_group_menu'])?$_POST['kd_group_menu']:"";
			$keterangan = isset($_POST['keterangan'])?$_POST['keterangan']:"";
			$link = isset($_POST['link'])?$_POST['link']:"";
			$from = isset($_POST['from'])?$_POST['from']:"0";
			$from = ($from=="")?"0":$from;
			$fa = array("menu" => $menu,"kd_group_menu" => $kd_group_menu,"keterangan"=>$keterangan,"link"=>$link);
			Form($menu, $kd_group_menu, $keterangan, $link, "?aksi=addsave");
			tampil(true,$fa,$from);
		}
	}
	pagefooter($dir);
}else{
	header ("Location: ".$dir."index.php");
}
return 0;

function fillValue($menu, $kd_group_menu, $keterangan, $link, $param){
?>
<script type="text/javascript">
<!--
<?if (contains("add",$param)){?>
document.getElementById('menu').value="<? echo $menu;?>";
<?}?>
document.getElementById('kd_group_menu').value="<? echo $kd_group_menu;?>";
document.getElementById('keterangan').value="<? echo $keterangan;?>";
document.getElementById('link').value="<? echo $link;?>";
document.getElementById('from').value="<? echo isset($_POST['from'])?$_POST['from']:"0";?>";
//-->
</script>
<?
}

function validateForm($state){
	global $MySelf;
?>
<script type="text/javascript">
<!--
function validateForm(form) {
	if (Right(form.action,frm_action.length)==frm_action){
		return true;
	}
	<? if ($state == "new"){?>
	if ((form.menu.value==null)||(form.menu.value=="")){
	   alert("Menu tidak boleh kosong !");
	   form.menu.focus();
	   return false;
	}else if ((form.kd_group_menu.value==null)||(form.kd_group_menu.value=="")){
	   alert("Kode Group Menu tidak boleh kosong !");
	   form.kd_group_menu.focus();
	   return false;
	<?}else{?>
	if ((form.kd_group_menu.value==null)||(form.kd_group_menu.value=="")){
	   alert("Kode Group Menu tidak boleh kosong !");
	   form.kd_group_menu.focus();
	   return false;
	<?}?>
	}else if ((form.keterangan.value==null)||(form.keterangan.value=="")){
	   alert("Keterangan tidak boleh kosong !");
	   form.keterangan.focus();
	   return false;
	}else if ((form.link.value==null)||(form.link.value=="")){
	   alert("Link tidak boleh kosong !");
	   form.link.focus();
	   return false;
	}else{
	   return true;
	}
}
//-->
</script>
<?
}

function tampil($filter=false,$fa=array(),$from=0){
	global $TEXT, $MySelf;
	$conn = bukaDatabase();
	if($conn){
		if($filter){
			$filter = getFilter($fa);
			$ssql = "Select menu, keterangan, link, kd_group_menu From mst_menu ".$filter."Order By menu Limit %from, %perpage;";
			$ssql2 = "Select Count(*) From mst_menu ".$filter.";";
		}else{
			$ssql = "Select menu, keterangan, link, kd_group_menu From mst_menu Order By menu Limit %from, %perpage;";
			$ssql2 = "Select Count(*) From mst_menu ;";
		}
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
					    <td nowrap="nowrap" width="10%">No</td>
					    <td nowrap="nowrap" width="10%">Menu</td>
					    <td nowrap="nowrap" width="10%">Kode Group Menu</td>
					    <td nowrap="nowrap" width="10%">Keterangan</td>
					    <td nowrap="nowrap" width="10%">Link</td>
					    <td nowrap="nowrap" width="5%">Edit</td>
					    <td nowrap="nowrap" width="5%">Delete</td>
				    </tr>
					<?
				    $brs = $from+1;
				    do {
						if ($brs%2 == 0){
							?><tr class = "genapoff" onmouseover="this.style.backgroundColor='<?echo $TEXT['hover_color'];?>';" onmouseout="this.style.backgroundColor='<?echo $TEXT['genap_color'];?>';"><?
						}else{
							?><tr class = "ganjiloff" onmouseover="this.style.backgroundColor='<?echo $TEXT['hover_color'];?>';" onmouseout="this.style.backgroundColor='<?echo $TEXT['ganjil_color'];?>';"><?
					    }
						?>
							<td nowrap="nowrap"><? echo $brs; ?></td>
							<td nowrap="nowrap"><? echo $rec['menu']; ?></td>
							<td nowrap="nowrap"><? echo $rec['kd_group_menu']; ?></td>
							<td nowrap="nowrap"><? echo $rec['keterangan']; ?></td>
							<td nowrap="nowrap"><? echo $rec['link']; ?></td>
							<td nowrap="nowrap">
								<a href="<?echo $MySelf;?>?aksi=edit&id=<? echo $rec['menu']; ?>">edit</a></td>
							<td nowrap="nowrap">
								<a href="<?echo $MySelf;?>?aksi=delete&id=<? echo $rec['menu']; ?>">delete</a></td>
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

function Form($id, $kd_group_menu, $keterangan, $link, $param){
	global $TEXT, $MySelf;
	$tmpRet = "";
	$judul = "";
	if (contains("edit",$param)) {
		validateForm("edit");
		$tmpRet = "validateForm";
		$judul = "Perbaiki Data Menu";
	}else if (contains("delete",$param)) {
		$tmpRet = "";
		$judul = "Anda yakin hapus data";
	}else{
		validateForm("new");
		$tmpRet = "validateForm";
		$judul = "Tambah Data Menu";
	}
	?>
	<br />
	<br />
	<?
	if ($tmpRet == ""){
		?><form name="frmmenu" id="frmmenu" method="post" action="<?echo $MySelf.$param; ?>"><?
	}else{
		?><form name="frmmenu" id="frmmenu" method="post" action="<?echo $MySelf.$param; ?>" onsubmit="return <? echo $tmpRet; ?>(this);"><?
	}
	?>
		<table width="500" border="1" align="center" cellpadding="2" cellspacing="0">
			<tr align="left" bgcolor="<?echo $TEXT['tr_def_color'];?>">
				<td><b><? echo $judul; ?></b></td>
			</tr>
		</table>
		<table width="500" border="1" cellpadding="2" align="center">
			<tr>
				<td width="30%">Menu</td>
				<td width="5%" align="center">:</td>
				<td>
				<?	if ((contains("edit",$param))||(contains("delete",$param))) {
						echo $id;
					}else{
						?><input type="text" maxlength="10" size="10" name="menu" id="menu" value="" class="uppercase" /><?
					}
				?>
				<b><font color="red">*</font></b></td>
			</tr>
			<tr>
				<td>Kode Group Menu</td>
				<td align="center">:</td>
				<td>
				<?if (contains("delete",$param)) {
						echo $kd_group_menu;
					}else{
						?><input type="text" maxlength="10" size="10" name="kd_group_menu" id="kd_group_menu" value="" class="uppercase" />
						  <input id="Hlov" type="button" onclick="popUp('tampilGroupMenu', 'kd_group_menu');" value="?" /><?
					}
				?>
				<b><font color="red">*</font></b></td>	
			</tr>
			<tr>
				<td>Keterangan</td>
				<td align="center">:</td>
				<td>
				<?if (contains("delete",$param)) {
						echo $keterangan;
					}else{
						?><input type="text" maxlength="100" size="35" name="keterangan" id="keterangan" value="" class="uppercase" /><?
					}
				?>
				<b><font color="red">*</font></b></td>
			</tr>
			<tr>
				<td>Link</td>
				<td align="center">:</td>
				<td>
				<?if (contains("delete",$param)) {
						echo $link;
					}else{
						?><input type="text" maxlength="100" size="35" name="link" id="link" value="" class="uppercase" /><?
					}
				?>
				<b><font color="red">*</font></b></td>	
			</tr>
			<tr>
				<td align="right" colspan="2">
					<?$javascript = "javascript:changeAction('frmmenu','".$MySelf.$param."');";?>
					<input type="submit" name="submit" onclick="<?echo $javascript;?>" value="Submit" />
					<?if (!contains("delete",$param)) {?>
						<input type="reset" name="reset" value="Reset" />
					<?}?>
				</td>
				<td class="uang">
					<?if (contains("add",$param)){
						$javascript = "javascript:changeAction('frmmenu','".$MySelf."?aksi=filter');";?>
						<input type="button" id="flush" onclick="window.location.href='<?echo $MySelf;?>';" value="Flush" />
						<input type="submit" id="filter" onclick="<?echo $javascript;?>" value="Filter" />
						<input type="hidden" id="from" name="from" />
					<?}else{?>
						&nbsp;
					<?}?>
				</td>
			</tr>
		</table>
		<p>
		<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
			<td align="left"><b><font color="red" size="0.5px">(*) = Wajib Di isi</font></b></td>
		</table>
	</form>
	<?
	fillValue($id, $kd_group_menu, $keterangan, $link, $param);
}

function tambah_Form(){
	$id = "";
	$keterangan = "";
	$link = "";
	$kd_group_menu = "";
	Form($id, $kd_group_menu, $keterangan, $link, "?aksi=addsave");
}

function tambah_Save($menu, $kd_group_menu, $keterangan, $link, $username){
	global $MySelf;
	$cancel = before_Update("new",strtoupper($menu),strtoupper($kd_group_menu),strtoupper($keterangan),$link,strtoupper($username));
	if(!$cancel){
		$result = add(strtoupper($menu),strtoupper($kd_group_menu),strtoupper($keterangan),$link,strtoupper($username));
		if ($result==0){
			echo "<p>Berhasil simpan !</p>";
		}else if ($result==1){
			echo "<p>Gagal simpan, Menu telah ada !</p>";
			Form($menu, $kd_group_menu, $keterangan, $link, "?aksi=addsave");
		}else{
			echo "<p>Gagal simpan, proses gagal !</p>";
		}
	}else{
		Form($menu, $kd_group_menu, $keterangan, $link, "?aksi=addsave");
	}
	echo "<p><a href='$MySelf'>Klik untuk kembali !</a></p>";
}

function perbaiki_Form($id){
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select keterangan, link, kd_group_menu From mst_menu Where menu = '$id';";
		if ($rs = mysql_query($ssql)){
			if ($rec = mysql_fetch_array($rs)){
				$keterangan = $rec['keterangan'];
				$link = $rec['link'];
				$kd_group_menu = $rec['kd_group_menu'];
				Form($id, $kd_group_menu, $keterangan, $link, "?aksi=editsave&id=".$id);
			}else{
				echo "<p>Tidak ada data !</p>";
			}
		}
		tutupDatabase($conn);
	}
}

function perbaiki_Save($id, $kd_group_menu, $keterangan, $link, $username){
	global $MySelf;
	$cancel = before_Update("edit",strtoupper($id),strtoupper($kd_group_menu),strtoupper($keterangan),$link,strtoupper($username));
	if(!$cancel){
		$result = edit($id,strtoupper($kd_group_menu),strtoupper($keterangan),$link,strtoupper($username));
		if ($result > 0){
			echo "<p>Berhasil simpan !</p>";
		}else{
			echo "<p>Gagal simpan, atau tidak ada perubahan data !</p>";
		}
	}else{
		Form($id, $kd_group_menu, $keterangan, $link, "?aksi=editsave&id=".$id);
	}
	echo "<p><a href='$MySelf'>Klik untuk kembali !</a></p>";
}

function hapus_Confirm($id){
	$conn=bukaDatabase();
	if($conn){
		$ssql = "Select keterangan, link, kd_group_menu From mst_menu Where menu = '$id';";
		if ($rs = mysql_query($ssql)){
			if ($rec = mysql_fetch_array($rs)){
				$kd_group_menu = $rec['kd_group_menu'];
		        $keterangan = $rec['keterangan'];
				$link = $rec['link'];
				Form($id, $kd_group_menu, $keterangan, $link, "?aksi=deleteconfirmed&id=".$id);
			}else{
				echo "<p>Tidak ada data !</p>";
			}
	    }
		tutupDatabase($conn);
	}
}

function hapus_Confirmed($id){
	global $MySelf;
	$cancel = before_Delete($id);
	if(!$cancel){
		$result = hapus($id);
		if ($result > 0){
			echo "<p>Berhasil hapus !</p>";
		}else{
			echo "<p>Gagal hapus data !</p>";
		}
	}
	echo "<p><a href='$MySelf'>Klik untuk kembali !</a></p>";
}
?>
