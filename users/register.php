<html>
	<head>
		<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<body>
		<div class="main">
			<div id="head"></div>
			<div style="width:50%; margin:100px auto;">
				<?php session_start();
					//@$sessionUsername = $_SESSION['sUsername'];
					//@$newUsername = mysql_escape_string($_POST['newUsername']);
					//@$givenPassword = mysql_escape_string($_POST['newPassword']);
					$db = mysqli_connect('localhost', 'root', '', 'news') or die ("unable to connect to db");
					
					function nameExists($name){
						global $db;
						$user = mysqli_query($db, "SELECT username FROM newsusers WHERE username= '$name'") or die('Database error');		
						return mysqli_num_rows($user);
					}
					if(isset($_POST['newUsername'])){
						$newUsername = $_POST['newUsername'];
					}
					if(isset( $_POST['newPassword'])){
						$givenPassword = $_POST['newPassword'];
					}					
					if( ( isset($_POST['newUsername']) && @$_POST['newUsername']=="" || nameExists(@$_POST['newUsername']) ) || (isset($_POST['newPassword'])
					 && @$_POST['newPassword']=="") || (!isset($_POST['newUsername']) || !isset($_POST['newPassword'])  ) ){

						if(!isset( $_SESSION['username'] )){
							echo '<form method="post">
							<div id="fieldsDescription">
							Username :</br> 
							Password : </div>	
							<div id="loginFields" style="width:150px;">
							<input type="text" id="newUsername" name="newUsername"></br>
							<input type=  "password" id="newPassword" name="newPassword"></br>
							</div>		
							<input type="submit" name="submit" value = "register!" class="defaultButton" style="position:relative; top:-12px; left:20px;">
							</form>';
							
							if( @$_POST['submit']=='register!' && isset($newUsername) && isset($givenPassword) && ($newUsername=="" || $givenPassword=="") ){
								echo 'Give new username and new password!';
							} 
							if(isset( $newUsername) && nameExists($newUsername) ){
								echo 'User with such username is already registered';
							}
						}else{
							echo 'You are already logged in!';
						}					
					}else{						
							@$newPassword = md5($givenPassword);				
							mysqli_query($db, "INSERT INTO newsusers(username, password, usertype) VALUES('$newUsername','$newPassword', 'normal')") 
							or die('there is a problem in registering new user');
							echo "registration succesfull";
							$_SESSION['username'] = $newUsername;
							echo '</br>You are logged as <b>'.$_SESSION['username'].'</b>' ;
					}
				?>
				</br><a href = "../news.php">Back</a>
			</div>
		</div>
	</body>
</html>		