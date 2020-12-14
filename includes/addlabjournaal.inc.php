<?PHP
include_once 'dbh.inc.php';
if (isset($_POST['LSubmit']))
{
    $titelLabjournaal =  filter_input(INPUT_POST,'titelLabjournaal', FILTER_SANITIZE_SPECIAL_CHARS); 
    $uitvoerders = filter_input(INPUT_POST,'uitvoerders', FILTER_SANITIZE_SPECIAL_CHARS);
    $experimentdatum = filter_input(INPUT_POST,'experimentdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $experimentstartdatum = filter_input(INPUT_POST,'experimentstartdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $experimenteinddatum = filter_input(INPUT_POST,'experimenteinddatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uploadveiligheid = $_POST['uploadveiligheid'];
    $doel = filter_input(INPUT_POST,'doel', FILTER_SANITIZE_SPECIAL_CHARS);
    $uploadwaarnemingen = $_POST['uploadwaarnemingen'];
    $hypothese = filter_input(INPUT_POST,'hypothese', FILTER_SANITIZE_SPECIAL_CHARS);
    $materialen = filter_input(INPUT_POST,'materialen', FILTER_SANITIZE_SPECIAL_CHARS);
    $methode = filter_input(INPUT_POST,'methode', FILTER_SANITIZE_SPECIAL_CHARS);
    $uploadmeetresultaten = $_POST['uploadmeetresultaten'];
    $logboek = filter_input(INPUT_POST,'logboek',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uploadlogboek = $_POST['uploadlogboek'];
    $observaties = filter_input(INPUT_POST,'observaties',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uploadobservaties = $_POST['uploadobservaties'];
    $weeggegevens = filter_input(INPUT_POST,'weeggegevens',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uploadweeggegevens = $_POST['uploadweeggegevens'];
    $uploadafbeelding = $_POST['uploadafbeelding'];
    $vakken = $_POST['LVak'];

    // $afbeelding = file_get_contents($uploadwaarnemingen);
    // $uploadwaarnemingendata = base64_encode($afbeelding);

   
    $verplichteInput = array
    ($titelLabjournaal,$experimentdatum);//studentnummer
    
    foreach($verplichteInput as $input)
    {
        if(empty($input))
        {
            header("location: ../pages/labjournaalformulier.php?addLabjournaal=failed");
            DIE;
        }
    }
/*
    queryAanmaken('
    INSERT INTO labjournaal
    (
        studentID,docentID,labjournaalTitel,experimentDatum,experimentBeginDatum,
        experimentEindDatum,logboek,observaties,weeggegevens,afbeeldingBron,bijlageLogboek,
        bijlageObservaties,bijlageWeeggegevens,vakken,uitvoerder
    
    
    ');*/
 



 /*   queryAanmaken('INSERT INTO labjournaal(studentID,docentID,labjournaalTitel,experimentDatum,experimentBeginDatum,
    experimentEindDatum,logboek,observaties,weeggegevens,/*afbeelding,figuur,*//*afbeeldingBron,bijlageLogboek,bijlageObservaties,
    bijlageWeeggegevens,vakken,uitvoerders,veiligheid,hypothese,materialen,methode,meetresultaten,doel)
                   VALUES ("1","1","'.$titelLabjournaal.'","'.$experimentdatum.'","'.$experimentstartdatum.'"
                   ,"'.$experimenteinddatum.'","'.$logboek.'","'.$observaties.'"
                   ,"'.$weeggegevens.'","'.$uploadafbeelding.'","'.$uploadlogboek.'"
                   ,"'.$uploadobservaties.'","","'.$uploadweeggegevens.'","","'.$vakken.'","'.$uitvoerders.'","","
                   ","'.$uploadveiligheid.'","","'.$hypothese.'","'.$materialen.'","
                   ","'.$methode.'","","'.$uploadmeetresultaten.'","'.$doel.'");');
    querySluiten();
	header("location: ../pages/labjournaalformulier.php?addLabjournaal=succes");    */
}

