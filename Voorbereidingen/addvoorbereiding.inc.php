<?PHP
include_once 'dbh.inc.php';

if (isset($_POST['LSubmit']))
{
    $titelvoorbereiding =  filter_input(INPUT_POST,'titelvoorbereiding', FILTER_SANITIZE_SPECIAL_CHARS); 
    $uitvoerders = filter_input(INPUT_POST,'uitvoerders', FILTER_SANITIZE_SPECIAL_CHARS);
    $voorbereidingsdatum = filter_input(INPUT_POST,'voorbereidingsdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$experimentstartdatum = filter_input(INPUT_POST,'experimentstartdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$experimenteinddatum = filter_input(INPUT_POST,'experimenteinddatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uploadtheorie = "uploadtheorie";    
    $materialen = filter_input(INPUT_POST,'materialen', FILTER_SANITIZE_SPECIAL_CHARS);
    //$bijlageWaarnemingen = "waarnemingen";//$_POST['uploadwaarnemingen'];
    $methode = filter_input(INPUT_POST,'methode', FILTER_SANITIZE_SPECIAL_CHARS);
    $hypothese = filter_input(INPUT_POST,'hypothese', FILTER_SANITIZE_SPECIAL_CHARS);
    $instellingenappraten = filter_input(INPUT_POST,'methode', FILTER_SANITIZE_SPECIAL_CHARS);
    //$bijlageMeetresultaten = "meetresultaten";//$_POST['uploadmeetresultaten'];
    $voorbereidendevragen = filter_input(INPUT_POST,'voorbereidendevragen',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$bijlageLogboek = "logboek";//$_POST['uploadlogboek'];
    $veiligheid = filter_input(INPUT_POST,'veiligheid',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$bijlageObservaties = "observaties";//$_POST['uploadobservaties'];
    //$weeggegevens = filter_input(INPUT_POST,'weeggegevens',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$bijlageWeeggegevens = "weeggegevens";//$_POST['uploadweeggegevens'];
    //$bijlageAfbeelding = "afbeelding";//$_POST['uploadafbeelding'];
    $vak = $_POST['LVak'];
    $jaar = $_POST['PJaar'];
    $uitvoeringsdatum = filter_input(INPUT_POST,'uitvoeringsdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $benodigdeFormules = filter_input(INPUT_POST,'benodigdeFormules',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $doel = filter_input(INPUT_POST,'doel',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $voorbereidingID = "abc";
    $studentID = $_SESSION["studentNummer"];
  

    $verplichteInput = array($titelvoorbereiding,$uitvoerders, $voorbereidingsdatum, $uploadtheorie, $materialen,
                             $methode, $hypothese, $instellingenappraten, $voorbereidendevragen, $veiligheid, $vak, $jaar, $uitvoeringsdatum, $benodigdeFormules, $doel);//studentnummer
  
    foreach($verplichteInput as $input)
    {
        if(empty($input))
        {
            header("location: ../pages/Voorbereidingenaanmaak.php?addvoorbereiding=failed");
            DIE;
        }
    }
    
    queryAanmaken('
    INSERT INTO voorbereiding
    (
       voorbereidingID,studentID,voorbereidingTitel,voorbereidingDatum,materialen,
       methode,hypothese,instellingenApparaten,voorbereidendevragen,veiligheid,
       vakken,uitvoerders,uitvoeringsDatum,theorie,benodigdeFormules,doel
    )
    VALUES
    (
        "'.$voorbereidingID.'","'.$studentID.'","'.$titelvoorbereiding.'","'.$voorbereidingsdatum.'","'.$materialen.'","'.$methode.'","'.$hypothese.'","'
        .$instellingenappraten.'","'.$voorbereidendevragen.'","'.$veiligheid.'","'.$vak.'","'.$uitvoerders.'","'.$uitvoeringsdatum.'","'
        .$uploadtheorie.'","'.$benodigdeFormules.'","'.$doel.'"
    );');
    querySluiten();
	header("location: ../pages/Voorbereidingenaanmaak.php?addvoorbereiding=succes");    

}