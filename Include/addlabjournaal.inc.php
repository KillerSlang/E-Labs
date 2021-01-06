<?PHP
// Start the session
session_start();
include_once 'dbh.inc.php';
$titelLabjournaal =  filter_input(INPUT_POST,'titelLabjournaal', FILTER_SANITIZE_SPECIAL_CHARS); 
$uitvoerders = base64_encode(serialize($_SESSION ['studentNummerArray']));
$experimentdatum = filter_input(INPUT_POST,'experimentdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$experimentstartdatum = filter_input(INPUT_POST,'experimentstartdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$experimenteinddatum = filter_input(INPUT_POST,'experimenteinddatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$veiligheid = $_FILES['uploadveiligheid'];
$doel = filter_input(INPUT_POST,'doel', FILTER_SANITIZE_SPECIAL_CHARS);
$bijlageWaarnemingen = "bijlageWaarnemingen";//$_POST['uploadwaarnemingen'];
$hypothese = filter_input(INPUT_POST,'hypothese', FILTER_SANITIZE_SPECIAL_CHARS);
$materialen = filter_input(INPUT_POST,'materialen', FILTER_SANITIZE_SPECIAL_CHARS);
$methode = filter_input(INPUT_POST,'methode', FILTER_SANITIZE_SPECIAL_CHARS);
$bijlageMeetresultaten = "bijlageMeetresultaten";//$_POST['uploadmeetresultaten'];
$logboek = filter_input(INPUT_POST,'logboek',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$bijlageLogboek = "bijlageLogboek";//$_POST['uploadlogboek'];
$observaties = filter_input(INPUT_POST,'observaties',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$bijlageObservaties = "bijlageObservaties";//$_POST['uploadobservaties'];
$weeggegevens = filter_input(INPUT_POST,'weeggegevens',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$bijlageWeeggegevens = "bijlageWeeggegevens";//$_POST['uploadweeggegevens'];
$bijlageAfbeelding = "afbeelding";//$_POST['uploadafbeelding'];
$vak = $_POST['LVak'];
$jaar = $_POST['PJaar'];


$_SESSION['titelLabjournaal'] = $titelLabjournaal;
//$_SESSION['uitvoerders'] = $uitvoerders;
$_SESSION['experimentdatum'] = $experimentdatum;
$_SESSION['experimentstartdatum'] = $experimentstartdatum;
$_SESSION['experimenteinddatum'] = $experimenteinddatum;
$_SESSION['uploadveiligheid'] = $veiligheid;
$_SESSION['doel'] = $doel;
$_SESSION['bijlageWaarnemingen'] = $bijlageWaarnemingen;
$_SESSION['hypothese'] = $hypothese;
$_SESSION['materialen'] = $materialen;
$_SESSION['methode'] = $methode;
$_SESSION['meetresultaten'] = $bijlageMeetresultaten;
$_SESSION['logboek'] = $logboek;
$_SESSION['bijlageLogboek'] = $bijlageLogboek;
$_SESSION['observaties'] = $observaties;
$_SESSION['bijlageObservaties'] = $bijlageObservaties;
$_SESSION['weeggegevens'] = $weeggegevens;
$_SESSION['bijlageWeeggegevens'] = $bijlageWeeggegevens;
$_SESSION['bijlageAfbeelding'] = $bijlageAfbeelding;
$_SESSION['vak'] = $vak;
$_SESSION['jaar'] = $jaar;
if (isset($_POST['LSubmit']))
{
        // upload veiligheid //
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
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
    
        } else {
            echo "Sorry, alleen JPG, JPEG, PNG & Excel bestanden zijn toegestaan.";
        }

        $uploadveiligheid = $_FILES['uploadveiligheid']['name']; 
        $veiligheid = addslashes(file_get_contents($uploadveiligheid)); 
        
       /* $last_id = mysqli_insert_id($conn); 
        queryAanmaken('UPDATE labjournaal
        SET veiligheid="'.$veiligheid.'"
        WHERE labjournaalID = '.$last_id );
        querySluiten();*/
        
    

           // upload waarnemingen //
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
               } else {
                   echo "Sorry, there was an error uploading your file.";
               }
       
           } else {
               echo "Sorry, alleen JPG, JPEG, PNG bestanden zijn toegestaan.";
           }
   
           $uploadwaarnemingen = $_FILES['uploadwaarnemingen']['tmp_name']; 
           $bijlageWaarnemingen = addslashes(file_get_contents($uploadwaarnemingen));

            // upload meetresultaten //
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
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
        
            } else {
                echo "Sorry, alleen JPG, JPEG, PNG & Excel bestanden zijn toegestaan.";
            }
    
            $uploadmeetresultaten = $_FILES['uploadmeetresultaten']['tmp_name']; 
            $bijlageMeetresultaten = addslashes(file_get_contents($uploadmeetresultaten));

            // upload logboek //
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
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
        
            } else {
                echo "Sorry, alleen Excel & Word bestanden zijn toegestaan.";
            }
    
            $uploadlogboek = $_FILES['uploadlogboek']['tmp_name']; 
            $bijlageLogboek = addslashes(file_get_contents($uploadlogboek));


                    // upload observatie //
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
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                
                    } else {
                        echo "Sorry, alleen PNG, JPG, JPEG & Word bestanden zijn toegestaan.";
                    }
            
                    $uploadobservaties = $_FILES['uploadobservaties']['tmp_name']; 
                    $bijlageObservaties = addslashes(file_get_contents($uploadobservaties));


                                    // upload weeggegevens //
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
                                        } else {
                                            echo "Sorry, there was an error uploading your file.";
                                        }
                                
                                    } else {
                                        echo "Sorry, alleen Excel bestanden zijn toegestaan.";
                                    }
                            
                                    $uploadweeggegevens = $_FILES['uploadweeggegevens']['tmp_name']; 
                                    $bijlageWeeggegevens = addslashes(file_get_contents($uploadweeggegevens));


                                    // upload afbeeldingen //
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
                                        } else {
                                            echo "Sorry, there was an error uploading your file.";
                                        }
                                
                                    } else {
                                        echo "Sorry, alleen PNG, JPG & JPEG afbeeldingen zijn toegestaan.";
                                    }
                            
                                    $uploadafbeeldingen = $_FILES['uploadafbeelding']['tmp_name']; 
                                    $bijlageAfbeelding = addslashes(file_get_contents($uploadafbeeldingen));

    
        

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
        '.$_SESSION["StudentID"].',"1","'.$titelLabjournaal.'","'.$uitvoerders.'","'.$experimentdatum.'","'.$experimentstartdatum.'","'.$experimenteinddatum.'","'.$doel.'","'.$bijlageWaarnemingen.'","'.$hypothese.'","'.$materialen.'","'.$methode.'","'
        .$bijlageMeetresultaten.'","'.$logboek.'","'.$bijlageLogboek.'","'.$observaties.'","'.$bijlageObservaties.'","'.$weeggegevens.'","'
        .$bijlageWeeggegevens.'","'.$bijlageAfbeelding.'","'.$vak.'","'.$jaar.'","'.$veiligheid.'"
    );');
    $last_id = mysqli_insert_id($conn);    
    
    
   /* if(!empty($veiligheid)){
        $fileName = basename($_FILES["uploadveiligheid"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        if($fileType == 'pdf'){ 

            $docx = $_FILES['uploadveiligheid']['tmp_name']; 
            $docxContent = addslashes(file_get_contents($docx)); 
            queryAanmaken('UPDATE labjournaal
            SET veiligheid="'.$docxContent.'"
            WHERE labjournaalID = '.$last_id );
            querySluiten();

        }
    }*/
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



