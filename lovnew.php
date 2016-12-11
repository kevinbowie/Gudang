<?
session_start();
include("library.php");
if (periksalogin($_SESSION['username'],$_SESSION['password']) != 0){
	?>
	<script type="text/javascript">
	<!--
	function passBack(id, passVal){
		opener.document.getElementById(id).value = passVal;
		opener.document.getElementById(id).focus();
		close();
	}
	function applyFilter(url){
		var field = document.getElementById("field").value;
		var fieldvalue = document.getElementById("fieldvalue").value;
		var targeturl;
		if ((fieldvalue==null)||(fieldvalue=="")){
			targeturl = url + "0";
		}else{
			targeturl = url + field + " like " + "'~" + fieldvalue + "~'";
		}
		location.href=targeturl;
	}
	//-->
	</script>
	<?
	//http://localhost/lov.php?lov=tampilrelasi&id=$id&from=0
	$perpage = 15;

	if (!isset($_GET['lov']) or !isset($_GET['id']) or !isset($_GET['from'])){
		echo 'invalid parameter !';
		exit;
	}

	$param = $_GET['lov'];
	$id    = $_GET['id'];
	$from  = $_GET['from'];
	
	if (isset($_GET['filter'])){
		$filter = $_GET['filter'];
		$filter = str_replace("\'~","'%",$filter);
		$filter = str_replace("~\'","%'",$filter);
	}else{
		$filter = "0";
	}
	//echo $filter;
	$fltr = explode("%",$filter);
	//print_r($fltr);
	//echo $param.'<br />';
	if ($param=="tampilkd_pt"){
		$title = "LOV Kode PT Cabang";
		$ssql1 = "Select kodept, kd_dept, kd_intern From mst_operator Where (not kodept is null or kodept != '') and kodept <> 'ACC' and not kodept like 'CSC%' %filter Order By kodept Limit %from, %perpage;";
		$ssql2 = "Select Count(*) From mst_operator Where (not kodept is null or kodept != '') and kodept <> 'ACC' and not kodept like 'CSC%' %filter;";
		$num  = 3;
		$th   = '<td width="100" nowrap="nowrap"><b>Kode PT / SO</b></td><td width="100" nowrap="nowrap"><b>Kode Dept / SO</b></td><td width="100" nowrap="nowrap"><b>Kode Intern</b></td>';
		$tr   = '<td scope="row"><a href="javascript:passBack(%id,%passValue);">%0</a></td><td>%1</td><td>%2</td>';
		$ff   = "Kode PT;Kode Dept / SO;Kode Intern";
		$fl   = "kodept;kd_dept;kd_intern";
	}

	if ($filter == "0"){
		$ssql1 = str_replace("%filter","",$ssql1);
		$ssql2 = str_replace("%filter","",$ssql2);
	}else{
		$ssql1 = str_replace("%filter","and ". $filter,$ssql1);
		$ssql2 = str_replace("%filter","and ". $filter,$ssql2);
	}
	
	$ssql1 = str_replace("%from",$from,$ssql1);
	$ssql1 = str_replace("%perpage",$perpage,$ssql1);
	//echo $ssql1.'<br />'.$ssql2;
	echo '<html><title>'.$title.'</title>';
	echo "<body>";

	$conn= BukaDatabase();

	$record = $from + 1;
	$maxrec = 0;
	if ($rs2 = mysql_query($ssql2)){
		if ($rec2 = mysql_fetch_row($rs2)){
			$maxrec = $rec2[0];
		}
	}
	echo "<p>From Record / Max Record : $record / $maxrec</p>";
	$col = explode(";", $ff);
	$colx = explode(";", $fl);

	echo '<p>Filter by : <select id="field" >';

	for($i=0;$i<count($col);$i++){
		if($i==0)
			echo '<option value="'.$colx[$i].'" selected>'.$col[$i].'</option>';
		else
			echo '<option value="'.$colx[$i].'">'.$col[$i].'</option>';
	}
	echo '</select>';
	echo $filter=="0"?' LIKE <input id="fieldvalue" value="">':' LIKE <input id="fieldvalue" value="'.$fltr[1].'">';
	$javascript = "javascript:applyFilter('lov.php?lov=".$param."&id=".$id."&from=0&filter=');";
	echo '<input id="lovfilter" type="button" onclick="'.$javascript.'" value="Go" />';
	echo "<br /><br />";
	navigator($from,$maxrec,$perpage,$param,$id,$filter);
	echo "<table border='0' cellspacing='2' align='center'>";
	echo "<thead><tr bgcolor=".$TEXT['tr_dtl_color'].">" . $th . "</tr></thead>";
	echo "<tbody>";

	if ($rs = mysql_query($ssql1)){
		$brs = 1;
		while ($rec = mysql_fetch_row($rs)){
			$temp = $tr;
			if ($brs%2 == 0){
				?><tr class = "genapoff" onmouseover="this.style.backgroundColor='<?echo $TEXT['hover_color'];?>';" onmouseout="this.style.backgroundColor='<?echo $TEXT['genap_color'];?>';"> <?
			}else{ 
				?><tr class = "ganjiloff" onmouseover="this.style.backgroundColor='<?echo $TEXT['hover_color'];?>';" onmouseout="this.style.backgroundColor='<?echo $TEXT['ganjil_color'];?>';"> <?
			}
			//echo "<tr>";
			for ($col=0; $col < $num; $col++){
				if ($col == 0){
					$temp = str_replace("%id","'".$id."'", $temp);
					$temp = str_replace("%passValue","'".$rec[0]."'", $temp);
				}
				$search = "%".$col;
	            $temp = str_replace($search,$rec[$col], $temp);
			}
			echo $temp;
			echo "</tr>";
			$brs = $brs + 1;
		}
	}

	echo "</tbody>";
	echo "</table>";

	navigator($from,$maxrec,$perpage,$param,$id,$filter);

	TutupDatabase($conn);

	echo "</body>";
	echo "</html>";
}else{
	echo "<font color='red'><h1>Maaf, Anda belum Login</h1></font>";
}

function navigator($from,$maxrec,$perpage,$param,$id,$filter){
	$maxrec--;
	$filter = str_replace("'%","'~",$filter);
	$filter = str_replace("%'","~'",$filter);
	echo '<p align = "center">';
	echo '&nbsp;<a href="lov.php?lov='.$param.'&id='.$id.'&from=0&filter='.$filter.'"><< First</a>     ';

	$prev = ($from - $perpage);
	if ($prev >= 0){
		echo '&nbsp;<a href="lov.php?lov='.$param.'&id='.$id.'&from='.$prev.'&filter='.$filter.'">Prev</a>     ';
	}else{
		echo "&nbsp;Prev     ";
	}

	$next = ($from + $perpage);
	if ($next <= $maxrec){
		echo '&nbsp;<a href="lov.php?lov='.$param.'&id='.$id.'&from='.$next.'&filter='.$filter.'">Next</a>     ';
	}else{
		echo "&nbsp;Next     ";
	}  

	//$last = $maxrec % $perpage;
	//$pbg = ceil($maxrec / $perpage);
	$last = $maxrec - ($maxrec % $perpage);
	if($from != $last){
		if ($last < 0) $last = 0;
		echo '&nbsp;<a href="lov.php?lov='.$param.'&id='.$id.'&from='.$last.'&filter='.$filter.'">Last >></a>';
	}else{
		echo "&nbsp;Last>>     ";
	}
	echo "</p>";
}
?>