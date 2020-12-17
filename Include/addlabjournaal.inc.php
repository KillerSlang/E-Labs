<?PHP
// Start the session
session_start();
include_once 'dbh.inc.php';

if (isset($_POST['LSubmit']))
{
    $titelLabjournaal =  filter_input(INPUT_POST,'titelLabjournaal', FILTER_SANITIZE_SPECIAL_CHARS); 
    $uitvoerders = filter_input(INPUT_POST,'uitvoerders', FILTER_SANITIZE_SPECIAL_CHARS);
    $experimentdatum = filter_input(INPUT_POST,'experimentdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $experimentstartdatum = filter_input(INPUT_POST,'experimentstartdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $experimenteinddatum = filter_input(INPUT_POST,'experimenteinddatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $veiligheid = $_FILES['uploadveiligheid'];
    $doel = filter_input(INPUT_POST,'doel', FILTER_SANITIZE_SPECIAL_CHARS);
    $bijlageWaarnemingen = "waarnemingen";//$_POST['uploadwaarnemingen'];
    $hypothese = filter_input(INPUT_POST,'hypothese', FILTER_SANITIZE_SPECIAL_CHARS);
    $materialen = filter_input(INPUT_POST,'materialen', FILTER_SANITIZE_SPECIAL_CHARS);
    $methode = filter_input(INPUT_POST,'methode', FILTER_SANITIZE_SPECIAL_CHARS);
    $bijlageMeetresultaten = "meetresultaten";//$_POST['uploadmeetresultaten'];
    $logboek = filter_input(INPUT_POST,'logboek',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bijlageLogboek = "logboek";//$_POST['uploadlogboek'];
    $observaties = filter_input(INPUT_POST,'observaties',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bijlageObservaties = "observaties";//$_POST['uploadobservaties'];
    $weeggegevens = filter_input(INPUT_POST,'weeggegevens',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bijlageWeeggegevens = "weeggegevens";//$_POST['uploadweeggegevens'];
    $bijlageAfbeelding = "afbeelding";//$_POST['uploadafbeelding'];
    $vak = $_POST['LVak'];
    $jaar = $_POST['PJaar'];
  

    $verplichteInput = array($titelLabjournaal,$uitvoerders, $experimentdatum, $experimentstartdatum, $experimenteinddatum, $veiligheid, $doel,
                             $hypothese, $materialen, $methode, $logboek, $observaties, $weeggegevens, $vak, $jaar);//studentnummer
  
    foreach($verplichteInput as $input)
    {
        if(empty($input))
        {
            header("location: ../pages/labjournaalformulier.php?addLabjournaal=failed");
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
       bijlageAfbeelding,vak,jaar   
    )
    VALUES
    (
        '.$_SESSION["StudentID"].',"1","'.$titelLabjournaal.'","'.$uitvoerders.'","'.$experimentdatum.'","'.$experimentstartdatum.'","'.$experimenteinddatum.'","'.$doel.'","'.$bijlageWaarnemingen.'","'.$hypothese.'","'.$materialen.'","'.$methode.'","'
        .$bijlageMeetresultaten.'","'.$logboek.'","'.$bijlageLogboek.'","'.$observaties.'","'.$bijlageObservaties.'","'.$weeggegevens.'","'
        .$bijlageWeeggegevens.'","'.$bijlageAfbeelding.'","'.$vak.'","'.$jaar.'"
    );');
    $last_id = mysqli_insert_id($conn);
    
    
    
    
    
    if(!empty($veiligheid)){
        $fileName = basename($_FILES["uploadveiligheid"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        if($fileType == 'docx'){ 

            $docx = $_FILES['uploadveiligheid']['tmp_name']; 
            $docxContent = addslashes(base64_encode($docx)); 
            queryAanmaken('UPDATE labjournaal
            SET veiligheid="'.$docxContent.'"
            WHERE labjournaalID = '.$last_id );
            querySluiten();

        }
    }
	header("location: ../pages/labjournalen.php?addLabjournaal=succes");  

}

