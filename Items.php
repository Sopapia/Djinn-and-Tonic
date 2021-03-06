<!doctype html>
<html lang="en">
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
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        </ul>
    </nav>

     <div class="jumbotron">
       <h1 class="display-3">Djinn and Tonic</h1>
       <p class="lead">Item Search</p>
       <hr class="my-2">
       <form class="form-inline" action="Items.php" method="post">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search">
        <button class="btn btn-success" type="submit">Search</button>
      </form>
     </div>


     <?php
        session_start();
	      // Make a connection to the database
        // The values here MUST BE CHANGED to match the database and credentials you wish to use
        //$dbhost = pg_connect("host=hostname dbname=databasename user=username password=password");
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
        $sql = "SELECT i.ItemName, i.ItemPrice, i.ItemDesc, it.TypeName, i.ItemID FROM Item i
                JOIN ItemType it on it.ItemTypeID = i.ItemTypeID
                WHERE LOWER(i.ItemName) LIKE '%".strtolower($_POST['search'])."%'
                ORDER BY i.ItemTypeID";

              // Run the SQL query
        $result = pg_query($dbhost, $sql);

              // If the $result variable is not defined, there was an error in the query
        if (!$result)
        {
          die("Error in query: ".pg_last_error());
        }

        $arr = pg_fetch_all($result);

        echo("<table class='table table-striped'><tbody>");
        $total=count($arr);
        for($i=0; $i<$total; $i++){
	        $itemID = $arr[$i]['itemid'];
          $itemName = $arr[$i]['itemname'];
          $itemDesc = $arr[$i]['itemdesc'];  
          $itemPrice = $arr[$i]['itemprice'];
          $typeName = $arr[$i]['typename'];
          
          echo("<tr><td scope='row'>". $itemName . "</td><td>" . $itemDesc . "</td><td>" . "Price: " . $itemPrice . "</td><td>" . $typeName . "</td><td>
          <form class='form-inline' action='Items.php' method='post'>
            <button class='btn btn-success' name='buy' type='buy'>Buy</button>
            <input type='hidden' name='eventid' value=".$itemID.">
          </form>");
          
          
          
        }
        echo("</tbody></table>");

        if(isset($_POST['buy'])){
          $sql = 'DELETE FROM Item i WHERE i.ItemID = '.$_POST['eventid'];
          pg_query($sql);          
          header("Refresh:0");
        }


        // Free the result from memory
        pg_free_result($result);

        // Close the database connection
        pg_close($dbhost);
      ?>
      
      A great query     vvvvvv
        <br>
      SELECT i.ItemName, i.ItemPrice, i.ItemDesc, it.TypeName, i.ItemID FROM Item i
                JOIN ItemType it on it.ItemTypeID = i.ItemTypeID
                WHERE LOWER(i.ItemName) LIKE '%".strtolower($_POST['search'])."%'
                ORDER BY i.ItemTypeID


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
