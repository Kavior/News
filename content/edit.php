<?php session_start(); ?>
<html>
	<head>
		<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<body>
		<div class="main">
			<div id="head"></div>
			<div id="editArea">
				<?php 		
					$editedNewsId = $_GET['id'];
					//If logged in
					if(isset($_SESSION['username']) ){
						$userType = $_SESSION['userType'];
						//Only admin and entitled users can edit the news
						if($userType=='admin'|| $userType=='entitled' ){
							//require ("../dbIssues.php");
							$add = false;
							require ("content.php");
						}else{
							echo 'You have no permission to edit the news!';
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