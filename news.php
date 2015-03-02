<?php 	session_start(); ?>
<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="ICON" href="img/news.ico" type="image/ico" />
		<script type="text/javascript" src="jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="jquery-ui.js"></script>
	</head>
	<body>
		<script>
			$(document).ready(function(){
				//Show and hide news
				$('.switcher').click(function(){
					//hide all other news content
					$('.breaker').each(function(){
						$(this).hide();
					});
					
					if ($(this).text() == "More..."){
						$('.switcher').each(function(){
							$(this).text("More...");
						});	
						//remove dots after short text
						$(this).parent('.news').children('.dots').remove();
						//show news content
						$(this).parent('.news').children('.breaker').toggle(500);
		   				$(this).text("Less...")
				   }else{
				   		//hide news content
						$('.breaker').hide();
						$(this).parent('.news').append('<span class="dots">...</span>');
						$(this).text("More...");
				   }				   
				});			
			});
		</script>
		<div class="main">
			<div id="head"></div>
			<div id="newsArea">
				<?php
					require_once 'users/usertype.php';
			
					$newsData = mysqli_query($db, "SELECT content, title, author, id, date FROM news") or die('News data error');
					//Get news from database
					while($row = mysqli_fetch_row($newsData)){				
						$content = $row[0];
						$title = $row[1];
						$author = $row[2];
						$id = $row[3];
						$date = substr($row[4],0,-4);
						//Hide news content if news is 100 words or more long
							echo '<div class="news"><b>Date: </b>'.$date.'</br><b>Author</b>: '.$author.
							'</br><b>Title</b>: '.$title.'</br>';
						if(@strpos($content,' ',100)){
							$lastHeaderWord= strpos($content,' ',100);
							echo '<button class="switcher ">More...</button><hr>'.substr($content,0,$lastHeaderWord).
							'<span class="dots">...</span><span class="breaker">'.
							substr($content,$lastHeaderWord).'</span>';
						}else{
							echo '<hr>'.$content.'</br>';
						}
						//check if user is logged in, is author of the news or is admin, so he can edit the news:
						if(loggedIn() && isset($sessionUsername) && $sessionUsername==$author||@$userType=='admin'){
							echo '</br><a href =content/edit.php?id='.$id.'>Edit</a>&nbsp;<a href =content/delete.php?id='.$id.'>Delete</a>';
						}
						echo '</div>';
					} 
				?>
			</div>
			<div class="userPanel" >
				<div class="userPanelContent">
					<?php 
						//echo $sessionUsername;
						if(loggedIn()){
							//Admin and entitled users can add news
					    	if(isAdmin() || isEntitled()){
							echo '<a style="display:block" href="content/addNews.php"><div id="add"></div> </a></br>';
							}		    
					    	//Admin gets access to admin panel
							if(isAdmin()){
								echo '<a style="display:block" href="admin/adminPanel.php"><div id="adminPanelButton"></div></a>';
							}
							
							echo '<div id="loginInfo" style="position:relative; top:25px; bottom:5px;><span style="width:60%; 
							margin:auto; padding-left:10px; "><center>Logged as: <span style="margin:auto;"><b>'.$sessionUsername .'</b></center></span></span>' ;
							echo '<a href="users/logout.php"><button type="button" id="logOut" class="defaultButton" 
							style="height:40px; width:90px; padding:1px;" value= "log out">log out</button></a></div>';
					    }else{
					    	echo ' <a href = "users/loginform.php"><button type="button" 
					    	id="logIn" class="defaultButton" >Log in</button></a></br><a href = "users/register.php"><button type="button" id="register" 
					    	class="defaultButton" >register</button></a>';
					    }
				    ?>
			    </div>
		    </div>
		</div>
	</body>
</html>