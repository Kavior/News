<?php session_start(); ?>
<html>
	<head>
		<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<body >
		<div class="main">
			<div id="head"></div>
			<div id="addArea">
				<?php 
					if(isset( $_SESSION['username']) ){
						$userType = $_SESSION['userType'];
						// Admins and entitled users are able to add a news
						if($userType=='admin'|| $userType=='entitled'){
							$add= true;
							require ("content.php");	
						}else{
							echo 'You have no permission to add the news!';
						}
					}else{
						echo 'You are not logged in!';
					}
					echo '</br><a href = "../news.php">Back to the main page</a>';				
				?>
			</div>
		</div>
	</body>
</html>