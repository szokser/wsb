<!DOCTYPE HTML>
<html>

<head>
  <link rel='stylesheet' type='text/css' media='screen' href='css/css_helpdesk.css'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="./fav/favicon.png">
  <title>HelpDesk - dodaj bilecik</title>
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

if($_SESSION["user"]==true)
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
	  <a href="helpdesk.php" class="link">Aktywne tickety</a>
	  <a href="add_ticket.php" class="link">Dodaj bilecik</a>
	  <a href="historia.php" class="link">Historia bilecików</a>
      <a href="wyloguj.php" class="link">Wyloguj</a>
	</div>
    <?php

$login=$_SESSION["user"];
$query=mysqli_query($connection,"SELECT * FROM users WHERE login='$login'");
$row=mysqli_fetch_array($query);



$id=$row["id"];

if(isset($_REQUEST["submit1"])) //PRZYCISK DODANIA BILECIKA
{
	$title=$_REQUEST["title"];
	$desc=$_REQUEST["desc"];
	$priority=$_REQUEST["priority"];
	$id=$row["id"];
	
	if ($_REQUEST["title"]=="" || $_REQUEST["desc"]=="" || $_REQUEST["priority"]=="") echo "<div id=bad_alert><br>Niepoprawnie wypełniony formularz!</div>";
	
	else
	{  	  
		mysqli_query($connection,"INSERT INTO tickets(title,description,priority,active,id_user)VALUE('$title','$desc','$priority',1,'$id')");
		echo "<br><div id='succes_alert'>Dodano bilecik!</div>";
	}
	
}
?>
	<!-- FORMULARZ -->
	
	<br><h1>Dodaj bilecik</h1>
	
    <br><form method="post" class="form">

      <div class="row">
        <div class="column">
          <p>1. Wpisz tytuł zgłoszenia: <input type="text" id="input_width" name="title"/></p><br>
		  <p>2. Opisz szczegółowo twój problem: <textarea rows = "5" cols = "60" id = "input_width" name="desc"></textarea></p><br>
		  <p>3. Podaj priorytet: 
			  <input list="priority" name="priority">
			  <datalist id="priority">
				<option value="1 - Bardzo wysoki">
				<option value="2 - Wysoki">
				<option value="3 - Średni">
				<option value="4 - Niski">
			  </datalist></p><br>
			<input type="submit" value="Dodaj bilecik" name="submit1" class="btn_2">
        </div>
    </form>
  </div>
</body>

</html>