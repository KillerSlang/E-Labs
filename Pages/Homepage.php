<!DOCTYPE HTML>
<html>
    <head>
        <title><?=$Homepagina?></title>

        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"> -->
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="stylesheet" href="../Css/Responsive.css">
    </head>
    <body>
        <header> 
            <?php 
            /* Header */
            include_once '../Include/Header.php';
            ?>
        </header>

        <div id="mainhomepage">
            <h1 id="Hh1"><?=$Bestemming?></h1>
            <hr>

            <div id ="container">
                <div class="homebtn" onclick="location.href='voorbereidingen.php';" id="Voorbereidingen">
                    
                    <p><?=$Voorbereidingen?></p>
                    <hr>
                    <img class='homeimage' id="Voorbereidingenimage" src="../Images/Voorbereidingenicon.png" alt="Voorbereiding icon">

                </div>
                <div class="homebtn" onclick="location.href='labjournalen.php?jaar=0';" id="Labjournalen">
                    
                    <p><?=$Labjournalen?></p>
                    <hr>
                    <img class='homeimage' id="Labjournalenimage" src="../Images/Labjournalenicon.png" alt="Labjournalen icon">
                    
                </div>
                
                <div class="homebtn" onclick="location.href='Protocollen.php?jaar=0';" id="Protocollen">
                    
                    <p><?=$Protocollen?></p>
                    <hr>
                    <img class='homeimage' id="Protocollenimage" src="../Images/Protocollenicon.png" alt="Protocollen icon">
                    
                </div>

        <?php

         if($_SESSION["SorD"] == "Student"){
            echo'
                <div onclick=window.location="Voorbereidingenaanmaak.php" class="homebtn" id="Voorbereidingenaanmaken">
                   
                        <p>'.$VoorbereidingNieuw.'</p>
                        <hr>      
                        <img class="homeimage" id="Voorbereidingenaanmakenimage" src="../Images/Voorbereidingen_small.png" alt="Voorbereiding small icon">
                       
                </div>
                <div onclick=window.location="labjournaalformulier.php" class="homebtn" id="Labjournalenaanmaken">
                    
                    <p>'.$LabjournaalNieuw.'</p>
                    <hr>
                    <img class="homeimage" id="Labjournalenaanmakenimage" src="../Images/Labjournalen_small.png" alt="Labjournalen small icon">
                    
                </div>
                <div onclick=window.location="NewProtocol.php" class="homebtn" id="Protocollenaanmaken">
                    
                    <p>'.$ProtocolNieuw.'</p>
                    <hr>
                    <img class="homeimage" id="Protocollenaanmakenimage" src="../Images/Protocollen_small.png" alt="Protocollen small icon">
                    
                </div>';
         }

        ?>

            </div>
            
        </div>

            
                <?php 
                /* Footer */
                include_once '../Include/Footer.php';
                ?> 
            
    </body>

</html>