<?php // connect.php allows connection to the database
    $hn = 'localhost';
	$db = '20db033';
	$un = '20usr033';
	$pw = 'FHTAJHCNF72';
	
	$conn = new mysqli($hn, $un,$pw,$db);
	
	if ($conn->connect_error)
		{ die($conn->connect_error);
		echo '<br>';
		echo 'Unfortunately you could not be connected to the database
		      please check you have the correct credentials';
	}
	else 
	{	
		echo '<br>';
		echo '<b>You have connected to the database successfully!</b><br><br>';
		
	};

   ?>
