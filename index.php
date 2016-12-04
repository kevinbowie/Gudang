<?php
include_once 'dbconfig.php';
if(!isset($_SESSION['user']) == 0){
	header('Location: menu.php');
}
if(isset($_POST['login'])){
	$user = $_POST['username'];
	$password = $_POST['password'];
	if($lib->login($user, $password)){
		header("location: menu.php");
	}
	else{
		$msg = "<div class='alert alert-warning'>
					<strong>USERNAME DAN PASSWORD TIDAK TEPAT</strong>
				</div>";
	}
}
else{
	$msg = '';
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>WELCOME</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" > 
	<link href="bootstrap/css/main.css" rel="stylesheet" > 

</head>
<body>
	<h1>WELCOME</h1>
	<h2>Please Login</h2>
	<form method="post">
		<div class="user">Username</div>
		<input type="text" name="username" placeholder="username" required>
		<br>
		<div class="password">Password</div>
		<input type="password" name="password" placeholder="******" required>
		<input type="submit" name="login" value="login">
	</form>
	<?php echo $msg; ?>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>