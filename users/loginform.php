<html>
	<head>
		<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<body>
		<div class="main">
			<div id="head"></div>
			<div style="width:50%; margin:100px auto;">
				<?php
					session_start();
					$loginSuccess = false;
					@$usernameLogin = mysql_escape_string($_POST['usernameLogin']);
					@$passwordLogin = mysql_escape_string($_POST['passwordLogin']);
					$codedPas = md5($passwordLogin);
					require_once '../admin/banFunc.php';
					if(!isset($_SESSION['username'])){
		
						if( isset($usernameLogin) && isset($passwordLogin) && 
						!empty($usernameLogin)  && !empty($passwordLogin) && !$loginSuccess && !isBanned(getId($usernameLogin))){
							
						 	$db = mysqli_connect('localhost', 'root', '', 'news') or die ("unable to connect to database");
						 	$nickFromDb = mysqli_query($db, "SELECT username FROM newsusers 
						 	WHERE username = '$usernameLogin' AND password = '$codedPas'") 
						 	or die ("no such username");
					
							while($row = mysqli_fetch_array($nickFromDb)) {
						        $loginSuccess = true;
						     $_SESSION['username']= $usernameLogin; 
								
						        echo "Logged in successfully!";
							}
							

						
					
						 }else if(isBanned(getId($usernameLogin))){
						 	echo 'You are banned!';
						 }else{

							echo '<form method="post">
							<div id="fieldsDescription"><span style="position:relative; bottom:14px;">Login :</span></br>
							Password :</div>
							<div id="loginFields">
							<input type="text" id="usernameLogin" name="usernameLogin" ></br><input type=  "password" id="passwordLogin" 
							name="passwordLogin">
							<input type="submit" value = "Log in" class="defaultButton" style="position:relative; top:-15px; left:20px;"></div>
							</form>';						    	
						    } 

						    if(!isBanned(getId($usernameLogin)) && !isset($_SESSION['username']) && isset($usernameLogin) && $usernameLogin!=="" && !$loginSuccess &&
						    (isset($passwordLogin) && $passwordLogin!=="")   ) {
						    	//$_SESSION['username']= null;
						        echo '<div class="alert alert-danger">Oops! It looks like your username and/or password are incorrect. 
						        Please try again.</div>';
						    }		
						 
					 }else{
					 	echo 'You are logged as ' .  $_SESSION['username'];
					 }
				
				?>
				</br><a href = "../news.php">Back</a>
			</div>
		</div>
	</body>