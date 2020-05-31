<?php
	class Teams {

		function __construct($id, $name){
			$this->id=$id;
			$this->name=$name;
		}

		function getID(){
			return $this->id;
		}

		function getName(){
			return $this->name;
		}
	}
?>