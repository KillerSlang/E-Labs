<?PHP
// Start the session
session_start();
include_once 'dbh.inc.php';
// sanitize post
if(!empty($_GET['ID']))
    {
        $ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
    }else{ $ID = 0; }

    $titelvoorbereiding =  filter_input(INPUT_POST,'titelvoorbereiding', FILTER_SANITIZE_SPECIAL_CHARS); 
    $uitvoerders = base64_encode(serialize($_SESSION ['studentNummerArray']));
    $voorbereidingsdatum = filter_input(INPUT_POST,'voorbereidingsDatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uitvoeringsdatum = filter_input(INPUT_POST,'uitvoeringsDatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $doel = filter_input(INPUT_POST,'doel',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $benodigdeFormules = filter_input(INPUT_POST,'benodigdeFormules', FILTER_SANITIZE_STRING);
    $InstellingenApparaten = filter_input(INPUT_POST,'InstellingenApparaten', FILTER_SANITIZE_STRING);
    $hypothese = filter_input(INPUT_POST,'Hypothese', FILTER_SANITIZE_STRING);
    $materialen = filter_input(INPUT_POST,'materialen', FILTER_SANITIZE_STRING);
    $methode = filter_input(INPUT_POST,'methode',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $veiligheid = filter_input(INPUT_POST,'veiligheid',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $voorbereidendevragen = filter_input(INPUT_POST,'Voorbereidendevragen',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vak = $_POST['LVak'];
    $bijlageTheorie = "" ; 
    $bijlageMaterialen = "" ; 
    $bijlageMethode = "" ; 
    $bijlageVeiligheid = "" ; 
    $bijlageVoorbereidendevragen = "" ; 
$uploadArray = array();
$databaseNames = array();

$_SESSION['titelvoorbereiding'] = $titelvoorbereiding;
$_SESSION['voorbereidingsdatum'] = $voorbereidingsdatum;
$_SESSION['uitvoeringsdatum'] = $uitvoeringsdatum;
$_SESSION['doel'] = $doel;
$_SESSION['benodigdeFormules'] = $benodigdeFormules;
$_SESSION['InstellingenApparaten'] = $InstellingenApparaten;
$_SESSION['hypothese'] = $hypothese;
$_SESSION['materialen'] = $materialen;
$_SESSION['methode'] = $methode;
$_SESSION['veiligheid'] = $veiligheid;
$_SESSION['voorbereidendevragen'] = $voorbereidendevragen;
$_SESSION['vak'] = $vak;

if (isset($_POST['LSubmit'])) // wanneer er vanaf de VoorbereidingNieuw pagina op de opslaan knop wordt gedrukt.
{    
    
    if(!empty($_FILES["uploadtheorie"]))
    {
        // upload veiligheid
        $target_dir = "../uploads/voorbereiding/theorie";
        $target_file_theorie = $target_dir . basename($_FILES["uploadtheorie"]["name"]);
        $imageFileTypeveiligheid = strtolower(pathinfo($target_file_theorie,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_theorie)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadtheorie"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadtheorie']['type'] == 'image/png' ||  $_FILES['uploadtheorie']['type'] == 'image/jpeg' ||  $_FILES['uploadtheorie']['type'] == 'image/jpg' || $_FILES['uploadtheorie']['type'] == 'application/msword' || $_FILES['uploadtheorie']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
            if (move_uploaded_file($_FILES["uploadtheorie"]["tmp_name"], $target_file_theorie)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadtheorie"]["name"])). " is succesvol geupload.";
                $bijlageTheorie = $target_file_theorie;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen PNG, JPG, JPEG & Word bestanden zijn toegestaan.";
        }  
          
    }
    
    if(!empty($_FILES["uploadmaterialen"]))
    {
        // upload waarnemingen
        $target_dir = "../uploads/voorbereiding/materialen";
        $target_file_materialen = $target_dir . basename($_FILES["uploadmaterialen"]["name"]);
        $imageFileTypematerialen = strtolower(pathinfo($target_file_materialen,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_materialen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadmaterialen"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadmaterialen']['type'] == 'application/vnd.ms-excel' || $_FILES['uploadmaterialen']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
            if (move_uploaded_file($_FILES["uploadmaterialen"]["tmp_name"], $target_file_materialen)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadmaterialen"]["name"])). " is succesvol geupload.";
                $bijlageMaterialen = $target_file_materialen;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }

        } else {
            echo "Sorry, alleen Excel bestanden zijn toegestaan.";
        }
    }
           
    if(!empty($_FILES["uploadmethode"]))
    {
        // upload waarnemingen
        $target_dir = "../uploads/voorbereiding/methode";
        $target_file_methode = $target_dir . basename($_FILES["uploadmethode"]["name"]);
        $imageFileTypemethode = strtolower(pathinfo($target_file_methode,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_methode)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadmaterialen"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadmethode']['type'] == 'application/vnd.ms-excel' || $_FILES['uploadmethode']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
            if (move_uploaded_file($_FILES["uploadmethode"]["tmp_name"], $target_file_methode)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadmethode"]["name"])). " is succesvol geupload.";
                $bijlageMethode = $target_file_methode;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }

        } else {
            echo "Sorry, alleen Excel bestanden zijn toegestaan.";
        }
    }
            
    if(!empty($_FILES["uploadveiligheid"]))
    {
        // upload logboek
        $target_dir = "../uploads/voorbereiding/veiligheid";
        $target_file_veiligheid = $target_dir . basename($_FILES["uploadveiligheid"]["name"]);
        $imageFileTypeveiligheid = strtolower(pathinfo($target_file_veiligheid,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_veiligheid)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadveiligheid"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadveiligheid']['type'] == 'image/png' ||  $_FILES['uploadveiligheid']['type'] == 'image/jpeg' ||  $_FILES['uploadveiligheid']['type'] == 'image/jpg' || $_FILES['uploadveiligheid']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['uploadveiligheid']['type'] == 'application/vnd.ms-excel' ) {
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

    if(!empty($_FILES["uploadvoorbereidendevragen"]))
    {
        // upload observatie
        $target_dir = "../uploads/voorbereiding/voorbereidendevragen";
        $target_file_voorbereidendevragen = $target_dir . basename($_FILES["uploadvoorbereidendevragen"]["name"]);
        $imageFileTypevoorbereidendevragen = strtolower(pathinfo($target_file_voorbereidendevragen,PATHINFO_EXTENSION));
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_voorbereidendevragen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadvoorbereidendevragen"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Sta de juiste bestandtypes toe
        if($_FILES['uploadvoorbereidendevragen']['type'] == 'image/png' ||  $_FILES['uploadvoorbereidendevragen']['type'] == 'image/jpeg' ||  $_FILES['uploadvoorbereidendevragen']['type'] == 'image/jpg' || $_FILES['uploadvoorbereidendevragen']['type'] == 'application/msword' || $_FILES['uploadvoorbereidendevragen']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $_FILES['uploadmethode']['type'] == 'application/vnd.ms-excel' || $_FILES['uploadmethode']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
            if (move_uploaded_file($_FILES["uploadvoorbereidendevragen"]["tmp_name"], $target_file_voorbereidendevragen)) {
                echo "Het bestand ". htmlspecialchars( basename( $_FILES["uploadvoorbereidendevragen"]["name"])). " is succesvol geupload.";
                $bijlageVoorbereidendevragen = $target_file_voorbereidendevragen;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen PNG, JPG, JPEG & Word & Excel bestanden zijn toegestaan.";
        }
    }
    // array van alle verplichten inputvelden.
    $verplichteInput = array($titelvoorbereiding, $voorbereidingsdatum, $uitvoeringsdatum, $benodigdeFormules, $InstellingenApparaten,
    $hypothese, $materialen, $methode, $veiligheid, $voorbereidendevragen, $vak,$doel);//studentnummer
    
    foreach($verplichteInput as $input) //check of alle verplichte velden zijn ingevuld.
    {
        if(empty($input)) // wanneer dit niet het geval is, ga terug naar het formulier.
        {
            header("location: ../pages/voorbereidingBewerk.php?ID=".$ID."&addLabjournaal=failed");
            exit;
        }
    }    
    queryAanmaken('
        UPDATE voorbereiding
        SET
        studentID = ?,voorbereidingTitel = ?,voorbereidingDatum = ?,materialen = ?,methode = ?,hypothese = ?,
        instellingenApparaten = ?,voorbereidendeVragen = ?,veiligheid = ?,vak = ?,uitvoerders = ?,
        uitvoeringsDatum = ?,benodigdeFormules = ?,jaar = ?,bijlageTheorie = ?,bijlageMaterialen = ?,
        bijlageMethode = ?,bijlageVeiligheid = ?,bijlageVoorbereidendevragen= ?,doel = ? 
        WHERE voorbereidingID = ?'
        ,"issssssssssssissssssi"
        ,$_SESSION["StudentID"],$titelvoorbereiding,$voorbereidingsdatum,$materialen,$methode,$hypothese,
        $InstellingenApparaten,$voorbereidendevragen,$veiligheid,$vak,$uitvoerders,$uitvoeringsdatum,$benodigdeFormules,
        $_SESSION['jaar'],$bijlageTheorie,$bijlageMaterialen,$bijlageMethode,$bijlageVeiligheid,$bijlageVoorbereidendevragen,
        $doel,$ID
    );    
    querysluiten();   
	header("location: ../pages/voorbereidingen.php?addLabjournaal=succes");  
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
            header("location: ../pages/voorbereidingBewerk.php?ID=".$ID."&adduser=succes"); 
        }
        else // wanneer geen resultaat ga terug naar het formulier met de GET Failed.
        {
            header("location: ../pages/voorbereidingBewerk.php?ID=".$ID."&adduser=failed");  
        }
    }
    header("location: ../pages/voorbereidingBewerk.php?ID=".$ID."&adduser=succes");      
}
if(isset($_POST['userVerwijderen'])) // wanneer er op de knop uitvoerder verwijderen wordt gedrukt.
{
    if (isset($_SESSION["studentNaamArray"])) // wanneer de array bestaat.
    {
        array_pop($_SESSION ['studentNaamArray']); // verwijder de laatst toegevoegde waarde van de array.
        array_pop($_SESSION ['studentNummerArray']); // verwijder de laatst toegevoegde waarde van de array.
    }
    header("location: ../pages/voorbereidingBewerk.php?ID=".$ID."&deleteuser=succes"); // ga terug naar het formulier.
}



