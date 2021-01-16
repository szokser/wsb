<!DOCTYPE HTML>
<html>

<head>
  <link rel='stylesheet' type='text/css' media='screen' href='css/css_helpdesk.css'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="./fav/favicon.png">
  <title>HelpDesk - lista użytkowników</title>
</head>

<body id="secondPage">

  <div class="box2">
      
	  <!-- NAGŁÓWEK -->
	  
	  <?php
session_start();

$connection = mysqli_connect("localhost", "root", "", "helpdesk");
if (!$connection) {
	die("Database connection failed: " . mysqli_connect_error());
}

// WYBÓR DB

$db_select = mysqli_select_db($connection, "helpdesk");
if (!$db_select) {
	die("Database selection failed: " . mysqli_connect_error());
}

if($_SESSION["user"]==true AND $_SESSION["user"] == "admin")
{
	$login=$_SESSION["user"];
	$query=mysqli_query($connection,"SELECT * FROM users WHERE login='$login'");
	$row=mysqli_fetch_array($query);

	$id=$row["id"];
	$name=$row["name"];
		
	echo "<br><p><span style:'float:left'>Witaj ".$name."!</span>";
}
else
{
	 header('location:index.php');
}



?>

	
<!-- MENU -->

    <div class="user"> 
	  <a href="helpdesk_admin.php" class="link">Aktywne tickety</a>
	  <a href="add_user.php" class="link">Lista użytkowników</a>
	  <a href="historia_admin.php" class="link">Historia bilecików</a>
      <a href="wyloguj.php" class="link">Wyloguj</a>
	</div>
    <?php

$login=$_SESSION["user"];
$query=mysqli_query($connection,"SELECT * FROM users WHERE login='$login'");
$row=mysqli_fetch_array($query);



$id=$row["id"];

if(isset($_REQUEST["submit1"])) //PRZYCISK DODANIA USERA
{
	$name=$_REQUEST["name"];
	$surname=$_REQUEST["surname"];
	$country=$_REQUEST["country"];
	$gender=$_REQUEST["gender"];
	$login=$_REQUEST["login"];
	$pass1=$_REQUEST["pass1"];
	$pass2=$_REQUEST["pass2"];
	
	$query2=mysqli_query($connection,"SELECT * FROM users WHERE login='$login'");
	$row2=mysqli_fetch_array($query2);
	
	if ($_REQUEST["name"]!="" || $_REQUEST["surname"]!="" || $_REQUEST["country"]!="" || $_REQUEST["gender"]!="" || $_REQUEST["login"]!="" || $_REQUEST["pass1"]!="" || $_REQUEST["pass2"]!="")
	{
			if ($_REQUEST["pass1"] == $_REQUEST["pass2"])
			{
				if (!isset($row2["login"]))
				{
					mysqli_query($connection,"INSERT INTO users(login,pass,name,surname,gender,country)VALUE('$login','$pass1','$name','$surname','$gender','$country')");
					echo "<br><div id='succes_alert'>Dodano użytkownika!</div>";
				}
				
				else
				{
					if ($_REQUEST["login"] == $row2["login"])
					{
						echo "<div id=bad_alert><br>Taki użytkownik istnieje już w bazie!</div>";
					}
				}
				
			}	
		
		else echo "<div id=bad_alert><br>Hasła są niezgodne!</div>";
	}
	
	else echo "<div id=bad_alert><br>Niepoprawnie wypełniony formularz!</div>";
}
?>
	<!-- FORMULARZ -->
		
		<?php
		
		$query2=mysqli_query($connection,"SELECT * FROM users WHERE id != 0");
		$rowcount2=mysqli_num_rows($query2);	
	?>
	
	<br><h1>Lista użytkowników</h1>
	<br><table border='1'>
      <tr id="tab_nag">
        <td>ID</td>
        <td>Imię</td>
        <td>Nazwisko</td>
        <td>Płeć</td>
		<td>Państwo</td>
      </tr>
      
	  <?php
        for($i=1;$i<=$rowcount2;$i++)
        {
            $row2=mysqli_fetch_array($query2);
      ?>
		<td><?php echo $row2["id"] ?></td>
        <td><?php echo $row2["name"] ?></td>
        <td><?php echo $row2["surname"] ?></td>
        <td><?php echo $row2["gender"] ?></td>
		<td><?php echo $row2["country"]?></td>
      </tr>

      <?php
        }
        ?>
    </table>
	
	
	<br><h1>Dodaj użytkownika</h1>
	
    <br><form method="post" class="form">

      <div class="row">
        <div class="column">
          <p>1. Wpisz imię: <input type="text" id="input_width" name="name"/></p><br>
		  <p>2. Wpisz nazwisko: <textarea rows = "1" cols = "60" id = "input_width" name="surname"></textarea></p><br>
		  <p>3. Wpisz kraj: <input type="text" id="input_width" name="country"/></p><br>
		  <p>4. Wybierz płeć: 
			  <input list="gender" name="gender">
			  <datalist id="gender">
				<option value="Mężczyzna">
				<option value="Kobieta">
				<option value="Inna">
			  </datalist></p><br>
		   <p>5. Podaj login: <input type="text" id="input_width" name="login"/></p><br>
		   <p>6. Podaj hasło: <input type="password" id="input_width" name="pass1"/></p><br>
		   <p>7. Potwierdź hasło: <input type="password" id="input_width" name="pass2"/></p><br>
		   <input type="submit" value="Dodaj użytkownika" name="submit1" class="btn_2">
        </div>
    </form>
  </div>
</body>

</html>