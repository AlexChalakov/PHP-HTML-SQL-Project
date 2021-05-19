<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="interface.css">
	<link rel="stylesheet" type="text/css" href="interface2.css">
</head>

<body>

<ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="add.php">Add data</a></li>
  <li><a class="active" href="delete.php">Delete data</a></li>
  <li><a href="update.php">Edit & Update </a></li>
  
</ul>

<?php // connect.php allows connection to the database

require_once 'connect.php'; //using require will include the connect.php file each time it is called.

/*
The server side validation. Checks the variables.
*/
	function validationcheck()
	{
		global $error;
		global $conn;
		$error = "Book record deleted successfully!";//Introducing a message for when the function is true
		

		//Book ID check
		/* 	Presence checks.*/
		if(empty($_POST['id']))
		{
			$error = "Please enter the Book ID!";
			return false;
		}
		/* Numeric checks. */
		else if (!is_numeric($_POST['id'])) 	
		{
			$error = "Is NOT numeric. Please enter valid numbers.";
			return false;
		}
		/* Length checks. */
		else if(strlen($_POST['id']) < 3)
		{
			$error = "ID is too short! Has to be more than 3 numbers.";
			return false;
		}
		
		return true;	
	}  // end of validationcheck() function 


echo '<b>If you would like to delete a book record type in the Books ID from the table below and click on the "DELETE RECORD" button! </b><br><br>';

    if (isset($_POST['id']))
	{
		$id = assign_data($conn, 'id');
    
		$validated = validationcheck();
		
		if($validated)
		{
			$query    = "DELETE FROM books WHERE id = $_POST[id]";
			$result   = $conn->query($query);
		
			if (!$result) echo "<br><br>DELETE failed: $query<br>" .
				$conn->error . "<br><br>";
		}
  } // end of delete command

//  else {
//	  print "<br><br> You did not fill all required <br><br>";
//  }



print<<<_HTML
   <form action="delete.php" method="post">
  
    Book ID:		(3 or more digits)	<input type="text" name="id" value = ""> <br><br>
      
    <input type="submit" value="DELETE RECORD">
	
   </form>
_HTML;
  
  echo "<p>";
	if(isset($error))
		{ echo "<p><em>$error</em></p>";} //Displays error message if it exists
	echo "</p>";
  
 function assign_data($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  
  
	$query  = "SELECT * FROM books";
	$result = $conn->query($query);
	if (!$result) die ("Database access failed: " . $conn->error);

	$rows = $result->num_rows;


print<<<_HTML
   <b>Here is your Books list: </b>
   
	<table id = "book_table">
		  <tr>
			<th>Book ID</th>
			<th>Title</th>
			<th>Author</th>
			<th>Pages</th>
			<th>Genre</th>
			<th>Year Published</th>
		  </tr>
_HTML;

	if ($result->num_rows >0)
			{
				while($row = $result->fetch_assoc()) 
					{
						echo "<tr>";
						echo "<td>".$row["id"]."</td>";
						echo "<td>".$row["title"]."</td>";
           				echo "<td>".$row["author"]."</td>";
						echo "<td>".$row["pages"]."</td>";
			            echo "<td>".$row["genre"]."</td>";
			            echo "<td>".$row["yearpublished"]."</td>";
						echo "</tr>";
					}
			} 
				else 
			{
				echo "0 results";
			}


print<<<_HTML
 </table>
	<br>
	<a href="index.php" target="_self"> <p>Home</p></a> 
_HTML;
				
$result->close();
$conn->close(); 
?>
 
</body>	
</html>
