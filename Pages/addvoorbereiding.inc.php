<?PHP
include_once '../Include/dbh.inc.php';

session_start();


if (isset($_POST['LSubmit']))
{
    $titelvoorbereiding =  filter_input(INPUT_POST,'titelvoorbereiding', FILTER_SANITIZE_SPECIAL_CHARS); 
    $uitvoerders = filter_input(INPUT_POST,'uitvoerders', FILTER_SANITIZE_SPECIAL_CHARS);
    $voorbereidingsdatum = filter_input(INPUT_POST,'voorbereidingsdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $uploadtheorie = "uploadtheorie";    
    $materialen = filter_input(INPUT_POST,'materialen', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $methode = filter_input(INPUT_POST,'methode', FILTER_SANITIZE_SPECIAL_CHARS);
    $hypothese = filter_input(INPUT_POST,'hypothese', FILTER_SANITIZE_SPECIAL_CHARS);
    $instellingenappraten = filter_input(INPUT_POST,'methode', FILTER_SANITIZE_SPECIAL_CHARS);
 
    $voorbereidendevragen = filter_input(INPUT_POST,'voorbereidendevragen',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $veiligheid = filter_input(INPUT_POST,'veiligheid',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $vak = $_POST['LVak'];
    $Jaar = $_POST['PJaar'];
    $uitvoeringsdatum = filter_input(INPUT_POST,'uitvoeringsdatum',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $benodigdeFormules = filter_input(INPUT_POST,'benodigdeFormules',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $doel = filter_input(INPUT_POST,'doel',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //$voorbereidingID = "abc";
    $studentID = $_SESSION["StudentID"];
  

    $verplichteInput = array($titelvoorbereiding,$uitvoerders, $voorbereidingsdatum, $uploadtheorie, $materialen,
                             $methode, $hypothese, $instellingenappraten, $voorbereidendevragen, $veiligheid, $vak, $Jaar, $uitvoeringsdatum, $benodigdeFormules, $doel);//studentnummer
  
    foreach($verplichteInput as $input)
    {
        if(empty($input))
        {
            header("location: ../Pages/Voorbereidingenaanmaak.php?addvoorbereiding=failed");
            die;
        }
    }
    
    queryAanmaken('
    INSERT INTO voorbereiding
    (
       studentID,voorbereidingTitel,voorbereidingDatum,materialen,
       methode,hypothese,instellingenApparaten,voorbereidendevragen,veiligheid,
       vakken,uitvoerders,uitvoeringsDatum,theorie,benodigdeFormules,doel,Jaar
    )
    VALUES
    (
        "'.$studentID.'","'.$titelvoorbereiding.'","'.$voorbereidingsdatum.'","'.$materialen.'","'.$methode.'","'.$hypothese.'","'
        .$instellingenappraten.'","'.$voorbereidendevragen.'","'.$veiligheid.'","'.$vak.'","'.$uitvoerders.'","'.$uitvoeringsdatum.'","'
        .$uploadtheorie.'","'.$benodigdeFormules.'","'.$doel.'","'.$Jaar.'"
    );');
    querySluiten();
	header("location: ../pages/Voorbereidingenaanmaak.php?=addvoorbereiding=succes");    

}