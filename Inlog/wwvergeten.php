<img src="" alt = "Logo wit" >
<h1><b>Wachtwoord Wijzigen</b></h1>
<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
    
    <p><label for="Studentnummer">Studentnummer:</label><br> 
    <input type = "Number" name = "Studentnummer" placeholder="voer hier uw studentnummer in..."></p>
    
    <p><label for="Email"><b>E-mail:</b></label><br> 
    <input type = "email" name = "Email" placeholder="voer hier uw e-mail in..."></p>
    
    <p><label for="Beveilingsvragen"><b>Beveiligingsvragen</b></label></p>
    <p><label for="Beveiligingsvraag1">Vraag 1: Wat is je lievelingskleur?</label><br>
    <input type = "text" name = "Vraag1" placeholder="antwoord op vraag 1..."></p>

    <p><label for="Beveiligingsvraag2">Vraag 2: Wat is de naam van je eerste huisdier?</label><br>
    <input type = "text" name = "Vraag2" placeholder="antwoord op vraag 2..."></p>

    <p><label for="Beveiligingsvraag3">Vraag 3: Hoe heet de stad/dorp waarin je bent geboren?</label><br>
    <input type = "text" name = "Vraag3" placeholder="antwoord op vraag 3..."></p>

    <p><label for="Nieuwwachtwoord"><b>Nieuw Wachtwoord</b></label><br>
    <input type = "password" name = "Nieuwwachtwoord" placeholder="Voer hier uw nieuw wachtwoord in..."></p>

    <p><label for="Herhaalwachtwoord"><b>Herhaal Wachtwoord</b></label><br>
    <input type = "password" name = "Herhaalwachtwoord" placeholder="Herhaal uw wachtwoord..."></p>

    <input type = "submit" name = "Submit" value = "Wijzig Wachtwoord">
</form>

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