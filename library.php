<?php
class lib{
	private $db;
	function __construct($con){
		$this->db = $con;
	}

	public function newCust($id, $nama, $alamat, $handphone){
		try{
			$sql = $this->db->prepare("INSERT INTO mst_customers(id, nama, alamat, handphone) VALUES(:id, :nama, :alamat, :handphone)");
			$sql->bindparam(":id", $id);
			$sql->bindparam(":nama", $nama);
			$sql->bindparam(":alamat", $alamat);
			$sql->bindparam(":handphone", $handphone);
			$sql->execute();
			return true;
		}
		catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}
	
	public function newItems($id, $nama, $qty){
		try{
			$sql = $this->db->prepare("INSERT INTO mst_items(id, nama_barang, HPP, HET) VALUES(:id, :nama, :HPP, :HET)");
			$sql->bindparam(":id", $id);
			$sql->bindparam(":nama", $nama);
			$sql->bindparam(":HPP", $HPP);
			$sql->bindparam(":HET", $HET);
			$sql->execute();
			return true;
		}
		catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}

	public function login($user, $password){
		try{
			$sql = $this->db->prepare("SELECT * FROM operator WHERE user = :user AND password = :password");
			$sql->bindparam(':user', $user);
			$sql->bindparam(':password', $password);
			$sql->execute();
			$row = $sql->rowCount();
			if ($row == 1){
				$_SESSION['user'] = $user;
				return true;
			}
			else{
				return false;
			}
		}
		catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}

	public function pembelian($nama, $qty){
		try{
			$sql = $this->db->prepare("INSERT INTO pembelian (nama, qty) VALUES (:nama, :qty)");
			$sql->bindparam(':nama', $nama);
			$sql->bindparam(':qty', $qty);
			$sql->execute();
			return true;
		}
		catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}
}
?>