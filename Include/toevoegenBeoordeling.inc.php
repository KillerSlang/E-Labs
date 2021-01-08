<?php
session_start();
include_once 'Dbh.inc.php';
$ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
$beoordeling = filter_input(INPUT_POST, 'beoordeling', FILTER_SANITIZE_SPECIAL_CHARS);
$_SESSION['beoordeling'] = $beoordeling;

if (isset($_POST['beoordelingSubmit']))
{
    
    $sql = 'UPDATE labjournaal SET beoordeling='.$beoordeling.' WHERE labjournaalID = '.$ID;
    queryAanmaken($sql); 
    
    // mysqli_stmt_bind_param($stmt, 'si', $beoordeling, $ID);

    querySluiten(); 
}
header("location: ../Pages/labjournalen.php?beoordeling=succes");

