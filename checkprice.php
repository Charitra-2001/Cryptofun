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
    $sol="<b><u>Current Price of cryptocurrency!</u></b><br>";
    for($i=0;$i<5;$i++)
        {
            $s="";
            if($i==0)
            {
                $s="BTC";
            }
            else if($i==1)
            {
                $s='ETH';
            }
            else if($i==2)
            {
                $s="ADA";
            }
            else if($i==3)
            {
                $s="DOGE";
            }
            else{
                $s="LTC";
            }
            $context = stream_context_create(array(
                'http' => array('ignore_errors' => true),
            ));
            
            $j=file_get_contents("https://api.coinbase.com/v2/prices/".$s."-USD/buy");
            $A=json_decode($j,true);

            $sol.="1 ".$s." = USD ".$A['data']['amount']."<br>";
        }
    $query="SELECT `Total` FROM `users` WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
    $row=mysqli_fetch_array(mysqli_query($link,$query));
    $income=$row['Total'];

    if(isset($_GET['mybutton'])==1)
    {
          

        $ans="";
        $json=file_get_contents("https://api.coinbase.com/v2/prices/".$_GET['currency']."-".$_GET['country']."/buy-H 'Authorization: Bearer abd90df5f27a7b170cd775abf89d632b350b7c1c9d53e08b340cd9832ce52c2c'");
        $arr=json_decode($json,true);
        
      
        $val=1;
        $cal=$_GET['calculate'];
        if($cal>0)
        {
            $val=$arr['data']['amount']*$_GET['calculate'];
            $ans.=$_GET['calculate']." ".$_GET['currency']." = ".$arr['data']['currency']." ".$val;
        }
        else{
            $errors.="Enter the valid value <br>";
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
    <title>Price Checker!</title>
    <style type="text/css">
        body{
            margin:0;
            padding:0;
            background-image:url("checkbackground.jpeg");
                    no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
            
        }
        .lete
        {
            width:850px;
            text-align:center;
            color:white;
            margin-top:35px
        }
        h1{
            font-size:50px;
        }
        h5{
            margin-bottom:30px;
        }
    </style>
  </head>
  <body>
  <nav class="navbar navbar-dark bg-#055288">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Crypto Fun</a>
        
            <span class="navbar-text">
            
            <b> Current Balance: <i class="fa fa-usd"></i> <?php echo($income) ?></b>
            </span>
        
        <a href="signin.php?logout=1"><button class="btn btn-outline-success" type="submit">Log Out</button></a>
        
    </div>
 </nav>
 <div class="dropdown">
  <button style="width:100%" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
   Categories
  </button>
  <ul  style="width:100%"  class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
    <li><a class="dropdown-item" href="home.php">Home</a></li>
    <li><a class="dropdown-item active" href="checkprice.php">Check price</a></li>
    <li><a class="dropdown-item" href="buyandsell.php">Buy and sell</a></li>
   
  </ul>
</div>

      <div class="container-fluid lete">

          <h1><u>Check the price and take the risk!</u></h1>
          <h5><u>Prices of the most popular crypto currencies is avaliable here</u></h5>
          <div class="current">
            <?php

                echo('<div class="alert alert-warning" role="alert"><span class="current">'
               .$sol.
                '</span></div>');
            
            
            ?>
          </div>
          <div class="ans">
        <?php
                if($ans&&$errors=="")
                {

                    echo('<div class="alert alert-success" role="alert"><span class="current">'
               .$ans.
                '</span></div>');
                }
                else if($errors){

                echo('<div class="alert alert-danger" role="alert"><span class="current">'
               .$errors.
                '</span></div>');
                }
                ?>
          </div>
              <form>
            <div class="row">
                <div class="col">
                    <select class="form-select sizing" name='currency' aria-label="Default select example">
                        <option value="BTC" selected> Bitcoin </option>
                        <option value="ETH" > Ethereum </option>
                        <option value="ADA" > Cardano </option>
                        <option value="DOGE" > Dogecoin </option>
                        <option value="LTC" > Litecoin </option>
                    </select>
                </div>
                <div class="col">
                    <select class="form-select sizing" name='country' aria-label="Default select example">
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
    
            <div style="margin-top:20px"class="input-group mb-3">
            <input type="number"  name='calculate' class="form-control" placeholder="Enter the amount of crypto you want " aria-label="Recipient's username" aria-describedby="button-addon2">
            <input class="btn btn-info" type="submit" name='mybutton' id="button-addon2" value="Check">
            </div>
          
        </form>
          </div>
                <marquee style="font-size:40px; color:white; text-weight:bold; margin-top:25px" behavior="scroll" direction="left"><u>Price of the crypto changes very quickly. Please refresh the page to see the latest update!</u></marquee>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  </body>
</html>