<?PHP
include_once 'dbh.inc.php';
if (isset($_POST['submit']))
{
    $titelLabjournaal =  filter_input(INPUT_POST,'titelLabjournaal', FILTER_SANITIZE_SPECIAL_CHARS); 
    $experimentdatum = filter_input(INPUT_POST,'experimentdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $experimentstartdatum = filter_input(INPUT_POST,'experimentstartdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $experimenteinddatum = filter_input(INPUT_POST,'experimenteinddatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $logboek = filter_input(INPUT_POST,'logboek',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uploadlogboek = $_POST['uploadlogboek'];
    $observaties = filter_input(INPUT_POST,'observaties',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uploadobservaties = $_POST['uploadobservaties'];
    $weeggegevens = filter_input(INPUT_POST,'weeggegevens',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uploadweeggegevens = $_POST['uploadweeggegevens'];
    $uploadafbeelding = $_POST['uploadafbeelding'];
    $verplichteInput = array($titelLabjournaal,$experimentdatum);//studentnummer
    foreach($verplichteInput as $input)
    {
        if(empty($input))
        {
            echo "Een verplicht veld is niet ingevoerd.";
            header("location: ../index.php?addLabjournaal=failed");
        }
    }

    queryAanmaken('INSERT INTO labjournaal(studentID,docentID,labjournaalTitel,experimentDatum,experimentBeginDatum,
    experimentEindDatum,logboek,bijlageLogboek,observaties,bijlageObservaties,weeggegevens,bijlageWeeggegevens,afbeelding)
                   VALUES ("1","1","'.$titelLabjournaal.'","'.$experimentdatum.'","'.$experimentstartdatum.'"
                   ,"'.$experimenteinddatum.'","'.$logboek.'","'.$uploadlogboek.'"
                   ,"'.$observaties.'","'.$uploadobservaties.'","'.$weeggegevens.'"
                   ,"'.$uploadweeggegevens.'","'.$uploadafbeelding.'");');
    querySluiten();
	header("location: ../index.php?addLabjournaal=succes");    
}

