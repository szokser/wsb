<!DOCTYPE HTML>
<html>

<head>
  <link rel='stylesheet' type='text/css' media='screen' href='css/css_helpdesk.css'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="./fav/favicon.png">
  <title>HelpDesk - edytuj bilecik</title>
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
	$idticket=$_POST['id_ticket'];
		
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
	  <a href="add_user.php" class="link">Dodaj użytkownika</a>
	  <a href="historia_admin.php" class="link">Historia bilecików</a>
      <a href="wyloguj.php" class="link">Wyloguj</a>
	</div>
    <?php

$login=$_SESSION["user"];
$query=mysqli_query($connection,"SELECT * FROM users WHERE login='$login'");
$row=mysqli_fetch_array($query);

$id=$row["id"];

if(isset($_REQUEST["submit2"])) //PRZYCISK ZMIANY BILECIKA
{
	$title=$_REQUEST["title"];
	$desc=$_REQUEST["desc"];
	$idticket2=$_REQUEST["id_ticket"];
	$active=$_REQUEST["active"];
	
	if ($_REQUEST["title"]=="" || $_REQUEST["desc"]=="" || $_REQUEST["active"]=="") echo "<div id=bad_alert><br>Niepoprawnie wypełniony formularz!</div>";
	
	else
	{  	  
		mysqli_query($connection,"UPDATE tickets SET title='$title', description='$desc', active='$active' WHERE id_ticket='$idticket2'");
		echo "<br><div id='succes_alert'>Zmieniono bilecik! </div>";
	}
	
}
?>
	<!-- FORMULARZ -->
	
	<br><h1>Edytuj bilecik</h1>
	
    <br><form method="post" class="form">
		
		<?php
			$query2=mysqli_query($connection,"SELECT * FROM tickets WHERE id_ticket='$idticket'");
			$row2=mysqli_fetch_array($query2);
		?>
		
      <div class="row">
        <div class="column">
          <p>1. ID Ticketa: <input type="text" name="id_ticket" id="input_width" value="<?php echo $idticket ?>" readonly="readonly">
		  <p>2. Wpisz tytuł zgłoszenia: <input type="text" id="input_width" name="title" value="<?php echo $row2["title"] ?>"/></p><br>
		  <p>3. Opisz szczegółowo twój problem: <textarea rows = "5" cols = "60" id = "input_width" name="desc"><?php echo $row2["description"] ?></textarea></p><br>
			<p>4. Zmień status: 
			  <input list="active" name="active" value="<?php echo $row2["active"]?>">
			  <datalist id="active">
				<option value="2 - W trakcie realizacji">
				<option value="3 - Zakończony">
			  </datalist></p><br>
			<input type="submit" value="Zmień bilecik" name="submit2" class="btn_2">
        </div>
    </form>
  </div>
</body>

</html>