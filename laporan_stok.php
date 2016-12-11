<?php
include_once 'dbconfig.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>LAPORAN STOK</title>
</head>
<body>
<table border="0" cellspacing="2" width="60%" align="center">
	<tr align="center">
	    <td nowrap="nowrap" width="10%">No</td>
	    <td nowrap="nowrap" width="10%">Id</td>
	    <td nowrap="nowrap" width="10%">Nama Barang</td>
	    <td nowrap="nowrap" width="10%">Qty</td>
	</tr>
	<?php
	tampil();
	?>
</table>
</body>
</html>