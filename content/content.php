<?php
		global $db;
		require ("../dbIssues.php");
		if(isset( $_POST['title'])){
			$newTitle = $_POST['title'];
		}else{
			$newTitle = '';
		}
		if(isset($_POST['newContent'])){
			$newContent = $_POST['newContent'];
		}else{
			$newContent = '';
		}
			//if user adds nnew content
			if($add){
				$sessionUsername = $_SESSION['username'];
				$action='addNews.php';
				$editedContent = '';
				$title = '';
				$date = date("Y-m-d h:i:sa");
			}else{//When user edits old content
				$action='edit.php?id='.$editedNewsId;
			}		
		
		//get disposed ob <br /> signs
		$editedContent = str_replace('<br />','',$editedContent);
		//If some content has already been written, but not correct
		if(isset($_POST['newContent'])){$editedContent = $_POST['newContent'];}
		if(isset($_POST['title'])){$title = $_POST['title'];}
		
		echo '<form method="POST" action = "'.$action.'">
		title:</br><input type="text"
		value="'.$title.'" name="title" id="title"></br>
		content:</br><textarea name = "newContent"
		value="" id="newContent">'.$editedContent.'</textarea></br>
		<input type= "submit" name="submit" value="Submit">
		</form>';
		if(isset($_POST['submit'])){
			if(isset($newContent) && !empty($newContent)  && isset($newTitle) && !empty($newTitle) && strlen($newTitle)>1  && strlen($newContent)>14){	
				//convert new line to </br> tag
				$newContent = nl2br($newContent);		
				global $db;
				if($add){
					$query = "INSERT INTO news(title,date,author, content) VALUES('$newTitle','$date','$sessionUsername', '$newContent')";
				}else{
					$query =  "UPDATE news SET title='$newTitle', content= '$newContent' WHERE id='$editedNewsId'";
				}
				mysqli_query($db, $query) or die('Unable to add news to the database');
				header("Location: ../news.php");								
			}else if(isset($newContent) && empty($newContent) && isset($newTitle) && empty($newTitle)){
				echo 'Give a title and content';
			}else if(isset($newContent) && empty($newContent)){
				echo 'Give a content';
			}else if(isset($newTitle) && empty($newTitle)){
				echo 'Give a title';
			}else if(!empty($newTitle) && !empty($newContent) &&strlen($newTitle)<2 && strlen($newContent)<15){
			 	echo "Too short content and title (min 15 and 2 characters)";
			}else if(!empty($newTitle) && strlen($newTitle)<2){
				echo 'Title must have min. 2 charaters';
			}else if(!empty($newContent) && strlen($newContent)<15){
				echo 'Content must have min. 15 charaters';	
			}
		}
?>