<?php
	include('../model/categories.php');

	class CategoriesController {

		private $table="categories";

		function __construct($host, $user, $pass, $port, $database){
			$this->db = new DB($host, $user, $pass, $port, $database);
		}

		function getAllCategories(){
			$this->db->open();
			$query = "select * from $this->table";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
                $id=$data['id'];
                $name=$data['name'];
                $product_id=$data['product_id'];
				$categories = new Categories($id, $name, $product_id);
				array_push($list, $categories);
			}
			return $list;
		}
		
		function getAllCategoriesWithProductID($product_id){
			$this->db->open();
			$query = "select * from $this->table where product_id = $product_id";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
                $id=$data['id'];
                $name=$data['name'];
                $product_id=$data['product_id'];
				$categories = new Categories($id, $name, $product_id);
				array_push($list, $categories);
			}
			return $list;
		}
		
		function checkNameWithProductID($name,$product_id){
			$this->db->open();
			$query = "select * from $this->table where name = '$name' and product_id = $product_id";
			$result = $this->db->query($query);
			$this->db->close();
			$row = mysqli_num_rows($result);
			if ($row > 0){
				return true;
			} else {
				return false;
			}
		}

		function addCategoriesWithProductID($name,$product_id){
			$this->db->open();
			$query = "insert into $this->table (name, product_id) VALUES ('$name',$product_id)";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function updateCategoriesWithProductID($id, $name, $product_id){
			$this->db->open();
			$query = "update $this->table set name = '$name' where id = '$id' and product_id = $product_id";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function delCategories($id){
			$this->db->open();
			$query = "delete from $this->table where id = $id";
			$result = $this->db->query($query);
			$this->db->close();
		}
    }
?>