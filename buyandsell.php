<?php
    session_start();


    $ans="";
    $errors="";
    $link=mysqli_connect("localhost","root","","crypto");
    if(mysqli_connect_error())
    {
        die("Database not connected");
    }
    $query="SELECT * FROM `users` WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
    $row=mysqli_fetch_array(mysqli_query($link,$query));
    $sol="<b><u>The crypto you are having</u></b> <br>";
    $sol.="<b>BTC</b> : ".$row['BTC']."<br>";
    $sol.="<b>ETH</b> : ".$row['ETH']."<br>";
    $sol.="<b>ADA</b> : ".$row['ADA']."<br>";
    $sol.="<b>DOGE</b> : ".$row['DOGE']."<br>";
    $sol.="<b>LTC</b> : ".$row['LTC']."<br>";

    $query="SELECT `Total` FROM `users` WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
    $row=mysqli_fetch_array(mysqli_query($link,$query));
    $income=$row['Total'];
    if(isset($_GET['buy'])==1)
    {
        
        // for converting currency
        
        $curr=file_get_contents("https://open.er-api.com/v6/latest/".$_GET['paise']."");
        $money=json_decode($curr,true);
        $json=file_get_contents("https://api.coinbase.com/v2/prices/".$_GET['buying']."-USD/buy");
        $arr=json_decode($json,true);

       if(isset($_GET['amount'])!=0)
       {
           
           $conver=$_GET['amount']*$money['rates']['USD'];
           if($income>=$conver)
           {

               $income-=$conver;
               $query="UPDATE users SET `Total`='$income' WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
               mysqli_query($link,$query);
               $cal=$conver/$arr['data']['amount'];
               $n=$_GET['buying'];
               $query="UPDATE users SET `$n` = '$cal' WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
               mysqli_query($link,$query);
               $ans.="You Buyed ".$cal." ".$_GET['buying']." of USD ".$conver;           
            
           }
           else{
               $errors.='Not enough money to buy the crypto'.'<br>';
           }

       }
       else{
           $errors.='Enter the valid amount'.'<br>';
       }


    }
    else if(isset($_GET['sell'])==1)
    {


       
        $json = file_get_contents("https://api.coinbase.com/v2/prices/".$_GET['selling']."-USD/sell");
        $arr=json_decode($json,true);

        $val=1;
        if(isset($_GET['sellingamount'])!=0)
        {
            $n=$_GET['selling'];
            $query="SELECT `$n` FROM `users` WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
            $row=mysqli_fetch_array(mysqli_query($link,$query));
            $lim=$row[$n];
          

            if($lim>=$_GET['sellingamount'])
            {
                $val=$arr['data']['amount']*$_GET['sellingamount'];
                $income+=$val;
                $query="UPDATE users SET `Total`='$income' WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
                mysqli_query($link,$query);
                $ansss=$_GET['sellingamount'];
                $solution=$lim -$ansss;
                $query="UPDATE users SET `$n`='$solution' WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
                mysqli_query($link,$query);
                $ans.=$_GET['sellingamount']." ".$_GET['selling']." sold of  USD ".$val;
            }
            else{
                $errors.="Not enough ".$n." to sell<br>";
            }
          
        }
        else{

            $errors.="Enter the amount of the crypto you want to sell"."<br>"; 

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
    <script src="https://use.fontawesome.com/d7e943cb98.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <title>Buy and Sell</title>
    <style type="text/css">
    body{
        background-image:url("buyandsellbackground.jpeg");
    }
    h1{
        text-decoration:underline;
        font-weight:bold;
        font-size:38px;
    }
    .container
    {
        text-align:center;
        width:880px;
      background-color:#EBD090;
      color:#47d160;
      margin-top:10px;
    
    }
    </style>
  </head>
  <body>
  <nav class="navbar navbar-light" style="background-color:#CC9A07">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Crypto Fun</a>
        
            <span class="navbar-text">
            
            <b> Current Balance: <i class="fa fa-usd"></i> <?php echo($income) ?></b>
            </span>
        
        <a href="signin.php?logout=1"><button class="btn btn-outline-success" type="submit">Log Out</button></a>
        
    </div>
 </nav>
 <div class="dropdown">
  <button style="width:100%" class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
   Categories
  </button>
  <ul  style="width:100%"  class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
    <li><a class="dropdown-item" href="home.php">Home</a></li>
    <li><a class="dropdown-item" href="checkprice.php">Check price</a></li>
    <li><a class="dropdown-item active" href="buyandsell.php">Buy and sell</a></li>
   
  </ul>
</div>

    <div class="container">
        <h1>Buy and Sell the crypto on the latest prices!</h1>
       
        <div class="current">
            <?php

                echo('<div class="alert alert-warning" role="alert"><span class="current">'
               .$sol.
                '</span></div>');
            
            
            ?>
          </div>
          <div class="ans"><?php if($ans&&$errors=="")
        {
           echo( '<div class="alert alert-success" role="alert"> <span class="ans">'
            .$ans.
            '</span></div>');
        }
        else if($errors){

            echo( '<div class="alert alert-danger" role="alert"> <span class="ans">'
            .$errors.
            '</span></div>');

        } ?></div>
         <form>
        <h1>Buy  the crypto</h1>
        <h5>Select the currency in which you want to buy the crypto</h5>

       
        <div class="row">
            <div class="col">
                <select class="form-select sizing" name='buying' aria-label="Default select example">
                    <option value="BTC" selected> Bitcoin </option>
                    <option value="ETH" > Ethereum </option>
                    <option value="ADA" > Cardano </option>
                    <option value="DOGE" > Dogecoin </option>
                    <option value="LTC" > Litecoin </option>
                </select>
            </div>
            <div class="col">
                <select class="form-select sizing" name='paise' aria-label="Default select example">
                    <option value="AFN">Afghan Afghani</option>
                    <option value="ALL">Albanian Lek</option>
                    <option value="DZD">Algerian Dinar</option>
                    <option value="AOA">Angolan Kwanza</option>
                    <option value="ARS">Argentine Peso</option>
                    <option value="AMD">Armenian Dram</option>
                    <option value="AWG">Aruban Florin</option>
                    <option value="AUD">Australian Dollar</option>
                    <option value="AZN">Azerbaijani Manat</option>
                    <option value="BSD">Bahamian Dollar</option>
                    <option value="BHD">Bahraini Dinar</option>
                    <option value="BDT">Bangladeshi Taka</option>
                    <option value="BBD">Barbadian Dollar</option>
                    <option value="BYR">Belarusian Ruble</option>
                    <option value="BEF">Belgian Franc</option>
                    <option value="BZD">Belize Dollar</option>
                    <option value="BMD">Bermudan Dollar</option>
                    <option value="BTN">Bhutanese Ngultrum</option>
                    <option value="BTC">Bitcoin</option>
                    <option value="BOB">Bolivian Boliviano</option>
                    <option value="BAM">Bosnia-Herzegovina Convertible Mark</option>
                    <option value="BWP">Botswanan Pula</option>
                    <option value="BRL">Brazilian Real</option>
                    <option value="GBP">British Pound Sterling</option>
                    <option value="BND">Brunei Dollar</option>
                    <option value="BGN">Bulgarian Lev</option>
                    <option value="BIF">Burundian Franc</option>
                    <option value="KHR">Cambodian Riel</option>
                    <option value="CAD">Canadian Dollar</option>
                    <option value="CVE">Cape Verdean Escudo</option>
                    <option value="KYD">Cayman Islands Dollar</option>
                    <option value="XOF">CFA Franc BCEAO</option>
                    <option value="XAF">CFA Franc BEAC</option>
                    <option value="XPF">CFP Franc</option>
                    <option value="CLP">Chilean Peso</option>
                    <option value="CNY">Chinese Yuan</option>
                    <option value="COP">Colombian Peso</option>
                    <option value="KMF">Comorian Franc</option>
                    <option value="CDF">Congolese Franc</option>
                    <option value="CRC">Costa Rican ColÃ³n</option>
                    <option value="HRK">Croatian Kuna</option>
                    <option value="CUC">Cuban Convertible Peso</option>
                    <option value="CZK">Czech Republic Koruna</option>
                    <option value="DKK">Danish Krone</option>
                    <option value="DJF">Djiboutian Franc</option>
                    <option value="DOP">Dominican Peso</option>
                    <option value="XCD">East Caribbean Dollar</option>
                    <option value="EGP">Egyptian Pound</option>
                    <option value="ERN">Eritrean Nakfa</option>
                    <option value="EEK">Estonian Kroon</option>
                    <option value="ETB">Ethiopian Birr</option>
                    <option value="EUR">Euro</option>
                    <option value="FKP">Falkland Islands Pound</option>
                    <option value="FJD">Fijian Dollar</option>
                    <option value="GMD">Gambian Dalasi</option>
                    <option value="GEL">Georgian Lari</option>
                    <option value="DEM">German Mark</option>
                    <option value="GHS">Ghanaian Cedi</option>
                    <option value="GIP">Gibraltar Pound</option>
                    <option value="GRD">Greek Drachma</option>
                    <option value="GTQ">Guatemalan Quetzal</option>
                    <option value="GNF">Guinean Franc</option>
                    <option value="GYD">Guyanaese Dollar</option>
                    <option value="HTG">Haitian Gourde</option>
                    <option value="HNL">Honduran Lempira</option>
                    <option value="HKD">Hong Kong Dollar</option>
                    <option value="HUF">Hungarian Forint</option>
                    <option value="ISK">Icelandic KrÃ³na</option>
                    <option value="INR">Indian Rupee</option>
                    <option value="IDR">Indonesian Rupiah</option>
                    <option value="IRR">Iranian Rial</option>
                    <option value="IQD">Iraqi Dinar</option>
                    <option value="ILS">Israeli New Sheqel</option>
                    <option value="ITL">Italian Lira</option>
                    <option value="JMD">Jamaican Dollar</option>
                    <option value="JPY">Japanese Yen</option>
                    <option value="JOD">Jordanian Dinar</option>
                    <option value="KZT">Kazakhstani Tenge</option>
                    <option value="KES">Kenyan Shilling</option>
                    <option value="KWD">Kuwaiti Dinar</option>
                    <option value="KGS">Kyrgystani Som</option>
                    <option value="LAK">Laotian Kip</option>
                    <option value="LVL">Latvian Lats</option>
                    <option value="LBP">Lebanese Pound</option>
                    <option value="LSL">Lesotho Loti</option>
                    <option value="LRD">Liberian Dollar</option>
                    <option value="LYD">Libyan Dinar</option>
                    <option value="LTL">Lithuanian Litas</option>
                    <option value="MOP">Macanese Pataca</option>
                    <option value="MKD">Macedonian Denar</option>
                    <option value="MGA">Malagasy Ariary</option>
                    <option value="MWK">Malawian Kwacha</option>
                    <option value="MYR">Malaysian Ringgit</option>
                    <option value="MVR">Maldivian Rufiyaa</option>
                    <option value="MRO">Mauritanian Ouguiya</option>
                    <option value="MUR">Mauritian Rupee</option>
                    <option value="MXN">Mexican Peso</option>
                    <option value="MDL">Moldovan Leu</option>
                    <option value="MNT">Mongolian Tugrik</option>
                    <option value="MAD">Moroccan Dirham</option>
                    <option value="MZM">Mozambican Metical</option>
                    <option value="MMK">Myanmar Kyat</option>
                    <option value="NAD">Namibian Dollar</option>
                    <option value="NPR">Nepalese Rupee</option>
                    <option value="ANG">Netherlands Antillean Guilder</option>
                    <option value="TWD">New Taiwan Dollar</option>
                    <option value="NZD">New Zealand Dollar</option>
                    <option value="NIO">Nicaraguan CÃ³rdoba</option>
                    <option value="NGN">Nigerian Naira</option>
                    <option value="KPW">North Korean Won</option>
                    <option value="NOK">Norwegian Krone</option>
                    <option value="OMR">Omani Rial</option>
                    <option value="PKR">Pakistani Rupee</option>
                    <option value="PAB">Panamanian Balboa</option>
                    <option value="PGK">Papua New Guinean Kina</option>
                    <option value="PYG">Paraguayan Guarani</option>
                    <option value="PEN">Peruvian Nuevo Sol</option>
                    <option value="PHP">Philippine Peso</option>
                    <option value="PLN">Polish Zloty</option>
                    <option value="QAR">Qatari Rial</option>
                    <option value="RON">Romanian Leu</option>
                    <option value="RUB">Russian Ruble</option>
                    <option value="RWF">Rwandan Franc</option>
                    <option value="SVC">Salvadoran ColÃ³n</option>
                    <option value="WST">Samoan Tala</option>
                    <option value="SAR">Saudi Riyal</option>
                    <option value="RSD">Serbian Dinar</option>
                    <option value="SCR">Seychellois Rupee</option>
                    <option value="SLL">Sierra Leonean Leone</option>
                    <option value="SGD">Singapore Dollar</option>
                    <option value="SKK">Slovak Koruna</option>
                    <option value="SBD">Solomon Islands Dollar</option>
                    <option value="SOS">Somali Shilling</option>
                    <option value="ZAR">South African Rand</option>
                    <option value="KRW">South Korean Won</option>
                    <option value="XDR">Special Drawing Rights</option>
                    <option value="LKR">Sri Lankan Rupee</option>
                    <option value="SHP">St. Helena Pound</option>
                    <option value="SDG">Sudanese Pound</option>
                    <option value="SRD">Surinamese Dollar</option>
                    <option value="SZL">Swazi Lilangeni</option>
                    <option value="SEK">Swedish Krona</option>
                    <option value="CHF">Swiss Franc</option>
                    <option value="SYP">Syrian Pound</option>
                    <option value="STD">São Tomé and Príncipe Dobra</option>
                    <option value="TJS">Tajikistani Somoni</option>
                    <option value="TZS">Tanzanian Shilling</option>
                    <option value="THB">Thai Baht</option>
                    <option value="TOP">Tongan pa'anga</option>
                    <option value="TTD">Trinidad & Tobago Dollar</option>
                    <option value="TND">Tunisian Dinar</option>
                    <option value="TRY">Turkish Lira</option>
                    <option value="TMT">Turkmenistani Manat</option>
                    <option value="UGX">Ugandan Shilling</option>
                    <option value="UAH">Ukrainian Hryvnia</option>
                    <option value="AED">United Arab Emirates Dirham</option>
                    <option value="UYU">Uruguayan Peso</option>
                    <option value="USD" selected>US Dollar</option>
                    <option value="UZS">Uzbekistan Som</option>
                    <option value="VUV">Vanuatu Vatu</option>
                    <option value="VEF">Venezuelan BolÃ­var</option>
                    <option value="VND">Vietnamese Dong</option>
                    <option value="YER">Yemeni Rial</option>
                    <option value="ZMK">Zambian Kwacha</option>
                </select>
            </div>
        </div>
        <p></p>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa fa-money"></i></span>
          
            <input type="number" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" name='amount' placeholder="Enter the amount">
        </div>
        <input class="btn btn-primary dis" name='buy'type="submit" value="Buy">
       <p></p>
       <p></p>
        <h1>Sell the crypto</h1>
        <h5>Select the crypto you want to sell</h5>

       
        <div class="row">
            <div class="col">
                <select class="form-select sizing" name='selling' aria-label="Default select example">
                    <option value="BTC" selected> Bitcoin </option>
                    <option value="ETH" > Ethereum </option>
                    <option value="ADA" > Cardano </option>
                    <option value="DOGE" > Dogecoin </option>
                    <option value="LTC" > Litecoin </option>
                </select>
            </div>
        </div>
        <p></p>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa fa-btc"></i></span>
          
            <input type="number" step='0.00000000000000001'class="form-control" aria-label="Dollar amount (with dot and two decimal places)" name='sellingamount' id="datapoint" placeholder="Enter the amount of crypto you want to sell">
        </div>
    
        <input class="btn btn-primary dis" name='sell' type="submit" value="Sell">
      
    </div>
    </form>
  

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  </body>
</html>