<?php session_start(); ?>
<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>
		<?php 
		if(isset($_SESSION['userType']) ){		
			$userType = $_SESSION['userType'];
			//admin and entitled users can delete news
			if($userType=='admin'|| $userType=='entitled'){
				$deletedNewsId = $_GET['id'];
				require "../dbIssues.php";
				echo 'Do you really want to delete news titled "'.$title.'"?</br><form method="POST" 
				action="delete.php?id='.$deletedNewsId.'">
				<input type="submit" name="yes" id="yes" value = "Yes">&nbsp;<input type="submit"
				 name="no" value = "No"></form></br>';
				 
				if(isset($_POST['yes'])){		
					mysqli_query($db , "DELETE FROM news WHERE id = '$editedNewsId'") or die ('Delete error');
					echo 'The news titled"'.$title.'was successfully deleted</br>';
					unset($_SESSION['deletedId']);
					header("Location: ../news.php");
				}else if (isset($_POST['no'])){
					header("Location: ../news.php");
				}		
				echo '<a href = "../news.php">Back</a>';
			}
		}
		?>
	</body>
</html>