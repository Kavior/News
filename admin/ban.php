<?php
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	if(isset($_SESSION['userType']) && $_SESSION['userType']==='admin'){
		require_once 'banFunc.php';
		if(isset($_GET['banId'])){
			$banId = $_GET['banId'];
			if(!empty($banId) && !isBanned($banId)){
				$bannedUserName = getNameById($banId);
				echo 'Do you really want to ban user '.$bannedUserName.'?';
				echo '<form method="POST"><input type="submit" value="yes" name="yes" id="yes"></br>
				 <input type="submit" value="no" name="no" id="no">
				</form>';
				if(isset($_POST['yes'])){
					mysqli_query($db, "UPDATE newsusers SET status='banned' WHERE id='$banId'") or die(mysqli_error($db));
					echo 'User named '.$bannedUserName.' was banned</br><a href="permissions.php?id='.$banId.'">Back</a>';
				}else if(isset($_POST['no'])){
					header("Location: permissions.php?id=".$banId);
				}
			}
		}
	}else{
		echo 'You have no permission to access this page!';
	}
?>
