<?php
// functie om de beoordeling van docent toe te voegen bij voorbereidingen.
session_start();
include_once 'Dbh.inc.php';
$ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
$beoordeling = filter_input(INPUT_POST, 'beoordeling', FILTER_SANITIZE_SPECIAL_CHARS);
$_SESSION['beoordeling'] = $beoordeling;

if (isset($_POST['beoordelingSubmit']))
{
    queryAanmaken(
        'UPDATE voorbereiding SET docentID = ?, beoordeling= ? WHERE voorbereidingID = ?'
        ,"isi"
        ,$_SESSION['docentID'],$beoordeling,$ID 
    ); 
    querySluiten(); 
}
header("location: ../Pages/voorbereidingen.php?beoordeling=succes");

