<?PHP
// Start de sessie
session_start();
include_once 'dbh.inc.php';

    // filter de ingevulde velden.
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
$vak = filter_input(INPUT_POST,'LVak',FILTER_SANITIZE_FULL_SPECIAL_CHARS);//$_POST['LVak'];
$beoordeling = filter_input(INPUT_POST,'beoordeling', FILTER_SANITIZE_STRING);

    /* vul de sessies met de post variabelen, zodat wanneer
    een waarde niet ingevuld is en het labjournaal wordt ingeleverd
    niet alle tekstvakken leeg worden gehaald. */
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


$bijlageWaarnemingen = "" ;
$bijlageMeetresultaten = "" ;
$bijlageLogboek = "" ;
$bijlageObservaties = "" ;
$bijlageWeeggegevens = "" ;
$bijlageAfbeelding = "" ;
$bijlageVeiligheid  = "";

if (isset($_POST['LSubmit'])) // wanneer er vanaf de labjournaalNieuw pagina op de opslaan knop wordt gedrukt.
{    
    
    if(!empty($_FILES["uploadveiligheid"])) // waneer er een bestand upgeload is bij uploadveiligheid
    {
        $target_dir = "../uploads/"; // sla het bestand op in de map uploads
        $target_file_veiligheid = $target_dir . basename($_FILES["uploadveiligheid"]["name"]);
        $FileTypeveiligheid = strtolower(pathinfo($target_file_veiligheid,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat
        if (file_exists($target_file_veiligheid)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadveiligheid"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de goede bestandtypes toe
        if($_FILES['uploadveiligheid']['type'] == 'image/png' ||  $_FILES['uploadveiligheid']['type'] == 'image/jpeg' || $_FILES['uploadveiligheid']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['uploadveiligheid']['type'] == 'application/vnd.ms-excel' ) {
            if (move_uploaded_file($_FILES["uploadveiligheid"]["tmp_name"], $target_file_veiligheid)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadveiligheid"]["name"])). " is succesvol geupload.";
                $bijlageVeiligheid = $target_file_veiligheid;
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
        
        // Controleer of het bestand al bestaat
        if (file_exists($target_file_waarnemingen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadwaarnemingen"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de goede bestandtypes toe
        if($_FILES['uploadwaarnemingen']['type'] == 'image/png' ||  $_FILES['uploadwaarnemingen']['type'] == 'image/jpeg' ||  $_FILES['uploadwaarnemingen']['type'] == 'image/jpg') {
            if (move_uploaded_file($_FILES["uploadwaarnemingen"]["tmp_name"], $target_file_waarnemingen)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadwaarnemingen"]["name"])). " is succesvol geupload.";
                $bijlageWaarnemingen = $target_file_waarnemingen;
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
        
        // Controleer of het bestand al bestaat
        if (file_exists($target_file_meetresultaten)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadmeetresultaten"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de goede bestandtypes toe
        if($_FILES['uploadmeetresultaten']['type'] == 'image/png' ||  $_FILES['uploadmeetresultaten']['type'] == 'image/jpeg' ||  $_FILES['uploadmeetresultaten']['type'] == 'image/jpg' || $_FILES['uploadmeetresultaten']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['uploadmeetresultaten']['type'] == 'application/vnd.ms-excel' ) {
            if (move_uploaded_file($_FILES["uploadmeetresultaten"]["tmp_name"], $target_file_meetresultaten)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadmeetresultaten"]["name"])). " is succesvol geupload.";
                $bijlageMeetresultaten = $target_file_meetresultaten;
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
        
        // Controleer of het bestand al bestaat
        if (file_exists($target_file_logboek)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadlogboek"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de goede bestandtypes toe
        if($_FILES['uploadlogboek']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||  $_FILES['uploadlogboek']['type'] == 'application/vnd.ms-excel' || $_FILES['uploadlogboek']['type'] == 'application/msword' || $_FILES['uploadlogboek']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
            if (move_uploaded_file($_FILES["uploadlogboek"]["tmp_name"], $target_file_logboek)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadlogboek"]["name"])). " is succesvol geupload.";
                $bijlageLogboek = $target_file_logboek;
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
        
        // Controleer of het bestand al bestaat
        if (file_exists($target_file_observaties)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadobservaties"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de goede bestandtypes toe
        if($_FILES['uploadobservaties']['type'] == 'image/png' ||  $_FILES['uploadobservaties']['type'] == 'image/jpeg' ||  $_FILES['uploadobservaties']['type'] == 'image/jpg' || $_FILES['uploadobservaties']['type'] == 'application/msword' || $_FILES['uploadobservaties']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
            if (move_uploaded_file($_FILES["uploadobservaties"]["tmp_name"], $target_file_observaties)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadobservaties"]["name"])). " is succesvol geupload.";
                $bijlageObservaties = $target_file_observaties;
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
        
        // Controleer of het bestand al bestaat
        if (file_exists($target_file_weeggegevens)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadweeggegevens"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de goede bestandtypes toe
        if($_FILES['uploadweeggegevens']['type'] == 'application/vnd.ms-excel' || $_FILES['uploadweeggegevens']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
            if (move_uploaded_file($_FILES["uploadweeggegevens"]["tmp_name"], $target_file_weeggegevens)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadweeggegevens"]["name"])). " is succesvol geupload.";
                $bijlageWeeggegevens = $target_file_weeggegevens;
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
        
        // Controleer of het bestand al bestaat
        if (file_exists($target_file_afbeeldingen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadafbeelding"]["size"] > 40000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de goede bestandtypes toe
        if($_FILES['uploadafbeelding']['type'] == 'image/png' || $_FILES['uploadafbeelding']['type'] == 'image/jpeg' || $_FILES['uploadafbeelding']['type'] == 'image/jpg' ) {
            if (move_uploaded_file($_FILES["uploadafbeelding"]["tmp_name"], $target_file_afbeeldingen)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadafbeelding"]["name"])). " is succesvol geupload.";
                $bijlageAfbeelding = $target_file_afbeeldingen;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen PNG, JPG & JPEG afbeeldingen zijn toegestaan.";
        }
    }
    // array met alle verplichte waardes die ingevuld moeten worden.
    $verplichteInput = array($titelLabjournaal,$uitvoerders, $experimentdatum, $experimentstartdatum, $experimenteinddatum, $doel,
                             $hypothese, $materialen, $methode, $logboek, $observaties, $weeggegevens, $vak);//studentnummer
  
    foreach($verplichteInput as $input) // loop door de gehele array heen.
    {
        if(empty($input)) // als een waarde niet is ingevuld ga dan terug naar de pagina.
        {
            header("location: ../pages/labjournaalNieuw.php?addLabjournaal=failed");
            exit;
        }
    }   
    $aanmaakDatum = date("Y-m-d H:i:s"); // maak een variabele aan met de datum van nu.
   // echo $aanmaakDatum; exit;
    $bewerkTotDatum = date('Y-m-d H:i:s', strtotime($aanmaakDatum. ' + 1 days')); // tel 1 dag bij deze datum op. Tot en met deze datum is het labjournaal te bewerken.
    queryAanmaken('
    INSERT INTO labjournaal
    (
       studentID,labjournaalTitel,uitvoerders,experimentdatum,
       experimentBeginDatum,experimentEindDatum,doel,bijlageWaarnemingen,
       hypothese,materialen,methode,bijlageMeetresultaten,logboek,bijlageLogboek,
       observaties,bijlageObservaties,weeggegevens,bijlageWeeggegevens,
       bijlageAfbeelding,vak,jaar,veiligheid,bewerkTotDatum 
    )
    VALUES
    (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
    ,"isssssssssssssssssssiss"
    ,$_SESSION["StudentID"],$titelLabjournaal,$uitvoerders,$experimentdatum,$experimentstartdatum,
    $experimenteinddatum,$doel,$bijlageWaarnemingen,$hypothese,$materialen,$methode,
    $bijlageMeetresultaten,$logboek,$bijlageLogboek,$observaties,$bijlageObservaties,$weeggegevens,
    $bijlageWeeggegevens,$bijlageAfbeelding,$vak,$_SESSION['jaar'],$bijlageVeiligheid,$bewerkTotDatum); 

	header("location: ../pages/labjournalen.php?addLabjournaal=succes"); // na het succesvol uploaden van het labjournaal ga terug naar de overzichtpagina. 
}

if (isset($_POST['userSubmit'])) // wanneer er op de knop van gebruiker toevoegen wordt gedrukt.
{
    $uitvoerders = filter_input(INPUT_POST,'uitvoerders', FILTER_SANITIZE_SPECIAL_CHARS); // filter de input van uitvoerders vanaf het formulier
    if(!empty($uitvoerders)) // wanneer de POST niet leeg is.
    {
        queryAanmaken(
           'SELECT studentNaam,studentNummer
            FROM student
            WHERE studentNummer = ?',
            "i",
            $uitvoerders
        ); // vraag de naam en het studentnummer op van de uitvoerd.
        mysqli_stmt_bind_result($stmt, $studentNaam,$studentNummer); // bind de resultaten.
        mysqli_stmt_store_result($stmt); // sla de resultaten op.
        
        if(mysqli_stmt_num_rows($stmt) != 0) // wanneer er resultaat is.
        {
            while (mysqli_stmt_fetch($stmt)) 
            {  
                if (empty($_SESSION ['studentNummerArray'])) // wanneer de studentNummerArray nog niet bestaat maak een nieuwe array aan voor de namen en de studentnummers.
                {
                    $_SESSION ['studentNaamArray'] =  array();
                    $_SESSION ['studentNummerArray'] =  array();
                }
                
                array_push($_SESSION ['studentNaamArray'],$studentNaam);  // voeg de studentNaam van de uitvoerder toe aan de array
                array_push($_SESSION ['studentNummerArray'],$studentNummer); // voeg het studentNummer van de uitvoerder toe aan de array.            
            }
            querysluiten(); // sluit de connectie met de database.
            
            header("location: ../pages/labjournaalNieuw.php?adduser=succes"); //wanneer de gebruikers succesvol is toegevoegd ga terug naar het formulier.
        }
        else // wanneer er geen resultaten zijn.
        {
            header("location: ../pages/labjournaalNieuw.php?adduser=failed"); // ga terug naar het formulier en geef aan dat er geen resultaat is door de GET te vullen met failed. 
        }
    }  
    header("location: ../pages/labjournaalNieuw.php?adduser=succes"); // wanneer de uitvoerder POST toch leeg is ga terug naar het formulier en vul de GET met succes zodat er geen meldingen op het formulier komen.  
}
if(isset($_POST['userVerwijderen'])) // wanneer er op de knop gebruiker verwijderen wordt gedrukt.
{
    if (isset($_SESSION["studentNaamArray"])) // wanneer de studentNaamArray bestaat.
    {
        array_pop($_SESSION ['studentNaamArray']); // verwijder de laatste waarde van de array.
        array_pop($_SESSION ['studentNummerArray']); // verwijder de laatste waarde van de array.
    }
    header("location: ../pages/labjournaalNieuw.php?deleteuser=succes"); // ga terug naar het formulier en geef geen meldingen weer.
}



