<?php
// Starting session
session_start();
include_once "../Include/Dbh.inc.php";
//kijkt of Submit gezet is
if(isset($_POST["Submit"])){

    $email = $_POST["Email"];
    $ww = $_POST["Password"];
    $wachtwoord = sha1($ww);
    $SorD = filter_input(INPUT_POST,'SorD',FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    //kijkt hier of een student inlogt  
    if(isset($_POST["Submit"]) and $SorD == "Student")
    {
        queryAanmaken( //kijkt of er een student account is waarmee de inlog gegevens overheen komen en logt dan daarmee in
            'SELECT studentID, studentNummer, studentNaam, jaar FROM student WHERE wachtwoord = ? AND studentEmail = ? ',
            "ss",
            $wachtwoord,$email
        ); // maak  de query aan
        mysqli_stmt_bind_result($stmt, $studentID, $studentNummer,$studentNaam,$jaar);// bind de resultaten.     
        mysqli_stmt_store_result($stmt); // sla de resultaten op.  
        if(mysqli_stmt_num_rows($stmt) != 0) 
        {
            while(mysqli_stmt_fetch($stmt))
            {                    
                //vult de SESSION     
                $_SESSION["StudentID"] = $studentID;
                $_SESSION["SorD"] = "Student";
                $_SESSION["studentNummer"] = $studentNummer;
                $_SESSION["Name"] = $studentNaam; 
     	        $_SESSION["jaar"] = $jaar;
            }
            header("Location: Homepage.php");
        }else
        {
            header("Location: index.php?error=1");
        }
        querySluiten(); // sluit de connectie met de database   
    }
    //kijkt hier of een docent inlogt 
    if(isset($_POST["Submit"]) and $SorD == "Docent")
    {
        
        queryAanmaken( //kijkt of er een docent account is waarmee de inlog gegevens overheen komen en logt dan daarmee in
            'SELECT docentID, docentNaam FROM docent WHERE wachtwoord = ? and docentEmail = ? ',
            "ss",
            $wachtwoord,$email
        );
            mysqli_stmt_bind_result($stmt, $docentID, $docentNaam);// bind de resultaten.  
            mysqli_stmt_store_result($stmt); // sla de resultaten op.           
        if(mysqli_stmt_num_rows($stmt) != 0)
        {
            while(mysqli_stmt_fetch($stmt))
            {
                //vult de SESSION
                $_SESSION["docentID"] = $docentID;
                $_SESSION["SorD"] = "Docent";
                $_SESSION["Name"] = $docentNaam;
                
            }
            header("Location: Homepage.php");
        }else
        {
                        
            header("Location: index.php?error=1");
        }
        querySluiten(); // sluit de connectie met de database 
    }   
}
?>