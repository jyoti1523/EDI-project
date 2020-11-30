<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
      echo '<script>alert("Username cannot be blank")</script>';
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                 
                  echo '<script>alert("already usernmae taken")</script>';
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
            
                echo '<script>alert("somthing went wrong")</script>';
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
        echo '<script>alert("Passwords should match")</script>';

}
//check for fullname
if(empty(trim($_POST['fullname']))){
    $fullname_err = "fullname not blank";
}
else{
    $fullname = trim($_POST['fullname']);
}

// check for mobile
if(empty(trim($_POST['mobile']))){
    $mobile_err = "mobile not blank";
}
else{
    $mobile = trim($_POST['mobile']);
}


// check for branch
if(empty(trim($_POST['branch']))){
    $branch_err = "branch not blank";
}
else{
    $branch = trim($_POST['branch']);
}





// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username, password,fullname,mobile,branch) VALUES (?, ? ,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "sssis", $param_username, $param_password ,$param_fullname,$param_mobile,$param_branch);

        // Set these parameters
        $param_username = $username;
        $param_fullname=$fullname;
        $param_mobile = $mobile;
        $param_branch=$branch;
        
        $param_password = password_hash($password, PASSWORD_DEFAULT);
      

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            
          echo '<script>alert("Something went wrong so wait")</script>';
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>PHP login system!</title>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"> Login System</a>
  
 
  
  <ul class="navbar-nav">
      
     
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Login</a>
      </li>

      
     
    </ul>
  </div>
</nav>

    <style type="text/css">
      body{
        background-color: black;
      }
      div{
        color: white;
      }
      div.logo{
      color: #d9d9d9;
      font-size: 60px;
      font-family: sans-serif;
      
    }
    .cornerlogo{
      border-radius: 50%;
    }
    li a{
      text-decoration: none;
    }
    </style>
  </head>
  <body>
    
  
<div class="logo"><img class="cornerlogo" src="pictures/prakalp.png" height="100" width="100" alt="Avatar">Prakalp</div>  


<div class="container mt-4">
<h3>Please Sign up Here:</h3>
<hr>
<form action="" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">GR NO</label>
      <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="Email" required="">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" name ="password" id="inputPassword4" placeholder="Password" required="">
    </div>
  
  <div class="form-group col-md-6">
      <label for="inputPassword4">Confirm Password</label>
      <input type="password" class="form-control" name ="confirm_password" id="inputPassword"   required="" placeholder="Confirm Password">
    </div>
    
  <div class="form-group col-md-6">
    <label for="inputAddress2">Full Name</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder=" Enter your Name", name="fullname" >
  </div>
  
  <div class="form-group col-md-6">
    <label for="inputAddress2">Mobile No</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder=" Enter your Name", name="mobile" >
  </div>
  <div class="form-group col-md-6">
    <label for="inputAddress2">Branch</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder=" Enter your Name", name="branch" >
  </div>
  
  <button type="submit" class="btn btn-primary" onclick="login.php">Sign in </button>
</div>

</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    

  </body>
</html>
