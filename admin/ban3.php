<?php
	@session_start();
	if($_SESSION['userType']==='admin'){
		@$banName = $results['username'];
			require_once 'banFunc.php';
			@$banId = $_GET['banId'];
			$bannedUserName = getNameById($banId);
			if(isset($banId) && !empty($banId) && !isBanned($banId)){
				@$banId = $_GET['banId'];
				echo ' do you really want to ban user '.$bannedUserName.'?';
				echo '<form method="POST"><input type="submit" value="yes" name="yes" id="yes"></br>
				 <input type="submit" value="no" name="no" id="no">
				</form>';
				if(isset($_POST['yes'])){
					//mysqli_query($db, "INSERT INTO newsusers(status) VALUES(banned) WHERE id=$banId ") 
					mysqli_query($db, "UPDATE newsusers SET status='banned' WHERE id='$banId'")
					or die(mysqli_error($db));
					echo 'User named '.$bannedUserName.' was banned';
					echo '</br><a href="permissions.php?id='.$banId.'">Back</a>';
				}
				else if(isset($_POST['no'])){
					
					header("Location: permissions.php?id=".$banId);
					
				}
			}else if(!isBanned(@$editedUserId)){
				echo '</br><a href="ban.php?banId='.@$editedUserId.'">Ban this user</a></br>';
				//echo '</br><a href="permissions.php">Back</a>';
			}
				
			
	}
?>
