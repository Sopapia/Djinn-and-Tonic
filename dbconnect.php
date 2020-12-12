<head>
<title>Djinn and Tonic</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Items.php">Items</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="myitems.php">Sell</a>
            </li>
          </ul>
        </nav>

		<?php
	      // Make a connection to the database
        // The values here MUST BE CHANGED to match the database and credentials you wish to use
        //$dbhost = pg_connect("host=hostname dbname=databasename user=username password=password");
        session_start();
        $myfile = fopen("./pg_connection_info.txt", "r") or die("Unable to open \"./pg_connection_info.txt\" file!");
        $my_host = fgets($myfile);
        $my_dbname = fgets($myfile);
        $my_user = fgets($myfile);
        $my_password = fgets($myfile);
        fclose($myfile);
        $dbhost = pg_connect("host=$my_host dbname=$my_dbname user=$my_user password=$my_password");


        // If the $dbhost variable is not defined, there was an error
        if(!$dbhost)
        {
          die("Error: ".pg_last_error());
        }

        // Define the SQL query to run (replace these values as well)
        $sql = "SELECT * FROM pg_tables";

              // Run the SQL query
        $result = pg_query($dbhost, $sql);
        function pre_r( $array ) {
            echo '<pre>';
            print_r($array);
            echo '</pre>';
        }
        //pre_r($result);
        pre_r($result->fetch_assoc());
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

        // Need user info for supplier id
        if (isset($_POST['save'])){
            $name = $_POST['itemName'];
            $price = $_POST['itemPrice'];
            $type = $_POST['itemType'];
            // unfinished query
            $sql = "INSERT INTO Item (ItemName, ItemPrice, ItemTypeID) VALUES('$name', '$price', '$type')";
            pg_query($dbhost, $sql);
        }
      ?>
    
</body>
</html>
