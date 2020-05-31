<?php
	include('../model/products.php');

	class ProductsController {

		private $table="products";

		function __construct($host, $user, $pass, $port, $database){
			$this->db = new DB($host, $user, $pass, $port, $database);
		}

		function getAllProducts(){
			$this->db->open();
			$query = "select * from $this->table";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
                $id=$data['id'];
                $name=$data['name'];
				$products = new Products($id, $name);
				array_push($list, $products);
			}
			return $list;
		}
		
		function addProducts($name){
			$this->db->open();
			$query = "insert into $this->table (name) VALUES ('$name')";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function checkName($name){
			$this->db->open();
			$query = "select * from $this->table where name = '$name'";
			$result = $this->db->query($query);
			$this->db->close();
			$row = mysqli_num_rows($result);
			if ($row > 0){
				return true;
			} else {
				return false;
			}
		}

		function updateProducts($id, $name){
			$this->db->open();
			$query = "update $this->table set name = '$name' where id = '$id'";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function delProducts($id){
			$this->db->open();
			$query = "delete from $this->table where id = $id";
			$result = $this->db->query($query);
			$this->db->close();
		}
    }
?>