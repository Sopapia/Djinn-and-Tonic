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
              <a class="nav-link" href="profile.php">Profile</a>
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
       <p class="lead">Register New Account</p>
       <hr class="my-2">
       <form class="form-inline" action="register.php" method="POST">
                <input class="form-control mr-sm-2" type="text" placeholder="Username" name="userName">
                <input class="form-control mr-sm-2" type="text" placeholder="Password" name="password">
                <input class="form-control mr-sm-2" type="text" placeholder="First Name" name="fName">
                <input class="form-control mr-wm-2" type="text" placeholder="Last Name" name="lName">
                <button name="reg" class="btn btn-success" type="submit">Register</button>
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

        if (isset($_POST['reg'])){
            $username = $_POST['userName'];
            $password = $_POST['password'];
            $fName = $_POST['fName'];
            $lName = $_POST['lName'];
            $sql = "SELECT UserID from Client WHERE UserID='$username'";
            $result = pg_query($dbhost, $sql);
            $count = pg_num_rows($result);
            if ($count > 0){
                echo "<h1>Sorry, this username is taken.</h1>";
            }
            else {
                $sql = "INSERT INTO Client (FirstName, LastName, Username, Password) 
                    VALUES('". $fName ."', '". $lName ."', '". $username ."', '". $password ."')";
                pg_query($dbhost, $sql);
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
