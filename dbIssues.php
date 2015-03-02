<?php
	$db = mysqli_connect('localhost', 'root', '', 'news') or die ('un');
	if(isset($_GET['id'])){
	$editedNewsId = $_GET['id'];
	}else if(isset( $_SESSION['editId'])){
		$editedNewsId = $_SESSION['editId'];
	}

	if(isset($editedNewsId)){
		$news = mysqli_query($db , "SELECT content AS ct FROM news WHERE id = '$editedNewsId'") or die('content error');
		while($row = $news->fetch_assoc()){
			$editedContent = $row['ct'];
		}
		
		$tt = mysqli_query($db , "SELECT title AS tt FROM news WHERE id = '$editedNewsId'") or die('title error');
		while($row = $tt->fetch_assoc()){
			$title = $row['tt'];
		}
	}	
?>