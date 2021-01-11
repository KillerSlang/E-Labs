<?php
// functie om de beoordeling van docent toe te voegen.
session_start();
include_once 'Dbh.inc.php';
$ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
$beoordeling = filter_input(INPUT_POST, 'beoordeling', FILTER_SANITIZE_SPECIAL_CHARS);
$_SESSION['beoordeling'] = $beoordeling;
if (isset($_POST['beoordelingSubmit']))
{
    queryAanmaken(
        'UPDATE labjournaal SET docentID = ?, beoordeling= ? WHERE labjournaalID = ?'
        ,"isi"
        ,$_SESSION['docentID'],$beoordeling,$ID 
    ); 
    querySluiten(); 
}
header("location: ../Pages/labjournalen.php?beoordeling=succes");

