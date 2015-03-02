<?php
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	if(isset($_GET['id'])){
		$changedId = $_GET['id'] ;
		if(isset($_SESSION['userType']) && $_SESSION['userType']=='admin'){	
			require_once '../users/usertype.php';
			//Print information about user status
			if(!isset($_GET['newStatus']) ){
				$usertypeQuery = mysqli_query($db, "SELECT usertype AS ut FROM newsusers WHERE id = '$changedId'") or die ("Usertype selecting error");
				while($row = $usertypeQuery->fetch_assoc()){
					$uT = $row['ut'];	
					$editedUserType = $_SESSION['editedUserType'] = $uT;	
				}					
				echo '</br>usertype: ' .$editedUserType.' (';
				echo'<a href="permissions.php?changedId='.$changedId.'">Change user status</a>)</br></br>';
			//if admin chose new status to be set
			}else {
				//Send confirmation message
				if(!isset($_GET['choice'])){
					$newStatus =  $_GET['newStatus'];
					echo 'Do you really want to set this user '.$newStatus.'?</br>';
					echo'<form  method="get" action="changeStatus.php">
					<input type="hidden" name="id" value="'.$changedId.'">
					<input type="hidden" name="newStatus" value="'.$newStatus.'">				
					<input type = "submit" name= "choice" value="yes">
					<input type = "submit" name= "choice" value="no">
					</form>';	
				//if user answered confirmation message		
				}else{
					$setNewStatus= mysql_escape_string($_GET['newStatus']);
					$choice = $_GET['choice'];
		
					if( $choice=='yes'){
						$db = mysqli_connect('localhost', 'root', '', 'news') or die ("unable to connect to db");
						mysqli_query($db, "UPDATE newsusers SET usertype = '$setNewStatus' WHERE id='$changedId'") or die ("update error");
						echo 'User status has been changed.</br><a href="permissions.php?id='.$changedId.'">back</a>';
					}else if($choice=='no'){
						$header = 'Location: permissions.php?idd='.$changedId;
						header($header);
					}
				}
			}						
		}else{
			echo 'you have no permission to access this page!';
		}		
	}
?>
