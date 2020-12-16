<!DOCTYPE HTML>
<html>
    <head>
        <title>Wachtwoord Vergeten</title>
        <link href="../Css/inlog.css" rel="stylesheet" type="text/css">
    </head>
    <body> 
        <div id="Container">
            <div id="inlogbox">
                <div id="logobalk">
                    <div id="logobalklogo">
                        <img src="../Images/Logo.png" alt = "Logo wit">
                    </div>
                    <div id="logobalktext">
                        <h1><b>Wachtwoord Wijzigen</b></h1>
                    </div>
                </div> 
                <div id="inlogruimte">
                    <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
        
                        <div id="Invoerveld1"><p><label for="Studentnummer">Studentnummer:</label><br> 
                        <input type = "Number" name = "Studentnummer" placeholder="voer hier uw studentnummer in..."></p></div>
                        
                        <div id="Invoerveld2"><p><label for="Email"><b>E-mail:</b></label><br> 
                        <input type = "email" name = "Email" placeholder="voer hier uw e-mail in..."></p></div>
                        
                        <div id="Invoerveld3"><p><label for="Beveilingsvragen"><b>Beveiligingsvragen</b></label></p>
                        <p><label for="Beveiligingsvraag1">Vraag 1: Wat is je lievelingskleur?</label><br>
                        <input type = "text" name = "Vraag1" placeholder="antwoord op vraag 1..."></p></div>

                        <div id="Invoerveld4"><p><label for="Beveiligingsvraag2">Vraag 2: Wat is de naam van je eerste huisdier?</label><br>
                        <input type = "text" name = "Vraag2" placeholder="antwoord op vraag 2..."></p></div>

                        <div id="Invoerveld5"><p><label for="Beveiligingsvraag3">Vraag 3: Hoe heet de stad/dorp waarin je bent geboren?</label><br>
                        <input type = "text" name = "Vraag3" placeholder="antwoord op vraag 3..."></p></div>

                        <div id="Invoerveld6"><p><label for="Nieuwwachtwoord"><b>Nieuw Wachtwoord</b></label><br>
                        <input type = "password" name = "Nieuwwachtwoord" placeholder="Voer hier uw nieuw wachtwoord in..."></p></div>

                        <div id="Invoerveld7"><p><label for="Herhaalwachtwoord"><b>Herhaal Wachtwoord</b></label><br>
                        <input type = "password" name = "Herhaalwachtwoord" placeholder="Herhaal uw wachtwoord..."></p></div>

                        <div id="wwwijzigbutton"><input type = "submit" name = "Submit" value = "Wijzig Wachtwoord"></div>
                    </form> 

                    <div id="errorcodes"><b>




        <?php

            $email = $_POST["Email"];
            $studentnummer = $_POST["Studentnummer"];
            
            $Pass = $_POST["Nieuwwachtwoord"];
            $Word = $_POST["Herhaalwachtwoord"];

            if($Pass === $Word){

            $PW = $Pass;

            }else{
                
                echo "Ingevoerde wachtwoorden niet hetzelfde";
                Die;
            }

            $Password = sha1($PW); 
            $vraag1 = sha1($_POST["Vraag1"]);
            $vraag2 = sha1($_POST["Vraag2"]); 
            $vraag3 = sha1($_POST["Vraag3"]);
            
            
            if(isset($_POST["Submit"]))
            {

                $link = mysqli_connect("localhost","root","") 
                OR DIE("Could not connect to the database!");
                if($link)
                {
            
                        $conn = mysqli_connect("localhost","root","");
                        mysqli_select_db($conn, 'elabs');
            
                        $SQL = "SELECT studentID FROM student WHERE studentNummer = '$studentnummer' and studentEmail = '$email' and beveiligingsVraag1 = '$vraag1' and beveiligingsVraag2 = '$vraag2' and beveiligingsVraag3 = '$vraag3'";
                        $check = mysqli_query($conn, $SQL);
            
        
                            if(mysqli_num_rows($check) == 1){
                                
                                $row = mysqli_fetch_array($check);
                                
                                $studentID = $row['studentID'];
                                
                                $SQLUW = "UPDATE student SET wachtwoord='$Password' WHERE studentID = '$studentID'";
                                
                                if(mysqli_query($conn, $SQLUW)) {
                                    echo "Wachtwoord succesvol bijgewerkt! druk <a href='inlog.php'>Hier</a> Om terug te gaan naar de <a href='inlog.php'>login pagina</a>.";
                                } else {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }
                                    
                                
                                
                            }else{
                                echo "Probeer opnieuw gegevens zijn onjuist";
                                
                                
                            }
                        mysqli_close($conn);
                }
            }      
        ?>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>