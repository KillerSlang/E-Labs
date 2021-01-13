<?PHP
// Start the session
session_start();
include_once 'dbh.inc.php';
// sanitize post
if(!empty($_GET['ID']))
    {
        $ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
    }else{ $ID = 0; }

$titelLabjournaal =  filter_input(INPUT_POST,'titelLabjournaal', FILTER_SANITIZE_SPECIAL_CHARS); 
$uitvoerders = base64_encode(serialize($_SESSION ['studentNummerArray']));
$experimentdatum = filter_input(INPUT_POST,'experimentdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$experimentstartdatum = filter_input(INPUT_POST,'experimentstartdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$experimenteinddatum = filter_input(INPUT_POST,'experimenteinddatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$doel = filter_input(INPUT_POST,'doel', FILTER_SANITIZE_STRING);
$hypothese = filter_input(INPUT_POST,'hypothese', FILTER_SANITIZE_STRING);
$materialen = filter_input(INPUT_POST,'materialen', FILTER_SANITIZE_STRING);
$methode = filter_input(INPUT_POST,'methode', FILTER_SANITIZE_STRING);
$logboek = filter_input(INPUT_POST,'logboek',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$observaties = filter_input(INPUT_POST,'observaties',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$weeggegevens = filter_input(INPUT_POST,'weeggegevens',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$vak = $_POST['LVak'];
$bijlageWaarnemingen = "" ;
$bijlageMeetresultaten = "" ;
$bijlageLogboek = "" ;
$bijlageObservaties = "" ;
$bijlageWeeggegevens = "" ;
$bijlageAfbeelding = "" ;
$bijlageVeiligheid  = "";
$uploadArray = array();
$databaseNames = array();

$_SESSION['titelLabjournaal'] = $titelLabjournaal;
$_SESSION['experimentdatum'] = $experimentdatum;
$_SESSION['experimentstartdatum'] = $experimentstartdatum;
$_SESSION['experimenteinddatum'] = $experimenteinddatum;
$_SESSION['doel'] = $doel;
$_SESSION['hypothese'] = $hypothese;
$_SESSION['materialen'] = $materialen;
$_SESSION['methode'] = $methode;
$_SESSION['logboek'] = $logboek;
$_SESSION['observaties'] = $observaties;
$_SESSION['weeggegevens'] = $weeggegevens;
$_SESSION['vak'] = $vak;

if (isset($_POST['LSubmit'])) // wanneer er een labjournaal wordt opgeslagen.
{    
    if(!empty($_FILES["uploadveiligheid"]))
    {
        // upload veiligheid
        $target_dir = "../uploads/";
        $target_file_veiligheid = $target_dir . basename($_FILES["uploadveiligheid"]["name"]);
        $FileTypeveiligheid = strtolower(pathinfo($target_file_veiligheid,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_veiligheid)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadveiligheid"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadveiligheid']['type'] == 'image/png' ||  $_FILES['uploadveiligheid']['type'] == 'image/jpeg' || $_FILES['uploadveiligheid']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['uploadveiligheid']['type'] == 'application/vnd.ms-excel' ) {
            if (move_uploaded_file($_FILES["uploadveiligheid"]["tmp_name"], $target_file_veiligheid)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadveiligheid"]["name"])). " is succesvol geupload.";
                $bijlageVeiligheid = $target_file_veiligheid;
                array_push($uploadArray,$bijlageVeiligheid);
                array_push($databaseNames, 'veiligheid');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen JPG, JPEG, PNG & Excel bestanden zijn toegestaan.";
        }       
    }
    
    
    if(!empty($_FILES["uploadwaarnemingen"]))
    {
        // upload waarnemingen
        $target_dir = "../uploads/";
        $target_file_waarnemingen = $target_dir . basename($_FILES["uploadwaarnemingen"]["name"]);
        $FileTypewaarnemingen = strtolower(pathinfo($target_file_waarnemingen,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_waarnemingen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadwaarnemingen"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadwaarnemingen']['type'] == 'image/png' ||  $_FILES['uploadwaarnemingen']['type'] == 'image/jpeg' ||  $_FILES['uploadwaarnemingen']['type'] == 'image/jpg') {
            if (move_uploaded_file($_FILES["uploadwaarnemingen"]["tmp_name"], $target_file_waarnemingen)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadwaarnemingen"]["name"])). " is succesvol geupload.";
                $bijlageWaarnemingen = $target_file_waarnemingen;
                array_push($uploadArray,$bijlageWaarnemingen);
                array_push($databaseNames, 'bijlageWaarnemingen');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen JPG, JPEG, PNG bestanden zijn toegestaan.";
        }
    }
           
    if(!empty($_FILES["uploadmeetresultaten"]))
    {
        // upload meetresultaten
        $target_dir = "../uploads/";
        $target_file_meetresultaten = $target_dir . basename($_FILES["uploadmeetresultaten"]["name"]);
        $FileTypemeetresultaten = strtolower(pathinfo($target_file_meetresultaten,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_meetresultaten)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadmeetresultaten"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadmeetresultaten']['type'] == 'image/png' ||  $_FILES['uploadmeetresultaten']['type'] == 'image/jpeg' ||  $_FILES['uploadmeetresultaten']['type'] == 'image/jpg' || $_FILES['uploadmeetresultaten']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['uploadmeetresultaten']['type'] == 'application/vnd.ms-excel' ) {
            if (move_uploaded_file($_FILES["uploadmeetresultaten"]["tmp_name"], $target_file_meetresultaten)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadmeetresultaten"]["name"])). " is succesvol geupload.";
                $bijlageMeetresultaten = $target_file_meetresultaten;
                array_push($uploadArray,$bijlageMeetresultaten);
                array_push($databaseNames, 'bijlageMeetresultaten');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen JPG, JPEG, PNG & Excel bestanden zijn toegestaan.";
        }
    }
            
    if(!empty($_FILES["uploadlogboek"]))
    {
        // upload logboek
        $target_dir = "../uploads/";
        $target_file_logboek = $target_dir . basename($_FILES["uploadlogboek"]["name"]);
        $FileTypelogboek = strtolower(pathinfo($target_file_logboek,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_logboek)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadlogboek"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadlogboek']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||  $_FILES['uploadlogboek']['type'] == 'application/vnd.ms-excel' || $_FILES['uploadlogboek']['type'] == 'application/msword' || $_FILES['uploadlogboek']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
            if (move_uploaded_file($_FILES["uploadlogboek"]["tmp_name"], $target_file_logboek)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadlogboek"]["name"])). " is succesvol geupload.";
                $bijlageLogboek = $target_file_logboek;
                array_push($uploadArray,$bijlageLogboek);
                array_push($databaseNames, 'bijlageLogboek');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen Excel & Word bestanden zijn toegestaan.";
        }
    }

    if(!empty($_FILES["uploadobservaties"]))
    {
        // upload observatie
        $target_dir = "../uploads/";
        $target_file_observaties = $target_dir . basename($_FILES["uploadobservaties"]["name"]);
        $FileTypeobservaties = strtolower(pathinfo($target_file_observaties,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_observaties)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadobservaties"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadobservaties']['type'] == 'image/png' ||  $_FILES['uploadobservaties']['type'] == 'image/jpeg' ||  $_FILES['uploadobservaties']['type'] == 'image/jpg' || $_FILES['uploadobservaties']['type'] == 'application/msword' || $_FILES['uploadobservaties']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
            if (move_uploaded_file($_FILES["uploadobservaties"]["tmp_name"], $target_file_observaties)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadobservaties"]["name"])). " is succesvol geupload.";
                $bijlageObservaties = $target_file_observaties;
                array_push($uploadArray,$bijlageObservaties);
                array_push($databaseNames, 'bijlageObservaties');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen PNG, JPG, JPEG & Word bestanden zijn toegestaan.";
        }
    }        
                    
    if(!empty($_FILES["uploadweeggegevens"]))
    {
        // upload weeggegevens
        $target_dir = "../uploads/";
        $target_file_weeggegevens = $target_dir . basename($_FILES["uploadweeggegevens"]["name"]);
        $FileTypeweeggegevens = strtolower(pathinfo($target_file_weeggegevens,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_weeggegevens)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadweeggegevens"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadweeggegevens']['type'] == 'application/vnd.ms-excel' || $_FILES['uploadweeggegevens']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
            if (move_uploaded_file($_FILES["uploadweeggegevens"]["tmp_name"], $target_file_weeggegevens)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadweeggegevens"]["name"])). " is succesvol geupload.";
                $bijlageWeeggegevens = $target_file_weeggegevens;
                array_push($uploadArray,$bijlageWeeggegevens);
                array_push($databaseNames, 'bijlageWeeggegevens');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }

        } else {
            echo "Sorry, alleen Excel bestanden zijn toegestaan.";
        }
    }                                

    if(!empty($_FILES["uploadafbeelding"]))
    {
        // upload afbeeldingen
        $target_dir = "../uploads/";
        $target_file_afbeeldingen = $target_dir . basename($_FILES["uploadafbeelding"]["name"]);
        $FileTypeafbeeldingen = strtolower(pathinfo($target_file_afbeeldingen,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_afbeeldingen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadafbeelding"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadafbeelding']['type'] == 'image/png' || $_FILES['uploadafbeelding']['type'] == 'image/jpeg' || $_FILES['uploadafbeelding']['type'] == 'image/jpg' ) {
            if (move_uploaded_file($_FILES["uploadafbeelding"]["tmp_name"], $target_file_afbeeldingen)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadafbeelding"]["name"])). " is succesvol geupload.";
                $bijlageAfbeelding = $target_file_afbeeldingen;
                array_push($uploadArray,$bijlageAfbeelding);
                array_push($databaseNames, 'bijlageAfbeelding');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen PNG, JPG & JPEG afbeeldingen zijn toegestaan.";
        }
    }                                                          
    if (!empty($databaseNames)) // het uploaden van de bestanden.
    { 
        queryAanmakenAdvanced('UPDATE labjournaal SET ',false);
        $datatypes = '';
        $max = sizeof($databaseNames);
        for($i = 0; $i < $max;$i++)
        {
            if ($i == 0)
            {
                $sql = $databaseNames[$i].' = ?';
                $datatypes = 's';
            }
            else
            {
                $sql = ' , '.$databaseNames[$i].' = ? ';
                $datatypes = 's';
            }
            queryAanmakenAdvanced($sql,false,$datatypes,$uploadArray[$i]);        
        }
        queryAanmakenAdvanced(' WHERE labjournaalID = ?',true,'i',$ID);
        /*array_push($uploadArray,$ID);
        $datatypes .= 'i';*/
        querySluiten();
    }
    // array van alle verplichten inputvelden.
    $verplichteInput = array($titelLabjournaal,$uitvoerders, $experimentdatum, $experimentstartdatum, $experimenteinddatum, $doel,
                             $hypothese, $materialen, $methode, $logboek, $observaties, $weeggegevens, $vak);//studentnummer
    
    foreach($verplichteInput as $input) //check of alle verplichte velden zijn ingevuld.
    {
        if(empty($input)) // wanneer dit niet het geval is, ga terug naar het formulier.
        {
            header("location: ../pages/labjournaalBewerk.php?ID=".$ID."&addLabjournaal=failed");
            exit;
        }
    }    
    queryAanmaken('
        UPDATE labjournaal
        SET
        studentID = ?,labjournaalTitel = ?,uitvoerders = ?,experimentdatum = ?,
        experimentBeginDatum = ?,experimentEindDatum = ?,doel = ?,
        hypothese = ?,materialen = ?,methode = ?,logboek = ?,
        observaties = ?,weeggegevens = ?,vak = ?
        WHERE labjournaalID = ?'
        ,"isssssssssssssi"
        ,$_SESSION["StudentID"],$titelLabjournaal,$uitvoerders,$experimentdatum,$experimentstartdatum,
        $experimenteinddatum,$doel,$hypothese,$materialen,$methode,$logboek,$observaties,$weeggegevens,
        $vak,$ID
    );    
    querysluiten();   
	header("location: ../pages/labjournalen.php?addLabjournaal=succes");  
}

if (isset($_POST['userSubmit'])) // wanneer er op de gebruiker toevoegen knop wordt gedrukt.
{ 
    $uitvoerders = filter_input(INPUT_POST,'uitvoerders', FILTER_SANITIZE_SPECIAL_CHARS); // haal de POST van uitvoerders op
    if(!empty($uitvoerders)) // wanneer de POST niet leeg is.
    {
        queryAanmaken(
            'SELECT studentNaam,studentNummer
            FROM student
            WHERE studentNummer = ?',
            "i",$uitvoerders
        );
        mysqli_stmt_bind_result($stmt, $studentNaam,$studentNummer); // bind de resultaten.
        mysqli_stmt_store_result($stmt); //sla de resultaten op.        
        if(mysqli_stmt_num_rows($stmt) != 0) //wanneer er resultaat is.
        {
            while (mysqli_stmt_fetch($stmt)) 
            {
                if (empty($_SESSION ['studentNummerArray'])) // wanneer de studentNummerarray leeg is.
                {                    
                    $_SESSION ['studentNaamArray'] =  array(); // maak nieuwe array aan.
                    $_SESSION ['studentNummerArray'] =  array(); //maak nieuwe array aan.
                }                
                array_push($_SESSION ['studentNaamArray'],$studentNaam);  // voeg de studentnaam van de uitvoerder toe aan de array.
                array_push($_SESSION ['studentNummerArray'],$studentNummer); // voeg het studentnummer van de uitvoerder toe aan de array.           
            }
            querysluiten(); // sluit de connectie met de database.            
            header("location: ../pages/labjournaalBewerk.php?ID=".$ID."&adduser=succes"); 
        }
        else // wanneer geen resultaat ga terug naar het formulier met de GET Failed.
        {
            header("location: ../pages/labjournaalBewerk.php?ID=".$ID."&adduser=failed");  
        }
    }
    header("location: ../pages/labjournaalBewerk.php?ID=".$ID."&adduser=succes");      
}
if(isset($_POST['userVerwijderen'])) // wanneer er op de knop uitvoerder verwijderen wordt gedrukt.
{
    if (isset($_SESSION["studentNaamArray"])) // wanneer de array bestaat.
    {
        array_pop($_SESSION ['studentNaamArray']); // verwijder de laatst toegevoegde waarde van de array.
        array_pop($_SESSION ['studentNummerArray']); // verwijder de laatst toegevoegde waarde van de array.
    }
    header("location: ../pages/labjournaalBewerk.php?ID=".$ID."&deleteuser=succes"); // ga terug naar het formulier.
}



