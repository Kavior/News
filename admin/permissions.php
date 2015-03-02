<?php session_start();?>
<html>
	<head>
		<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<body>
		<div class="main">
			<div id="head"></div>
			<div class="userPanel" >
				<div class="userPanelContent">
					<?php
						if(isset($_SESSION['userType']) && $_SESSION['userType']=='admin'){
							echo '<a href="permissions.php" style="display:block; text-decoration:none;"><div id="changePermissionsButton" 
							title="Change permissions"></div>Permissions</a>';							
						}
						echo '</br><a href = "../news.php">Back to the main page</a>';				
					?>
				</div>
			</div>
			<div id="permissionsArea">
			<?php			
				require_once 'banFunc.php';
				if(isset($_SESSION['userType']) && $_SESSION['userType']=='admin'){
					//$db = mysqli_connect('localhost', 'root', '', 'news') or die ("unable to connect to db");					
					if(isset($_GET['id'])){
						$editedUserId = $_GET['id'];
					}else if(isset( $_GET['changedId'])){
						$editedUserId = $_GET['changedId'];

						echo 'usertype: ' .@$_SESSION['editedUserType'].'</br> New user type:';
						echo '<form action="changeStatus.php">
						<label for "normal">Normal user</label>
						<input type="radio" name="newStatus" value="normal" id="normal" /></br>
						<label for "entitled">Advanced user</label>
						<input type = "radio" name="newStatus" value ="entitled" id="entitled"/></br>
						<label for "admin">Admin</label>
						<input type = "radio" name= "newStatus" value = "admin" id="admin"/></br>
						<input type="hidden" name="id" value="'.$editedUserId.'">
						<input type="submit" value="submit">
						</form>';					
					}
					// If there was a request to edit some user
					if(isset($editedUserId)){
						$editedUserName =getNameById($editedUserId);
						echo 'username: '.$editedUserName.'</br>status: ';				
						echo isBanned($editedUserId)?'Banned':'Not banned';
						
						if(!isBanned($editedUserId)){
							require 'ban.php';
							echo '</br><a href="ban.php?banId='.@$editedUserId.'">Ban this user</a></br>';
						}else{
							require 'unban.php';
						}
						require 'changeStatus.php';							
					}

				   	echo '	<div id="searchBox">
							<form action="permissions.php" method="GET">Search user: <input type ="text" name ="searchUser">
							<input type="submit" class= "defaultButton" value= "search" style="margin-top:10px;"></form>
							</div>';
							
					
					if(isset($_GET['searchUser'])){
						$searchUser = $_GET['searchUser'];	
						echo '</br>Users found:</br>';
						$usersFound = mysqli_query($db, "SELECT id, username FROM newsusers WHERE username LIKE '%$searchUser%' ") or die('cannot find user');
						
						while($results = $usersFound->fetch_assoc()){
							echo '<div class="result"><a href=permissions.php?id='.@$results[id].'>'.$results['username'].'</a></div></br>';								
						}										
					}
				}else{
					echo "</div>you have no permission to access this page</br>";
				}
						
				if(isset( $_GET['changedId'])){
					echo '</br><a href="permissions.php?id='. $_GET['changedId'].'">Back</a></div>';	
				}
			?>
			</div>
		</div>
	</body>
</html>