<?php
	$db = mysqli_connect('localhost', 'root', '', 'news') or die ("unable to connect to database");
	function getNameById($id){
		global $db;	
		$usernameFromDatabase = mysqli_query($db, "SELECT username FROM newsusers WHERE id='$id'");
		while($row = $usernameFromDatabase->fetch_assoc()){
			 return $row['username'];
		}							
	}
		
	function getId($name){
		global $db;
		$id = mysqli_query($db,"SELECT id AS id FROM newsusers WHERE username='$name'") or die('error selecting');
		while($getId = $id->fetch_assoc()){
			$userId = $getId['id'];
		}
		return @$userId;
	}
	
	function isBanned($id){
		global $db;
		$selectStatus = mysqli_query($db,"SELECT status AS status FROM newsusers WHERE id='$id'") or die('error selecting');
		while($stat = $selectStatus ->fetch_assoc()){
			$status = $stat['status'];
		}
		return @$status=='banned'?true:false;
	}
?>