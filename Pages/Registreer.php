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
    } elseif($_COOKIE["taal"] == "english"){        // controleert of er al een taalswitch in de cookies is gemaakt.
        include_once "../Include/Engels.php";       // include de engelse vertalingen
    } else {
        include_once "../Include/Nederlands.php";   // include de nederlandse vertalingen
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title><?= $Registreren ?></title>
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
                            <h1 id="ILh1"><b>Welkom!</b></h1>
                        </div>

                        <div>
                            <?php
                             if($_GET["taal"] == "E"){

                                echo '<a id="engelsknop" href="Registreer.php?taal=N">Nederlands</a>';

                             }else{

                                echo '<a id="engelsknop" href="Registreer.php?taal=E">English</a>';

                             }
                            ?>
                            
                        </div>
                    </div>
                    
                    <div id="inlogruimte">
                        <form class = "ILform" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">

                            <div class="Invoerveld"><p><label for="Voornaam"><?=$Voornaam?></label><br> 
                            <input type = "Text" name = "Voornaam" placeholder ="<?=$voerVoornaam?>"></p></div>

                            <div class="Invoerveld"><p><label for="Achternaam"><?=$Achternaam?></label><br> 
                            <input type = "Text" name = "Achternaam" placeholder ="<?=$voerAchternaam?>"></p></div>

                            <div class="Invoerveld"><p><label for="Studentnummer"><?=$StudentNummer?></label><br> 
                            <input type = "Number" name = "Studentnummer" placeholder ="<?=$voerstudentnummer?>"></p></div>

                            <div class="Invoerveld"><p><label for="Email">E-Mail:</label><br> 
                            <input type = "email" name = "Email" placeholder ="<?=$voeremail?>"></p></div>

                            <div class="Invoerveld"><p><label for="Pass"><?=$Wachtwoord?></label><br>
                            <input type = "password" name = "Pass" placeholder ="<?=$voerww?>"></p></div>

                            <div class="Invoerveld"><p><label for="Word"><?=$Vwoi?></label><br>
                            <input type = "password" name = "Word" placeholder ="<?=$herhaalww?>"></p></div>

                            <div class="Invoerveld"><p><?=$Vraag1?><br><input type = "text" name = "Vraag1" placeholder ="<?=$voerantwoord?>"></p></div>
                            <div class="Invoerveld"><p><?=$Vraag2?><br><input type = "text" name = "Vraag2" placeholder ="<?=$voerantwoord?>"></p></div>
                            <div class="Invoerveld"><p><?=$Vraag3?><br><input type = "text" name = "Vraag3" placeholder ="<?=$voerantwoord?>"></p></div>

                            <div class="registreerbutton"><p>   
                                <input id="Registreersubmit"class="ILsubmit" type = "submit" name = "Submit" value = "Submit">
                            </p></div>
                        </form>

                    <div id="errorcodes"><b>


<?php
include_once'../Include/Dbh.inc.php';

if(isset($_POST["Submit"]))
{
    //controleren of alle velden ingevuld zijn
    if(isset($_POST['Submit']) and strlen($_POST['Voornaam']) == 0 or strlen($_POST['Studentnummer']) == 0 or strlen($_POST['Achternaam']) == 0 or strlen($_POST['Pass']) == 0 or strlen($_POST['Word']) == 0 or strlen($_POST['Vraag1']) == 0 or strlen($_POST['Vraag2']) == 0 or strlen($_POST['Vraag3']) == 0){

        echo "$Erregvelden";
    }
    

    // Data ophalen uit de Form
    $Voornaam = $_POST["Voornaam"];
    $Voornaam = filter_var($Voornaam, FILTER_SANITIZE_SPECIAL_CHARS);

    $Achternaam = $_POST["Achternaam"];
    $Achternaam = filter_var($Achternaam, FILTER_SANITIZE_SPECIAL_CHARS);

    // voornaam + achternaam samen voegen tot een gehele Naam
    $Naam = $Voornaam . " " . $Achternaam;

    $Email = $_POST["Email"];

    $Email = filter_var($Email, FILTER_SANITIZE_EMAIL);

    // checken of het een juiste email is

    $explodemail = explode("@" , $Email);

    if(end($explodemail) == "student.nhlstenden.com"){

        $SorD = "Student";

        
    }else{

        $SorD = "NoStudent";

    }


    $Studentnummer = $_POST["Studentnummer"];
    $Studentnummer = filter_var($Studentnummer, FILTER_SANITIZE_NUMBER_INT);

    $Pass = $_POST["Pass"];
    $Word = $_POST["Word"];

    if($Pass === $Word){ // alleen als de wachtwoorden overeen komen dan pas mag je verder

    $PW = $Pass;

    }else{              // error message 
        
        echo "$Erregwwcheck";
        exit;
    }

    $Password = sha1($PW); 
    $vraag1 = sha1($_POST["Vraag1"]);
    $vraag2 = sha1($_POST["Vraag2"]); 
    $vraag3 = sha1($_POST["Vraag3"]);  

    // Data controleren + in de database schrijven 
    if($SorD == "Student" and isset($_POST['Submit']) and strlen($_POST['Voornaam']) >= 1 and strlen($_POST['Studentnummer']) >= 1 and strlen($_POST['Achternaam']) >= 1 and strlen($_POST['Email']) >= 1 and strlen($_POST['Pass']) >= 1 and strlen($_POST['Word']) >= 1 and strlen($_POST['Vraag1']) >= 1 and strlen($_POST['Vraag2']) >= 1 and strlen($_POST['Vraag3']) >= 1)
    {          
        queryAanmaken( // zoek de studentnummer op en checkt of deze al in gebruik is.
            'SELECT studentNummer FROM student WHERE studentNummer = ? ',
            "i",
            $Studentnummer);
            mysqli_stmt_bind_result($stmt, $studentNummerD);
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) != 0) // wanneer er resultaten zijn.
            {
                $SNumstatus = "Bestaat";
            }
            else
            {
                $SNumstatus = "Nieuw";
            }
        querySluiten();  
        
        queryAanmaken( // zoek de student email op en checkt of deze al in gebruik is.
            'SELECT studentEmail FROM student WHERE studentEmail = ? ',
            "s",
            $Email);
            mysqli_stmt_bind_result($stmt, $EmailD);
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) != 0) // wanneer er resultaten zijn.
            {
                $Emailstatus = "Bestaat";
            }
            else
            {
                $Emailstatus = "Nieuw";
            }
        querySluiten();

        if($Emailstatus == "Nieuw" AND $SNumstatus == "Nieuw")
        {
            queryAanmaken( // zoek of de account al is aangemaakt
                'INSERT INTO student 
                (studentNummer, studentNaam, studentEmail, wachtwoord, beveiligingsVraag1, beveiligingsVraag2, beveiligingsVraag3)
                VALUES
                ( ?,?,?,?,?,?,? )',
                "issssss",
                $Studentnummer,$Naam,$Email,$Password,$vraag1,$vraag2,$vraag3    
            ); 
            querySluiten();
            header("location: ../index.html");  // als alles nieuw is dan wordt je naar de inlogpagina gestuurd.
        }
        elseif($Emailstatus == "Bestaat") // anders error
        {
            echo "$Erregemailingebruik";
        }elseif($SNumstatus == "Bestaat") // anders error
        { 
            echo "$Erregstudentnummeringebruik";
        }       
   }
} 
?>

                    </b></div>
                </div>
            </div>
        </div>
        
    </body>
</html>