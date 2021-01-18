<?php
// Starting session
session_start();
include_once "../Include/Dbh.inc.php";

if(isset($_POST["Submit"])){

    $email = $_POST["Email"];
    $ww = $_POST["Password"];
    $wachtwoord = sha1($ww);
    $SorD = filter_input(INPUT_POST,'SorD',FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

    if(isset($_POST["Submit"]) and $SorD == "Student")
    {
        queryAanmaken(
            'SELECT studentID, studentNummer, studentNaam, jaar FROM student WHERE wachtwoord = ? AND studentEmail = ? ',
            "ss",
            $wachtwoord,$email
        );    
        mysqli_stmt_bind_result($stmt, $studentID, $studentNummer,$studentNaam,$jaar);
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) != 0) // wanneer er resultaten zijn wordt de tabel uitgeprint en de knoppen onderaan ook weergeven anders niet.
        {
            while(mysqli_stmt_fetch($stmt)) // alle resultaten in een rij van de tabel zetten.
            {                    
                // $studentID = $row['studentID'];
                // $studentNummer = $row['studentNummer'];
                // $studentNaam = $row['studentNaam'];                        
                $_SESSION["StudentID"] = $studentID;
                $_SESSION["SorD"] = "Student";
                $_SESSION["studentNummer"] = $studentNummer;
                $_SESSION["Name"] = $studentNaam; 
     	        $_SESSION["jaar"] = $jaar;
            }
            header("Location: Homepage.php");
        }else
        {
            header("Location: index.php");
        }
        querySluiten();
    }

    if(isset($_POST["Submit"]) and $SorD == "Docent")
    {
        
        queryAanmaken(
            'SELECT docentID, docentNaam FROM docent WHERE wachtwoord = ? and docentEmail = ? ',
            "ss",
            $wachtwoord,$email
        );
            mysqli_stmt_bind_result($stmt, $docentID, $docentNaam);
            mysqli_stmt_store_result($stmt);            
        if(mysqli_stmt_num_rows($stmt) != 0) // wanneer er resultaten zijn wordt de tabel uitgeprint en de knoppen onderaan ook weergeven anders niet.
        {
            while(mysqli_stmt_fetch($stmt)) // alle resultaten in een rij van de tabel zetten.
            {
                
                $_SESSION["docentID"] = $docentID;
                $_SESSION["SorD"] = "Docent";
                $_SESSION["Name"] = $docentNaam;
                
            }
            header("Location: Homepage.php");
        }else
        {
                        
            header("Location: index.php");
        }
        querySluiten();
    }   
}
?>