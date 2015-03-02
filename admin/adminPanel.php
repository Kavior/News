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
						session_start();
						if(@$_SESSION['userType']=='admin'){							
							echo '<a href="permissions.php" style="display:block; text-decoration:none;"><div id="changePermissionsButton" 
							title="Change permissions"></div>Permissions</a>';					
						}else{
							echo 'You are not the admin!';
						}
						echo '</br><a href = "news.php">Back to the main page</a>';
					?>
				</div>
			</div>
   		</div>
	</body>
</html>