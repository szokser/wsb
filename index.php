<!DOCTYPE HTML>

<head>
  <html>
  <link rel='stylesheet' type='text/css' media='screen' href='css\css_index.css'>
  <link rel="icon" type="image/png" href="./fav/favicon.png">
  <title>HelpDesk - Logowanie</title>

</head>

<body id="firstPage">

<?php
	session_start();

	$connection = mysqli_connect("localhost", "root", "", "helpdesk");
	if (!$connection) {
		die("Połączenie z bazą danych nie powiodło się: " . mysqli_connect_error());
	}

	$db_select = mysqli_select_db($connection, "helpdesk");
	if (!$db_select) {
		die("Wybór bazy danych nie powiódł się: " . mysqli_connect_error());
	}
?>

  <div class="box">
    <form method="post">
      <span class="text-center">HelpDesk</span>
      <span class="text-center2">zarządzaj swoim ticketem</span>
	  
	  <?php
		if(isset($_REQUEST["submit"]))
		{
			$login=$_REQUEST["user"];
			$pass=$_REQUEST["pass"];
			$query=mysqli_query($connection,"SELECT * FROM users WHERE login='$login' && pass='$pass'");
			$rowcount=mysqli_num_rows($query);

			if($rowcount==true)
			{
				$_SESSION["user"]=$login;
			   header('location:helpdesk.php');
			}
			else
			{
			   echo "<div id='bad_alert'><p><center>Nieprawidłowy login lub hasło!</center></p></div>";
			}
		}
	  
	  ?>
	  
	  <!-- FORMULARZ LOGOWANIA -->
	  
      <div class="input-container">
        <input type="text" name="user" required="" />
        <label>Login</label>
      </div>
      <div class="input-container">
        <input type="password" name="pass" required="" />
        <label>Hasło</label>
      </div>

      <input type="submit" value="Zaloguj się" name="submit" class="btn">


    </form>
    </form>
  </div>
</body>

</html>