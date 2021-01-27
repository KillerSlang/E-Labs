<?php
    if(!(empty($_GET) || empty($_GET["taal"]))){
        if($_GET["taal"] == "E"){
            setcookie("taal", "english");
            include_once "../Include/Engels.php";
        }
        if($_GET["taal"] == "N"){
            setcookie("taal", "nederlands");
            include_once "../Include/Nederlands.php";
        }
    } elseif($_COOKIE["taal"] == "english"){
        include_once "../Include/Engels.php";
    } else {
        include_once "../Include/Nederlands.php";
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title><?=$wwvergetentitel?></title>
        <link href="../Css/Main.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" type="image/png" href="../Images/favicon.png"/>
    </head>
    <body>
        <div id="ILachtergrond"> 
            <div id="Container">
                <div id="inlogbox">
                    <div id="logobalk">
                        
                        <div id="logobalklogo">
                            <img class="ILimg" src="../Images/Logo.png" alt = "Logo wit">
                        </div>

                        <div id="logobalktext">
                            <h1 id="ILh1"><b><?= $wwwijzigen ?></b></h1>
                        </div>

                        <div>
                            <?php
                             if($_GET["taal"] == "E"){ // als de taal engels is krijg je nl button.

                                echo '<a id="engelsknop" href="wwvergeten.php?taal=N">Nederlands</a>';

                             }else{                  // anders krijg je english button.

                                echo '<a id="engelsknop" href="wwvergeten.php?taal=E">English</a>';

                             }
                            ?>
                            
                        </div>
                    </div> 
                    <div id="inlogruimte">

                        

                        <form class="ILform" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
            
                            <div class="Invoerveld"><p><label for="Studentnummer"><b><?= $StudentNummer ?></b></label><br> 
                            <input class="ILinput" type = "Number" name = "Studentnummer" placeholder="<?= $voerstudentnummer ?>"></p></div>
                            
                            <div class="Invoerveld"><p><label for="Email"><b><?= $Email ?></b></label><br> 
                            <input class="ILinput" type = "email" name = "Email" placeholder="<?= $voeremail ?>"></p></div>
                            
                            <div id="Beveiliging"><p><b><?= $Beveiligingsvragen ?></b></p></div>

                            <div class="Invoerveld"><p><label for="Beveiligingsvraag1"><?= $Vraag1 ?></label><br>
                            <input class="ILinput" type = "text" name = "Vraag1" placeholder="<?= $antwoordvraag1 ?>"></p></div>

                            <div class="Invoerveld"><p><label for="Beveiligingsvraag2"><?= $Vraag2 ?></label><br>
                            <input class="ILinput" type = "text" name = "Vraag2" placeholder="<?= $antwoordvraag2 ?>"></p></div>

                            <div class="Invoerveld"><p><label for="Beveiligingsvraag3"><?= $Vraag3 ?></label><br>
                            <input class="ILinput" type = "text" name = "Vraag3" placeholder="<?= $antwoordvraag3 ?>"></p></div>

                            <div class="Invoerveld"><p><label for="Nieuwwachtwoord"><b><?= $Nieuwww ?></b></label><br>
                            <input class="ILinput" type = "password" name = "Nieuwwachtwoord" placeholder="<?= $voernieuwww ?>"></p></div>

                            <div class="Invoerveld"><p><label for="Herhaalwachtwoord"><b><?= $herhaalww ?></b></label><br>
                            <input class="ILinput" type = "password" name = "Herhaalwachtwoord" placeholder="<?= $voerherhaalww ?>"></p></div>

                            <div id="wwwijzigbutton"><input class="ILsubmit" type = "submit" name = "Submit" value = "<?= $Wijzigww ?>"></div>
                        </form> 

                        <div id="errorcodes"><b>

            <?php
    include_once '../Include/Dbh.inc.php';
    if(isset($_POST["Submit"])){
        
                $email = $_POST["Email"];
                $studentnummer = $_POST["Studentnummer"];
                
                $Pass = $_POST["Nieuwwachtwoord"];
                $Word = $_POST["Herhaalwachtwoord"];

                if($Pass === $Word){ // alleen als de wachtwoorden overeen komen dan pas mag je verder

                $PW = $Pass;

                }else{               // error message 
                    echo $Erregwwcheck; 
                    exit;
                }
                $Password = sha1($PW); 
                $vraag1 = sha1($_POST["Vraag1"]);
                $vraag2 = sha1($_POST["Vraag2"]); 
                $vraag3 = sha1($_POST["Vraag3"]);
                queryAanmaken( // kijkt welke studentID bij de gegevens hoort
                    'SELECT studentID 
                    FROM student 
                    WHERE studentNummer = ? AND studentEmail = ? AND beveiligingsVraag1 = ? AND beveiligingsVraag2 = ? AND beveiligingsVraag3 = ?'
                    ,"issss",
                    $studentnummer,$email,$vraag1,$vraag2,$vraag3
                );
                mysqli_stmt_bind_result($stmt, $studentID);
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) != 0) // we gaan er vanuit dat er maar 1 resultaat is.
                {
                    while (mysqli_stmt_fetch($stmt)){ }                                                            
                }
                querySluiten();   
                queryAanmaken( // als alles klopt wordt het wachtwoord geupdate
                    'UPDATE student 
                    SET wachtwoord = ?
                    WHERE studentID = ?'
                    ,"si",
                    $Password,$studentID
                    
                );
                querySluiten(); 
                Header("location: index.php"); // terug naar de inlog pagina         
                } 

            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>