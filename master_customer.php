<?php
include_once 'dbconfig.php';
$me = $_SERVER['PHP_SELF'];
if(isset($_POST['btn-save'])){
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$handphone = $_POST['handphone'];

	if($lib->newCust($id, $nama, $alamat, $handphone)){
		header("Location: master_customer.php?success");
	}
	else{
		header("Location: master_customer.php?failure");
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>CUSTOMER</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" > 
	<link href="bootstrap/css/main.css" rel="stylesheet" > 
</head>
<body>
	<?php
	if(isset($_GET['success'])){
		?>
		<div class="container">
			<div class="alert alert-info">
				<strong>CUSTOMER BERHASIL DITAMBAHKAN</strong>
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
	<div class="clearfix"></div><br>
	<h1>CUSTOMERS</h1>
	<form method="post">
		<table class='table table-bordered'>
			<tr>
				<td>ID</td>
				<td><input type="text" name="id" class='form-control' required></td>
			</tr>
			<tr>
				<td>NAMA</td>
				<td><input type="text" name="nama" class="form-control" required="true"></td>
			</tr>
			<tr>
				<td>ALAMAT</td>
				<td><input type="text" name="alamat" class="form-control" required="true"></td>
			</tr>
			<tr>
				<td>HANDPHONE</td>
				<td><input type="text" name="handphone" class="form-control" required="true"></td>
			</tr>
		</table>
		<button class="btn-primary btn" type="submit" name="btn-save">ADD</button>
	</form>
</body>
</html>