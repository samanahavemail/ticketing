<?php
	class Categories {

		function __construct($id, $name, $product_id){
			$this->id=$id;
            $this->name=$name;
            $this->product_id=$product_id;
		}

		function getID(){
			return $this->id;
		}

		function getName(){
			return $this->name;
        }
        
        function getProductID(){
            return $this->product_id;
        }
	}
?>