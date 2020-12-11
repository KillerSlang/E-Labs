

    <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">

    <p><label for="Voornaam">Voornaam:</label><br> 
    <input type = "Text" name = "Voornaam"></p>

    <p><label for="Achternaam">Achternaam:</label><br> 
    <input type = "Text" name = "Achternaam"></p>

    <p><label for="Studentnummer">Studentnummer:</label><br> 
    <input type = "Number" name = "Studentnummer"></p>

    <p><label for="Email">E-Mail:</label><br> 
    <input type = "email" name = "Email"></p>

    <p><label for="Password">Wachtwoord:</label><br>
    <input type = "password" name = "Password"></p>

    <p>vraag1 <input type = "text" name = "vraag1"></p>
    <p>vraag2 <input type = "text" name = "vraag2"></p>
    <p>vraag3 <input type = "text" name = "vraag3"></p>

    <p>   
        <input type = "submit" name = "Submit" value = "Submit">
    </p>


    </form>


<?php
    // Data ophalen uit de Form
    $Voornaam = filter_input(INPUT_GET, '$_POST["Voornaam"]', FILTER_SANITIZE_SPECIAL_CHARS);
    $Achternaam = filter_input(INPUT_GET, '$_POST["Achternaam"]', FILTER_SANITIZE_SPECIAL_CHARS);

    // voornaam + achternaam samen voegen tot een gehele Naam
    $Naam = $Voornaam . " " . $Achternaam;

    $Email = $_POST["Email"];

    $Email = filter_var($Email, FILTER_SANITIZE_EMAIL);

    // checken of het een juiste email is
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo("$email is a valid email address");
    } else {
        echo("$email is not a valid email address");
    }


    $explodemail = explode("@" , $Email);

    if(end($explodemail) == "student.nhlstenden.com"){

        $SorD = "Student";

        
    }else{

        $SorD = "NoStudent";

    }


    $Studentnummer = filter_input(INPUT_GET, '$_POST["Studentnummer"]', FILTER_SANITIZE_NUMBER_INT);

    $Password = $_POST["Password"]; //moet nog gencrypt worden 
    $vraag1 = $_POST["vraag1"]; //moet nog gencrypt worden 
    $vraag2 = $_POST["vraag2"]; //moet nog gencrypt worden 
    $vraag3 = $_POST["vraag3"]; //moet nog gencrypt worden 

    // Data controleren + in de database schrijven 

    
       
        
    $link = mysqli_connect("localhost","root","") 
	OR DIE("Could not connect to the database!");
	if($link)
	{
        
            if($SorD == "Student" and isset($_POST['submit']) and strlen($_POST['Voornaam']) >= 1 and strlen($_POST['Achternaam']) >= 1 and strlen($_POST['Email']) >= 1 and strlen($_POST['Password']) >= 1 and strlen($_POST['Vraag1']) >= 1 and strlen($_POST['Vraag2']) >= 1 and strlen($_POST['Vraag3']) >= 1){




                        $conn = mysqli_connect("127.0.0.1","root","");
                        mysqli_select_db($conn, "elabs");
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
                                        '$vraag3',
                                        
                                   )";
                        $stmt = mysqli_prepare($conn, $sql)
                        OR DIE("Preparation Error");
                        mysqli_stmt_execute($stmt)
                        OR DIE(mysqli_error($conn));
                        mysqli_stmt_close($stmt);
                        
                        mysqli_close($conn);

                        header("location: inlog.php");  

            }else{

                Echo "Niet alle velden waren (goed)ingevuld";

            }
            
        }
    
    

    

?>