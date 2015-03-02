<?php
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	if($_SESSION['userType']==='admin'){
		if(isset( $_GET['banId'])){
			require_once 'banFunc.php';
			$banId =$_GET['banId'];
			$bannedUserName = getNameById($banId);
			if( !empty($banId) && isBanned($banId)){		
				echo ' do you really want to unBan user '.$bannedUserName.'?';
				echo '<form method="POST"><input type="submit" value="yes" name="yes" id="yes"></br>
				<input type="submit" value="no" name="no" id="no"></form>';			
				if(isset($_POST['yes'])){			
					mysqli_query($db, "UPDATE newsusers SET status='unbanned' WHERE id='$banId'")
					or die(mysqli_error($db));
					echo 'User '.$bannedUserName. ' was unbanned.</br><a href="permissions.php?id='.$banId.'">Back</a>';
				}else if(isset($_POST['no'])){				
					header("Location: permissions.php?id=".$banId);	
				}
			}
		}else if(isBanned(@$editedUserId)){
				echo '</br><a href="unban.php?banId='.@$editedUserId.'">unBan this user</a>';		
		}
	}else{
			echo '<a href="permissions.php?id='.$banId.'">Back</a>';
	}
?>
