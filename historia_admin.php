<!DOCTYPE HTML>
<html>
<head>
  <link rel='stylesheet' type='text/css' media='screen' href='css/css_helpdesk.css'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="./fav/favicon.png">
  <title>HelpDesk - historia ticketów</title>
</head>

<body id="secondPage">
	<div class="box2">

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

			$query=mysqli_query($connection,"SELECT * FROM tickets JOIN users ON tickets.id_user=users.id WHERE tickets.active=3");
			$rowcount=mysqli_num_rows($query);	
		?>
	
		<br><h1>Historia ticketów</h1>
	
		<br><table border='1'>
		  <tr id="tab_nag">
			<td>ID</td>
			<td>Tytuł bilecika</td>
			<td>Opis szczegółowy</td>
			<td>Data</td>
			<td>Priorytet</td>
			<td>Status</td>
			<td>Właściciel</td>
		  </tr>
      
		<?php
			for($i=1;$i<=$rowcount;$i++)
			{
					  $row=mysqli_fetch_array($query);
					  
		?>
		
		   <tr>
			<td><?php echo $row["id_ticket"] ?></td>
			<td><?php echo $row["title"] ?></td>
			<td><?php echo $row["description"] ?></td>
			<td><?php echo $row["date"] ?></td>
			<td><?php echo "Priorytet ".$row["priority"]?></td>
			<td>
			
			<?php
			
				if($row["active"] == 1) echo "Wpisany";
				else if ($row["active"] == 2) echo "W trakcie realizacji";
				else echo "Zakończony";			
			?>
			
			</td>
		
			<td><?php echo $row["name"]." ".$row["surname"] ?></td>

		  </tr>

		<?php
			}
		?>
    
		</table>  
	</div>
</body>
</html>