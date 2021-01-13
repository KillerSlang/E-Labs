<?PHP
session_start();
include_once 'Dbh.inc.php';
$ID = $_GET['ID'];
$studentID = $_SESSION["StudentID"];
if (isset($_POST['LSubmit']))
{
    $titelLabjournaal =  filter_input(INPUT_POST,'titelLabjournaal', FILTER_SANITIZE_SPECIAL_CHARS); 
    $uitvoerders = filter_input(INPUT_POST,'uitvoerders', FILTER_SANITIZE_SPECIAL_CHARS);
    $experimentdatum = filter_input(INPUT_POST,'experimentdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $experimentstartdatum = filter_input(INPUT_POST,'experimentstartdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $experimenteinddatum = filter_input(INPUT_POST,'experimenteinddatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$veiligheid = "veiligheid";    
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
  

    $verplichteInput = array($titelLabjournaal,$uitvoerders, $experimentdatum, $experimentstartdatum, $experimenteinddatum, /*$veiligheid,*/ $doel,
                             $hypothese, $materialen, $methode, $logboek, $observaties, $weeggegevens, $vak, $jaar);//studentnummer
  
    foreach($verplichteInput as $input)
    {
        if(empty($input))
        {
            header("location: ../Pages/labjournaal.php?addLabjournaal=failed");
            DIE;
        }
    }
    
    queryAanmaken('
    UPDATE labjournaal
    SET
       labjournaalTitel = "'.$titelLabjournaal.'",uitvoerders = "'.$uitvoerders.'",experimentdatum = "'.$experimentdatum.'",
       experimentBeginDatum = "'.$experimentstartdatum.'",experimentEindDatum = "'.$experimenteinddatum.'",veiligheid = "'.$veiligheid.'",doel = "'.$doel.'
       ",bijlageWaarnemingen = "'.$bijlageWaarnemingen.'", hypothese = "'.$hypothese.'",materialen = "'.$materialen.'",methode = "'.$methode.'
       ",bijlageMeetresultaten = "'.$bijlageMeetresultaten.'",logboek ="'.$logboek.'",bijlageLogboek = "'.$bijlageLogboek.'",
       observaties = "'.$observaties.'",bijlageObservaties = "'.$bijlageObservaties.'",weeggegevens = "'.$weeggegevens.'
       ",bijlageWeeggegevens = "'.$bijlageWeeggegevens.'",bijlageAfbeelding = "'.$bijlageAfbeelding.'",vak = "'.$vak.'",jaar = "'.$jaar.'"   
    WHERE labjournaalID = "'.$ID.'" AND studentID = '.$studentID);
    querySluiten();
	header("location: ../Pages/labjournalen.php?addLabjournaal=succes");    
}
