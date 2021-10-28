<?php
session_start();
$link=mysqli_connect("localhost","root","","crypto");
    if(mysqli_connect_error())
    {
        die("Database not connected");
    }
    $query="SELECT `Total` FROM `users` WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
    $row=mysqli_fetch_array(mysqli_query($link,$query));
    $income=$row['Total'];
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/d7e943cb98.js"></script>
    <title>Crypto Fun</title>
    <style type='text/css'>
    body{
        background:url("currencybackground.jpeg");
      
        color:white;
    }
    h1{
        text-align:center;
        font-size:100px;
        font-weight:bold;
        text-decoration:underline;
    }
    h5{
        margin-top:50px;
        width:500px;
        font-size:30px;
        text-align:center

    }
    </style>
  </head>
  <body>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand">Crypto Fun</a>
        
            <span class="navbar-text">
            
            <b> Current Balance: <i class="fa fa-usd"></i> <?php echo($income) ?></b>
            </span>
        
        <a href="signin.php?logout=1"><button class="btn btn-outline-success" type="submit">Log Out</button></a>
        
    </div>
 </nav>
 
    <h1>Welcome to the world of cryptocurrency!</h1>
    <h5>Here you are going to take the same risks that you will take with the real money. This is only for the practise and to get the accuracy over the prices of the crypto currecy</h5>
    <marquee style="font-size:40px" behavior="scroll" direction="left">Explore the page to view all the options! </marquee>
    <div class="d-grid gap-2 col-6 mx-auto">
    <a role="button" href="checkprice.php"class="btn btn-outline-info">Click here to check the price of crypto</a>
  <a class="btn btn-warning" href="buyandsell.php" role="button">Click here to Buy or sell the crypto</a>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  </body>
</html>