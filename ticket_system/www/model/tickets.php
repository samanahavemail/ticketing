<?php
	class Tickets {

		function __construct($id, $date, $description, $requester, $tel, $status, $topic, $product_id, $category_id, $team_id){
            $this->id=$id;
            $this->date=$date;
            $this->description=$description;
            $this->requester=$requester;
            $this->tel=$tel;
            $this->status=$status;
            $this->topic=$topic;
            $this->product_id=$product_id;
            $this->category_id=$category_id;
            $this->team_id=$team_id;
		}

		function getID(){
			return $this->id;
        }
        
        function getDate(){
			return $this->date;
        }

        function getDescription(){
            return $this->description;
        }
        
        function getRequester(){
			return $this->requester;
        }
        
        function getTel(){
			return $this->tel;
        }
        
        function getStatus(){
			return $this->status;
        }
        
        function getTopic(){
			return $this->topic;
        }
        
        function getProductID(){
			return $this->product_id;
        }
        
        function getCategoryID(){
			return $this->category_id;
        }
        
        function getTeamID(){
			return $this->team_id;
		}
	}
?>