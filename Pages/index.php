<!DOCTYPE HTML>
<html>
    <head>

        <?php
            if(!empty($_GET && !empty($_GET["taal"]))){
                if($_GET["taal"] == "E"){
                    setcookie("taal", "english");
                }
            }
            if($_COOKIE["taal"] == "Nederlands"){
                include_once "../Include/Nederlands.php";
            } else {
                include_once "../Include/Engels.php";
            }
        ?>  


        <title><?= $InlogPagina ?></title>
        <link href="../Css/inlog.css" rel="stylesheet" type="text/css">
        <link href="../Css/Main.css" rel="stylesheet" type="text/css">
        
    </head>
    <body> 
    <div id="ILachtergrond">
        <div id="Container">
            <div id="inlogbox">
                <div id="logobalk">
                    <div id="logobalklogo">
                        <img src="../Images/Logo.png" alt = "Logo wit" >
                   </div>

                    <div id="logobalktext">
                        <h1><b><?= $Welkom ?></b></h1>
                    </div>
                </div>
                
                <div id="inlogruimte">
                   
                        <form action = "Inlog.php" method = "POST" >
                            <div id="Invoerveld1"><p><label for="Email"><b><?= $Email ?></b></label><br> 
                            <input type = "email" name = "Email" placeholder="<?= $voeremail ?>"></p></div>

                            <div id="Invoerveld2"><p><label for="Password"><b><?= $Wachtwoord ?></b></label><br>
                            <input type = "password" name = "Password" placeholder="<?= $voerww?>"></div>
                            <div id="wwvergeten"><a href = "wwvergeten.php" ><?= $Wwvergeten ?></a></div>

                            <div id="SorD"><p><input type = "radio" id = "Student" name = "SorD" value = "Student" checked = "checked"><?= $Student ?>
                            <input type = "radio" id = "Docent" name = "SorD" value = "Docent"><?= $Docent ?></div>
                            
                            
                            <div id="inlogbutton">
                                <input type = "submit" name = "Submit" value = "<?= $Inloggen ?>">
                            </div>
                            
                            <div id="registrerenbutton">
                                <button formaction = "Registreer.php"><?= $Registreren ?></button>
                            </div>
                            
                        </form>

                        <div id="errorcodes"><b>
                                
                                <?php
                                    if(!empty($_GET) && !empty($_GET["error"])){
                                        $errorcode = $_GET["error"];
                                        
                                        if($errorcode == "1"){

                                        $error = "Probeer opnieuw";

                                        echo $error;

                                        }

                                        
                                    }
                                ?>

                        </b></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>