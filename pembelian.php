<?php
include_once 'dbconfig.php';

if(isset($_POST['add'])){
	for($i=0; $i<count($_POST['id']); $i++){
		if($lib->pembelian($_POST['jenis'], $_POST['id'][$i], $_POST['nama'][$i], $_POST['qty'][$i])){
			header("Location: pembelian.php?success");
		}
		else{
			header("Location: pembelian.php?failure");
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PEMBELIAN</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" > 
	<link href="bootstrap/css/main.css" rel="stylesheet" > 
</head>
<body onload="reset()"> 
	<?php
	if(isset($_GET['success'])){
		?>
		<div class="container">
			<div class="alert alert-info">
				<strong>TRANSAKSI BERHASIL DITAMBAHKAN</strong>
			</div>
		</div>
		<?php
	}
	else if(isset($_GET['failure'])){
		?>
		<div class="container">
			<div class="alert alert-warning">
			<strong>ERROR! RECORD GAGAL DISIMPAN!</strong>
			</div>
		</div>
		<?php
	}
	?>
<form id="myForm" method="post">
	<input type="reset" name="reset" onclick="reset()" value="resset"><br>
	<input type="radio" name="jenis" value="plus" checked="true">Tambah Stok<br>
	<input type="radio" name="jenis" value="minus">Kurang Stok<br>
		<table class='table table-bordered' id = 'myTable'>
			<thead>
				<tr>		
					<th>No.</th>
					<th>ID Barang</th>
					<th>Nama Barang</th>
					<th>Qty</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1.</td>
					<td>
						<input type="text" name="id[]" class="id">
						<input type="button" name="lov" onclick="popUp('lov_barang', 'id');" value="?">
					</td>
					<td><input type="text" name="nama[]" class="nama"></td>
					<td><input type="text" name="qty[]" class="qty" onkeypress="inputEnter(event);"></td>
				</tr>
			</tbody>
		</table>	
	<input class="btn-primary btn" type="submit" name="add" value="add" id="tambah">
	
	<script type="text/javascript">
		function popUp(lov, id){
			//$url = $dir + 'lov.php?lov=' + $lov + '&id=' + $id + '&from=0';
			w = window.open('lov.php', "r");
			if (w.opener == null) 
				w.opener = self;
			w.focus();
			}


		function reset(){
			var nama = document.getElementById('myForm').reset();
		}

		function inputEnter(e){
			//if(e.which==13||e.keycode=13){
				newRow();
			//}
		}

		function newRow(){
			var table = document.getElementById('myTable'),
				tr_count = table.rows.length,
				x = document.getElementsByClassName('qty')[tr_count-2];
			if (document.activeElement === x){
				var row = table.insertRow(tr_count),
					no = row.insertCell(0),
					id = row.insertCell(1),
					nama = row.insertCell(2),
					qty = row.insertCell(3);
				no.innerHTML = "<td>"+tr_count+"."+"</td>";
				id.innerHTML = "<input type='text' name='id[]' class='id'>";
				id.innerHTML = id.innerHTML + "<input type='button' name='lov' onclick=\"popUp('lov_barang', 'id')\" value='?'>";
				nama.innerHTML = "<td><input type='text' name='nama[]' class='nama'></td>";
				qty.innerHTML = "<td><input type='text' name='qty[]' class='qty' onkeypress='inputEnter(event)'></td>";
			}
		}

			// function addRow(){
			// 	var template = document.querySelector('#rowTemplate'),
			// 		tbl = document.querySelector('#myTable'),
			// 		tbody = document.querySelector('tbody'),
			// 	    td_slNo = template.content.querySelectorAll("td")[0],
			// 	    tr_count = tbl.rows.length;
			// 	td_slNo.textContent = tr_count + ".";
			// 	var clone = document.importNode(template.content, true);
			//   	tbody.appendChild(clone);
			// }
	</script>
		<!-- <template id="rowTemplate">
			<tr>
				<td></td>
				<td><input type="text" name="nama"></td>
				<td><input type="number" name="qty"></td>
			</tr>
		</template> -->
</form>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>