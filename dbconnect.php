<head>
</head>
<body>

<?php
	// Make a connection to the database
        // The values here MUST BE CHANGED to match the database and credentials you wish to use
	$dbhost = pg_connect("host=hostname dbname=databasename user=username password=password");

	// If the $dbhost variable is not defined, there was an error
	if(!$dbhost)
	{
		die("Error: ".pg_last_error());
	}

	// Define the SQL query to run (replace these values as well)
	$sql = "SELECT * FROM pg_tables";

        // Run the SQL query
	$result = pg_query($dbhost, $sql);

        // If the $result variable is not defined, there was an error in the query
	if (!$result)
	{
		die("Error in query: ".pg_last_error());
	}

	// Iterate through each row of the result 
	while ($row = pg_fetch_array($result))
	{
		// Write HTML to the page, replace this with whatever you wish to do with the data
		echo $row[0]."<br/>\n";
	}

	// Free the result from memory
	pg_free_result($result);

	// Close the database connection
	pg_close($dbhost);
?>

</body>
</html>