<?php
    if(!(empty($_GET) || empty($_GET["taal"]))){ // de taalswitch button
        if($_GET["taal"] == "E"){
            setcookie("taal", "english");
            include_once "../Include/Engels.php"; // engelse taal
        }
        if($_GET["taal"] == "N"){
            setcookie("taal", "nederlands");
            include_once "../Include/Nederlands.php"; // nederlandse taal.
        }
    } elseif($_COOKIE["taal"] == "english"){     // kijkt of er al een engels cookie gezet is
        include_once "../Include/Engels.php";   // include de engelse vertalingen
    } else {
        include_once "../Include/Nederlands.php"; // include de nederlandse vertalingen
    }
?>
<!DOCTYPE HTML>
<html>
    <head> 
        <title><?= $InlogPagina ?></title> 
        <link href="../Css/Main.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" type="image/png" href="../Images/favicon.png"/>
    </head>
    <body> 
        <div id="ILachtergrond">
            <div id="Container">
                <div id="inlogbox">
                    <div id="logobalk">
                        <div id="logobalklogo">
                            <img class="ILimg" src="../Images/Logo.png" alt = "Logo wit" >
                        </div>

                        <div id="logobalktext">
                            <h1 id="ILh1"><b><?= $Welkom ?></b></h1>
                        </div>

                        <div>
                            <?php
                             if($_GET["taal"] == "E"){ // als de taal engels is krijg je nl button.

                                echo '<a id="engelsknop" href="index.php?taal=N">Nederlands</a>';

                             }else{                    // anders krijg je english button.

                                echo '<a id="engelsknop" href="index.php?taal=E">English</a>';

                             }
                            ?>
                        </div>

                    </div>
                        
                    <div id="inlogruimte">
                    
                        <form class="ILform" action = "Inlog.php" method = "POST" >
                            <div class="Invoerveld"><p><label for="Email"><b><?= $Email ?></b></label><br> 
                            <input class="ILinput" type = "email" name = "Email" placeholder="<?= $voeremail ?>"></p></div>

                            <div class="Invoerveld"><p><label for="Password"><b><?= $Wachtwoord ?></b></label><br>
                            <input class="ILinput" type = "password" name = "Password" placeholder="<?= $voerww?>"></div>
                            <div id="wwvergeten"><a id="ILww" href = "wwvergeten.php" ><?= $Wwvergeten ?></a></div>

                            <div id="SorD"><p><input class="ILradio" type = "radio" id = "Student" name = "SorD" value = "Student" checked = "checked"><?= $Student ?>
                            <input class="ILradio" type = "radio" id = "Docent" name = "SorD" value = "Docent"><?= $Docent ?></div>
                            
                            
                            <div id="inlogbutton">
                                <input class="ILsubmit" type = "submit" name = "Submit" value = "<?= $Inloggen ?>">
                            </div>
                            
                            <div id="registrerenbutton">
                                <button formaction = "Registreer.php"><?= $Registreren ?></button>
                            </div>
                            
                        </form>

                        <div id="errorcodes">
                            <b>
                                <?php
                                    if(!empty($_GET) && !empty($_GET["error"])){ // uit de link word de error code gehaald.
                                        $errorcode = $_GET["error"];
                                        
                                        if($errorcode == "1"){

                                        $error = "Probeer opnieuw";

                                        echo $error;

                                        }

                                        
                                    }
                                ?>
                            </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>