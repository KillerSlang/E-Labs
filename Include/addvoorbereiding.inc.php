<?PHP
// Start de sessie
session_start();
include_once 'Dbh.inc.php';
$_SESSION['jaar'] = "1";

// filter ingevulde velden
$titelvoorbereiding =  filter_input(INPUT_POST,'titelvoorbereiding', FILTER_SANITIZE_SPECIAL_CHARS); 
$uitvoerders = base64_encode(serialize($_SESSION ['studentNummerArray']));
$voorbereidingsdatum = filter_input(INPUT_POST,'voorbereidingsdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$uitvoeringsdatum = filter_input(INPUT_POST,'uitvoeringsdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$doel = filter_input(INPUT_POST,'doel',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$benodigdeFormules = filter_input(INPUT_POST,'benodigdeFormules', FILTER_SANITIZE_STRING);
$InstellingenApparaten = filter_input(INPUT_POST,'instellingenapparaten', FILTER_SANITIZE_STRING);
$hypothese = filter_input(INPUT_POST,'hypothese', FILTER_SANITIZE_STRING);
$materialen = filter_input(INPUT_POST,'materialen', FILTER_SANITIZE_STRING);
$methode = filter_input(INPUT_POST,'methode',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$veiligheid = filter_input(INPUT_POST,'veiligheid',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$voorbereidendevragen = filter_input(INPUT_POST,'voorbereidendevragen',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$vak = $_POST['LVak'];
$bijlageTheorie = "" ; 
$bijlageMaterialen = "" ; 
$bijlageMethode = "" ; 
$bijlageVeiligheid = "" ; 
$bijlageVoorbereidendevragen = "" ; 


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
        // upload Theorie
        $fileType = pathinfo(basename($_FILES["uploadtheorie"]["name"]), PATHINFO_EXTENSION); 
        $target_dir = "../upload/voorbereiding/theoriën/Theorie ";
        $date = date("Y-m-d_G-i-s");
        $target_file_theorie = $target_dir.$_SESSION["Name"]." ".$date.'.'.$fileType;
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_theorie)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadtheorie"]["size"] > 4000000) {
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
        $fileType = pathinfo(basename($_FILES["uploadmaterialen"]["name"]), PATHINFO_EXTENSION); 
        $target_dir = "../upload/voorbereiding/materialen/Materiaal ";
        $date = date("Y-m-d_G-i-s");
        $target_file_materialen = $target_dir.$_SESSION["Name"]." ".$date.'.'.$fileType;
        
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_materialen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadmaterialen"]["size"] > 4000000) {
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
        $fileType = pathinfo(basename($_FILES["uploadmethode"]["name"]), PATHINFO_EXTENSION); 
        $target_dir = "../upload/voorbereiding/methodes/Methode ";
        $date = date("Y-m-d_G-i-s");
        $target_file_methode = $target_dir.$_SESSION["Name"]." ".$date.'.'.$fileType;
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_methode)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadmaterialen"]["size"] > 4000000) {
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
        $fileType = pathinfo(basename($_FILES["uploadveiligheid"]["name"]), PATHINFO_EXTENSION); 
        $target_dir = "../upload/voorbereiding/veiligheden/Veiligheid ";
        $date = date("Y-m-d_G-i-s");
        $target_file_veiligheid = $target_dir.$_SESSION["Name"]." ".$date.'.'.$fileType;
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_veiligheid)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadveiligheid"]["size"] > 4000000) {
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
        $fileType = pathinfo(basename($_FILES["uploadvoorbereidendevragen"]["name"]), PATHINFO_EXTENSION); 
        $target_dir = "../upload/voorbereiding/vragen/Vragen ";
        $date = date("Y-m-d_G-i-s");
        $target_file_voorbereidendevragen = $target_dir.$_SESSION["Name"]." ".$date.'.'.$fileType;
        
        // Controleer of het bestand al bestaat.
        if (file_exists($target_file_voorbereidendevragen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Controleer de grootte van het bestand.
        if ($_FILES["uploadvoorbereidendevragen"]["size"] > 4000000) {
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
    
    foreach($verplichteInput as $input) // loop door de gehele array heen.
    {
        if(empty($input)) // als een waarde niet is ingevuld ga dan terug naar de pagina.
        {
            header("location: ../Pages/VoorbereidingNieuw.php?addLabjournaal=failed");
            exit;
        }
    }   
    $aanmaakDatum = date("Y-m-d H:i:s"); // maak een variabele aan met de datum van nu.
   // //echo $aanmaakDatum; exit;
    $bewerkTotDatum = date('Y-m-d H:i:s', strtotime($aanmaakDatum. ' + 1 days')); // tel 1 dag bij deze datum op. Tot en met deze datum is het voorbereiding te bewerken.
    queryAanmaken('
        INSERT INTO voorbereiding
        (
        studentID,voorbereidingTitel,voorbereidingDatum,materialen,methode,hypothese,
        instellingenApparaten,voorbereidendeVragen,veiligheid,vak,uitvoerders,
        uitvoeringsDatum,benodigdeFormules,jaar,bijlageTheorie,bijlageMaterialen,
        bijlageMethode,bijlageVeiligheid,bijlageVoorbereidendevragen,bewerkTotDatum,doel
        )
        VALUES
        (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
        ,"issssssssssssisssssss"
        ,$_SESSION["StudentID"],$titelvoorbereiding,$voorbereidingsdatum,$materialen,$methode,$hypothese,
        $InstellingenApparaten,$voorbereidendevragen,$veiligheid,$vak,$uitvoerders,$uitvoeringsdatum,$benodigdeFormules,
        $_SESSION['jaar'],$bijlageTheorie,$bijlageMaterialen,$bijlageMethode,$bijlageVeiligheid,$bijlageVoorbereidendevragen,
        $bewerkTotDatum,$doel
    );    
    querySluiten();
	header("location: ../Pages/voorbereidingen.php?addLabjournaal=succes"); // na het succesvol uploaden van de Voorbereiding ga terug naar de overzichtpagina. 
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
            
            header("location: ../Pages/VoorbereidingNieuw.php?adduser=succes"); //wanneer de gebruikers succesvol is toegevoegd ga terug naar het formulier.
        }
        else // wanneer er geen resultaten zijn.
        {
            header("location: ../Pages/VoorbereidingNieuw.php?adduser=failed"); // ga terug naar het formulier en geef aan dat er geen resultaat is door de GET te vullen met failed. 
        }
    }  
    header("location: ../Pages/VoorbereidingNieuw.php?adduser=succes"); // wanneer de uitvoerder POST toch leeg is ga terug naar het formulier en vul de GET met succes zodat er geen meldingen op het formulier komen.  
}
if(isset($_POST['userVerwijderen'])) // wanneer er op de knop gebruiker verwijderen wordt gedrukt.
{
    if (isset($_SESSION["studentNaamArray"])) // wanneer de studentNaamArray bestaat.
    {
        array_pop($_SESSION ['studentNaamArray']); // verwijder de laatste waarde van de array.
        array_pop($_SESSION ['studentNummerArray']); // verwijder de laatste waarde van de array.
    }
    header("location: ../Pages/VoorbereidingNieuw.php?deleteuser=succes"); // ga terug naar het formulier en geef geen meldingen weer.
}



