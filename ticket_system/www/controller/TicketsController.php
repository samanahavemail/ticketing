<?php
	include('../model/tickets.php');

	class TicketsController {

		private $table="tickets";

		function __construct($host, $user, $pass, $port, $database){
			$this->db = new DB($host, $user, $pass, $port, $database);
		}

		function getAllTickets(){
			$this->db->open();
			$query = "select * from $this->table";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
                $id=$data['id'];
                $date=$data['date'];
                $description=$data['description'];
                $requester=$data['requester'];
                $tel=$data['tel'];
                $status=$data['status'];
                $topic=$data['topic'];
                $product_id=$data['product_id'];
                $category_id=$data['category_id'];
                $team_id=$data['team_id'];
				$tickets = new Tickets($id, $date, $description, $requester, $tel, $status, $topic, $product_id, $category_id, $team_id);
				array_push($list, $tickets);
			}
			return $list;
		}

		function getReports($start_date,$end_date){
			$this->db->open();
			$query = "";
			$query = $query."select products.name as pname,IFNULL(categories.name,'new ticket') as cname,IFNULL(sopen.count,0) as open,IFNULL(sprogress.count,0)  as progress,IFNULL(sclose.count,0) as close ";
			$query = $query."from tickets ";
			$query = $query."left join products ";
			$query = $query."on tickets.product_id = products.id ";
			$query = $query."left join categories ";
			$query = $query."on tickets.category_id = categories.id ";
			$query = $query."left join (select product_id,category_id,count(*) as count from tickets where status = 'open' group by product_id,category_id) as sopen ";
			$query = $query."on tickets.product_id = sopen.product_id and (tickets.category_id = sopen.category_id or sopen.category_id = 0) ";
			$query = $query."left join (select product_id,category_id,count(*) as count from tickets where status = 'progress' group by product_id,category_id) as sprogress ";
			$query = $query."on tickets.product_id = sprogress.product_id and (tickets.category_id = sprogress.category_id or sprogress.category_id = 0) ";
			$query = $query."left join (select product_id,category_id,count(*) as count from tickets where status = 'close' group by product_id,category_id) as sclose ";
			$query = $query."on tickets.product_id = sclose.product_id and (tickets.category_id = sclose.category_id or sclose.category_id = 0) ";
			$query = $query."where tickets.date >= '$start_date' and tickets.date <= '$end_date' ";
			$query = $query."group by tickets.product_id,tickets.category_id ";
			$query = $query."order by products.name,categories.name ";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
				array_push($list, $data);
			}
			return $list;
		}

		function findTickets($requester){
			$this->db->open();
			$query = "select * from $this->table where requester = '$requester' or tel = '$requester'";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
                $id=$data['id'];
                $date=$data['date'];
                $description=$data['description'];
                $requester=$data['requester'];
                $tel=$data['tel'];
                $status=$data['status'];
                $topic=$data['topic'];
                $product_id=$data['product_id'];
                $category_id=$data['category_id'];
                $team_id=$data['team_id'];
				$tickets = new Tickets($id, $date, $description, $requester, $tel, $status, $topic, $product_id, $category_id, $team_id);
				array_push($list, $tickets);
			}
			return $list;
		}
		
		function addTickets($topic,$product_id,$requester,$tel,$status,$date){
			$this->db->open();
			$query = "insert into $this->table (topic,requester,tel,product_id,status,date) VALUES ('$topic','$requester','$tel',$product_id,'$status','$date')";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function getByStatus($status){
			$this->db->open();
			$query = "select * from $this->table where status = '$status'";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
                $id=$data['id'];
                $date=$data['date'];
                $description=$data['description'];
                $requester=$data['requester'];
                $tel=$data['tel'];
                $status=$data['status'];
                $topic=$data['topic'];
                $product_id=$data['product_id'];
                $category_id=$data['category_id'];
                $team_id=$data['team_id'];
				$tickets = new Tickets($id, $date, $description, $requester, $tel, $status, $topic, $product_id, $category_id, $team_id);
				array_push($list, $tickets);
			}
			return $list;
		}

		function getByStatusAndTeamID($status,$team_id){
			$this->db->open();
			$query = "select * from $this->table where status = '$status' and (team_id = $team_id or team_id = 0)";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
                $id=$data['id'];
                $date=$data['date'];
                $description=$data['description'];
                $requester=$data['requester'];
                $tel=$data['tel'];
                $status=$data['status'];
                $topic=$data['topic'];
                $product_id=$data['product_id'];
                $category_id=$data['category_id'];
                $team_id=$data['team_id'];
				$tickets = new Tickets($id, $date, $description, $requester, $tel, $status, $topic, $product_id, $category_id, $team_id);
				array_push($list, $tickets);
			}
			return $list;
		}

		function getDescription($ticket_id){
			$this->db->open();
			$query = "select * from $this->table where id = $ticket_id";
			$result = $this->db->query($query);
			while($data = mysqli_fetch_array($result)){
				$description=$data['description'];
				return $description;
			}
		}

		function updateTickets($id,$topic,$description,$product_id,$category_id,$team_id,$status){
			$this->db->open();
			$query = "update $this->table set topic='$topic',description='$description',product_id=$product_id,category_id=$category_id,team_id=$team_id,status='$status' where id = $id";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function getProductID($ticket_id){
			$this->db->open();
			$query = "select * from $this->table where id = $ticket_id";
			$result = $this->db->query($query);
			while($data = mysqli_fetch_array($result)){
				$product_id=$data['product_id'];
				return $product_id;
			}
		}

		function getCategoryID($ticket_id){
			$this->db->open();
			$query = "select * from $this->table where id = $ticket_id";
			$result = $this->db->query($query);
			while($data = mysqli_fetch_array($result)){
				$category_id=$data['category_id'];
				return $category_id;
			}
		}
    }
?>