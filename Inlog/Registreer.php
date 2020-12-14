

<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">

<p><label for="Voornaam">Voornaam:</label><br> 
<input type = "Text" name = "Voornaam"></p>

<p><label for="Achternaam">Achternaam:</label><br> 
<input type = "Text" name = "Achternaam"></p>

<p><label for="Studentnummer">Studentnummer:</label><br> 
<input type = "Number" name = "Studentnummer"></p>

<p><label for="Email">E-Mail:</label><br> 
<input type = "email" name = "Email"></p>

<p><label for="Pass">Wachtwoord:</label><br>
<input type = "password" name = "Pass"></p>

<p><label for="Word">Voor wachtwoord opnieuw in:</label><br>
<input type = "password" name = "Word"></p>

<p>Vraag 1: Wat is je lievelingskleur? <input type = "text" name = "Vraag1"></p>
<p>Vraag 2: Wat is de naam van je eerste huisdier? <input type = "text" name = "Vraag2"></p>
<p>Vraag 3: Hoe heet de stad/dorp waarin je bent geboren? <input type = "text" name = "Vraag3"></p>

<p>   
    <input type = "submit" name = "Submit" value = "Submit">
</p>


</form>


<?php



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
    
  //  echo similar_text($Pass, $Word);
   // echo $Pass . $Word;
    echo "Ingevoerde wachtwoorden niet hetzelfde";
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




                    $conn = mysqli_connect("127.0.0.1","root","");
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

                    header("location: inlog.php");  

        }elseif($Emailstatus == "Bestaat"){
            
            echo "Deze Email is al ingebruik!";
            
        }elseif($SNumstatus == "Bestaat"){
            
            echo "Dit Studentennummer is al ingebruik!";
            
        }elseif(isset($_POST['Submit']) and $SorD == "NoStudent" and strlen($_POST['Voornaam']) >= 1 and strlen($_POST['Studentnummer']) >= 1 and strlen($_POST['Achternaam']) >= 1 and strlen($_POST['Password']) >= 1 and strlen($_POST['Vraag1']) >= 1 and strlen($_POST['Vraag2']) >= 1 and strlen($_POST['Vraag3']) >= 1){

            Echo "Geen Studenten Email ingevoerd";


        }elseif(isset($_POST['Submit'])){

            Echo "Niet Alle velden waren ingevuld";


        }

        }
        
    }


  


?>
