<?php
	if(isset($_SESSION['username'])){
		$sessionUsername = $_SESSION['username'];
	}
	 function loggedIn(){
		return isset($_SESSION['username'])? true: false;
	}    
	
	$db = mysqli_connect('localhost', 'root', '', 'news') or die ('Unable to connect to the database');

	if(loggedIn()){			
			$uTQuery = mysqli_query($db, "SELECT usertype AS ut FROM newsusers WHERE username = '$sessionUsername'") or die ("Database error");
			while($row = $uTQuery->fetch_assoc()){
				$uT = $row['ut'];		
			}
			$userType = $_SESSION['userType'] = $uT;
			
			function isAdmin(){
				global $userType;
				return $userType =='admin'? true: false;
			}
			
			function isEntitled(){
				global $userType;
				return $userType =='entitled'?true: false;		
			}
	}
?>