<?php
session_start();


    $checking='';
    if(array_key_exists("logout",$_GET)=='1')
      {
          unset($_SESSION);
          setcookie("id","",time()-60*60);
          $_COOKIE['id']="";
      }
      

        if(isset($_POST['Username'])=='')
        {
          $checking.="Enter the Email id!<br>";
        }
        if(isset($_POST['Password'])=='')
        {
          $checking.="Enter the password!<br>";
        }
        $link=mysqli_connect("localhost","root","","crypto");
        if(isset($_POST['Username'])!=''&&$_POST['Password']!='')
        {
         
    
          if(mysqli_connect_error())
          {
            die("Database not connected successfully");
          }
          
          $query="SELECT `id` FROM `users` WHERE email = '".mysqli_real_escape_string($link,$_POST['Username'])."' LIMIT 1";
          $result=mysqli_query($link,$query);
    
          if(!$result or mysqli_num_rows($result)==0)
          {
             $query="INSERT INTO `users`(`email`,`password`) VALUES ('".mysqli_real_escape_string($link,$_POST['Username'])."','".mysqli_real_escape_string($link,$_POST['Password'])."')";
    
             if(mysqli_query($link,$query)){
               $query="SELECT id FROM `users` WHERE email='".mysqli_real_escape_string($link,$_POST['Username'])."'LIMIT 1";
               $result=mysqli_query($link,$query);
                $row=mysqli_fetch_array($result);
                $query="UPDATE `users` SET password = '".md5(md5($row['id']).$_POST['Password'])."' WHERE email = '".mysqli_real_escape_string($link,$_POST['Username'])."' LIMIT 1";
                mysqli_query($link,$query);
    
                $_SESSION['id']=$row['id'];
                if($_POST['stayloggedin']=='1')
                {
                  setcookie('id',$row['id'],time()+60*60*24*365);
                }
              
               
               header("Location:home.php");
             }
             else{
               echo "Not done";
             }
          }
          else{ 
            $checking.="Email is already registered! Try another one";
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
    <title>Crypto fun</title>
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

          <h1 class="design"><u>Crypto fun</u></h1>
          <h5 class="design">Practise and Pro your skills in cryptocurrency</h5>
          <div id="error"><?php if($checking!='')
          {
            echo '<div class="alert alert-danger working" role="alert"><span id="error">'.$checking.'</span></div>';
          }
            ?></div>
         

          <h6 class="design">Intrested ? Sign Up now!</h6>
            <p></p>
            <p></p>
            <form method="post">
          <div class="mb-3">
            
            <input type="email" class="form-control" id="emailing" name="Username" placeholder="Enter your Email">
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
          <input type="submit" class="btn btn-success" id="mybutton" value="Sign Up">
          </form>        
          <p></p>
          <a href="signin.php"class="mylogin"><strong>Log in</strong></a>
      

      </div>

        










    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    -->
  </body>
</html>