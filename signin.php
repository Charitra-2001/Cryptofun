<?php


      session_start();
      $checking="";
      if(array_key_exists("logout",$_GET)=='1')
      {
          unset($_SESSION);
          setcookie("id","",time()-60*60);
          $_COOKIE['id']="";
      }
      
   


        $link=mysqli_connect("localhost","root","","crypto");
       
        if(isset($_POST['Username'])=='')
        {
          $checking.="Enter the Email id!<br>";
        }
        if(isset($_POST['Password'])=='')
        {
          $checking.="Enter the password!<br>";
        }
        if(isset($_POST['Username'])!=''&&isset($_POST['Password'])!='')
        {
          

          if(mysqli_connect_error())
          {
            die("Database not connected successfully");
          }
          $query="SELECT `id` FROM `users` WHERE email = '".mysqli_real_escape_string($link,$_POST['Username'])."'";
          $result=mysqli_query($link,$query);
          if(!$result or mysqli_num_rows($result)==0)
          {
           
            $checking=("Email is not registerd. Sign Up please<br>");
            
           
           
          }
          else{

             $row=mysqli_fetch_assoc($result);
              $pass=md5(md5($row['id']).$_POST['Password']);
              $_SESSION['id']=$row['id'];
              if('stayloggedin'=='1')
              {
                setcookie("id",$row['id'],time()+24*60*60*365);
              }
            $query="SELECT `password` FROM `users` WHERE email = '".mysqli_real_escape_string($link,$_POST['Username'])."'";
            $result=mysqli_query($link,$query);
            $row=mysqli_fetch_array($result);
            if($row['password']==$pass)
            {

            
              header("Location:home.php");
            }
            else{
              
             
                $checking=("Incorrect Password!<br>");
                
            }
          }

        }
        
      


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Crypto Fun</title>
    <style type="text/css">

        body{
            background-image:url("loginbackground.jpeg");
           background-position:top;
        }
        
        .container{
            width:450px;
            margin-top:17%;
        }
        .design{
            color:white;
        }
        .place{
            margin-left:30%;
        }
    </style>
  </head>
  <body class="img-responsive">
      <div class="container" style="text-align:center">

          <h1 class="design"><u>Crypto Fun</u></h1>
          <h5 class="design">Practise and Pro your skills in cryptocurrency</h5>
          <div id="error"><?php if($checking!='')
          {
            echo '<div class="alert alert-danger working" role="alert"><span id="error">'.$checking.'</span></div>';
          }
            ?></div>
          <h6 class="design">Enter your username and password</h6>
            <p></p>
            <p></p>
          <form method="post">
          <div class="mb-3">
            
            <input type="email" class="form-control" id="email" name="Username"placeholder="Enter your Email">
            </div>
            <div class="mb-3">
            
            <input type="password" class="form-control" id="passwords" name="Password"placeholder="Enter your Password">
          </div>
          <p></p>
          <div class="form-check" style="margin-left:34%">
            <input class="form-check-input place" type="checkbox" value="" id="flexCheckDefault" name="stayloggedin">
            <label style="float:left"class="form-check-label design" for="flexCheckDefault">
                Stay logged in
            </label>
          </div>
          <p></p>
          <input class="btn btn-success" type="submit" id="mybutton" value="Log In!">
      </form>
          <p></p>
          <a href="signup.php"class="mylogin"><strong>Sign Up</strong></a>
      </div>

      
      
     









    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    -->
  </body>
</html>