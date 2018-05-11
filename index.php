<?php
	
	session_start();
	
	include("./actions/db_connection.php");
	if(isset($_POST['login']))
	{
		$email            = $con->real_escape_string($_POST['email']);
		$password         = $con->real_escape_string($_POST['password']);
		
		if($email == "" || $password == "")
		{
			header("Location: ./layout/login.php?error=check_inputs");
			exit();
		}
		else
		{
			$sql = $con->query("SELECT id, firstname, lastname, email , password , isEmailConfirmed ,isAdmin FROM users WHERE email='$email'");
			if($sql->num_rows > 0)
			{
				$data = $sql->fetch_array();
				if(password_verify($password, $data['password']))
				{
					if($data['isEmailConfirmed'] == 0)
					{
						header("Location: ./layout/login.php?error=email_not_confirmed");
						exit();
					}
					else
					{	
						$_SESSION['user_id']        = $data['id'];
						$_SESSION['user_firstname'] = $data['firstname'];
						$_SESSION['user_lastname']  = $data['lastname'];
						$_SESSION['user_email']     = $data['email'];
					}
				}
				else
				{
					header("Location: ./layout/login.php?error=email_or_psd_inc");
					exit();
				}
			}
			else
			{
				header("Location: ./layout/login.php?error=email_or_psd_inc");
				exit();
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Chat with fun! :)</title>
	<link rel="stylesheet" type="text/css" href="style/index.style.css"/>
</head>
<body>
	<header>
			<nav>
				<div class="main-wrapper">
					<ul>	
						<li>
							<a href="index.php">Home</a>
							
						</li>
					</ul>
					<div class="nav-logout">
							<?php
								if(isset($_SESSION['user_id']))
								{
									echo '<form action="./functionality/logout.functionality.php" method="POST" accept-charset="utf-8">
											<button type="submit" name="submit">Logout</button>
										  </form>';
								}
								else
								{
									header("Location: ./layout/login.php");
									exit();
								}
							?>
							
					</div>
				</div>
			</nav>
	</header>
</body>
</html>