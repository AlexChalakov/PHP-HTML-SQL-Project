<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="interface.css">
</head>

<body>

<ul>
  <li><a class="active" href="index.php">Home</a></li>
  <li><a href="add.php">Add data</a></li>
  <li><a href="delete.php">Delete data</a></li>
  <li><a href="update.php">Edit & Update </a></li>
  
</ul>



 <?php // connect.php allows connection to the database

  require 'connect.php'; //using require will include the connect.php file each time it is called.

 // SELECT DATA FROM BOOK TABLE IN DATABASE  
  
  $query  = "SELECT * FROM books ";
  $result = $conn->query($query);
  
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;

print<<<_HTML
  
  <p> Here is your Books list: </p>
	
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
