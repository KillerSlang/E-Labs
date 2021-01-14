<!DOCTYPE HTML>
<html>
    <head>

    <?php
            if(!empty($_GET && !empty($_GET["taal"]))){
                if($_GET["taal"] == "E"){
                    setcookie("taal", "english");
                }
            }
            if($_COOKIE["taal"] == "Engels"){
                include_once "../Include/Engels.php";
            } else {
                include_once "../Include/Nederlands.php";
            }
        ?> 

        <title><?= $wwvergetentitel ?></title>
        <link href="../Css/inlog.css" rel="stylesheet" type="text/css">
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
                            <h1><b><?= $wwwijzigen ?></b></h1>
                        </div>
                    </div> 
                    <div id="inlogruimte">

                        

                        <form class="ILform" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
            
                            <div id="Invoerveld1"><p><label for="Studentnummer"><b><?= $StudentNummer ?></b></label><br> 
                            <input class="ILinput" type = "Number" name = "Studentnummer" placeholder="<?= $voerstudentnummer ?>"></p></div>
                            
                            <div id="Invoerveld2"><p><label for="Email"><b><?= $Email ?></b></label><br> 
                            <input class="ILinput" type = "email" name = "Email" placeholder="<?= $voeremail ?>"></p></div>
                            
                            <div id="Invoerveld3"><p><label for="Beveilingsvragen"><b><?= $Beveiligingsvragen ?></b></label></p>
                            <p><label for="Beveiligingsvraag1"><?= $Vraag1 ?></label><br>
                            <input class="ILinput" type = "text" name = "Vraag1" placeholder="<?= $antwoordvraag1 ?>"></p></div>

                            <div id="Invoerveld4"><p><label for="Beveiligingsvraag2"><?= $Vraag2 ?></label><br>
                            <input class="ILinput" type = "text" name = "Vraag2" placeholder="<?= $antwoordvraag2 ?>"></p></div>

                            <div id="Invoerveld5"><p><label for="Beveiligingsvraag3"><?= $Vraag3 ?></label><br>
                            <input class="ILinput" type = "text" name = "Vraag3" placeholder="<?= $antwoordvraag3 ?>"></p></div>

                            <div id="Invoerveld6"><p><label for="Nieuwwachtwoord"><b><?= $Nieuwww ?></b></label><br>
                            <input class="ILinput" type = "password" name = "Nieuwwachtwoord" placeholder="<?= $voernieuwww ?>"></p></div>

                            <div id="Invoerveld7"><p><label for="Herhaalwachtwoord"><b><?= $herhaalww ?></b></label><br>
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

                if($Pass === $Word){

                $PW = $Pass;

                }else{                    
                    echo $Erregwwcheck;
                    Die;
                }
                $Password = sha1($PW); 
                $vraag1 = sha1($_POST["Vraag1"]);
                $vraag2 = sha1($_POST["Vraag2"]); 
                $vraag3 = sha1($_POST["Vraag3"]);
                queryAanmaken(
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
                queryAanmaken(
                    'UPDATE student 
                    SET wachtwoord = ?
                    WHERE studentID = ?'
                    ,"si",
                    $Password,$studentID
                    
                );
                querySluiten();
                            
                } 
                
            
            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>