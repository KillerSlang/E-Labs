<!DOCTYPE HTML>
<html>
    <head>  

    <?php
        if(empty($_COOKIE["taal"])){
            setcookie("taal", "nederlands");
        }
        if($_COOKIE["taal"] == "english"){
            include_once "../Include/Engels.php";
        } else {
            include_once "../Include/Nederlands.php";
        }
        ?> 

        <title><?= $Registreren ?></title>
        <link href="../Css/inlog.css" rel="stylesheet" type="text/css">
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
                            <h1><b><?= $Registreren ?></b></h1>                       
                        </div>
                    </div>
                    <div id="inlogruimte">
                            <form class="ILform" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">

                                <div id="Invoerveld1"><p><label for="Voornaam"><?= $Voornaam ?></label><br> 
                                <input class="ILinput" type = "Text" name = "Voornaam"></p></div>

                                <div id="Invoerveld2"><p><label for="Achternaam"><?= $Achternaam ?></label><br> 
                                <input class="ILinput" type = "Text" name = "Achternaam"></p></div>

                                <div id="Invoerveld3"><p><label for="Studentnummer"><?= $StudentNummer ?></label><br> 
                                <input class="ILinput" type = "Number" name = "Studentnummer"></p></div>

                                <div id="Invoerveld4"><p><label for="Email"><?= $Email ?></label><br> 
                                <input class="ILinput" type = "email" name = "Email"></p></div>

                                <div id="Invoerveld5"><p><label for="Pass"><?= $Wachtwoord ?></label><br>
                                <input class="ILinput" type = "password" name = "Pass"></p></div>

                                <div id="Invoerveld6"><p><label for="Word"><?= $Vwoi ?></label><br>
                                <input class="ILinput" type = "password" name = "Word"></p></div>

                                <div id="Invoerveld7"><p><?= $Vraag1 ?><input class="ILinput" type = "text" name = "Vraag1"></p></div>
                                <div id="Invoerveld8"><p><?= $Vraag2 ?><input class="ILinput" type = "text" name = "Vraag2"></p></div>
                                <div id="Invoerveld9"><p><?= $Vraag3 ?><input class="ILinput" type = "text" name = "Vraag3"></p></div>

                                <div id="registreerbutton"><p>   
                                    <input class="ILsubmit" type = "submit" name = "Submit" value = "Submit">
                                </p></div>
                            </form>

                        <div id="errorcodes"><b>


    <?php

    if(isset($_POST["Submit"])){

    //controleren of alle velden ingevuld zijn
    if(isset($_POST['Submit']) and strlen($_POST['Voornaam']) == 0 or strlen($_POST['Studentnummer']) == 0 or strlen($_POST['Achternaam']) == 0 or strlen($_POST['Pass']) == 0 or strlen($_POST['Word']) == 0 or strlen($_POST['Vraag1']) == 0 or strlen($_POST['Vraag2']) == 0 or strlen($_POST['Vraag3']) == 0){

        Echo $Erregvelden;

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

    // Data controleren + in de database schrijven 

        
    $link = mysqli_connect("localhost","root","")
    OR DIE("Could not connect to the database!");
    if($link)
    {
        
            if($SorD == "Student" and isset($_POST['Submit']) and strlen($_POST['Voornaam']) >= 1 and strlen($_POST['Studentnummer']) >= 1 and strlen($_POST['Achternaam']) >= 1 and strlen($_POST['Email']) >= 1 and strlen($_POST['Pass']) >= 1 and strlen($_POST['Word']) >= 1 and strlen($_POST['Vraag1']) >= 1 and strlen($_POST['Vraag2']) >= 1 and strlen($_POST['Vraag3']) >= 1){




                        $conn = mysqli_connect("localhost","root","");
                        mysqli_select_db($conn, "elabs");
                        
                
                        $SQLSNum = "SELECT * FROM student WHERE studentNummer = '$Studentnummer'";
                        $checkSNum = mysqli_query($conn, $SQLSNum);


                            if(mysqli_num_rows($checkSNum) >= 1){
                                
                                $SNumstatus = "Bestaat";
                                
                            }else{
                                
                                $SNumstatus = "Nieuw";
                                
                            }
                        
                        
                        
                        
                        $SQLemail = "SELECT * FROM student WHERE studentEmail = '$Email'";
                        $checkemail = mysqli_query($conn, $SQLemail);


                            if(mysqli_num_rows($checkemail) >= 1){
                                
                                $Emailstatus = "Bestaat";
                                
                            }else{
                                
                                $Emailstatus = "Nieuw";
                                
                            }

                            
                        if($Emailstatus == "Nieuw" AND $SNumstatus == "Nieuw"){
                        
                        $sql = "INSERT INTO student 
                                (studentNummer, studentNaam, studentEmail, wachtwoord, beveiligingsVraag1, beveiligingsVraag2, beveiligingsVraag3)
                                VALUES
                                (
                                        
                                        '$Studentnummer',
                                        '$Naam',
                                        '$Email',
                                        '$Password',
                                        '$vraag1',
                                        '$vraag2',
                                        '$vraag3'
                                        
                                )";
                        $stmt = mysqli_prepare($conn, $sql)
                        OR DIE("Preparation Error");
                        mysqli_stmt_execute($stmt)
                        OR DIE(mysqli_error($conn));
                        mysqli_stmt_close($stmt);
                        
                        mysqli_close($conn);

                        echo "<script>location='../index.html'</script>";

                    // header("location: ../index.html");  

                        echo "<a href='../index.html'>naar inlog</a>";
                        

            }elseif($Emailstatus == "Bestaat"){
                
                echo $Erregemailingebruik;
                
            }elseif($SNumstatus == "Bestaat"){
                
                echo $Erregstudentnummeringebruik;
                
            }elseif(isset($_POST['Submit']) and $SorD == "NoStudent" and strlen($_POST['Voornaam']) >= 1 and strlen($_POST['Studentnummer']) >= 1 and strlen($_POST['Achternaam']) >= 1 and strlen($_POST['Password']) >= 1 and strlen($_POST['Vraag1']) >= 1 and strlen($_POST['Vraag2']) >= 1 and strlen($_POST['Vraag3']) >= 1){

                Echo $Erregfoutemail;


            }

            }
            
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