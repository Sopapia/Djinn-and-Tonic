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
       <p class="lead">Login</p>
       <hr class="my-2">
          <form class="form-inline" action="login.php" method="POST">
            <input class="form-control mr-sm-2" type="text" placeholder="Username" name="userName">
            <input class="form-control mr-sm-2" type="text" placeholder="Password" name="password">
            <button name="login" class="btn btn-success" type="submit">Login</button>
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

        if (isset($_POST['login'])){
            $username = $_POST['userName'];
            $password = $_POST['password'];
            $sql = "SELECT * FROM Client WHERE UserName='$username' AND Password='$password'";

            $result = pg_query($dbhost, $sql);
            $count = pg_num_rows($result);
            if ($count == 1){
                $_SESSION['username'] = $username;
                $_SESSION['logged_in'] = true;
                echo "<h1><center>You have successfully logged in!</center></h1>";
            } else {
                echo "<h1>Sorry, invalid username or password.</h1>";
            }
        }
      ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
