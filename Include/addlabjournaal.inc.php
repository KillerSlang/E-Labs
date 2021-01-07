<?PHP
// Start the session
session_start();
include_once 'dbh.inc.php';
// sanitize post
$titelLabjournaal =  filter_input(INPUT_POST,'titelLabjournaal', FILTER_SANITIZE_SPECIAL_CHARS); 
$uitvoerders = base64_encode(serialize($_SESSION ['studentNummerArray']));
$experimentdatum = filter_input(INPUT_POST,'experimentdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$experimentstartdatum = filter_input(INPUT_POST,'experimentstartdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$experimenteinddatum = filter_input(INPUT_POST,'experimenteinddatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$doel = filter_input(INPUT_POST,'doel', FILTER_SANITIZE_SPECIAL_CHARS);
$hypothese = filter_input(INPUT_POST,'hypothese', FILTER_SANITIZE_SPECIAL_CHARS);
$materialen = filter_input(INPUT_POST,'materialen', FILTER_SANITIZE_SPECIAL_CHARS);
$methode = filter_input(INPUT_POST,'methode', FILTER_SANITIZE_SPECIAL_CHARS);
$logboek = filter_input(INPUT_POST,'logboek',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$observaties = filter_input(INPUT_POST,'observaties',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$weeggegevens = filter_input(INPUT_POST,'weeggegevens',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$vak = $_POST['LVak'];
$jaar = $_POST['PJaar'];


$_SESSION['titelLabjournaal'] = $titelLabjournaal;
//$_SESSION['uitvoerders'] = $uitvoerders;
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
$_SESSION['jaar'] = $jaar;
if (isset($_POST['LSubmit']))
{    
    
    if(!empty($_FILES["uploadveiligheid"]))
    {
        // upload veiligheid
        $target_dir = "../uploads/";
        $target_file_veiligheid = $target_dir . basename($_FILES["uploadveiligheid"]["name"]);
        $imageFileTypeveiligheid = strtolower(pathinfo($target_file_veiligheid,PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file_veiligheid)) {
        echo "Sorry, bestand is al geupload";
        }
        // Check file size
        if ($_FILES["uploadveiligheid"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Allow certain file formats
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
        $imageFileTypewaarnemingen = strtolower(pathinfo($target_file_waarnemingen,PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file_waarnemingen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Check file size
        if ($_FILES["uploadwaarnemingen"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Allow certain file formats
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
        $imageFileTypemeetresultaten = strtolower(pathinfo($target_file_meetresultaten,PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file_meetresultaten)) {
        echo "Sorry, bestand is al geupload";
        }
        // Check file size
        if ($_FILES["uploadmeetresultaten"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Allow certain file formats
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
        $imageFileTypelogboek = strtolower(pathinfo($target_file_logboek,PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file_logboek)) {
        echo "Sorry, bestand is al geupload";
        }
        // Check file size
        if ($_FILES["uploadlogboek"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Allow certain file formats
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
        $imageFileTypeobservaties = strtolower(pathinfo($target_file_observaties,PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file_observaties)) {
        echo "Sorry, bestand is al geupload";
        }
        // Check file size
        if ($_FILES["uploadobservaties"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Allow certain file formats
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
        $imageFileTypeweeggegevens = strtolower(pathinfo($target_file_weeggegevens,PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file_weeggegevens)) {
        echo "Sorry, bestand is al geupload";
        }
        // Check file size
        if ($_FILES["uploadweeggegevens"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Allow certain file formats
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
        $imageFileTypeafbeeldingen = strtolower(pathinfo($target_file_afbeeldingen,PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file_afbeeldingen)) {
        echo "Sorry, bestand is al geupload";
        }
        // Check file size
        if ($_FILES["uploadafbeelding"]["size"] > 5000000) {
        echo "Sorry, bestand is te groot (maximaal 5MB toegestaan)";
        }
        // Allow certain file formats
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
                                                               

    
        

    //$_SESSION['studentNaam'] = "";
    $verplichteInput = array($titelLabjournaal,$uitvoerders, $experimentdatum, $experimentstartdatum, $experimenteinddatum, $doel,
                             $hypothese, $materialen, $methode, $logboek, $observaties, $weeggegevens, $vak, $jaar);//studentnummer
  
    foreach($verplichteInput as $input)
    {
        if(empty($input))
        {
            header("location: ../pages/labjournaalNieuw.php?addLabjournaal=failed");
            DIE;
        }
    }   
    
    queryAanmaken('
    INSERT INTO labjournaal
    (
       studentID,docentID,labjournaalTitel,uitvoerders,experimentdatum,
       experimentBeginDatum,experimentEindDatum,doel,bijlageWaarnemingen,
       hypothese,materialen,methode,bijlageMeetresultaten,logboek,bijlageLogboek,
       observaties,bijlageObservaties,weeggegevens,bijlageWeeggegevens,
       bijlageAfbeelding,vak,jaar,veiligheid   
    )
    VALUES
    (
        '.$_SESSION["StudentID"].',"1","'.$titelLabjournaal.'","'.$uitvoerders.'","'.$experimentdatum.'","'.$experimentstartdatum.'","'
        .$experimenteinddatum.'","'.$doel.'","'.$bijlageWaarnemingen.'","'.$hypothese.'","'.$materialen.'","'.$methode.'","'
        .$bijlageMeetresultaten.'","'.$logboek.'","'.$bijlageLogboek.'","'.$observaties.'","'.$bijlageObservaties.'","'.$weeggegevens.'","'
        .$bijlageWeeggegevens.'","'.$bijlageAfbeelding.'","'.$vak.'","'.$jaar.'","'.$bijlageVeiligheid.'"
    );'); 
    
    
	header("location: ../pages/labjournalen.php?addLabjournaal=succes");  

}
$GLOBALS ['array'] = array();
if (isset($_POST['userSubmit']))
{
    $uitvoerders = filter_input(INPUT_POST,'uitvoerders', FILTER_SANITIZE_SPECIAL_CHARS);
    if(!empty($uitvoerders))
    {
        $sql = ' 
        SELECT studentNaam,studentNummer
        FROM student
        WHERE studentNummer = 
        '.$uitvoerders;
        queryAanmaken($sql);
        mysqli_stmt_bind_result($stmt, $studentNaam,$studentNummer);
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) != 0)
        {
            while (mysqli_stmt_fetch($stmt)) 
            {
                
                if (empty($_SESSION ['studentNummerArray']))
                {
                    
                    $_SESSION ['studentNaamArray'] =  array();
                    $_SESSION ['studentNummerArray'] =  array();
                }
                
                array_push($_SESSION ['studentNaamArray'],$studentNaam);  
                array_push($_SESSION ['studentNummerArray'],$studentNummer);            
            }
            querysluiten();
            
            header("location: ../pages/labjournaalNieuw.php?adduser=succes"); 
        }
        else
        {
            header("location: ../pages/labjournaalNieuw.php?adduser=failed");  
        }
    }    
}
if(isset($_POST['userVerwijderen']))
{
    if (isset($_SESSION["studentNaamArray"]))
    {
        array_pop($_SESSION ['studentNaamArray']);
        array_pop($_SESSION ['studentNummerArray']);
    }
    header("location: ../pages/labjournaalNieuw.php?deleteuser=succes"); 
}



