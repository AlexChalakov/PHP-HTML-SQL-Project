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
  <li><a href="delete.php">Delete data</a></li>
  <li><a class="active" href="update.php">Edit & Update </a></li>
  
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
		$error = "Book successfully updated!";//Introducing a message for when the function is true
		

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
		
		
		//BOOK TITLE
		/* 	Presence checks.*/
		if(empty($_POST['title']))
		{
			$error = "Please enter a title!";
			return false;
		}
		/* Length checks. */
		else if(strlen($_POST['title']) > 70)
		{
			$error = "Title name is too long!";
			return false;
		}
		
		
		//AUTHOR NAME
		/* Presence checks. */
		if(empty($_POST['author']))
		{
			$error = "Please enter an author!";
			return false;
		}
		/* Length checks. */
		else if(strlen($_POST['author']) > 45)
		{
			$error = "Authors name is too long!";
			return false;
		}
			
			
		//PAGES 
		/* Presence checks. */
		if(empty($_POST['pages']))
		{
			$error = "Please enter the Books pages!";
			return false;
		}
		/* Numeric checks. */
		else if (!is_numeric($_POST['pages'])) 	/* Numeric checks. */
		{
			$error = "Is NOT numeric. Please enter valid numbers.";
			return false;
		} 
		/* Length checks. */
		else if(($_POST['pages']) < 0)
		{
			$error = "The books pages cannot be negative. Please provide a valid number!";
			return false;
		}
			
		
		//GENRE OF THE BOOKS
		/* Presence checks. */
		if(empty($_POST['genre']))
		{
			$error = "Please enter the Books genre!";
			return false;
		}
		/* Length checks. */
		else if(strlen($_POST['genre']) > 40)
		{
			$error = "Genre is too long!";
			return false;
		}
		
		
		//YEAR THE BOOK WAS PUBLISHED
		if(empty($_POST['yearpublished']))
		{
			$error = "Please enter the year the book was published!";
			return false;
		}
		/* Numeric checks. */
		else if (!is_numeric($_POST['yearpublished'])) 	
		{
			$error = "Is NOT numeric. Please enter valid numbers.";
			return false;
		}
		/* Length checks. */
		else if(($_POST['yearpublished']) < 0)
		{
			$error = "The books year of publishment cannot be negative. Please provide a valid number!";
			return false;
		}
		
		return true;	
	}  // end of validationcheck() function


echo '<b>If you would like to update an existing record type in all the details again (including whatever you want to update) and click on the "UPDATE RECORD" button! </b><br><br>';

    if (isset($_POST['id'])   &&
        isset($_POST['title']) &&
        isset($_POST['author']) &&
        isset($_POST['pages']) &&
        isset($_POST['genre']) &&
        isset($_POST['yearpublished'])
		)  
	{
		$id     = assign_data($conn, 'id');
		$title  = assign_data($conn, 'title');
		$author = assign_data($conn, 'author');
		$pages  = assign_data($conn, 'pages');
		$genre  = assign_data($conn, 'genre');
		$yearpublished = assign_data($conn, 'yearpublished');
		
		$validated = validationcheck();
		
		if($validated)
		{
			$query	= "UPDATE books set id='".$_POST['id'] ."
			', title ='".$_POST['title'] ."
			', author ='".$_POST['author'] ."
			', pages ='".$_POST['pages'] ."
			', genre ='".$_POST['genre'] ."
			', yearpublished ='".$_POST['yearpublished'] ."
			' WHERE id='".$_POST['id'] ."'";
			
			$result   = $conn->query($query);
			
			if (!$result) echo "<br><br>UPDATE failed: $query<br>" .
			  $conn->error . "<br><br>";
		  }
	}
		
//  else {
//	  print "<br><br> You did not fill all required <br><br>";
//  }



print<<<_HTML
   <form action=" " method="post">
  
    Book ID:		(3 or more digits)		<input type="text" name="id" value = ""> <br><br>
    Book Title:		(up to 70 characters)	<input type="text" name="title" value = ""> <br><br>
    Author name:	(up to 45 characters)	<input type="text" name="author" value = ""> <br><br>
    Pages:		 	(no negative numbers)	<input type="text" name="pages" value = ""> <br><br>
    Genre:		 	(up to 40 characters) 	<input type="text" name="genre" value = ""> <br><br>
    Year Published:	(no negative numbers)	<input type="text" name="yearpublished" value = ""> <br><br>
      
    <input type="submit" value="UPDATE RECORD">
	
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
