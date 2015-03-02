<div id="mainForm" style="display:inline-block; width:300px; position:absolute; left:30%; top:20%;">	
	<form action="createDb.php" method="post">
		<table>
			<tr>
				<td>Host name:</td><td><input type="text" name="host"></td>
			</tr>
			<tr>
				<td>User Name:</td><td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password:</td><td><input type="text" name="password"></td>
			</tr>	
			<tr>
				<td ><input type="submit" name="createDB" value="Create Database"></td>
				<td><input type="submit" name= "admin" value="Create admin user"></td>
			</tr>				
		</table>		
	</form>	
</div>
<?php
	@$host= $_POST['host'];
	@$username = $_POST['username'];
	@$password = $_POST['password'];
	if(isset($host) && isset($username) &&  isset($password) && isset($_POST['createDB']) ){
		$db = mysqli_connect($host, $username,$password);
		$databaseName= 'news';
		$createQuery = "CREATE DATABASE $databaseName";
		mysqli_query($db, $createQuery) or die('Wrong data given or database already exists.');
		$db  = mysqli_connect($host, $username,$password,$databaseName);
		
		$nicknamesQuery = "CREATE TABLE news(
		id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		title varchar(55),
		date varchar(20),
		author varchar(30),
		content mediumtext
		);
		
		CREATE TABLE newsusers(
		id int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		username varchar(22),
		password varchar(111),
		usertype varchar(30),
		status varchar(30)
		);			
		";
		mysqli_multi_query($db, $nicknamesQuery) or die('Database connect error');
		echo 'Database succesfully created!';
	}

	if(isset($_POST['admin'])){
		$db = mysqli_connect($host, $username,$password, 'news');
		$adminPass = md5('admin');
		$userExists = mysqli_num_rows( mysqli_query($db, "SELECT id FROM newsusers WHERE username='admin'") );
		if(!$userExists){
			mysqli_query($db, "INSERT INTO newsusers(username, password, usertype) VALUES('admin', '$adminPass', 'admin')")or die(mysqli_error($db));
			echo 'Admin user succesfully created!</br>Login: admin</br>Password: admin';
		}else{
			echo 'User called "admin" already exists';
		}
	}

?>