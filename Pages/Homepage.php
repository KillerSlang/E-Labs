<?php session_start();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Homepagina</title>

        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"> -->
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="stylesheet" href="../Css/Responsive.css">
        <link href="../Css/Homepage.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header> 
            <?php 
            /* Header */
            include_once '../Include/Header.php';
            ?>
        </header>

        <div id="mainhomepage">
            <h1 id="Hh1">Kies uw bestemming</h1>
            <hr>

            <div id ="container">
                <div id="Voorbereidingen">
                    
                        <p>Voorbereidingen</p>
                        <hr>
                    <a href="<?php if($_SESSION["SorD"] == "Student"){echo "voorbereidingen.php";}elseif($_SESSION["SorD"] == "Docent"){echo "voorbereidingen.php";} ?>">
                        <img id="Voorbereidingenimage" src="../Images/Voorbereidingenicon.png" alt="Voorbereiding icon">
                    </a>
                </div>
                <div id="Labjournalen">
                    
                        <p>Labjournalen</p>
                        <hr>
                    <a href="<?php if($_SESSION["SorD"] == "Student"){echo "labjournalen.php";}elseif($_SESSION["SorD"] == "Docent"){echo "labjournalen";} ?>">    
                        <img id="Labjournalenimage" src="../Images/Labjournalenicon.png" alt="Labjournalen icon">
                    </a>
                </div> 
                <div id="Protocollen">
                    
                        <p>Protocollen</p>
                        <hr>
                    <a href="<?php if($_SESSION["SorD"] == "Student"){echo "Protocollen.php";}elseif($_SESSION["SorD"] == "Docent"){echo "Protocollen.php";} ?>">
                        <img id="Protocollenimage" src="../Images/Protocollenicon.png" alt="Protocollen icon">
                    </a>
                </div>

        <?php

         if($_SESSION["SorD"] == "Student"){
            echo   "<div id='Voorbereidingenaanmaken'>
                    
                            <p>Nieuwe Voorbereiding</p>
                            <hr>
                        <a href='Voorbereidingenaanmaak.php'>        
                            <img id='Voorbereidingenaanmakenimage' src='../Images/Voorbereidingen_small.png' alt='Voorbereiding small icon'>
                        </a>
                    </div>
                    <div id='Labjournalenaanmaken'>
                        
                            <p>Nieuw Labjournaal</p>
                            <hr>
                        <a href='labjournaalformulier.php'>
                            <img id='Labjournalenaanmakenimage' src='../Images/Labjournalen_small.png' alt='Labjournalen small icon'>
                        </a>
                    </div> 
                    <div id='Protocollenaanmaken'>
                        
                            <p>Nieuw Protocool</p>
                            <hr>
                        <a href='NewProtocol.php'>
                            <img id='Protocollenaanmakenimage' src='../Images/Protocollen_small.png' alt='Protocollen small icon'>
                        </a>
                    </div>";
         }

        ?>

            </div>
            
        </div>

            <footer>
                <?php 
                /* Footer */
                include_once '../Include/Footer.php';
                ?> 
            </footer>
    </body>

</html>