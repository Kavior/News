<?php
	session_start();
	session_destroy();
	echo "Logged out successfully</br>";
	echo '<a href="../news.php">Go back</a>';
?>

